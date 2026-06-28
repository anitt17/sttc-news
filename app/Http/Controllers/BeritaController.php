<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Admin;

class BeritaController extends Controller
{
    private function attachRelations($beritas)
    {
        $kategoriIds = $beritas->pluck('id_kategori')->unique();
        $adminIds = $beritas->pluck('id_admin')->unique();

        $kategoris = Kategori::whereIn('id_kategori', $kategoriIds)->get()->keyBy('id_kategori');
        $admins = Admin::whereIn('id_admin', $adminIds)->get()->keyBy('id_admin');

        return $beritas->map(function ($berita) use ($kategoris, $admins) {
            $berita->kategori = $kategoris->get($berita->id_kategori);
            $berita->admin = $admins->get($berita->id_admin);
            return $berita;
        });
    }

    public function index()
    {
        $beritas = Berita::orderBy('tanggal', 'desc')->get();
        $beritas = $this->attachRelations($beritas);

        return response()->json([
            'success' => true,
            'data'    => $beritas,
        ], 200);
    }

    public function show($id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }

        $berita->kategori = Kategori::find($berita->id_kategori);
        $berita->admin = Admin::find($berita->id_admin);

        return response()->json([
            'success' => true,
            'data'    => $berita,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:200',
            'isi'         => 'required',
            'tanggal'     => 'required|date',
            'id_kategori' => 'required',
            'id_admin'    => 'required',
        ]);

        $berita = Berita::create([
            'judul'       => $request->judul,
            'isi'         => $request->isi,
            'tanggal'     => $request->tanggal,
            'id_kategori' => $request->id_kategori,
            'id_admin'    => $request->id_admin,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan',
            'data'    => $berita,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }

        $request->validate([
            'judul'       => 'required|string|max:200',
            'isi'         => 'required',
            'tanggal'     => 'required|date',
            'id_kategori' => 'required',
        ]);

        $berita->update([
            'judul'       => $request->judul,
            'isi'         => $request->isi,
            'tanggal'     => $request->tanggal,
            'id_kategori' => $request->id_kategori,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diupdate',
            'data'    => $berita,
        ], 200);
    }

    public function destroy($id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }

        $berita->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus',
        ], 200);
    }

    public function search(Request $request)
    {
        $keyword = $request->query('keyword');

        $beritas = Berita::where('judul', 'like', '%' . $keyword . '%')
                        ->orWhere('isi', 'like', '%' . $keyword . '%')
                        ->orderBy('tanggal', 'desc')
                        ->get();

        $beritas = $this->attachRelations($beritas);

        return response()->json([
            'success' => true,
            'data'    => $beritas,
        ], 200);
    }
}