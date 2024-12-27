<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Method to display the transaction report
    public function transaksi(Request $request)
    {
        $query = Transaksi::with('detailTransaksi');
    
        // Apply filters if they exist
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        }
    
        $transaksi = $query->get();
    
        return view('laporan-transaksi.index', compact('transaksi'));
    }
}

