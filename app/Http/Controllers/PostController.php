<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Cover;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest('created_at')->get();


        return view('post.index')
            ->with('posts' , $posts)
            ->with('mainHead' , '" Všetky články "');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all()->toArray();

        return view('post.create')
        ->with('tags' , $tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        //validacia
        $validated = $request->validated();

        //vytvori post z validated
        $post = Auth::user()->posts()->create($validated);

        //ak mame obrazok, ulozit ho, a do post->cover_id ulozit jeho id
        if ( $request->file('image') ) {
            $name = $request->file('image')->getClientOriginalName();
            $store = $request->file('image')->store('img');

            $cover = new Cover;

            $cover->name = $name;

            $cover->path = $store;

            $cover->save();
            
            $upload_cover = Cover::latest()->first()->id;

            $post->cover_id = $upload_cover;
        }

        //synchronizovat s pivot
        $post->tags()->sync($request->get('tag'));

        //ulozit post
        $post->save();

        return redirect('/')
            ->with('message' , 'Bol pridaný nový článok');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        

        return view('post.show')
            ->with('post' , $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        $post = Post::findOrFail($id);

        $post->tags;

        $post->cover;

        $tags = Tag::all();
        
        foreach ($post->tags as $tag_from_post) {
            foreach ($tags as $tag_from_tags) {
                if ($tag_from_post->id == $tag_from_tags->id) {
                    $tag_from_tags->status = 1;
                }
            }
        }

        return view('post.edit')
            ->with('post' , $post)
            ->with('tags' , $tags);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request , $id )
    {

        //ulozi z validacie
        $validated = $request->validated();

        //vytiahne z DB dany post
        $post = Post::findOrFail($id);

        //autorizacia
        $this->authorize('update', $post);

        //ak je zaskrtnuty checkbox tak vymaze obrazok
        if ( $request->input('delete_image') ) {
            $cover = Cover::find($post->cover_id);

            Storage::delete($cover->path);

            Cover::destroy($post->cover_id);
        }

        //ak mame obrazok, ulozit ho, a do post->cover_id ulozit jeho id
        if ( $request->file('image') ) {
            if ( $cover = Cover::find($post->cover_id) ) {
                Storage::delete($cover->path);
            
            Cover::destroy($post->cover_id);
            }
            

            $name = $request->file('image')->getClientOriginalName();
            $store = $request->file('image')->store('img');


            $cover = new Cover;

            $cover = new Cover;

            $cover->name = $name;

            $cover->path = $store;

            $cover->save();
            
            $upload_cover = Cover::latest()->first()->id;

            $post->cover_id = $upload_cover;

            Cover::destroy($id);
        }


        //syncgronizuje pivot
        $post->tags()->sync($request->get('tag'));

        //ulozi nove hodnoty
        $post->update($validated);

        return redirect('/')
            ->with('message' , 'Článok bol aktualizovný');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        //find post by id
        $post = Post::findOrFail($id);

        //autorizacia
        $this->authorize('delete', $post);

    

        //if post have cover, delete it
        if ( $post->cover_id ) {
            $cover = Cover::find($post->cover_id);

            Storage::delete($cover->path);

            Cover::destroy($post->cover_id);
        }

        //delete post
        Post::destroy($id);

        return redirect('/')
            ->with('message' , 'Článok bol vymazaný');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $post = Post::findOrFail($id);

        return view('post.delete')
            ->with('post' , $post);
    }

    public function user( $id )
    {
        // $posts = Post::all()->where('user_id' , $id);
        $posts = Post::latest('created_at')->where('user_id' , $id)->get();

        return view('post.user')
            ->with('posts' , $posts)
            ->with('mainHead' , '" '.Auth::user()->email.' "');
    }
}

