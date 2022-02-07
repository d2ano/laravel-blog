@extends('master')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger" id="flash">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<div class="showPost">

    <article class="post">
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
                {!! nl2br(e($post->text)) !!}
            </p>
            <p class="postAutor">
                autor: <a href="{{ route('user.show' , $post->user->id) }}">{{ $post->user->email }}</a>
            </p>
            @if ($post->tags)
            <div class="posttags">
                @foreach ($post->tags as $tag)
                    <a href="{{ route('tag.show' , $tag->id) }}">{{ $tag->title }}</a>
                @endforeach
            </div>
            @endif
            
            @if ($post->comments)
            <div class="commentA">
            @foreach ($post->comments as $comment)
            
            <div class="comment" id="{{ $comment->id }}">
                @if ($comment->user->avatar)
                <div class="commentImg">
                    <img src="{{ asset($comment->user->avatar->path) }}" alt="">
                </div>
                @endif
                <div class="commentPost">
                    <div class="commentAuthor">
                        <a href="{{ route('user.show' , $comment->user->id) }}">{{ $comment->user->email }}</a>
                    </div>
                    <div class="commentContent"> 
                        <p>
                            {!! nl2br(e($comment->text)) !!}
                        </p>
                    </div> 
                    @can('delete', $comment)
                    <div class="commentTool">
                        <a href="{{ route('comment.destroy' , $comment->id) }}" class="del">vymazať</a>
                    </div>  
                    <form id="del-{{ $comment->id }}" action="{{ route('comment.destroy' , $comment->id) }}" method="post" style="display: none">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endcan
                </div>
            </div>
            @endforeach
            </div>
            @endif
            
            <div class="commentAdd">
                <form action="{{ route('comment.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <textarea name="text" placeholder="pridaj sem komenár"></textarea>
                    <button type="submit">pridať</button>
                </form>
            </div>
        <div class="postLinks">
            <div class="postLinkHome">
                <a href="{{ url()->previous() }}">naspäť</a>
                
            </div>
            @can('update', $post)
            <div class="postLinkTool">
                <a href="{{ route('post.edit' , $post->id ) }}">upraviť</a>
                <a href="{{ route('post.delete' , $post->id ) }}">vymazať</a>
            </div> 
            @endcan   
        </div>
        
    </article>

</div>
@endsection