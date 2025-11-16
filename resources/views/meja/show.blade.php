@extends('layouts.app')
@section('title', 'Detail Meja')
@section('content')
<div class="page-header">
    <h2>Detail Meja</h2>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span>/</span>
        <a href="{{ route('meja.index') }}">Meja</a>
        <span>/</span>
        <span>Detail</span>
    </div>
</div>

<div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 30px; max-width: 600px;">
    <div style="margin-bottom: 24px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #7f8c8d; font-size: 0.9rem;">Nomor Meja</label>
        <div style="padding: 12px; background: #FAF9EE; border-radius: 8px; font-size: 1.1rem; font-weight: 600; color: #2c3e50;">
            {{ $meja->nomer_meja }}
        </div>
    </div>

    <div style="margin-bottom: 24px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #7f8c8d; font-size: 0.9rem;">Jumlah Kursi</label>
        <div style="padding: 12px; background: #FAF9EE; border-radius: 8px; font-size: 1.1rem; color: #2c3e50;">
            {{ $meja->kursi }} Kursi
        </div>
    </div>

    <div style="margin-bottom: 24px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #7f8c8d; font-size: 0.9rem;">Status</label>
        <div>
            <span style="padding: 8px 16px; border-radius: 8px; font-size: 0.9rem; font-weight: 600; 
                {{ $meja->status == 'tersedia' ? 'background: #D1FAE5; color: #065F46;' : 'background: #FEE2E2; color: #991B1B;' }}">
                {{ ucfirst($meja->status) }}
            </span>
        </div>
    </div>

    <div style="display: flex; gap: 12px; margin-top: 30px;">
        <a href="{{ route('meja.edit', $meja->id) }}" style="flex: 1; background: #A2AF9B; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="fa-solid fa-edit"></i> Edit
        </a>
        <a href="{{ route('meja.index') }}" style="flex: 1; background: #E0E0E0; color: #2c3e50; padding: 12px 24px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection

