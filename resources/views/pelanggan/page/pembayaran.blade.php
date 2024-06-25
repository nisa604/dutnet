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
        <section class="heroess position-relative" id="heroes">
        </section>
        {{-- VOUCHER SECTION --}}
        <section class="voucher section-gapp" id="voucher">
            @php
                $totalSubtotal = $detailPembelian->sum('subtotal');
                $totalQty = $detailPembelian->sum('qty');
                $vouchers = $detailPembelian->pluck('nama_jenis_voucher')->unique();
            @endphp
            @if ($detailPembelian->isNotEmpty())
                <div style="width: 65%; margin: auto; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); height: 550px;">
                    <div style="float: left; width: 32%; height: 100%; background-color: #C2B0FF; border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
                        <div style="text-align: center; padding-top: 40px; font-size: 14px; line-height: 1.5;">
                            Selesaikan pembayaran dalam
                        </div>
                        <div id="waktu" style="width: fit-content; margin: auto; margin-top: 20px; color: red; font-weight: bold; font-size: 5em;"></div>
                        <div style="text-align: center; font-size: 14px;">Batas akhir pembayaran</div>
                        <h4 style="text-align: center; margin-top: 20px; margin-bottom: 20px; font-size: 14px; font-weight: bold;">
                            {{ \Carbon\Carbon::now()->addMinutes(30)->formatLocalized('%A, %d %B %Y %H:%M %p') }}
                        </h4>
                        <div style="height: 2px; width: 80%; margin: auto; background-color: #D9D9D9;"></div>
                        <div style="text-align: left; margin-left: 32px; font-size: 14px; margin-top: 30px;">Jumlah bayar</div>
                        <div style="text-align: left; margin-left: 32px; font-weight: bold; font-size: 14px;">Rp. {{ $totalSubtotal }}</div>
                        <form action="{{ route('transaksi') }}" method="POST" style="display: flex; justify-content: flex-end; margin-right: 20px; margin-top: 75%">
                            @csrf
                            <input type="hidden" name="id_checkout" value="{{ $detailPembelian->first()->id_checkout }}">
                            <button type="submit" style="width: 60%; height: 50%; background-color: #5D37E1; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin: 4px 2px; border-radius: 9px;">
                                Lanjutkan Pembayaran
                            </button>
                        </form>
                    </div>
                    <div style="float: right; width: 65%; background-color: #ffffff; border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
                        <div style="text-align: center; margin-top: 40px;">
                            <img src="{{ asset('assets/img/logo/dutanet.png') }}" alt="DutaNet Logo" style="width: 12%; margin-right: 25px;">
                        </div>
                        <div style="text-align: center; font-size: 14px; margin-top: 20px;">
                            Pastikan anda melakukan pembayaran sebelum melewati batas <br> pembayaran dan dengan nominal yang tepat!
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 50px; margin-left: 6%">
                            <div style="text-align: left; font-size: 14px;">
                                <p style="font-weight: bold">Merchant</p>
                                <p style="margin-top: -6px;">Duta Net</p>
                                <p style="font-weight: bold">Nomor Transaksi</p>
                                <p style="margin-top: -6px;">{{ $reference }}</p>
                            </div>
                            <div style="text-align: left; font-size: 14px; margin-right: 25%">
                                <p style="font-weight: bold">Nama Pelanggan</p>
                                <p style="margin-top: -6px;">{{ $user->name }}</p>
                                <p style="font-weight: bold">Email</p>
                                <p style="margin-top: -6px;">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div style="text-align: left; font-size: 14px; margin-top: 20px; margin-left: 6%; font-weight: bold">Rincian Pembayaran</div>
                        <div style="height: 2px; width: 80%; margin: start; background-color: #D9D9D9; margin-top: 8px; margin-left: 6%"></div>
                        <div style="text-align: left; font-size: 14px; margin-top: 20px; margin-left: 6%">
                            @foreach ($vouchers as $voucher)
                                <div style="display: flex; justify-content: space-between; width: 85%">
                                    <div style="width: 33.33%; text-align: left;">{{ $voucher }}</div>
                                    <div style="width: 33.33%; text-align: center;">x{{ $detailPembelian->where('nama_jenis_voucher', $voucher)->sum('qty') }}</div>
                                    <div style="width: 20.33%; text-align: right;">Rp. {{ $detailPembelian->where('nama_jenis_voucher', $voucher)->sum('subtotal') }}</div>
                                </div>

                            @endforeach
                        </div>
                        <div style="height: 2px; width: 80%; margin: start; background-color: #D9D9D9; margin-top: 18px; margin-left: 6%"></div>
                        <div style="text-align: left; font-size: 14px; margin-top: 20px; margin-left: 6%">
                            <div style="display: flex; justify-content: space-between; width: 85%">
                                <div style="width: 33.33%; text-align: left; font-weight: bold"></div>
                                <div style="width: 40.33%; text-align: right; font-weight: bold">Total : Rp. {{ $totalSubtotal }}</div>
                            </div>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            @else
                <p style="text-align: center; font-size: 1.2em;">Tidak ada detail pembelian.</p>
            @endif
        </section>
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

        const waktu = document.getElementById('waktu');
        const batasWaktu = new Date().getTime() + (30 * 60 * 1000);

        let waktuInterval = setInterval(function() {
            const sisaWaktu = (batasWaktu - new Date().getTime()) / (1000 * 60);
            const jam = padNumber(Math.floor(sisaWaktu / 60));
            const menit = padNumber(Math.floor(sisaWaktu % 60));
            const detik = padNumber(Math.floor((sisaWaktu * 60) % 60));

            if (sisaWaktu < 0) {
                clearInterval(waktuInterval);
                waktu.innerHTML = '<h4>Waktu Habis</h4>';
                return;
            }

            waktu.innerHTML = `<h4>${jam}:${menit}:${detik}</h4>`;
        }, 1000);

        function padNumber(num) {
            return num.toString().padStart(2, '0');
        }
    </script>
</body>

</html>
