<?php

namespace App\Http\Controllers;

use App\Models\M_Voucher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Models\M_reward;
use App\Models\M_jenis_voucher;
use App\Models\M_rekap;
use App\Http\Controllers\C_segmen;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'Admin') {
            return $this->adminDashboard();
        } else {
            return $this->userDashboard();
        }
    }

    private function adminDashboard()
    {
        $all_vouchers = M_voucher::where('status_voucher', 'Tersedia')->get();
        $jumlah_terjual = M_voucher::where('status_voucher', 'Terjual')->count();
        Paginator::useBootstrap();
        $paginated_vouchers = M_voucher::with('jenisVoucher')->paginate(8);
        $pendapatanHariIni = $this->hitungPendapatanHariIni();
        $pendapatanBulanIni = $this->hitungPendapatanBulanIni();
        $dataPenjualan = $this->hitungPenjualanPerBulan();

        // Count vouchers for each specific type
        $count_1000_2JAM = M_jenis_voucher::where('nama_jenis_voucher', '1000_2JAM')->count();
        $count_3000_10JAM = M_jenis_voucher::where('nama_jenis_voucher', '3000_10JAM')->count();
        $count_5000_24JAM = M_jenis_voucher::where('nama_jenis_voucher', '5000_24JAM')->count();
        $count_10000_50JAM = M_jenis_voucher::where('nama_jenis_voucher', '10000_50JAM')->count();

        // Fetch available stock from M_jenis_voucher
        $jenisVouchers = M_jenis_voucher::whereIn('nama_jenis_voucher', [
            '1000_2JAM', '3000_10JAM', '5000_24JAM', '10000_50JAM'
        ])->pluck('stok_tersedia', 'nama_jenis_voucher')->toArray();

        return view('dutanet.index', [
            'title' => 'Admin Dashboard',
            'users' => User::all(),
            'mb' => M_Voucher::all(),
            'all_vouchers' => $all_vouchers,
            'voucher' => $paginated_vouchers,
            'jumlah_terjual' => $jumlah_terjual,
            'pendapatanHariIni' => $pendapatanHariIni,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'dataPenjualan' => $dataPenjualan,
            'count_1000_2JAM' => $count_1000_2JAM,
            'count_3000_10JAM' => $count_3000_10JAM,
            'count_5000_24JAM' => $count_5000_24JAM,
            'count_10000_50JAM' => $count_10000_50JAM,
            'jenisVouchers' => $jenisVouchers,
        ]);
    }

    // private function userDashboard()
    // {
    //     return view('pelanggan.page.home', [
    //         'title' => 'User Dashboard',
    //     ]);
    // }

    public function userDashboard()
    {
        $user = Auth::user();
        $reward = M_reward::where('id_pelanggan', $user->id_pelanggan)->first();
        $segmenController = new C_segmen();

        // Inisialisasi hargaVoucher dan hargaAsli
        $hargaVoucher = 0;
        $hargaAsli = 0;

        // Ambil data voucher yang paling banyak dibeli oleh pengguna
        $mostPurchasedVouchers = $segmenController->getMostPurchasedVouchers();
        $jenisVoucher = null;

        // Cek apakah pengguna memiliki mostPurchasedVouchers atau null
        if (isset($mostPurchasedVouchers[$user->id_pelanggan])) {
            $voucherName = $mostPurchasedVouchers[$user->id_pelanggan]['nama_jenis_voucher'];
            $jenisVoucher = M_jenis_voucher::where('nama_jenis_voucher', $voucherName)->first();
        } else {
            // Set default voucher name jika tidak ada mostPurchasedVouchers
            $voucherName = '5000_24JAM';
            $jenisVoucher = M_jenis_voucher::where('nama_jenis_voucher', $voucherName)->first();
        }

        // Cek apakah $jenisVoucher dan $reward tidak null
        if ($jenisVoucher && $reward) {
            // Hitung harga voucher dengan mempertimbangkan diskon dari tabel rewards
            $hargaVoucher = $jenisVoucher->harga - ($jenisVoucher->harga * ($reward->discount / 100));
            $hargaAsli = $jenisVoucher->harga;
        }

        return view('pelanggan.page.home', [
            'title' => 'User Dashboard',
            'jenisVoucher' => $jenisVoucher, // Menambahkan variabel jenisVoucher ke dalam data yang dikirimkan ke view
            'hargaVoucher' => $hargaVoucher,
            'hargaAsli' => $hargaAsli,
        ]);
    }

     private function hitungPendapatanHariIni()
    {
        $today = Carbon::today();
        $pendapatanHariIni = M_rekap::whereDate('waktu_transaksi', $today)
                            ->sum('harga_voucher');

        return $pendapatanHariIni;
    }

    private function hitungPendapatanBulanIni()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $pendapatanBulanIni = M_rekap::where('waktu_transaksi', '>=', $startOfMonth)
                                ->sum('harga_voucher');

        return $pendapatanBulanIni;
    }

   private function hitungPenjualanPerBulan()
{
    $data = [];
    $bulanIni = now()->month;

    for ($bulan = 1; $bulan <= $bulanIni; $bulan++) {
        $jumlahTerjual = M_voucher::whereMonth('created_at', $bulan)
                            ->where('status_voucher', 'Terjual')
                            ->count();

        $data[] = [
            'bulan' => \Carbon\Carbon::create(null, $bulan, 1)->format('M'),
            'jumlahTerjual' => $jumlahTerjual,
        ];
    }

    return $data;
}



}
