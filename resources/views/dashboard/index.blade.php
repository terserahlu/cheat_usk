@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="page-header">
        <h2>Dashboard</h2>
        <p>Selamat datang, {{ auth()->user()->name ?? auth()->user()->username }}! Kamu login sebagai <span style="color: #A2AF9B; font-weight: 600;">{{ ucfirst(auth()->user()->role) }}</span></p>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: #D1FAE5; border: 1px solid #6EE7B7; color: #065F46; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('failed'))
        <div class="alert alert-danger" style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('failed') }}
        </div>
    @endif
@endsection