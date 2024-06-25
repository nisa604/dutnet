<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_jenis_voucher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class C_pelanggan extends Controller
{
    public function index()
    {
        return view('pelanggan.page.home');
    }

    public function showbeli()
    {
        return view('pelanggan.page.beli', [
            'title' => 'Beli Voucher',
            'jenis_voucher' => M_jenis_voucher::paginate(8),
        ]);
    }

    public function reset(Request $request)
    {
        $request->session()->flush();
        return redirect()->back()->with('success', 'Session berhasil di-reset.');
    }


    public function showUser()
    {
        return view('dutanet.pelanggan.index', [
            'title' => 'Data Pelanggan',
            'users' => User::all(),
        ]);
    }

    public function showRiwayat()
    {
        return view('dutanet.pelanggan.riwayatpelanggan', [
            'title' => 'Detail User',
            'users' => User::all(),
        ]);
    }

    public function destroy(User $masteruser)
    {
        $result = User::destroy($masteruser->id);

        if ($result !== 1) {
            return redirect('/masteruser')->with('error', 'User gagal dihapus !!');
        }
        return redirect('/masteruser')->with('success', 'User berhasil dihapus !!');
    }
}
