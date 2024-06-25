@extends('layouts.main')
@section('container')
    <div class="page-heading">
        <div class="row">
            <div class="col">
                <div class="page-heading">
                    <div style="font-size: 1.25em; color: white;">Rekap Transaksi</div>
                </div>
            </div>
            <div class="col text-end">
                <div class="page-heading d-flex align-items-center justify-content-end" style="margin-top: -10px;">
                    <!-- Dropdown Button -->
                    <div class="dropdown">
                        <button class="btn btn-transparent text-white" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('assets/images/icon/user2.png') }}" alt="icon"
                                style="width: 20px; height: 20px; margin-right: 5px;">
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item text-black" href="{{ url('/logout') }}">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card" style="border-radius: 25px;">
                <div class="">
                    <div style="font-size: 1.25em; font-weight: bold; color: black; margin-left: 28px; margin-top: 35px">
                        Rekap Transaksi</div>
                </div>
                <div class="card-body">
                    @if ($rekapTransaksi->isEmpty())
                        <p>Tidak ada data rekap transaksi.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>Waktu Transaksi</th>
                                        <th>Nama Jenis Voucher</th>
                                        <th>Harga Voucher</th>
                                        <th>Kode Voucher</th>
                                        <th>Status Voucher</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalPendapatan = 0;
                                    @endphp
                                    @foreach ($rekapTransaksi as $transaksi)
                                        <tr>
                                            <td>{{ $transaksi->waktu_transaksi }}</td>
                                            <td>{{ $transaksi->nama_jenis_voucher }}</td>
                                            <td>{{ $transaksi->harga_voucher }}</td>
                                            <td>{{ $transaksi->kode_voucher }}</td>
                                            <td>{{ $transaksi->status_voucher }}</td>
                                            @php
                                                $totalPendapatan += $transaksi->harga_voucher;
                                            @endphp
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="font-size: 1.25em; font-weight: bold; margin-top: 20px;">
                            Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
        <!-- Basic Tables end -->
    </div>
@endsection
