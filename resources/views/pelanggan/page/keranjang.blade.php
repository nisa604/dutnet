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
        {{-- HEROESS SECTION --}}
        <section class="heroess position-relative" id="heroes">
        </section>
        {{-- END HEROESS SECTION --}}

        {{-- VOUCHER SECTION --}}
        <section class="voucher section-gapp" id="voucher">

            <div class="text-center">
                <h2 class="text-black">Keranjang</h2>
                <div class="d-flex justify-content-between"
                    style="width: 60rem; margin: 0 auto; color; margin-top: 8%;">
                    <span style="width: 24%; text-align: center; color: black;">Jenis Voucher</span>
                    <span style="width: 13%; text-align: center; color: black;">Harga</span>
                    <span style="width: 20%; text-align: center; color: black;">Jumlah</span>
                    <span style="width: 12%; text-align: center; color: black;">Total Harga</span>
                    <span style="width: 7%;"></span>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center mt-4">
                @foreach ($keranjang as $index => $item)
                    @php
                        $colors = ['#7482FF', '#FA9FF8', '#71CD71', '#FAA300'];
                        $backgroundColor = $colors[$index % count($colors)];
                    @endphp
                    <div class="card mb-4 d-flex flex-row justify-content-between align-items-center"
                        style="width: 60rem; background-color: #F2F2F2; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); border-radius: 20px;">
                        {{-- Kolom 1: Card --}}
                        <div class="card"
                            style="width: 20%; height: 40%; margin: 15px; background-color: white; border-radius: 20px; display: flex; flex-direction: column; padding: 20px;">
                            {{-- Card content --}}
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <img src="{{ asset('assets/img/logo/dutanet.png') }}" alt="DutaNet Logo"
                                    style="width: 30%; margin-right: 25px;">
                                <span style="color: {{ $backgroundColor }}; font-size: 12px;">Rp.
                                    {{ $item['harga'] }}</span>
                            </div>
                            <div style="height: 2px; background-color: {{ $backgroundColor }};"></div>
                            <span
                                style="color: {{ $backgroundColor }}; font-size: 12px; display: block; text-align: center;">{{ $item['nama_jenis_voucher'] }}</span>

                        </div>
                        {{-- Kolom 2: Harga Price --}}
                        <div class="card-price" style="width: 15%; text-align: right;"
                            data-price="{{ $item['harga'] }}">
                            <span style="color: black; font-size: 12px;">Rp. {{ $item['harga'] }}</span>
                        </div>
                        {{-- Kolom 3: Decrement/Increment --}}
                        <div class="card-counter"
                            style="width: 40%; display: flex; align-items: center; justify-content: center;">
                            <button type="button" class="btn"
                                onclick="updateQty({{ $index }}, -1)">
                                <img src="{{ asset('assets/images/icon/minus.png') }}" alt="Minus" style="height: 15px;">
                            </button>
                            <input type="number" name="qty_update" id="qty_{{ $index }}" class="form-control"
                                value="{{ $item['qty'] }}" min="1" style="width: 60px; text-align: center;"
                                data-price="{{ $item['harga'] }}"
                                data-voucher-name="{{ $item['nama_jenis_voucher'] }}" readonly>
                            <button type="button" class="btn"
                                onclick="updateQty({{ $index }}, 1)"><img src="{{ asset('assets/images/icon/plus.png') }}" alt="Plus" style="height: 15px;"></button>
                        </div>
                        {{-- Kolom 4: Total Harga --}}
                        <div class="card-total" style="width: 12%;">
                            <span id="total_{{ $index }}" style="color: black;">Rp.
                                {{ $item['harga'] * $item['qty'] }}</span>
                        </div>
                        {{-- Kolom 5: Delete Button --}}
                        <div class="card-delete" style="width: 7%;">
                            <form action="{{ route('update-keranjang', $index) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="hapus_item">
                                <button type="submit" class="btn"><img src="{{ asset('assets/images/icon/delete.png') }}" alt="Delete" style="height: 20px; width: 20px;"></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div
                style="text-align: right; margin-right: 22%; margin-top: 20px; font-size: 18px; font-weight: bold; color:black">
                Total Belanja: <span id="totalBelanja" style="color: #5D37E1;">Rp. {{ $totalBelanja }} <span
                        style="color: #5D37E1;"></span></span>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <form action="{{ route('showcheckout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        style="width: 20%; height: 75%; background-color: #5D37E1; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin: 4px 2px; border-radius: 25px;">Checkout</button>
                </form>
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

        document.addEventListener('DOMContentLoaded', function() {
            var jenisVoucher = '5000_24JAM'; // Jenis voucher yang diperiksa
            var hargavoucher = 5000; // Harga voucher yang diharapkan

            var qtyInput = document.getElementsByName('qty_update');
            qtyInput.forEach(function(input) {
                var voucherName = input.getAttribute('data-voucher-name');
                var hargaVoucher = parseInt(input.getAttribute('data-price'));
                if (voucherName === jenisVoucher && hargaVoucher !== hargavoucher) {
                    input.addEventListener('input', function(event) {
                        event.preventDefault();
                        alert('Anda hanya dapat membeli 1 voucher diskon');
                        input.value = 1;
                    });
                }
            });
        });

        function updateQty(index, delta) {
            let qtyInput = document.getElementById('qty_' + index);
            let newQty = parseInt(qtyInput.value) + delta;
            if (newQty < 1) {
                newQty = 1;
            }

            var hargaVoucher = parseInt(qtyInput.getAttribute('data-price'));
            var jenisVoucher = qtyInput.getAttribute('data-voucher-name');

            if (jenisVoucher === '5000_24JAM' && hargaVoucher !== 5000) {
                alert('Anda hanya dapat membeli 1 voucher diskon');
                qtyInput.value = 1;
            } else {
                qtyInput.value = newQty;

                // Update total price for the item
                let price = parseInt(qtyInput.closest('.card').querySelector('.card-price').getAttribute('data-price'));
                document.getElementById('total_' + index).innerText = 'Rp. ' + (newQty * price);

                // Update total shopping price
                updateTotalBelanja();

                // Send AJAX request to update the cart on the server
                let xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('update-keranjang', '') }}/' + index, true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.send('qty_update=' + newQty + '&_method=PUT');

                xhr.onload = function() {
                    if (xhr.status != 200) {
                        alert('Error: ' + xhr.status + ' - ' + xhr.statusText);
                    }
                };
            }
        }

        function updateTotalBelanja() {
            let totalBelanja = 0;
            document.querySelectorAll('input[name="qty_update"]').forEach(function(input) {
                let qty = parseInt(input.value);
                let price = parseInt(input.closest('.card').querySelector('.card-price').getAttribute(
                    'data-price'));
                totalBelanja += qty * price;
            });
            document.getElementById('totalBelanja').innerText = 'Rp. ' + totalBelanja;
        }
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
