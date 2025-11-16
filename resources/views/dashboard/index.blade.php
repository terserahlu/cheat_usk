@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <h1 class="logo-text">Welcome to Restoran App, {{ auth()->user()->nama }}</h2>
    <p class="logo-text">You are logged in as {{ auth()->user()->role }}</p>
@endsection