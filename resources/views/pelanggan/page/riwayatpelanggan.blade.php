<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Duta Net</title>

    {{-- STYLE CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    {{-- END STYLE --}}
</head>

<body>
    @include('components.navbar')
    <main>
        {{-- HEROES SECTION --}}
        <section class="heroess position-relative" id="heroes">
        </section>
        {{-- END HEROES SECTION --}}

        {{-- VOUCHER SECTION --}}
        <section class="voucher section-gap" id="voucher">
            @if ($riwayatTransaksi->isEmpty())
                <p>Tidak ada riwayat transaksi.</p>
            @else
                <div class="text-center">
                    <h2 class="text-black">Riwayat Transaksi</h2>
                </div>
                <div class="d-flex flex-column align-items-center mt-5">
                    @foreach ($riwayatTransaksi as $transaksi)
                        <a href="{{ route('detailriwayat', $transaksi->id) }}" class="text-decoration-none">
                            <div class="card mb-4 btn"
                                style="width: 60rem; background-color: #F2F2F2; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); border-radius: 20px; cursor: pointer;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between" style="padding: 10px;">
                                        <span
                                            style="color: #727272;">{{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->format('l, d F Y H:i:s') }}</span>
                                        {{-- <span class="status-label"
                                            style="background-color: {{ $transaksi->status_bayar == 'PAID' ? '#9DEE9D' : ($transaksi->status_bayar == 'UNPAID' ? '#FFD88E' : '#E4ACAC') }}; color: {{ $transaksi->status_bayar == 'PAID' ? '#028602' : ($transaksi->status_bayar == 'Pending' ? '#FA7800' : '#C10000') }}; border-radius: 8px; padding: 0 10px; display: inline-block; text-align: center; line-height: 25px;">
                                            {{ $transaksi->status_bayar }}
                                        </span> --}}
                                    </div>
                                    <hr style="border-top: 2px solid #727272; margin-top: -0.3%;">
                                    <div style="display: flex; align-items: center;">
                                        <div style="width: 20%; margin-left: 2%; margin-top: 1%; margin-bottom: 1%;">
                                            <div class="card"
                                                style="height: 40%; background-color: white; border-radius: 20px; display: flex; flex-direction: column; padding: 20px;">
                                                {{-- Card content --}}
                                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <img src="{{ asset('assets/img/logo/dutanet.png') }}"
                                                        alt="DutaNet Logo" style="width: 30%; margin-right: 25px;">
                                                    <span style="color: #7482FF; font-size: 12px;">Rp.
                                                        {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                                                </div>
                                                <div style="height: 2px; background-color: #7482FF;">
                                                </div>
                                                <span
                                                    style="color: #7482FF; font-size: 12px; display: block; text-align: center;">{{ $transaksi->nama_jenis_voucher }}</span>
                                            </div>
                                        </div>
                                        <span
                                            style="margin-top: 3.9%; margin-left: 2%; align-self: flex-start; font-size: 16px; color: #000000;">{{ $transaksi->nama_jenis_voucher }}<br></span>
                                        <span
                                            style="color: #727272; margin-top: 2%; margin-left: -11.6%;">x{{ $transaksi->qty }}</span>
                                        <span
                                            style="margin-top: 3.9%; margin-right: 2%; margin-left: auto; align-self: flex-start; font-size: 16px; color: #727272;">Rp.
                                            {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                                    </div>
                                    <hr style="border-top: 2px solid #727272;">
                                    <span
                                        style="display: block; text-align: center; color: #727272; margin-top: -1%;">Tampilkan
                                        Detail Riwayat</span>
                                    <hr style="border-top: 2px solid #727272;">
                                    <div class="d-flex justify-content-between" style="padding: 1px;">
                                        <span style="color: #727272;"></span>
                                        <span style="color: #727272;">Total pesanan: Rp.
                                            {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

    </main>
    @include('components.footer')
</body>

{{-- SCRIPT JS --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<script>
    AOS.init();
</script>

<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            prevEl: ".swiper-button-prev",
            nextEl: ".swiper-button-next",
        },
    });
</script>
