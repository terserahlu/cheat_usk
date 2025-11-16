@extends('layouts.app')
@section('title', 'Tambah Meja')
@section('content')
<div class="page-header">
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
        <a href="{{ route('meja.index') }}" style="background: #E0E0E0; color: #2c3e50; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;" onmouseover="this.style.background='#D4DED0';" onmouseout="this.style.background='#E0E0E0';">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>
    <h2>Tambah Meja</h2>
</div>

@if($errors->any())
    <div class="alert alert-danger" style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 30px; max-width: 600px;">
    <form action="{{ route('meja.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Nomor Meja <span style="color: #e74c3c;">*</span></label>
            <input type="text" name="nomer_meja" value="{{ old('nomer_meja') }}" 
                   style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem; transition: all 0.3s;"
                   onfocus="this.style.borderColor='#A2AF9B'; this.style.boxShadow='0 0 0 3px rgba(162,175,155,0.1)';"
                   onblur="this.style.borderColor='#D4DED0'; this.style.boxShadow='none';"
                   placeholder="Contoh: M01" required>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Jumlah Kursi <span style="color: #e74c3c;">*</span></label>
            <select name="kursi" 
                    style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem; transition: all 0.3s; background: white;"
                    onfocus="this.style.borderColor='#A2AF9B'; this.style.boxShadow='0 0 0 3px rgba(162,175,155,0.1)';"
                    onblur="this.style.borderColor='#D4DED0'; this.style.boxShadow='none';"
                    required>
                <option value="">Pilih Jumlah Kursi</option>
                <option value="2" {{ old('kursi') == '2' ? 'selected' : '' }}>2 Kursi</option>
                <option value="4" {{ old('kursi') == '4' ? 'selected' : '' }}>4 Kursi</option>
                <option value="8" {{ old('kursi') == '8' ? 'selected' : '' }}>8 Kursi</option>
            </select>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 30px;">
            <button type="submit" style="flex: 1; background: #A2AF9B; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
                    onmouseover="this.style.background='#8FA088'; this.style.transform='translateY(-2px)';"
                    onmouseout="this.style.background='#A2AF9B'; this.style.transform='translateY(0)';">
                <i class="fa-solid fa-save"></i> Simpan
            </button>
            <a href="{{ route('meja.index') }}" style="flex: 1; background: #E0E0E0; color: #2c3e50; padding: 12px 24px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fa-solid fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

