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

<body id="home">
    @include('components.navbar')
    <main>
        {{-- HERO SECTION --}}
        <section class="hero position-relative" id="hero">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('assets/img/banner/bg.png') }}" class="d-block w-100" alt="...">
                        <div class="welcome-message" style="position: absolute; top: 10%; right: 59%; padding: 10px;">
                            <h6 style="color: black; font-weight: bold; font-size: 2em; margin-bottom: 0.4em;">Selamat
                                datang,</h6>
                            <h6 style="color: white; font-weight: bold; font-size: 2em; margin-bottom: 0.4em;">
                                {{ auth()->user()->name }}!</h6>
                            <p style="color: white; font-size: 1em;">Lorem ipsum dolor sit amet consectetur. Turpis
                                purus aenean <br>
                                ultrices consequat.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/img/banner/bg.png') }}" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/img/banner/bg.png') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Slide 3</h5>
                            <p>Some representative placeholder content for the third slide.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
        {{-- END HERO SECTION --}}


        {{-- TRANSAKSI SECTION --}}
        <section class="transaksi section-gap" id="transaksi">
            <div class="container">
                {{-- TAMPILAN VOUCHER --}}
                <section class="voucher py-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            @if($jenisVoucher && $hargaVoucher != $hargaAsli)
                            <div class="card shadow hover-effect align-items-center justify-content-center"
                                style="transition: transform 0.3s; height: 300px; width: 45%; border-radius: 6%;">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-md-2" style="margin-left: 2%">
                                        <img src="{{ asset('assets/img/logo/dutanet.png') }}" alt="Voucher Image" class="img-fluid">
                                    </div>
                                    <div class="col-md-10 text-center">
                                        <div class="mb-2" style="color: #5D37E1; font-size: 1.3rem; font-weight:bold; margin-top: 2%;">{{ $jenisVoucher->nama_jenis_voucher ?? 'Voucher 5000 24 Jam' }}</div>
                                        {{-- Tampilkan harga setelah diskon --}}
                                        <div class="mb-2" style="font-size: 1rem; display: flex;">
                                            <del style="color: black; margin-left: 32%">Rp {{ number_format($hargaAsli, 0, ',', '.') }}</del>
                                            <span style="color: red; margin-left: 8%">Rp {{ number_format($hargaVoucher, 0, ',', '.') }}</span>
                                        </div>
                                        <p class="mb-2" style="font-size: 0.9rem;">Dapatkan voucher dengan harga diskon khusus untuk Anda!</p>
                                        {{-- Form untuk menambahkan ke keranjang --}}
                                        <form action="{{ route('tambah-keranjang') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="jenisVoucherId" name="jenis_voucher_id" value="1">
                                            <!-- Contoh nilai id jenis voucher -->
                                            <input type="hidden" id="namaVoucher" name="nama_jenis_voucher" value="5000_24JAM" data-harga="{{ $hargaVoucher }}">
                                            <!-- Contoh nama jenis voucher -->
                                            <input type="hidden" id="hargaVoucher" name="harga" value="{{ $hargaVoucher }}">
                                            <!-- Gunakan harga diskon yang telah dihitung sebelumnya -->
                                            <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 10px;">
                                                <button type="button" class="btn" onclick="decrement()" style="border: none; outline: none;">
                                                    <img src="{{ asset('assets/images/icon/minus.png') }}" alt="Minus" style="height: 15px;">
                                                </button>
                                                <input type="text" id="qtyVoucher" name="qty" value="1" style="width: 50px; text-align: center;">
                                                <button type="button" class="btn" onclick="increment()" style="border: none; outline: none;">
                                                    <img src="{{ asset('assets/images/icon/plus.png') }}" alt="Plus" style="height: 15px;">
                                                </button>
                                            </div>
                                            <!-- Input untuk quantity, pastikan tidak negatif -->
                                            <button type="submit" style="width: 50%; height: 60%; background-color: #5D37E1; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin: 4px 2px; border-radius: 25px;">Tambah ke Keranjang</button>
                                        </form>

                                    </div>

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>
                {{-- END TAMPILAN VOUCHER --}}

                <div class="container my-10">
                    @php
                        $buttons = [
                            ['icon' => 'cart.png', 'title' => 'Beli Voucher Wifi', 'route' => '/beli'],
                            ['icon' => 'history.png', 'title' => 'Riwayat Transaksi', 'route' => '/riwayat-transaksi'],
                        ];
                    @endphp

                    <div class="row justify-content-center">
                        @foreach ($buttons as $button)
                            <div class="col-md-4 mb-3 d-flex justify-content-center">
                                <a href="{{ $button['route'] }}" class="card shadow hover-effect"
                                    style="width: 70%; border-radius: 1rem; text-decoration: none;">
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center"
                                        style="transition: transform 0.3s; height: 220px;">
                                        <img src="{{ asset('/assets/images/icon/' . $button['icon']) }}"
                                            alt="{{ $button['title'] }} Icon"
                                            style="width: 90px; height: 90px; margin-bottom: 20px;">
                                        <h5 class="card-title"
                                            style="color: #5D37E1; font-size: 1.25rem; font-weight: bold;">
                                            {{ $button['title'] }}</h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <style>
                    .hover-effect:hover {
                        transform: scale(1.05);
                    }
                </style>
            </div>
        </section>
        {{-- END TRANSAKSI SECTION --}}
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
        function decrement() {
            var input = document.getElementById("qtyVoucher");
            var value = parseInt(input.value, 10);
            var harga = parseFloat(document.getElementById("namaVoucher").getAttribute("data-harga"));
            if (value > 1 || harga != 5000) input.value = value - 1;
        }

        function increment() {
            var input = document.getElementById("qtyVoucher");
            var value = parseInt(input.value, 10);
            var harga = parseFloat(document.getElementById("namaVoucher").getAttribute("data-harga"));
            if (value < 1 || value > 1 || harga != 5000) input.value = 1;
        }

    </script>

</body>

</html>
