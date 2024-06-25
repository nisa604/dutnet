<?php

namespace App\Http\Controllers;

use App\Models\M_voucher;
use App\Models\M_jenis_voucher;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportVoucher;
use App\Models\M_reward;
use Illuminate\Pagination\Paginator;

class C_voucher extends Controller
{
    public function index(Request $request)
    {
        $all_vouchers = M_voucher::where('status_voucher', 'Tersedia')->get();
        $jumlah_terjual = M_voucher::where('status_voucher', 'Terjual')->count();
        Paginator::useBootstrap();

        $jenisVoucher = $request->query('jenis_voucher');

        if ($jenisVoucher) {
            $paginated_vouchers = M_voucher::whereHas('jenisVoucher', function ($query) use ($jenisVoucher) {
                $query->where('nama_jenis_voucher', $jenisVoucher);
            })->paginate(8);
        } else {
            $paginated_vouchers = M_voucher::with('jenisVoucher')->paginate(8);
        }

        return view('dutanet.stok.index', [
            'title' => 'Stok Voucher',
            'all_vouchers' => $all_vouchers,
            'voucher' => $paginated_vouchers,
            'jumlah_terjual' => $jumlah_terjual,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_voucher' => 'required|unique:m_vouchers',
            'nama_jenis_voucher' => 'required',
            'harga_voucher' => 'required|numeric',
        ]);

        $jenisVoucher = M_jenis_voucher::where('nama_jenis_voucher', $validatedData['nama_jenis_voucher'])->first();

        if (!$jenisVoucher) {
            return redirect('/stokvoucher')->with('error', 'Jenis Voucher tidak ditemukan');
        }

        $validatedData['id_jenis'] = $jenisVoucher->id;
        unset($validatedData['nama_jenis_voucher']); // Remove unnecessary field

        try {
            M_voucher::create($validatedData);
            return redirect('/stokvoucher')->with('success', 'Data Voucher berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                // Handle duplicate entry error
                return redirect('/stokvoucher')->with('error', 'Kode voucher sudah ada');
            }
            // Handle other errors
            return redirect('/stokvoucher')->with('error', 'Terjadi kesalahan saat menambahkan voucher');
        }
    }

    // public function update($id)
    // {
    //     $voucher = M_jenis_voucher::where('harga', 5000)->find($id);

    //     if ($voucher) {
    //         $reward = $voucher->reward; // Ambil reward terkait dengan voucher

    //         if ($reward) {
    //             $discount = $reward->discount;

    //             $originalPrice = $voucher->harga_voucher;
    //             $discountedPrice = $originalPrice * (1 - $discount / 100);

    //             $voucher->diskon = $discount; // Update diskon pada voucher
    //             $voucher->harga_voucher = $discountedPrice;
    //             $voucher->save();

    //             return redirect('/stokvoucher')->with('success', 'Voucher berhasil diperbarui dengan diskon');
    //         } else {
    //             return redirect('/stokvoucher')->with('error', 'Reward untuk pelanggan tidak ditemukan');
    //         }
    //     }

    //     return redirect('/stokvoucher')->with('error', 'Voucher dengan harga 5000 tidak ditemukan');
    // }

    public function destroy($id)
    {
        $voucher = M_voucher::findOrFail($id);

        if ($voucher) {
            $voucher->delete();
            return redirect('/stokvoucher')->with('success', 'Data Voucher berhasil dihapus');
        }

        return redirect('/stokvoucher')->with('error', 'Data Voucher tidak ditemukan');
    }

    public function import(Request $request)
{
    try {
        Excel::import(new ImportVoucher, $request->file('file'));
        return redirect('/stokvoucher')->with('success', 'Data Voucher berhasil diimpor');
    } catch (\Exception $e) {
        // Check if the exception is a duplicate entry
        if (str_contains($e->getMessage(), 'Duplicate entry')) {
            return redirect('/stokvoucher')->with('error', 'Kode voucher sudah ada');
        }
        // Log the error for debugging purposes
        Log::error('Import error: ' . $e->getMessage());
        return redirect('/stokvoucher')->with('error', 'Terjadi kesalahan saat mengimpor voucher');
    }
}



    // public function exportBarang()
    // {
        //     return Excel::download(new MasterBarangExport, 'data_barang.xlsx');
        // }
    }
