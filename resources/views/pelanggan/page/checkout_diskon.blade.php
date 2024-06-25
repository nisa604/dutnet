<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>

<body>
    <main>
        <section class="heroess position-relative" id="heroes">
        </section>
        {{-- VOUCHER SECTION --}}
        <section class="voucher section-gapp" id="voucher">
            <div class="text-center">
                <h2 class="text-black">Checkout</h2>
                <div class="d-flex justify-content-between" style="width: 60rem; margin: 0 auto; color; margin-top: 8%;">
                    <span style="width: 24%; text-align: center; color: black;">Jenis Voucher</span>
                    <span style="width: 13%; text-align: center; color: black;">Harga</span>
                    <span style="width: 20%; text-align: center; color: black;">Jumlah</span>
                    <span style="width: 12%; text-align: center; color: black;">Total Harga</span>
                    <span style="width: 7%;"></span>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center mt-4">
                <div class="card mb-4" style="width: 60rem; background-color: #F2F2F2; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        {{-- Kolom 1: Card --}}
                        <div style="width: 20%; margin-left: 2%; margin-top: 2%; margin-bottom: 1%;">
                            <div class="card" style="height: 40%; background-color: white; border-radius: 20px; display: flex; flex-direction: column; padding: 20px;">
                                {{-- Card content --}}
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <img src="{{ asset('assets/img/logo/dutanet.png') }}" alt="DutaNet Logo" style="width: 30%; margin-right: 25px;">
                                    <span style="color: black; font-size: 12px;">Rp. {{ $voucher['harga'] }}</span>
                                </div>
                                <div style="height: 2px; background-color: black;"></div>
                                <span style="color: black; font-size: 12px; display: block; text-align: center;">{{ $voucher['nama_jenis_voucher'] }}</span>
                            </div>
                        </div>
                        {{-- Kolom 2: Harga Price --}}
                        <div style="width: 15%; text-align: right;">
                            <span style="color: black; font-size: 12px;">Rp. {{ $voucher['harga'] }}</span>
                        </div>
                        {{-- Kolom 3: Jumlah --}}
                        <div style="width: 40%; display: flex; align-items: center; justify-content: center;">
                            <span style="margin: 0 10px; color: black;">{{ $voucher['qty'] }}</span>
                        </div>
                        {{-- Kolom 4: Total Harga --}}
                        <div style="width: 12%;">
                            <span style="color: black;">Rp. {{ $voucher['harga'] * $voucher['qty'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div style="text-align: right; margin-right: 22%; margin-top: 20px; font-size: 18px; font-weight: bold; color:black">
                Total Belanja: <span style="color: #5D37E1;">Rp. {{ $voucher['harga'] * $voucher['qty'] }}</span>
            </div>
            <form action="{{ route('pembayaran') }}" method="POST" style="margin-top: -2%; margin-left: 16%">
                @csrf
                {{-- Isi form pembayaran --}}
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_pembayaran" id="shopeepay" value="ShopeePay" checked>
                    <label class="form-check-label" for="shopeepay" style="color: black">
                        ShopeePay
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_pembayaran" id="dana" value="DANA">
                    <label class="form-check-label" for="dana" style="color: black">
                        DANA
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_pembayaran" id="ovo" value="OVO">
                    <label class="form-check-label" for="ovo" style="color: black">
                        OVO
                    </label>
                </div>
                <br>
                <div style="text-align: center; margin-top: 25px; margin-right: 12%">
                    <button type="submit" style="width: 20%; height: 75%; background-color: #5D37E1; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin: 4px 2px; border-radius: 25px;">Bayar</button>
                </div>
            </form>
        </section>
    </main>
</body>

</html>
