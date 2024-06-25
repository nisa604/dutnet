@extends('layouts.main')
@section('container')
    <div class="page-heading">
        <div class="row">
            <div class="col">
                <div class="page-heading">
                    <div style="font-size: 1.25em; color: white">Akun Pelanggan</div>
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
            <div class="card" style="height: 430px; border-radius: 25px;">
                <div class="">
                    <div style="font-size: 1.25em; font-weight: bold; color: black; margin-left: 28px; margin-top: 35px">
                        Akun Pelanggan</div>
                </div>
                <div class="card-body" style="overflow-y: auto; max-height: 380px;">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Dibuat Sejak</th>
                                <th>Last Login</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>{{ Carbon\Carbon::parse($user->last_login)->diffForHumans() }}</td>

                                    <td>
                                        <a href="/masteruser/{{ $user->id }}" style="display: inline-block;">
                                            <img src="{{ asset('assets/images/icon/lihat.svg') }}" alt="View">
                                        </a>
                                        {{-- @if ($user->role == 'Admin')
                                        @else
                                            <form action="/masteruser/{{ $user->id }}" method="post" class="d-inline"
                                                style="display: inline-block;">
                                                @method('delete')
                                                @csrf
                                                <button class="border-0 bg-transparent"
                                                    onclick="return confirm('Hapus user dengan nama : {{ $user->name }} ?');">
                                                    <img src="{{ asset('assets/images/icon/delete.png') }}" alt="Delete"
                                                        style="width: 15px; height: 15px;">
                                                </button>
                                            </form>
                                        @endif --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- Basic Tables end -->
    </div>
@endsection
