@extends('master')

@section('content')
    <div class="allTags">
        <div class="allTagsContainer">
            @forelse ($tags as $tag)
            
            <div class="tags">
                <h1 class="tagsHeading">
                    <a href="{{ route('tag.show' , $tag->id) }}">{{ $tag->title }}</a>
                </h1>
            </div>

            @empty

            <p>nemáme žiadne kategórie</p>

            @endforelse
        </div>
        <div></div>
    </div>
@endsection