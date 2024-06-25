@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col">
            <div class="page-heading">
                <div style="font-size: 1.25em; color: white;">Dashboard</div>
            </div>
        </div>
        <div class="col text-end">
            <div class="page-heading d-flex align-items-center justify-content-end" style="margin-top: -10px;">
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
    <section class="section">
        <div class="row">
            @php
                $voucher_tersedia = $all_vouchers->count();
                $voucher_terjual = $jumlah_terjual;
            @endphp
            @for ($i = 1; $i <= 4; $i++)
                <div class="col-md-3">
                    <div class="card" style="height: 110px; width: 200px; border-radius: 12px;">
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 0.9em; color: #727272">
                                @switch($i)
                                    @case(1)
                                        Voucher Tersedia
                                        @php $value = $voucher_tersedia; @endphp
                                    @break

                                    @case(2)
                                        Voucher Terjual
                                        @php $value = $voucher_terjual; @endphp
                                    @break

                                    @case(3)
                                        Pendapatan Hari Ini
                                        @php $value = 'Rp. ' . number_format($pendapatanHariIni, 0, ',', '.'); @endphp
                                    @break

                                    @case(4)
                                        Pendapatan Bulan Ini
                                        @php $value = 'Rp. ' . number_format($pendapatanBulanIni, 0, ',', '.'); @endphp
                                    @break
                                @endswitch
                            </h5>
                            <p class="card-text" style="color: black; font-weight: bold;">{{ $value }}</p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </section>
    <div class="page-content">
        <div class="row">
            <div class="col-md-8">
                <div class="card" style=" height: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Penjualan Voucher</h5>
                        <canvas id="chartPenjualan"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style=" height: 100%;">
                     <h5 class="card-title" style="margin-left: 10%; margin-top: 7%">Jenis Voucher</h5>
                    <div class="row" style="margin-left: 1rem; margin-top: 1rem">
                        <div class="col-md-2">
                            <div style="width: 40px; height: 45px; background-color: #B89FF3; border-radius: 10%; display: flex; align-items: center; justify-content: center;">
                                1
                            </div>
                        </div>
                        <div class="col-md-10">
                            1000_2JAM <br>
                            {{ $jenisVouchers['1000_2JAM'] ?? 0 }} in Stock<br>
                        </div>
                    </div>
                    <div style="margin-top: 1rem"></div>
                    <div class="row" style="margin-left: 1rem">
                        <div class="col-md-2">
                            <div style="width: 40px; height: 45px; background-color: #B89FF3; border-radius: 10%; display: flex; align-items: center; justify-content: center;">
                                2
                            </div>
                        </div>
                        <div class="col-md-10">
                            3000_10JAM <br>
                            {{ $jenisVouchers['3000_10JAM'] ?? 0 }} in Stock <br>
                        </div>
                    </div>
                    <div style="margin-top: 1rem"></div>
                    <div class="row" style="margin-left: 1rem">
                        <div class="col-md-2">
                            <div style="width: 40px; height: 45px; background-color: #B89FF3; border-radius: 10%; display: flex; align-items: center; justify-content: center;">
                                3
                            </div>
                        </div>
                        <div class="col-md-10">
                            5000_24JAM <br>
                            {{ $jenisVouchers['5000_24JAM'] ?? 0 }} in Stock <br>
                        </div>
                    </div>
                    <div style="margin-top: 1rem"></div>
                    <div class="row" style="margin-left: 1rem">
                        <div class="col-md-2">
                            <div style="width: 40px; height: 45px; background-color: #B89FF3; border-radius: 10%; display: flex; align-items: center; justify-content: center;">
                                4
                            </div>
                        </div>
                        <div class="col-md-10">
                            10000_50JAM <br>
                            {{ $jenisVouchers['10000_50JAM'] ?? 0 }} in Stock
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var dataPenjualan = @json($dataPenjualan);

        var labels = dataPenjualan.map(function(item) {
            return item.bulan;
        });

        var data = dataPenjualan.map(function(item) {
            return item.jumlahTerjual;
        });

        var ctx = document.getElementById('chartPenjualan').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Voucher Terjual',
                    data: data,
                    backgroundColor: '#B89FF3',
                    borderColor: '#B89FF3',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
