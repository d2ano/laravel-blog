<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Avatar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail( $id );

        return view('user.show')
            ->with('user' , $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit')
            ->with('user' , $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUser $request , $id )
    {
        $validated = $request->validated();

        // if ( $request->password ) {
        //     $password = User::findOrFail($id);
        //     $password->password = bcrypt( $request->password );
        //     $password->save();
        // }


        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        //ak je zaskrtnuty checkbox tak vymaze obrazok
        if ( $request->input('delete_image') ) {
            $avatar = Avatar::find($user->avatar_id);

            Storage::delete($avatar->path);

            Avatar::destroy($user->avatar_id);
        }

        if ( $request->file('avatar') ) {
            //vymaz aktualny

            if ( $avatar = Avatar::find($user->avatar_id) ) {
                Storage::delete($avatar->path);

                Avatar::destroy($user->avatar_id);
            }
            // $avatar = Avatar::find($user->avatar_id);


            

            $name = $request->file('avatar')->getClientOriginalName();
            $store = $request->file('avatar')->store('avatar');
            

            $avatar = new Avatar;

            $avatar->name = $name;

            $avatar->path = $store;

            $avatar->save();

            $upload_avatar = Avatar::latest()->first()->id;

            $user->avatar_id = $upload_avatar;
        }

        //ulozi nove hodnoty
        $user->update($validated);

        if ( $request->password ) {
            $password = User::findOrFail($id);
            $password->password = bcrypt( $request->password );
            $password->save();
        }

        return redirect()->route('user.show' , Auth::user()->id)
            ->with('message' , 'Profil bol aktualizovný');


    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     $users = User::all();

    //     return $users;
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }
}
