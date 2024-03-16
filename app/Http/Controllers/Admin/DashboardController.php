<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksi =    DB::table('transaksis')
                            ->select('status', DB::raw('COUNT(id) as jumlah'))
                            ->where('status', '=', 'Menunggu Pembayaran')
                            ->groupBy('status')
                            ->first();
        $pembayaran =   DB::table('pembayarans')
                            ->select(DB::raw('COUNT(id) as jumlah, status_bayar'))
                            ->where('status_bayar', '=', 'Menunggu Verifikasi Pembayaran')
                            ->groupBy('status_bayar')
                            ->get();
        return view('admin.dashboard',compact('transaksi','pembayaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
