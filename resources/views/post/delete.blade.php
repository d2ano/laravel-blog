@extends('master')

@section('content')
<div class="deletePost">
    <article class="post delete">
        <form action="{{ route('post.destroy' , $post->id) }}" method="post">
            @csrf
            @method('DELETE')

            <div class="deleteHeader">
                <h1>Chceš vymazať tento článok?</h1>
            </div>
            
            @if ( $post->cover )
             <div class="postImageBackgtound">
                <img class="postImage" src="{{ asset($post->cover->path) }}" alt="">
            </div> 
            @endif
            <div class="postHeadingAndTime">
                <h1 class="postHeading">
                    {{ $post->title }}
                </h1>
                <time class="postTime">
                    {{ $post->date }}
                </time>    
            </div>
                <p class="postText">
                    {!! $post->text !!}
                </p>
                <p class="postAutor">
                    autor: <a href="">{{ $post->user->email }}</a>
                </p>
        
            <div class="deleteLinks">
                <button type="submit" class="deleteLinkTool">vymazať</button>
                <a class="deleteLinkHome" href="{{ route('home') }}">naspäť</a>
            </div>
            
        </form>
    </article>
</div>
@endsection