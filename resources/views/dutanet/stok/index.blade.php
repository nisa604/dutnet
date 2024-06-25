@extends('layouts.main')
@section('container')

    <div class="page-heading">
        <div class="row">
            <div class="col">
                <div class="page-heading">
                    <div style="font-size: 1.25em; color: white">Stok Voucher</div>
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

                <div class="mx-4 mt-3 mb-3">
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card"
                                style="background-color: #A48AFD; height: 110px; width: 200px; border-radius: 19px;">
                                <div class="card-body text-white">
                                    <h5 class="card-title">Voucher Tersedia</h5>
                                    <p class="card-text">{{ $all_vouchers->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card"
                                style="background-color: #A48AFD; height: 110px; width: 200px; border-radius: 19px;">
                                <div class="card-body text-white">
                                    <h5 class="card-title">Voucher Terjual</h5>
                                    <p class="card-text">{{ $jumlah_terjual }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Button trigger modal -->
                    <div class="d-flex align-items-center justify-content-start" style="margin-top: -10px; gap: 10px;">
                        <button type="button" class="btn" style="background-color: #A48AFD; color: white;"
                            data-bs-toggle="modal" data-bs-target="#FormModal">Tambah
                            Data Voucher</button>
                        <a href="/exportbarang" class="badge bg-danger fs-6"><span data-feather="printer"></span> Data
                            Voucher</a>
                        <div class="dropdown">
                            <button class="btn btn-transparent text-white" type="button" id="dropdownMenuButton"
                                style="background-color: #A48AFD;" data-bs-toggle="dropdown" aria-expanded="false">
                                Jenis Voucher
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item text-black" href="{{ url('/stokvoucher') }}">Semua Voucher</a>
                                </li>
                                <li><a class="dropdown-item text-black"
                                        href="{{ url('/stokvoucher?jenis_voucher=1000_2JAM') }}">1000 2 Jam</a></li>
                                <li><a class="dropdown-item text-black"
                                        href="{{ url('/stokvoucher?jenis_voucher=3000_10JAM') }}">3000 10 Jam</a></li>
                                <li><a class="dropdown-item text-black"
                                        href="{{ url('/stokvoucher?jenis_voucher=5000_24JAM') }}">5000 24 Jam</a></li>
                                <li><a class="dropdown-item text-black"
                                        href="{{ url('/stokvoucher?jenis_voucher=10000_50JAM') }}">10000 50 Jam</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mx-4 my-3" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-4 my-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show mx-4 my-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($voucher->count())
                    <div class="card-body">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>Kode Voucher</th>
                                    <th>Status</th>
                                    <th>Jenis Voucher</th>
                                    <th>Harga</th>
                                    {{-- <th>Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($voucher as $v)
                                    <tr>
                                        <td>{{ $v->kode_voucher }}</td>
                                        <td>{{ $v->status_voucher }}</td>
                                        <td>{{ $v->jenisVoucher->nama_jenis_voucher }}</td>
                                        <td>Rp. {{ number_format($v->harga_voucher, 0, ',', '.') }},-</td>
                                        {{-- <td>
                                            <form action="{{ route('voucher.destroy', $v->id) }}" method="post"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="border-0 bg-transparent"
                                                    onclick="return confirm('Hapus data barang : {{ $v->kode_voucher }} ?');">
                                                    <img src="{{ asset('assets/images/icon/delete.png') }}"
                                                        alt="Delete Icon">
                                                </button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $voucher->links() }}
                    </div>
            </div>
        </section>
        <!-- Basic Tables end -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="FormModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Import Data Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/importvoucher" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Masukan File (.csv / .xlsx / .xls)</label>
                            <input type="file" class="form-control" id="file" name="file"
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-danger alert-dismissible fade show mx-4 fs-3 text-center" role="alert">
        Data Barang Not Found.
    </div>
    @endif

@endsection
