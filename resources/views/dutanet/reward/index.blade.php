@extends('layouts.main')

@section('container')
    <div class="page-heading">
        <div class="row">
            <div class="col">
                <div class="page-heading">
                    <div style="font-size: 1.25em; color: white;">Data Reward</div>
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
    </div>
    <form action="{{ route('reward.index') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Cari Nama Pelanggan"
                value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>
    @if ($rewards->isEmpty())
        <p>Tidak ada data reward.</p>
    @else
        <!-- Daftar Reward start -->
        <section class="section">
            <div class="card" style="border-radius: 25px;">
                <div class="card-body">
                    <!-- Search Form -->

                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>ID Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Recency</th>
                                    <th>Frequency</th>
                                    <th>Monetary</th>
                                    <th>Engagement</th>
                                    <th>Total Score</th>
                                    <th>Segmentasi</th>
                                    <th>Discount</th>
                                    <th>Tanggal Expired</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rewards as $reward)
                                    <tr>
                                        <td>{{ $reward->id_pelanggan }}</td>
                                        <td>{{ $reward->user->name }}</td>
                                        <td>{{ $reward->recency }}</td>
                                        <td>{{ $reward->frequency }}</td>
                                        <td>{{ $reward->monetary }}</td>
                                        <td>{{ $reward->engagement }}</td>
                                        <td>{{ $reward->total_score }}</td>
                                        <td>{{ $reward->segmentasi }}</td>
                                        <td>{{ $reward->discount }}%</td>
                                        <td>{{ $reward->tgl_expired }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
    @endif
    </div>
    </div>
    </section>
    <!-- Daftar Reward end -->
@endsection
