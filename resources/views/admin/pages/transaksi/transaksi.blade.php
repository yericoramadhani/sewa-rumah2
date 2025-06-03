@extends('admin.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    <div class="mb-3 d-flex align-items-center gap-3">
        <div class="col-md-6">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari rumah berdasarkan nama, type, atau deskripsi...">
        </div>
        <div class="d-flex justify-content-between align-items-center ">
            {{-- <h3 class="mb-0">Pencarian Rumah</h3> --}}
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal"><i class="fa fa-filter me-1"></i>Filter</button>
        </div>
    </div>
    <div class="row" id="cardContainer">
        @foreach($lapangan as $item)
        <div class="col-md-4 mb-4 card-item"
            data-nama="{{ strtolower($item->rumah) }}"
            data-type="{{ strtolower($item->type) }}"
            data-harga="{{ $item->harga }}"
            data-lt="{{ $item->luas_tanah }}"
            data-lb="{{ $item->luas_bangunan }}"
            data-kt="{{ $item->jumlah_kamar }}"
            data-km="{{ $item->jumlah_kamar_mandi }}"
        >
            <div class="card h-100 shadow-sm border-0 position-relative">
                @if($item->gambar)
                <img src="{{ asset($item->gambar) }}" class="card-img-top" alt="{{ $item->rumah }}" style="height:220px;object-fit:cover;border-radius:12px 12px 0 0;">
                @else
                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:220px;color:white;border-radius:12px 12px 0 0;">Tidak ada gambar</div>
                @endif
                <div class="card-body pt-3">
                    <div class="mb-1" style="font-size:1.2rem;font-weight:700;color:#6f42c1;">{{ $item->rumah }}</div>
                    <div class="mb-2" style="font-size:1.5rem;font-weight:800;color:#6f42c1;">Rp {{ number_format($item->harga,0,',','.') }}</div>
                    <div class="mb-1" style="font-size:15px;font-weight:500;">{{ $item->deskripsi ?? '-' }}</div>
                    <div class="mb-2 text-secondary" style="font-size:13px;">
                        LT {{ $item->luas_tanah ?? '-' }} m² &nbsp; - &nbsp; LB {{ $item->luas_bangunan ?? '-' }} m² &nbsp; - &nbsp; KM {{ $item->jumlah_kamar_mandi ?? '-' }} &nbsp; - &nbsp; KT {{ $item->jumlah_kamar ?? '-' }}
                    </div>
                    <div class="mb-1">
                        <span class="badge {{ $item->status == 'tersedia' ? 'bg-success' : 'bg-danger' }} me-1" style="font-size:13px;">Status: {{ ucfirst($item->status) }}</span>
                        <span class="badge {{ $item->garasi == 'ada' ? 'bg-success' : 'bg-danger' }}" style="font-size:13px;">Garasi: {{ ucfirst($item->garasi) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div id="noResult" class="text-center text-danger fw-bold" style="display:none;">Tidak ada rumah yang sesuai...</div>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-end modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">Filter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Urutkan</label><br>
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-secondary sort-btn" data-sort="harga-desc">Harga Tertinggi</button>
            <button type="button" class="btn btn-outline-secondary sort-btn" data-sort="harga-asc">Harga Terendah</button>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Harga</label>
          <div class="row g-2 align-items-center">
            <div class="col">
              <input type="text" class="form-control format-rupiah" id="hargaMin" placeholder="Rp Minimum">
            </div>
            <div class="col-auto">-</div>
            <div class="col">
              <input type="text" class="form-control format-rupiah" id="hargaMax" placeholder="Rp Maksimum">
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Luas Tanah</label>
          <div class="row g-2 align-items-center">
            <div class="col">
              <input type="number" class="form-control" id="ltMin" placeholder="Minimum m²">
            </div>
            <div class="col-auto">-</div>
            <div class="col">
              <input type="number" class="form-control" id="ltMax" placeholder="Maksimum m²">
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Luas Bangunan</label>
          <div class="row g-2 align-items-center">
            <div class="col">
              <input type="number" class="form-control" id="lbMin" placeholder="Minimum m²">
            </div>
            <div class="col-auto">-</div>
            <div class="col">
              <input type="number" class="form-control" id="lbMax" placeholder="Maksimum m²">
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Kamar Tidur</label><br>
          <div class="btn-group" role="group" id="ktGroup">
            <button type="button" class="btn btn-outline-secondary kt-btn" data-kt="1">1+</button>
            <button type="button" class="btn btn-outline-secondary kt-btn" data-kt="2">2+</button>
            <button type="button" class="btn btn-outline-secondary kt-btn" data-kt="3">3+</button>
            <button type="button" class="btn btn-outline-secondary kt-btn" data-kt="4">4+</button>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Kamar Mandi</label><br>
          <div class="btn-group" role="group" id="kmGroup">
            <button type="button" class="btn btn-outline-secondary km-btn" data-km="1">1+</button>
            <button type="button" class="btn btn-outline-secondary km-btn" data-km="2">2+</button>
            <button type="button" class="btn btn-outline-secondary km-btn" data-km="3">3+</button>
            <button type="button" class="btn btn-outline-secondary km-btn" data-km="4">4+</button>
          </div>
        </div>
        {{-- <div class="mb-3">
          <label class="form-label">Jumlah Lantai</label><br>
          <div class="btn-group" role="group" id="lantaiGroup">
            <button type="button" class="btn btn-outline-secondary lantai-btn" data-lantai="1">1+</button>
            <button type="button" class="btn btn-outline-secondary lantai-btn" data-lantai="2">2+</button>
            <button type="button" class="btn btn-outline-secondary lantai-btn" data-lantai="3">3+</button>
            <button type="button" class="btn btn-outline-secondary lantai-btn" data-lantai="4">4+</button>
          </div>
        </div> --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="applyFilter">Terapkan</button>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<script>
// Format harga input dengan titik ribuan
function formatRupiah(angka) {
    let number_string = angka.replace(/[^\d]/g, ''),
        sisa = number_string.length % 3,
        rupiah = number_string.substr(0, sisa),
        ribuan = number_string.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    return rupiah;
}
document.querySelectorAll('.format-rupiah').forEach(function(input) {
    input.addEventListener('input', function(e) {
        let value = input.value.replace(/\./g, '');
        input.value = formatRupiah(value);
    });
});

// Filter logic
let sortType = null, ktMin = null, kmMin = null, lantaiMin = null;
document.querySelectorAll('.sort-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.sort-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        sortType = btn.getAttribute('data-sort');
    });
});
document.querySelectorAll('.kt-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.kt-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        ktMin = parseInt(btn.getAttribute('data-kt'));
    });
});
document.querySelectorAll('.km-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.km-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        kmMin = parseInt(btn.getAttribute('data-km'));
    });
});
document.querySelectorAll('.lantai-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.lantai-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        lantaiMin = parseInt(btn.getAttribute('data-lantai'));
    });
});

