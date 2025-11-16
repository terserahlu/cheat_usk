@extends('layouts.app')
@section('title', 'Buat Transaksi')
@section('content')
<div class="page-header">
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
        <a href="{{ route('transaksi.index') }}" style="background: #E0E0E0; color: #2c3e50; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;" onmouseover="this.style.background='#D4DED0';" onmouseout="this.style.background='#E0E0E0';">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>
    <h2>Buat Transaksi</h2>
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

@php
    use App\Models\Orderan;
    use App\Models\User;
    $orderans = Orderan::with(['menu', 'pelanggan', 'meja'])->whereDoesntHave('transaksi')->get();
    $kasirs = User::where('role', 'kasir')->orWhere('role', 'admin')->get();
    
    // Group orderan by pelanggan
    $groupedOrderans = $orderans->groupBy(function ($orderan) {
        return $orderan->idpelaggan;
    })->map(function ($group) {
        $firstOrderan = $group->first();
        $pelanggan = $firstOrderan->pelanggan;
        
        return [
            'id_pelanggan' => $pelanggan->id ?? null,
            'pelanggan' => $pelanggan,
            'orderans' => $group,
            'total_semua' => $group->sum(function ($orderan) {
                return ($orderan->menu->harga ?? 0) * $orderan->jumlah;
            }),
        ];
    })->values();
@endphp

