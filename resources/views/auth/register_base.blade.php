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
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="email" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password">
        <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="confirm password">
        <div class="loginTool">
            <button type="submit">registrovať</button>
            <a href="{{ route('login') }}">prihlásiť</a>
        </div>
    </form>
</div>
@endsection