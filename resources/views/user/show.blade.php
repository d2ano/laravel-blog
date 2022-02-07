@extends('master')

@section('content')
    <div class="showUser">
        <div class="content">
            @if ( $user->avatar )
            <img src="{{ asset($user->avatar->path) }}" alt="">
            @endif
            <h1>{{ $user->email }}</h1>
            <div class="userLink">
                <a class="backLink btn" href="{{ url()->previous() }}">naspäť</a>
                @can('update', $user)
                <a class="toolLink btn" href="{{ route('user.edit' , $user->id) }}">upraviť</a>
                @endcan
            </div>
        </div>
    </div>
@endsection