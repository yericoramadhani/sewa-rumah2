@extends('admin.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card px-4 py-2 tab-pane "  id="navs-pills-top-aktif" role="tabpanel">
        <a href="" class="btn btn-primary my-3"
        style="display: inline-block; width: auto; max-width: fit-content;" data-bs-toggle="modal" data-bs-target="#tambahlapangan" >
        Tambah Data rumah
    </a>
    
    <div class="text-nowrap table-responsive pt-0">
        <table id="myTable" class="datatables-basic table border-top">
            <thead>
                <tr>
                    <th>rumah</th>
                    <th>Deskripsi</th>
                    <th>LB</th>
                    <th>LT</th>
                    <th>JKT</th>
                    <th>JKM</th>
                    <th>garasi</th>
                    <th>type</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>status</th>
                    <th>Aksi</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($lapangan as $item)
                    <tr>
                        <td>{{ $item->rumah  }}</td>
                        <td>{{ $item->deskripsi  }}</td>
                        <td>{{ $item->luas_bangunan }}</td>
                        <td>{{ $item->luas_tanah }}</td>
                        <td>{{ $item->jumlah_kamar }}</td>
                        <td>{{ $item->jumlah_kamar_mandi }}</td>
                        <td>
                            <span class="badge {{ $item->garasi == 'ada' ? 'bg-success' : 'bg-danger' }}" style="color:white;">{{ ucfirst($item->garasi) }}</span>
                        </td>
                        <td>{{ $item->type  }}</td>
                        <td>{{ $item->harga }}</td>
                        <td><img style="width: 170px;" src="/{{ $item->gambar }}" alt=""></td>
                        <td>
                            <span class="badge {{ $item->status == 'tersedia' ? 'bg-success' : 'bg-danger' }}" style="color:white;">{{ ucfirst($item->status) }}</span>
                        </td>
                        <td class="">
                            {{-- <a href="{{ route('jadwal', $item->id) }}">
                            <button type="submit" class="btn btn-primary mb-3"
                                >Detail rumah</button>
                            <div class="d-flex gap-3">
                            </a> --}}
                                
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editlapangan{{ $item->id }}">Edit</button>
                            <form action="{{ route('delete_lapangan', $item->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            </div>
                            
                        </td>
                        
                    </tr>


                    <div class="modal fade" id="editlapangan{{ $item->id }}" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalToggleLabel">Edit Data rumah</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('edit_lapangan', $item->id ) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                            <div class="modal-body">
                                <label for="defaultFormControlInput" class="form-label">rumah</label>
                                <input type="text" class="form-control mb-2" id="defaultFormControlInput" value="{{ $item->rumah }}" placeholder="nama rumah" name="nama" aria-describedby="defaultFormControlHelp" />
                                <label for="defaultFormControlInput" class="form-label">Deskripsi</label>
                                <input type="text" class="form-control mb-2" id="defaultFormControlInput" value="{{ $item->deskripsi }}" placeholder="deskripsi" name="deskripsi" aria-describedby="defaultFormControlHelp" />
                                <label class="form-label">ukuran</label>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label class="form-label" style="font-size: 13px;">luas bangunan</label>
                                        <input type="number" class="form-control" name="luas_bangunan" value="{{ $item->luas_bangunan }}" placeholder="Luas Bangunan">
                                    </div>
                                    <div class="col">
                                        <label class="form-label" style="font-size: 13px;">luas tanah</label>
                                        <input type="number" class="form-control" name="luas_tanah" value="{{ $item->luas_tanah }}" placeholder="Luas Tanah">
                                    </div>
                                </div>
                                <label class="form-label">Jumlah Kamar Tidur</label>
                                <input type="number" class="form-control mb-2" name="jumlah_kamar" value="{{ $item->jumlah_kamar }}" placeholder="Jumlah Kamar">
                                <label class="form-label">Jumlah Kamar Mandi</label>
                                <input type="number" class="form-control mb-2" name="jumlah_kamar_mandi" value="{{ $item->jumlah_kamar_mandi }}" placeholder="Jumlah Kamar Mandi">
                                <label class="form-label">Garasi</label>
                                <select class="form-select mb-2" name="garasi" aria-label="Default select example">
                                    <option value="ada" {{ $item->garasi == 'ada' ? 'selected' : '' }}>Ada</option>
                                    <option value="tidak ada" {{ $item->garasi == 'tidak ada' ? 'selected' : '' }}>Tidak Ada</option>
                                </select>
                                <label for="defaultFormControlInput" class="form-label">Type</label>
                                <select class="form-select mb-2" name="tipe" id="exampleFormControlSelect1" aria-label="Default select example">
                                    <option value="rumah">rumah</option>
                                    <option value="rumah">rumah</option>
                                    <option value="rumah">rumah</option>
                                </select>
                                <label for="defaultFormControlInput" class="form-label">Harga</label>
                                <input type="text" class="form-control mb-2 format-rupiah" name="harga" value="{{ old('harga', isset($item) ? $item->harga : '') }}" id="hargaEdit{{ $item->id ?? 'Tambah' }}" placeholder="Harga" aria-describedby="defaultFormControlHelp" />
                                <label for="defaultFormControlInput" class="form-label">Status</label>
                                <select class="form-select" name="status" id="exampleFormControlSelect1"  aria-label="Default select example">
                                    <option value="tersedia" {{ $item->jenis == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Tidak Tersedia" {{ $item->jenis == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                </select>
                                <label for="defaultFormControlInput" class="form-label">Gambar</label>
                                
                                <input type="file" class="form-control mb-2" name="gambar" id="defaultFormControlInput" placeholder="Gambar" aria-describedby="defaultFormControlHelp" />
                                
                                @if($item->gambar)
                                            <img src="{{ asset($item->gambar) }}" alt="Current Image" class="img-fluid mb-3" style="width: 100px;">
                                @endif
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal">Edit Data</button>
                            </div>
                        </form>
                          </div>
                        </div>
                      </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="tambahlapangan" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalToggleLabel">Tambah data rumah</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambah_lapangan') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <label for="defaultFormControlInput" class="form-label">rumah</label>
                <input type="text" class="form-control mb-2" id="defaultFormControlInput" placeholder="nama rumah" name="nama" aria-describedby="defaultFormControlHelp" />
                <label for="defaultFormControlInput" class="form-label">Deskripsi</label>
                <input type="text" class="form-control mb-2" id="defaultFormControlInput" placeholder="deskripsi" name="deskripsi" aria-describedby="defaultFormControlHelp" />
                <label class="form-label">ukuran</label>
                <div class="row mb-2">
                    <div class="col">
                        <label class="form-label" style="font-size: 13px;">luas bangunan</label>
                        <input type="number" class="form-control" name="luas_bangunan" placeholder="Luas Bangunan">
                    </div>
                    <div class="col">
                        <label class="form-label" style="font-size: 13px;">luas tanah</label>
                        <input type="number" class="form-control" name="luas_tanah" placeholder="Luas Tanah">
                    </div>
                </div>
                <label class="form-label">Jumlah Kamar Tidur</label>
                <input type="number" class="form-control mb-2" name="jumlah_kamar" placeholder="Jumlah Kamar">
                <label class="form-label">Jumlah Kamar Mandi</label>
                <input type="number" class="form-control mb-2" name="jumlah_kamar_mandi" placeholder="Jumlah Kamar Mandi">
                <label class="form-label">Garasi</label>
                <select class="form-select mb-2" name="garasi" aria-label="Default select example">
                    <option value="ada">Ada</option>
                    <option value="tidak ada">Tidak Ada</option>
                </select>
                <label for="defaultFormControlInput" class="form-label">Type</label>
                <select class="form-select mb-2" name="tipe" id="exampleFormControlSelect1" aria-label="Default select example">
                    <option value="rumah">rumah</option>
                    <option value="rumah">rumah</option>
                    <option value="rumah">rumah</option>
                </select>
                <label for="defaultFormControlInput" class="form-label">Harga</label>
                <input type="text" class="form-control mb-2 format-rupiah" name="harga" id="hargaTambah" placeholder="Harga" aria-describedby="defaultFormControlHelp" />
                <label for="defaultFormControlInput" class="form-label">Gambar</label>
                <input type="file" class="form-control mb-2" name="gambar" id="defaultFormControlInput" placeholder="Gambar" aria-describedby="defaultFormControlHelp" />
                <label for="defaultFormControlInput" class="form-label">Status</label>
                <select class="form-select" name="status" id="exampleFormControlSelect1" aria-label="Default select example">
                    <option value="tersedia">Tersedia</option>
                    <option value="Tidak Tersedia">Tidak Tersedia</option>
                </select>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal">Tambah Data</button>
            </div>
        </form>
          </div>
        </div>
      </div>

    </div>
</div>

<script>
    @if(Session::has('berhasil_tambah'))
  
    Swal.fire({
      title: 'Berhasil',
      text: 'Data Berhasil ditambahkan',
      icon: 'success',
      confirmButtonText: 'Oke'
    })
  
    @elseif(Session::has('gagal_tambah'))
    Swal.fire({
      title: 'Gagal',
      text: 'Data gagal di tambahkan',
      icon: 'error',
      confirmButtonText: 'Oke'
    })
  
    @elseif(Session::has('berhasil_edit'))
  
    Swal.fire({
      title: 'Berhasil',
      text: 'Data Berhasil di edit',
      icon: 'success',
      confirmButtonText: 'Oke'
    })
  
    @elseif(Session::has('berhasil_hapus'))
  
    Swal.fire({
      title: 'Berhasil',
      text: 'Data Berhasil dihapus',
      icon: 'success',
      confirmButtonText: 'Oke'
    })
  
    @elseif(Session::has('kosong_tambah'))
  
    Swal.fire({
      title: 'Gagal ',
      text: 'Lengkapi data',
      icon: 'error',
      confirmButtonText: 'Oke'
    })
    @endif
  
     </script>

<script>
// Format harga input (tambah & edit) dengan titik ribuan
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
        let cursor = input.selectionStart;
        let value = input.value.replace(/\./g, '');
        input.value = formatRupiah(value);
        // Set cursor ke akhir
        input.setSelectionRange(input.value.length, input.value.length);
    });
    // Saat submit, hapus titik
    input.form && input.form.addEventListener('submit', function() {
        input.value = input.value.replace(/\./g, '');
    });
});
</script>
@endsection