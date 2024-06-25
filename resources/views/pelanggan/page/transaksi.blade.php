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
        <section class="heroesss position-relative" id="heroes">
            <div class="text-center" style="margin-top: 60px">
                <h3 class="text-white" style="font-weight: bold">Transaksi Berhasil</h2>
                    <div style="text-align: center; margin-top: 40px;">
                        <img src="{{ asset('assets/images/icon/checklist.png') }}" alt="DutaNet Logo"
                            style="width: 12%; ">
                    </div>
                    <div class= "text-white" style="text-align: center; font-size: 14px; margin-top: 35px">Dibayar pada
                        {{ \Carbon\Carbon::now()->formatLocalized('%A, %d %B %Y Pukul %H:%M %p') }}</div>
            </div>
        </section>
        {{-- VOUCHER SECTION --}}
        <section class="voucher section-gapp" id="voucher">
            <div class="card"
                style="width: 65%; border-radius: 25px; margin: 0 auto; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column;">
                <div class="">
                    <div
                        style="text-align: center; font-size: 1.25em; font-weight: bold; color: #727272; margin-top: 50px">
                        Detail Transaksi</div>
                </div>
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; margin-top: 50px; margin-left: 10%">
                        <div style="text-align: left; font-size: 14px;">
                            <p style="font-weight: bold; color: #727272">Nama Pelanggan</p>
                            <p style="font-weight: bold; margin-top: -6px; color: #5D37E1 ">{{ $pelanggan->name }}
                            </p>
                            <p style="font-weight: bold; color: #727272">Email</p>
                            <p style="font-weight: bold; margin-top: -6px; color: #5D37E1">{{ $pelanggan->email }}
                            </p>
                            <p style="font-weight: bold; color: #727272">Pembelian Voucher</p>
                            <p style="font-weight: bold; margin-top: -6px; color: #5D37E1">
                                @foreach ($detailPembelian as $detail)
                                    <li>{{ $detail->nama_jenis_voucher }} - {{ $detail->qty }}</li>
                                @endforeach
                            </p>
                        </div>
                        <div style="text-align: left; font-size: 14px; margin-right: 18%">
                            <p style="font-weight: bold; color: #727272">Nomor Transaksi</p>
                            <p style="font-weight: bold; margin-top: -6px; color: #5D37E1">
                                {{ $dataTransaksi['reference'] }}</p>
                            <p style="font-weight: bold; color: #727272">Total Belanja</p>
                            <p style="font-weight: bold; margin-top: -6px; color: #5D37E1"> Rp
                                {{ number_format($dataTransaksi['total_bayar'], 0, ',', '.') }}</p>
                            <p style="font-weight: bold; color: #727272">Jenis Pembayaran</p>
                            <p style="font-weight: bold; margin-top: -6px; color: #5D37E1">
                                {{ $dataTransaksi['jenis_pembayaran'] }}</p>
                            <p style="font-weight: bold; color: #727272">Kode Voucher</p>
                            <p style="font-weight: bold; margin-top: -6px; color: #5D37E1">
                                @foreach ($vouchers as $voucher)
                                    <li>{{ $voucher->kode_voucher }}</li>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            </div>



    </main>
    @include('components.footer')


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
</body>

</html>
