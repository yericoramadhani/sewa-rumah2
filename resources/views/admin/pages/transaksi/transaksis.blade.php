@extends('admin.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h3 class="mb-4">Pencarian Rumah</h3>
    <div class="mb-3 row">
        <div class="col-md-6">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari rumah berdasarkan nama, ukuran, atau tipe...">
        </div>
        <div class="col-md-3">
            <select id="ukuranFilter" class="form-select">
                <option value="">Semua Ukuran</option>
                @php
                    $ukuranList = $lapangan->pluck('ukuran')->unique();
                @endphp
                @foreach($ukuranList as $ukuran)
                    <option value="{{ $ukuran }}">{{ $ukuran }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row" id="cardContainer">
        @foreach($lapangan as $item)
        <div class="col-md-4 mb-4 card-item" data-nama="{{ strtolower($item->rumah) }}" data-ukuran="{{ strtolower($item->ukuran) }}" data-tipe="{{ strtolower($item->type) }}">
            <div class="card h-100">
                @if($item->gambar)
                <img src="{{ asset($item->gambar) }}" class="card-img-top" alt="{{ $item->rumah }}" style="height:200px;object-fit:cover;">
                @else
                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:200px;color:white;">Tidak ada gambar</div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->rumah }}</h5>
                    <p class="card-text mb-1"><strong>Ukuran:</strong> {{ $item->ukuran }}</p>
                    <p class="card-text mb-1"><strong>Tipe:</strong> {{ $item->type }}</p>
                    <p class="card-text mb-1"><strong>Harga:</strong> Rp{{ number_format($item->harga,0,',','.') }}</p>
                    <p class="card-text"><strong>Status:</strong> {{ ucfirst($item->status) }}</p>
                    <p class="card-text">{{ $item->deskripsi }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div id="noResult" class="text-center text-danger fw-bold" style="display:none;">Tidak ada rumah yang sesuai...</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const ukuranFilter = document.getElementById('ukuranFilter');
        const cardItems = document.querySelectorAll('.card-item');
        const noResult = document.getElementById('noResult');

        function filterCards() {
            const search = searchInput.value.toLowerCase();
            const ukuran = ukuranFilter.value.toLowerCase();
            let visibleCount = 0;
            cardItems.forEach(card => {
                const nama = card.getAttribute('data-nama');
                const cardUkuran = card.getAttribute('data-ukuran');
                const tipe = card.getAttribute('data-tipe');
                const matchSearch = nama.includes(search) || cardUkuran.includes(search) || tipe.includes(search);
                const matchUkuran = !ukuran || cardUkuran === ukuran;
                if (matchSearch && matchUkuran) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            noResult.style.display = visibleCount === 0 ? '' : 'none';
        }
        searchInput.addEventListener('input', filterCards);
        ukuranFilter.addEventListener('change', filterCards);
    });
</script>
@endsection