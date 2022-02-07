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
<div class="editPost">
    <form class="editPostForm" action="{{ route('post.update' , $post->id ) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input class="titleEditInput" type="text" name="title" placeholder="Nadpis" value="{{ $post->title }}">
        <textarea class="textEditInput" name="text" cols="30" rows="12" placeholder="Sem napíš text..." >{{ $post->text }}</textarea>
        <div class="editCheckbox">
        @foreach ($tags as $tag)
            <label>
                @if ( isset($tag['status']))
                    <input type="checkbox" name="tag[]" value="{{ $tag['id'] }}" checked>
                @else
                    <input type="checkbox" name="tag[]" value="{{ $tag['id'] }}">
                @endif
                {{ $tag['title'] }}
            </label>
        @endforeach
        </div>
        @if ( $post->cover )
        <div class="editImgBackground">
            <img class="editImg" src="{{ asset($post->cover->path) }}">
        </div>
        <label class="editCheckBackground">
            <input class="editCheck" type="checkbox" name="delete_image">
            Odstrániť obrázok z článku?
        </label>
        @endif
        <input class="fileInput" type="file" name="image">
        <div class="editLinks">
            <button type="submit" class="editLinkTool">upraviť</button>
            <a class="editLinkHome" href="{{ route('post.show' , $post->id) }}">naspäť</a>
        </div>
    </form>
</div>
@endsection