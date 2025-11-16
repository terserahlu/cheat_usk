@extends('layouts.app')
@section('title', 'Data Meja')
@section('content')
<div class="page-header">
    <h2>Data Meja</h2>
    <p>Kelola data meja restoran</p>
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

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <a href="{{ route('meja.create') }}" style="background: #A2AF9B; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-plus"></i> Tambah Meja
    </a>
</div>

<div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #FAF9EE; border-bottom: 2px solid #D4DED0;">
                <th style="padding: 16px; text-align: left; font-weight: 600; color: #2c3e50;">No</th>
                <th style="padding: 16px; text-align: left; font-weight: 600; color: #2c3e50;">Nomor Meja</th>
                <th style="padding: 16px; text-align: left; font-weight: 600; color: #2c3e50;">Jumlah Kursi</th>
                <th style="padding: 16px; text-align: left; font-weight: 600; color: #2c3e50;">Status</th>
                <th style="padding: 16px; text-align: left; font-weight: 600; color: #2c3e50;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($meja as $index => $m)
            <tr style="border-bottom: 1px solid #EEEEEE;">
                <td style="padding: 16px;">{{ $index + 1 }}</td>
                <td style="padding: 16px; font-weight: 600;">{{ $m->nomer_meja }}</td>
                <td style="padding: 16px;">{{ $m->kursi }} Kursi</td>
                <td style="padding: 16px;">
                    <span style="padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; 
                        {{ $m->status == 'tersedia' ? 'background: #D1FAE5; color: #065F46;' : 'background: #FEE2E2; color: #991B1B;' }}">
                        {{ ucfirst($m->status) }}
                    </span>
                </td>
                <td style="padding: 16px;">
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('meja.show', $m->id) }}" style="padding: 6px 12px; background: #E3F2FD; color: #1976D2; border-radius: 6px; text-decoration: none; font-size: 0.85rem;">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('meja.edit', $m->id) }}" style="padding: 6px 12px; background: #FFF3E0; color: #F57C00; border-radius: 6px; text-decoration: none; font-size: 0.85rem;">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <form action="{{ route('meja.destroy', $m->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 6px 12px; background: #FFEBEE; color: #C62828; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 40px; text-align: center; color: #7f8c8d;">
                    <i class="fa-solid fa-table" style="font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.5;"></i>
                    Belum ada data meja
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