<div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 30px; max-width: 1000px;">
    <form action="{{ route('transaksi.store') }}" method="POST" id="transaksiForm">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Pilih Orderan <span style="color: #e74c3c;">*</span></label>
            @if($groupedOrderans->count() > 0)
                <div style="max-height: 500px; overflow-y: auto;">
                    @foreach($groupedOrderans as $groupIndex => $group)
                    <div style="border: 2px solid #D4DED0; border-radius: 8px; padding: 16px; margin-bottom: 16px; background: #FAF9EE;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #D4DED0;">
                            <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                                <label style="display: flex; align-items: center; cursor: pointer; margin: 0;">
                                    <input type="checkbox" 
                                           class="group-checkbox" 
                                           data-group="{{ $groupIndex }}"
                                           onchange="toggleGroup({{ $groupIndex }})"
                                           style="width: 18px; height: 18px; cursor: pointer; flex-shrink: 0; margin-right: 12px;">
                                    <div>
                                        <h4 style="color: #2c3e50; margin: 0; font-size: 1rem; font-weight: 600;">
                                            {{ $group['pelanggan']->namapelanggan ?? 'Pelanggan Tidak Diketahui' }}
                                        </h4>
                                        @if(isset($group['pelanggan']->nohp))
                                            <p style="color: #7f8c8d; font-size: 0.85rem; margin: 4px 0 0 0;">
                                                Telp: {{ $group['pelanggan']->nohp }}
                                            </p>
                                        @endif
                                    </div>
                                </label>
                            </div>
                            <div style="font-weight: 600; color: #A2AF9B;">
                                Total: Rp {{ number_format($group['total_semua'], 0, ',', '.') }}
                            </div>
                        </div>
                        
                        @foreach($group['orderans'] as $orderan)
                        <label style="display: flex; align-items: center; padding: 12px; margin-bottom: 8px; background: white; border-radius: 6px; cursor: pointer; transition: all 0.2s; border: 1px solid #EEEEEE;"
                               onmouseover="this.style.borderColor='#A2AF9B'; this.style.boxShadow='0 2px 4px rgba(162,175,155,0.1)';"
                               onmouseout="this.style.borderColor='#EEEEEE'; this.style.boxShadow='none';">
                            <input type="checkbox" name="orderans[]" value="{{ $orderan->id }}" 
                                   class="orderan-checkbox group-{{ $groupIndex }}-checkbox" 
                                   onchange="calculateTotal(); updateGroupCheckbox({{ $groupIndex }});"
                                   style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer; flex-shrink: 0;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #2c3e50; margin-bottom: 4px;">{{ $orderan->menu->namamenu ?? 'Menu tidak ditemukan' }}</div>
                                <div style="font-size: 0.85rem; color: #7f8c8d;">
                                    Meja: {{ $orderan->meja->nomer_meja ?? 'N/A' }} | 
                                    Jumlah: {{ $orderan->jumlah }} | 
                                    Harga: Rp {{ number_format($orderan->menu->harga ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div style="font-weight: 600; color: #A2AF9B; margin-left: 12px; flex-shrink: 0;">
                                Rp {{ number_format(($orderan->menu->harga ?? 0) * $orderan->jumlah, 0, ',', '.') }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                <small style="color: #7f8c8d; margin-top: 8px; display: block;">
                    <i class="fa-solid fa-info-circle"></i> Pilih satu atau lebih orderan untuk ditransaksikan. Orderan dikelompokkan berdasarkan pelanggan.
                </small>
            @else
                <div style="padding: 20px; text-align: center; background: #FAF9EE; border-radius: 8px; color: #7f8c8d;">
                    <i class="fa-solid fa-info-circle" style="margin-right: 8px;"></i>
                    Tidak ada orderan yang tersedia untuk ditransaksikan
                </div>
            @endif
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Total Harga</label>
            <div id="totalHarga" style="padding: 12px; background: #FAF9EE; border-radius: 8px; font-size: 1.2rem; font-weight: 600; color: #2c3e50;">
                Rp 0
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Jumlah Bayar <span style="color: #e74c3c;">*</span></label>
            <input type="text" name="bayar" id="bayar" value="{{ old('bayar') }}"
                   pattern="[0-9]*" inputmode="numeric"
                   style="width: 100%; padding: 12px; border: 2px solid #D4DED0; border-radius: 8px; font-size: 1rem; transition: all 0.3s;"
                   onfocus="this.style.borderColor='#A2AF9B'; this.style.boxShadow='0 0 0 3px rgba(162,175,155,0.1)';"
                   onblur="this.style.borderColor='#D4DED0'; this.style.boxShadow='none';"
                   oninput="formatNumber(this); calculateKembalian();"
                   placeholder="Masukkan jumlah pembayaran (contoh: 25000)" required>
            <small style="color: #7f8c8d; margin-top: 4px; display: block;">Masukkan angka tanpa titik atau koma (contoh: 25000)</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Kembalian</label>
            <div id="kembalian" style="padding: 12px; background: #D1FAE5; border-radius: 8px; font-size: 1.2rem; font-weight: 600; color: #065F46;">
                Rp 0
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 30px;">
            <button type="submit" style="flex: 1; background: #A2AF9B; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
                    onmouseover="this.style.background='#8FA088'; this.style.transform='translateY(-2px)';"
                    onmouseout="this.style.background='#A2AF9B'; this.style.transform='translateY(0)';">
                <i class="fa-solid fa-save"></i> Simpan Transaksi
            </button>
            <a href="{{ route('transaksi.index') }}" style="flex: 1; background: #E0E0E0; color: #2c3e50; padding: 12px 24px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fa-solid fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
    let orderanData = {
        @foreach($orderans as $orderan)
        {{ $orderan->id }}: {
            harga: {{ $orderan->menu->harga ?? 0 }},
            jumlah: {{ $orderan->jumlah }},
            subtotal: {{ ($orderan->menu->harga ?? 0) * $orderan->jumlah }}
        },
        @endforeach
    };

    function formatNumber(input) {
        // Hanya izinkan angka
        input.value = input.value.replace(/[^0-9]/g, '');
    }

    function toggleGroup(groupIndex) {
        let groupCheckbox = document.querySelector(`.group-checkbox[data-group="${groupIndex}"]`);
        let checkboxes = document.querySelectorAll(`.group-${groupIndex}-checkbox`);
        let isChecked = groupCheckbox.checked;
        
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
        
        calculateTotal();
    }

    function updateGroupCheckbox(groupIndex) {
        let checkboxes = document.querySelectorAll(`.group-${groupIndex}-checkbox`);
        let groupCheckbox = document.querySelector(`.group-checkbox[data-group="${groupIndex}"]`);
        let allChecked = true;
        let anyChecked = false;
        
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                anyChecked = true;
            } else {
                allChecked = false;
            }
        });
        
        // Set group checkbox to checked if all are checked, unchecked if none are checked, indeterminate if some are checked
        if (allChecked) {
            groupCheckbox.checked = true;
            groupCheckbox.indeterminate = false;
        } else if (anyChecked) {
            groupCheckbox.checked = false;
            groupCheckbox.indeterminate = true;
        } else {
            groupCheckbox.checked = false;
            groupCheckbox.indeterminate = false;
        }
    }

    function calculateTotal() {
        let checkboxes = document.querySelectorAll('.orderan-checkbox:checked');
        let total = 0;
        
        checkboxes.forEach(function(checkbox) {
            let orderanId = parseInt(checkbox.value);
            if (orderanData[orderanId]) {
                total += orderanData[orderanId].subtotal;
            }
        });
        
        document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        calculateKembalian();
    }

    function calculateKembalian() {
        let totalText = document.getElementById('totalHarga').textContent;
        let total = parseInt(totalText.replace(/[^\d]/g, '')) || 0;
        let bayarInput = document.getElementById('bayar');
        let bayar = parseInt(bayarInput.value.replace(/[^\d]/g, '')) || 0;
        let kembalian = bayar - total;
        
        if (kembalian >= 0) {
            document.getElementById('kembalian').style.background = '#D1FAE5';
            document.getElementById('kembalian').style.color = '#065F46';
        } else {
            document.getElementById('kembalian').style.background = '#FEE2E2';
            document.getElementById('kembalian').style.color = '#991B1B';
        }
        
        document.getElementById('kembalian').textContent = 'Rp ' + Math.abs(kembalian).toLocaleString('id-ID') + (kembalian < 0 ? ' (Kurang)' : '');
    }

    document.getElementById('transaksiForm').addEventListener('submit', function(e) {
        let checkboxes = document.querySelectorAll('.orderan-checkbox:checked');
        if (checkboxes.length === 0) {
            e.preventDefault();
            alert('Pilih minimal satu orderan!');
            return false;
        }
        
        // Pastikan nilai bayar adalah angka valid
        let bayarInput = document.getElementById('bayar');
        let bayar = parseInt(bayarInput.value.replace(/[^\d]/g, '')) || 0;
        if (bayar <= 0) {
            e.preventDefault();
            alert('Jumlah bayar harus lebih dari 0!');
            return false;
        }
    });

    // Initialize group checkboxes on page load
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($groupedOrderans as $groupIndex => $group)
        updateGroupCheckbox({{ $groupIndex }});
        @endforeach
    });
</script>
@endsection

