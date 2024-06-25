<!-- resources/views/riwayat/detail.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>

        <div>
            <h2>Informasi User</h2>
            <p>Nama User: {{ $user->name }}</p>
            <p>Email: {{ $user->email }}</p>
            <!-- Tambahkan informasi user lainnya sesuai kebutuhan -->

            <hr>

            <h2>Detail Transaksi</h2>
            <p>Waktu Transaksi: {{ $transaksi->waktu_transaksi }}</p>
            <p>Reference: {{ $transaksi->reference }}</p>
            <p>Total Bayar: {{ $transaksi->total_bayar }}</p>
            <p>Jenis Pembayaran: {{ $transaksi->jenis_pembayaran }}</p>
            <!-- Tambahkan informasi transaksi lainnya sesuai kebutuhan -->

            <hr>

            <h2>Detail Pembelian Voucher</h2>
            <ul>
                @foreach ($details as $detail)
                    <li>Jenis Voucher: {{ $detail->nama_jenis_voucher }}</li>
                    <li>Qty: {{ $detail->qty }}</li>
                    <li>Subtotal: {{ $detail->subtotal }}</li>
                    <!-- Tambahkan informasi detail voucher lainnya sesuai kebutuhan -->
                @endforeach
            </ul>
        </div>
    </div>
@endsection
