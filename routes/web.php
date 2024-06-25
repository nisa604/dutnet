<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\C_pelanggan;
use App\Http\Controllers\C_login;
use App\Http\Controllers\C_voucher;
use App\Http\Controllers\C_jenis_voucher;
use App\Http\Controllers\C_transaksi;
use App\Http\Controllers\C_detail_pembelian_voucher;
use App\Http\Controllers\C_rekap;
use App\Http\Controllers\C_riwayat;
use App\Http\Controllers\C_segmen;
use App\Http\Controllers\C_tripay_callback;
use Illuminate\Routing\RouteGroup;

// Route untuk halaman login
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Route untuk proses pendaftaran (register)
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');

// Route untuk proses logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('admin')->group(function () {
    Route::get('/home', [C_pelanggan::class, 'index']);
    Route::get('/beli',[C_pelanggan::class, 'showbeli'])->name('Beli');
    Route::get('/keranjang', [C_transaksi::class, 'keranjang'])->name('keranjang');
    Route::post('/tambah-keranjang', [C_transaksi::class, 'tambahKeKeranjang'])->name('tambah-keranjang');
    Route::put('/keranjang/{index}', [C_transaksi::class, 'updateKeranjang'])->name('update-keranjang');
    Route::delete('/keranjang/{index}', 'C_jenis_voucher@destroy')->name('hapus-item-keranjang');
    Route::post('/showcheckout', [C_transaksi::class, 'showcheckout'])->name('showcheckout');
    Route::post('/pembayaran', [C_transaksi::class, 'pembayaran'])->name('pembayaran');
    Route::get('/detail-pembelian/{id_checkout}', [C_transaksi::class, 'showDetail'])->name('detail_pembelian');
    Route::post('/bayar-transaksi', [C_transaksi::class, 'transaksi'])->name('transaksi');
    Route::get('/stokvoucher', [C_voucher::class, 'index'])->name('stokvoucher');
    Route::post('/importvoucher', [C_voucher::class, 'import']);
    Route::post('/reset-session', [C_pelanggan::class, 'reset'])->name('reset-session');
    Route::delete('/stokvoucher/{id}', [C_voucher::class, 'destroy'])->name('voucher.destroy');
    Route::get('/datapelanggan', [C_pelanggan::class, 'showUser'])->name('datapelanggan');
    Route::get('/reward', [C_segmen::class, 'index'])->name('reward.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/beli',[C_pelanggan::class, 'showbeli'])->name('Beli');
    Route::get('/keranjang', [C_transaksi::class, 'keranjang'])->name('keranjang');
    Route::post('/tambah-keranjang', [C_transaksi::class, 'tambahKeKeranjang'])->name('tambah-keranjang');
    Route::put('/keranjang/{index}', [C_transaksi::class, 'updateKeranjang'])->name('update-keranjang');
    Route::delete('/keranjang/{index}', 'C_jenis_voucher@destroy')->name('hapus-item-keranjang');
    Route::post('/showcheckout', [C_transaksi::class, 'showcheckout'])->name('showcheckout');
    Route::post('/pembayaran', [C_transaksi::class, 'pembayaran'])->name('pembayaran');
    // Route::get('/detail-pembelian/{id_checkout}', [C_transaksi::class, 'showDetail'])->name('detail_pembelian');
    Route::get('/detail-pembelian/{id_checkout}/{reference}', [C_transaksi::class, 'showDetail'])->name('detail_pembelian');
    Route::post('/bayar-transaksi', [C_transaksi::class, 'transaksi'])->name('transaksi');
    Route::get('/datapelanggan',[C_pelanggan::class, 'showUser'])->name('datapelanggan');
    Route::get('/riwayat-transaksi', [C_riwayat::class, 'riwayatTransaksi'])->name('riwayatpelanggan');
    Route::get('//detailriwayat/{id_checkout}', [C_riwayat::class, 'riwayatTransaksi'])->name('detailriwayat');
    Route::get('/rekappenjualan', [C_rekap::class, 'rekap'])->name('rekap');
    // Route::get('/reward', [C_segmen::class, 'reward'])->name('reward');
    Route::get('/voucherfav', [C_segmen::class, 'getMostPurchasedVouchers']);
    Route::get('/calculate-rfme', [C_segmen::class, 'calculateRFME'])->name('calculateRFME');
});

Route::post('/callback', [C_tripay_callback::class, 'handle']);
// Route::get('/calculate-rfme', 'C_segmen@calculateRFME');
