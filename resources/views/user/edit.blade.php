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
    <div class="showUser">
        <div class="content">
        @if ( $user->avatar )
            <img src="{{ asset($user->avatar->path) }}" alt="">
            @endif
            <form action="{{ route('user.update' , $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="email" name="email" value="{{ $user->email }}" disabled>
                <input type="password" name="password" placeholder="password">
                <input type="password" name="password_confirmation" placeholder="confirm password">
                @if ($user->avatar)
                <label class="userCheckLabel">
                    <input class="userCheck" type="checkbox" name="delete_image">
                    Odstrániť obrázok z článku?
                </label>
                @endif
                
                <input class="fileInput" type="file" name="avatar">
                <div class="editLinks">
                    <button type="submit" class="editLinkTool">upraviť</button>
                    <a class="editLinkHome" href="{{ route('user.show' , Auth::user()->id) }}">naspäť</a>
                </div>
            </form>
        </div>
    </div>
@endsection