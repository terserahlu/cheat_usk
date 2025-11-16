@extends('layouts.app')
@section('title', 'Buat Pesanan')
@section('content')
<div class="page-header">
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
        <a href="{{ route('orderan.index') }}" style="background: #E0E0E0; color: #2c3e50; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;" onmouseover="this.style.background='#D4DED0';" onmouseout="this.style.background='#E0E0E0';">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>
    <h2>Buat Pesanan Baru</h2>
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

<div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 30px; max-width: 800px;">
    <form action="{{ route('orderan.store') }}" method="POST" id="orderForm">
        @csrf
        
        <h3 style="margin-bottom: 20px; color: #2c3e50; border-bottom: 2px solid #FAF9EE; padding-bottom: 10px;">Data Pelanggan</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Nama Pelanggan <span style="color: #e74c3c;">*</span></label>
                <input type="text" name="namapelanggan" value="{{ old('namapelanggan') }}" 
                       style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem;"
                       placeholder="Nama pelanggan" required>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Jenis Kelamin <span style="color: #e74c3c;">*</span></label>
                <select name="jeniskelamin" style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem; background: white;" required>
                    <option value="">Pilih</option>
                    <option value="0" {{ old('jeniskelamin') == '0' ? 'selected' : '' }}>Perempuan</option>
                    <option value="1" {{ old('jeniskelamin') == '1' ? 'selected' : '' }}>Laki-laki</option>
                </select>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">No. HP</label>
                <input type="text" name="nohp" value="{{ old('nohp') }}" 
                       style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem;"
                       placeholder="081234567890">
            </div>
        </div>
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Alamat</label>
            <textarea name="alamat" rows="2" style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem; resize: vertical;"
                      placeholder="Alamat pelanggan">{{ old('alamat') }}</textarea>
        </div>
        
        <h3 style="margin: 30px 0 20px 0; color: #2c3e50; border-bottom: 2px solid #FAF9EE; padding-bottom: 10px;">Pilih Meja & Menu</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Meja <span style="color: #e74c3c;">*</span></label>
                <select name="id_meja" id="id_meja" style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem; background: white;" required>
                    <option value="">Pilih Meja</option>
                    @foreach(\App\Models\Meja::where('status', 'tersedia')->get() as $meja)
                        <option value="{{ $meja->id }}">{{ $meja->nomer_meja }} ({{ $meja->kursi }} kursi)</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div id="menuContainer">
            <div class="menu-item" style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 15px; align-items: end; margin-bottom: 15px; padding: 15px; background: #FAF9EE; border-radius: 8px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Menu <span style="color: #e74c3c;">*</span></label>
                    <select name="orders[0][id_menu]" style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem; background: white;" required>
                        <option value="">Pilih Menu</option>
                        @foreach(\App\Models\Menu::all() as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->namamenu }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Jumlah</label>
                    <input type="number" name="orders[0][jumlah]" value="1" min="1" 
                           style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem;" required>
                </div>
                <div>
                    <button type="button" onclick="removeMenu(this)" style="padding: 12px; background: #e74c3c; color: white; border: none; border-radius: 8px; cursor: pointer;">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <button type="button" onclick="addMenu()" style="background: #A2AF9B; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; margin-bottom: 20px;">
            <i class="fa-solid fa-plus"></i> Tambah Menu
        </button>
        
        <div style="display: flex; gap: 12px; margin-top: 30px;">
            <button type="submit" style="flex: 1; background: #A2AF9B; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                <i class="fa-solid fa-save"></i> Simpan Pesanan
            </button>
            <a href="{{ route('orderan.index') }}" style="flex: 1; background: #E0E0E0; color: #2c3e50; padding: 12px 24px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fa-solid fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
let menuIndex = 1;
function addMenu() {
    const container = document.getElementById('menuContainer');
    const newMenu = document.createElement('div');
    newMenu.className = 'menu-item';
    newMenu.style.cssText = 'display: grid; grid-template-columns: 2fr 1fr auto; gap: 15px; align-items: end; margin-bottom: 15px; padding: 15px; background: #FAF9EE; border-radius: 8px;';
    newMenu.innerHTML = `
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Menu <span style="color: #e74c3c;">*</span></label>
            <select name="orders[${menuIndex}][id_menu]" style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem; background: white;" required>
                <option value="">Pilih Menu</option>
                @foreach(\App\Models\Menu::all() as $menu)
                    <option value="{{ $menu->id }}">{{ $menu->namamenu }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Jumlah</label>
            <input type="number" name="orders[${menuIndex}][jumlah]" value="1" min="1" 
                   style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem;" required>
        </div>
        <div>
            <button type="button" onclick="removeMenu(this)" style="padding: 12px; background: #e74c3c; color: white; border: none; border-radius: 8px; cursor: pointer;">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newMenu);
    menuIndex++;
}

function removeMenu(btn) {
    const items = document.querySelectorAll('.menu-item');
    if (items.length > 1) {
        btn.closest('.menu-item').remove();
    } else {
        alert('Minimal harus ada 1 menu');
    }
}
</script>
@endsection
