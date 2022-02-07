@extends('master')

@section('content')
    
        <div class="allPosts">

            <div class="mainHead">
                <h1>{{ $mainHead }}</h1>
            </div>


            @forelse ($posts as $post)

            <article class="posts">
                @if ($post->cover)
                <a href="{{ route('post.show' , $post->id ) }}" class="postImageLink">
                    <img class="postsImage" src="{{ asset($post->cover->path) }}">
                </a>
                @endif
                    <h1 class="postsHeading">
                        <a href="{{ route('post.show' , $post->id ) }}">{{ $post->title }}</a>
                    </h1>
                    <p class="postsText">
                        {!! nl2br(e($post->teaser)) !!}
                    </p>
                    <a class="postsMore" href="{{ route('post.show' , $post->id ) }}">Viac</a>
            </article>

            @empty

            <p class="nothing">havent got item</p>

            @endforelse

        </div>
@endsection