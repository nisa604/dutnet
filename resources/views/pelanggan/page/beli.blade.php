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
        <section class="heroes position-relative" id="heroes">
            <div class="text-center" style="margin-top: 100px">
                <h2 class="text-white">Beli Voucher</h2>
            </div>
        </section>
        {{-- END HEROES SECTION --}}

        {{-- VOUCHER SECTION --}}
        <section class="voucher section-gap" id="voucher">
            <div style="position: absolute; top: 58%; right: 8%; padding: 1rem;">
                <div
                    style="position: relative; display: inline-block; background-color: white; border-radius: 20%; padding: 0.5rem; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);">
                    <a href="{{ url('/keranjang') }}" class="btn-cart"
                        style="position: relative; display: inline-block; text-decoration: none;">
                        <img src="{{ asset('/assets/images/icon/cart.png') }}" alt="Cart Icon"
                            style="height: 20px; width: auto;">
                        <span class="cart-item-count"
                            style="position: absolute; top: -13px; right: -12px; font-weight: bold; color:#5D37E1; border-radius: 50%; padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                            {{ count(session('keranjang', [])) }}
                        </span>
                    </a>
                </div>
            </div>
            <div class="card"
                style="margin: auto; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); width: 800px; height: 650px; background-color: white; margin-top: -20px; border-radius: 20px;">
                @if ($jenis_voucher->count())
                    <div class="container">
                        <div class="container my-10">
                            <div class="row justify-content-center" style="margin-top: 60px; gap: 80px;">
                                @foreach ($jenis_voucher as $index => $jv)
                                    @php
                                        $colors = ['#7482FF', '#FA9FF8', '#71CD71', '#FAA300'];
                                        $backgroundColor = $colors[$index % count($colors)];
                                        $harga = '';
                                        if (strlen($jv->harga) === 5) {
                                            $harga =
                                                'Rp. ' .
                                                substr($jv->harga, 0, 2) .
                                                '.' .
                                                substr($jv->harga, 2, 5) .
                                                ',-';
                                        } elseif (strlen($jv->harga) === 6) {
                                            $harga =
                                                'Rp. ' .
                                                substr($jv->harga, 0, 3) .
                                                '.' .
                                                substr($jv->harga, 3, 6) .
                                                ',-';
                                        } elseif (strlen($jv->harga) === 4) {
                                            $harga =
                                                'Rp. ' .
                                                substr($jv->harga, 0, 1) .
                                                '.' .
                                                substr($jv->harga, 1, 4) .
                                                ',-';
                                        }
                                    @endphp
                                    <div class="col-md-4 mb-3 d-flex justify-content-center">
                                        <div class="card"
                                            style="flex: 1; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); background-color: {{ $backgroundColor }}; border-radius: 20px;">
                                            <div class="card"
                                                style="flex: 3; margin: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); background-color: white; border-radius: 20px; display: flex; flex-direction: column; padding: 20px;">
                                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <img src="{{ asset('assets/img/logo/dutanet.png') }}"
                                                        alt="DutaNet Logo" style="width: 30%; margin-right: 55px;">
                                                    <span
                                                        style="color: {{ $backgroundColor }}; font-size: 12px; margin-left: -10px;">{{ $harga }}</span>
                                                </div>
                                                <div
                                                    style="height: 2px; background-color: {{ $backgroundColor }}; margin-bottom: 10px;">
                                                </div>
                                                <span
                                                    style="color: {{ $backgroundColor }}; font-size: 12px; display: block; text-align: center;">{{ $jv->nama_jenis_voucher }}</span>
                                            </div>
                                            <div class="card hover-effect"
                                                style="flex: 1; margin: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); background-color: white; border-radius: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                                <button type="button" class="btn-cart"
                                                    style="background: transparent; border: none; display: flex; align-items: center;"
                                                    data-bs-toggle="modal" data-bs-target="#FormModal"
                                                    data-jenis-voucher="{{ $jv->id }}"
                                                    data-nama-voucher="{{ $jv->nama_jenis_voucher }}"
                                                    data-harga-voucher="{{ $jv->harga }}">
                                                    <img src="{{ asset('/assets/images/icon/cart.png') }}"
                                                        alt="Cart Icon" style="height: 20px; margin-right: 10px;">
                                                    <span
                                                        style="color: {{ $backgroundColor }}; font-size: 17px;">Beli</span></button>
                                            </div>
                                            @include('components.modal')
                                        </div>
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
                @endif
            </div>

            <!-- Modal -->
                    <div class="modal fade" id="FormModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content"
                        style="background: linear-gradient(to bottom, #A48AFD 70%, white 30%); border-radius: 20px 20px 20px 20px;">
                        <div class="card"
                            style="width: 32%; height: 40%; margin: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); margin-top: 5%; margin-left: 6%; background-color: white; border-radius: 20px; display: flex; flex-direction: column; padding: 20px;">
                            {{-- Card content --}}
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <img src="{{ asset('assets/img/logo/dutanet.png') }}" alt="DutaNet Logo"
                                    style="width: 30%; margin-right: 25px;">
                                <span style="color: {{ $backgroundColor }}; font-size: 8px;">
                                    <p id="hargaVoucherDisplay"></p>
                                </span>
                            </div>
                            <div style="height: 2px; margin-bottom: 4px; background-color: {{ $backgroundColor }};">
                            </div>
                            <span
                                style="color: {{ $backgroundColor }}; font-size: 10px; display: block; text-align: center;">
                                <div class="mb-6" id="jenisVoucherDisplay"></div>
                            </span>
                        </div>
                        <div style="margin-left: 42%; margin-top: -20%; font-size: 11px; color: white;">
                            <strong>Perhatian!</strong> <br>
                            Voucher yang anda beli tidak bisa dikembalikan. <br>
                            Pastikan anda membeli voucher yang benar.
                        </div>
                        <div class="card"
                            style="width: 100%; height: 45%;  margin-top: 10%; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);  background-color: white; border-radius: 20px; display: flex; flex-direction: column; padding: 20px;">
                            <form action="{{ route('tambah-keranjang') }}" method="POST">
                                @csrf
                                <input type="hidden" id="jenisVoucherId" name="jenis_voucher_id" value="">
                                <input type="hidden" id="namaVoucher" name="nama_jenis_voucher" value="">
                                <input type="hidden" id="hargaVoucher" name="harga" value="">
                                <div style="display: flex; justify-content: center; align-items: center; margin-bottom: -2%; margin-top: -3%;">
                                    <button type="button" class="btn" onclick="decrement()"><img
                                            src="{{ asset('assets/images/icon/minus.png') }}" alt="Minus"
                                            style="height: 15px; border: none; outline: none;"></button>
                                    <input type="text" id="qtyVoucher" name="qty" value="1"
                                        style="width: 50px; text-align: center;">
                                    <button type="button" class="btn" onclick="increment()"><img
                                            src="{{ asset('assets/images/icon/plus.png') }}" alt="Plus"
                                            style="height: 15px; border: none; outline: none;"></button>
                                </div>
                                <div style="display: flex; justify-content: center; margin-top: 10px;">
                                    <button type="submit"
                                        style="width: 50%; height: 60%; background-color: #5D37E1; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin: 4px 2px; border-radius: 25px;">Tambah
                                        ke Keranjang</button>
                                </div>

                            </form>

                            <script>
                                function decrement() {
                                    var input = document.getElementById("qtyVoucher");
                                    var value = parseInt(input.value, 10);
                                    if (value > 0) input.value = value - 1;
                                }

                                function increment() {
                                    var input = document.getElementById("qtyVoucher");
                                    var value = parseInt(input.value, 10);
                                    input.value = value + 1;
                                }
                            </script>
                        </div>

                    </div>
                    <div>

                    </div>
                </div>
            </div>

        </section>
        {{-- END VOUCHER SECTION --}}
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

        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        function showModal() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        function closeModal() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const jenisVoucherId = this.getAttribute('data-jenis-voucher');
                    const namaVoucher = this.getAttribute('data-nama-voucher');
                    const hargaVoucher = this.getAttribute('data-harga-voucher');

                    document.getElementById('jenisVoucherDisplay').innerText =
                        `${namaVoucher}`;
                    document.getElementById('hargaVoucherDisplay').innerText =
                        `Rp. ${hargaVoucher},-`;
                    document.getElementById('jenisVoucherId').value = jenisVoucherId;
                    document.getElementById('namaVoucher').value = namaVoucher;
                    document.getElementById('hargaVoucher').value = hargaVoucher;
                });
            });
        });
    </script>

</body>

</html>

