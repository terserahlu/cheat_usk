@extends('layouts.app')
@section('title', 'Data Menu')
@section('content')
<div class="page-header">
    <h2>Data Menu</h2>
    <p>Kelola menu makanan dan minuman</p>
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
    <a href="{{ route('menu.create') }}" style="background: #A2AF9B; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-plus"></i> Tambah Menu
    </a>
</div>

<div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #FAF9EE; border-bottom: 2px solid #D4DED0;">
                <th style="padding: 16px; text-align: left; font-weight: 600; color: #2c3e50;">No</th>
                <th style="padding: 16px; text-align: left; font-weight: 600; color: #2c3e50;">Nama Menu</th>
                <th style="padding: 16px; text-align: left; font-weight: 600; color: #2c3e50;">Harga</th>
                <th style="padding: 16px; text-align: left; font-weight: 600; color: #2c3e50;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menu as $index => $m)
            <tr style="border-bottom: 1px solid #EEEEEE;">
                <td style="padding: 16px;">{{ $index + 1 }}</td>
                <td style="padding: 16px; font-weight: 600;">{{ $m->namamenu }}</td>
                <td style="padding: 16px;">Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                <td style="padding: 16px;">
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('menu.show', $m->id) }}" style="padding: 6px 12px; background: #E3F2FD; color: #1976D2; border-radius: 6px; text-decoration: none; font-size: 0.85rem;">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('menu.edit', $m->id) }}" style="padding: 6px 12px; background: #FFF3E0; color: #F57C00; border-radius: 6px; text-decoration: none; font-size: 0.85rem;">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <form action="{{ route('menu.destroy', $m->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
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
                <td colspan="4" style="padding: 40px; text-align: center; color: #7f8c8d;">
                    <i class="fa-solid fa-utensils" style="font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.5;"></i>
                    Belum ada data menu
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