function applyAllFilters() {
    const hargaMin = parseInt(document.getElementById('hargaMin')?.value.replace(/\./g, '')) || 0;
    const hargaMax = parseInt(document.getElementById('hargaMax')?.value.replace(/\./g, '')) || 99999999999;
    const ltMin = parseInt(document.getElementById('ltMin')?.value) || 0;
    const ltMax = parseInt(document.getElementById('ltMax')?.value) || 999999999;
    const lbMin = parseInt(document.getElementById('lbMin')?.value) || 0;
    const lbMax = parseInt(document.getElementById('lbMax')?.value) || 999999999;
    const search = document.getElementById('searchInput').value.toLowerCase();
    const cardItems = document.querySelectorAll('.card-item');
    let visibleCount = 0;
    let cards = Array.from(cardItems);
    cards.forEach(card => {
        const nama = card.getAttribute('data-nama');
        const type = card.getAttribute('data-type');
        const harga = parseInt(card.getAttribute('data-harga'));
        const lt = parseInt(card.getAttribute('data-lt'));
        const lb = parseInt(card.getAttribute('data-lb'));
        const kt = parseInt(card.getAttribute('data-kt'));
        const km = parseInt(card.getAttribute('data-km'));
        let show = true;
        if (search && !(nama.includes(search) || type.includes(search))) show = false;
        if (harga < hargaMin || harga > hargaMax) show = false;
        if (lt < ltMin || lt > ltMax) show = false;
        if (lb < lbMin || lb > lbMax) show = false;
        if (ktMin && kt < ktMin) show = false;
        if (kmMin && km < kmMin) show = false;
        card.style.display = show ? '' : 'none';
        if (show) visibleCount++;
    });
    // Sorting
    if (sortType) {
        cards.sort((a, b) => {
            let va = parseInt(a.getAttribute('data-harga'));
            let vb = parseInt(b.getAttribute('data-harga'));
            if (sortType === 'harga-desc') return vb - va;
            if (sortType === 'harga-asc') return va - vb;
            return 0;
        });
        const container = document.getElementById('cardContainer');
        cards.forEach(card => container.appendChild(card));
    }
    document.getElementById('noResult').style.display = visibleCount === 0 ? '' : 'none';
}

document.getElementById('searchInput').addEventListener('input', applyAllFilters);
document.getElementById('applyFilter').addEventListener('click', function() {
    applyAllFilters();
    var modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
    modal.hide();
});
</script>
@endsection