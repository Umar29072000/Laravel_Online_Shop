<?php

namespace App\Http\Controllers\Admin;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Komentar;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $barangList = Barang::with('kategori')->orderBy('id', 'DESC')->get();
        return view('admin.barang.index', compact('barangList'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'deskripsi' => 'required',
            'tanggal_masuk' => 'required|date_format:d-m-Y',
            'kategori' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'required|image|max:1024', // Max file size 1MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['error' => $validator->errors()]);
        }

        $file = $request->file('gambar');
        $eks = $file->getClientOriginalExtension();
        $generate = Hash::make(time() .  $file->getClientOriginalName());
        $name = substr($generate, 0, 20);
        $nameFile = $name . '.' . $eks;
        $request->file('gambar')->move(public_path('images/barang'), $nameFile);

        Barang::create([
            'nama_barang' => $request->input('nama_barang'),
            'deskripsi' => $request->input('deskripsi'),
            'tanggal_masuk' => date('Y-m-d', strtotime($request->input('tanggal_masuk'))),
            'kategori_id' => $request->input('kategori'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
            'gambar' => $nameFile,
            'terjual' => '0'
        ]);

        return redirect()->route('admin.barang.index')->with('alert', 1);
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'deskripsi' => 'required',
            'tanggal_masuk' => 'required',
            'kategori' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'image|max:1024', // Max file size 1MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['error' => $validator->errors()]);
        }


        $barang = Barang::find($id);
        if ($barang->gambar != null) {
            File::delete('images/barang/' . $barang->gambar);
            $file = $request->file('gambar');
            $eks = $file->getClientOriginalExtension();
            $generate = Hash::make(time() .  $file->getClientOriginalName());
            $name = substr($generate, 0, 20);
            $nameFile = $name . '.' . $eks;
            $request->file('gambar')->move(public_path('images/barang'), $nameFile);
        } else {
            $nameFile = $barang->gambar;
        }
        // dd($gambarPath);
        Barang::where('id', $id)->update([
            'nama_barang' => $request->input('nama_barang'),
            'deskripsi' => $request->input('deskripsi'),
            'tanggal_masuk' => date('Y-m-d', strtotime($request->input('tanggal_masuk'))),
            'kategori_id' => $request->input('kategori'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
            'gambar' => $nameFile,
            // 'terjual' => $request->
        ]);

        return redirect()->route('admin.barang.index')->with('alert', 1);
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        Komentar::where('barang_id', $id)->delete();

        $barang->delete();
        return redirect()->route('admin.barang.index')->with('alert', 3);
    }
}
