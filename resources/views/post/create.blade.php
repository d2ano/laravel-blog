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

    <div class="createPost">
        <form class="createPostForm" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input class="titleCreateInput" type="text" name="title" placeholder="Nadpis" value="{{ old('title') }}">
            <textarea class="textCreateInput" name="text" cols="30" rows="12" placeholder="Sem napíš text...">{{ old('text') }}</textarea>
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
            <input class="fileInput" type="file" name="image" value="{{ old('image') }}">
            <div class="createLinks">
                <button type="submit" class="createLinkTool">pridať</button>
                <a class="createLinkHome" href="{{ route('home') }}">naspäť</a>
            </div>
            {{ old('image') }}
        </form>
    </div>

@endsection