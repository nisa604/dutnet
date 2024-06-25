@extends('layouts.main')

@section('container')
    <section class="section">
        <div class="card">
            <div class="card-header">
                Detail Pembelian
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Order</th>
                            <th>Jenis Voucher</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailPembelian as $item)
                            <tr>
                                <td>{{ $item->id_order }}</td>
                                <td>{{ $item->nama_jenis_voucher }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
