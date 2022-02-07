<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <title>Laravel</title>

    </head>
    <body>
        
        @auth
        <div class="authorNav">
            <ul>
                <li><a href="{{ route('user.show' , Auth::user()->id) }}">{{ $user = Auth::user()->email }}</a></li>
                <li><form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Odhlásiť</button>
                </form></li>
            </ul>
        </div>
        @endauth

        
        @auth
        <div class="mainMinNav">
            <a class="mainMinNavMenu" href="">MENU</a>
            <h1><a class="mainMinNavHeading" href="{{ route('home') }}">Blog</a></h1>
        </div>
        <div class="mainNav">
            <ul>
                <li><a href="{{ route('home') }}">Všetky príspevky</a></li>
                <li><a href="{{ route('tag.index') }}">Kategórie</a></li>
                <li><a href="{{ route('post.user' , Auth::user()->id) }}">Moje príspevky</a></li>
                <li><a href="{{ route('post.create') }}">Pridať nový príspevok</a></li>
            </ul>
        </div>
        @endauth
        
        

        @if ( session()->has('message') )
            <p class="alert alert-success" id="flash">{{ ucfirst( session('message').'.' ) }}</p>
        @endif
        
        @yield('content')
    </body>
    
    @auth
    <footer class="mainFooter">
        <p>created by me, bro...všetko je vyhradené, všetko..</p>
    </footer>
    @endauth
    
   

    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="{{ asset('js/main.js') }}"></script>
</html>
