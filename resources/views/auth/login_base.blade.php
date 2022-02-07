@extends('master')

@section('content')
<div class="login">
    @if ($errors->any())
    <div class="alert alert-danger" id="flash">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password">
        <div class="loginTool">
            <button type="submit">prihásiť</button>
            <a href="{{ route('register') }}">registrovať</a>
        </div>
    </form>
</div>
@endsection