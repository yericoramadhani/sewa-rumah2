<?php

namespace App\Http\Controllers;

use App\Models\lapanganModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LapanganController extends Controller
{

    public function show_lapangan()
    {
        $lapangan = lapanganModel::all();
        return view('admin.pages.lapangan.lapangan', [
            'title' => 'Data Rumah',
            'lapangan' => $lapangan,
        ]);
    }
    
    public function tambah(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'luas_tanah' => 'required|integer',
            'luas_bangunan' => 'required|integer',
            'jumlah_kamar' => 'required|integer',
            'jumlah_kamar_mandi' => 'required|integer',
            'harga' => 'required',
            'status' => 'required',
            'tipe' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
            'garasi' => 'required|in:ada,tidak ada',
        ]);

        $fileName = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('gambar_rumah'), $fileName);
        }

        $lapangan = LapanganModel::create([
            'rumah' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'luas_tanah' => $request->luas_tanah,
            'luas_bangunan' => $request->luas_bangunan,
            'jumlah_kamar' => $request->jumlah_kamar,
            'jumlah_kamar_mandi' => $request->jumlah_kamar_mandi,
            'harga' => $request->harga,
            'status' => $request->status,
            'type' => $request->tipe,
            'gambar' => $fileName ? 'gambar_rumah/' . $fileName : null,
            'garasi' => $request->garasi,
        ]);

        if ($lapangan) {
            return redirect()->route('lapangan')->with('berhasil_tambah', true);
        } else {
            return redirect()->route('lapangan')->with('gagal_tambah', true);
        }
    }

    public function delete(Request $request, $id)
    {
        $lapangan = LapanganModel::findOrFail($id);

        // Hapus gambar jika ada
        if ($lapangan->gambar && file_exists(public_path($lapangan->gambar))) {
            unlink(public_path($lapangan->gambar));
        }

        $lapangan->delete();

        return redirect()->route('lapangan')->with('berhasil_hapus', true);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'luas_tanah' => 'required|integer',
            'luas_bangunan' => 'required|integer',
            'jumlah_kamar' => 'required|integer',
            'jumlah_kamar_mandi' => 'required|integer',
            'harga' => 'required',
            'status' => 'required',
            'tipe' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
            'garasi' => 'required|in:ada,tidak ada',
        ]);

        $lapangan = LapanganModel::findOrFail($id);
        $lapangan->rumah = $request->nama;
        $lapangan->deskripsi = $request->deskripsi;
        $lapangan->luas_tanah = $request->luas_tanah;
        $lapangan->luas_bangunan = $request->luas_bangunan;
        $lapangan->jumlah_kamar = $request->jumlah_kamar;
        $lapangan->jumlah_kamar_mandi = $request->jumlah_kamar_mandi;
        $lapangan->harga = $request->harga;
        $lapangan->status = $request->status;
        $lapangan->type = $request->tipe;
        $lapangan->garasi = $request->garasi;

        if ($request->hasFile('gambar')) {
            if ($lapangan->gambar && file_exists(public_path($lapangan->gambar))) {
                unlink(public_path($lapangan->gambar));
            }
            $file = $request->file('gambar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('gambar_rumah'), $fileName);
            $lapangan->gambar = 'gambar_rumah/' . $fileName;
        }
        $lapangan->save();
        return redirect()->route('lapangan')->with('berhasil_edit', true);
    }
}
