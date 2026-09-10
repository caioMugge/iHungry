@extends('layouts.master')

@section('content')

<header>
    <a href="{{ route('users.create') }}">
        Cadastrar
    </a>
</header>

<hr>

<h2>Home</h2>

@endsection
