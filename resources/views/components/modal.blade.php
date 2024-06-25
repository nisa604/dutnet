<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content"
        style="background: linear-gradient(to bottom, #A48AFD 70%, white 30%); border-radius: 20px 20px 20px 20px;">
        <div class="card"
            style="width: 32%; height: 40%; margin: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); margin-top: 5%; margin-left: 6%; background-color: white; border-radius: 20px; display: flex; flex-direction: column; padding: 20px;">
            {{-- Card content --}}
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                <img src="{{ asset('assets/img/logo/dutanet.png') }}" alt="DutaNet Logo"
                    style="width: 30%; margin-right: 25px;">
                <span
                    style="color: {{ $backgroundColor }}; font-size: 8px;">{{ $harga }}</span>
            </div>
            <div style="height: 2px; margin-bottom: 4px; background-color: {{ $backgroundColor }};"></div>
            <span
                style="color: {{ $backgroundColor }}; font-size: 10px; display: block; text-align: center;">{{ $jv->nama_jenis_voucher }}</span>

        </div>
        <div style="margin-left: 42%; margin-top: -20%; font-size: 11px">
            <strong>Perhatian!</strong> <br>
            Voucher yang anda beli tidak bisa dikembalikan. <br>
            Pastikan anda membeli voucher yang benar.
        </div>
        <div class="card"
            style="width: 100%; height: 43%;  margin-top: 10%; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);  background-color: white; border-radius: 20px; display: flex; flex-direction: column; padding: 20px;">
            <div style="display: flex; align-items: center; justify-content: center;">
                <button onclick="decrement()" style="color: black; background: none; border: none; padding: 0;">
                    <img src="{{ asset('assets/images/icon/minus.png') }}" alt="Decrement"
                        style="width: 24px; height: 24px;">
                </button>
                <span id="counter" style="margin: 0 10px; color: black;">0</span>
                <button onclick="increment()" style="color: black; background: none; border: none; padding: 0;">
                    <img src="{{ asset('assets/images/icon/plus.png') }}" alt="increment"
                        style="width: 24px; height: 24px;">
                </button>
            </div>
            <div style="display: flex; justify-content: center; align-items: center; margin-top: 2% ">
                <button
                    style="width: 50%; height: 75%; background-color: #5D37E1; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin: 4px 2px; border-radius: 25px;">
                    Tambah ke keranjang
                </button>
            </div>

            <script>
                function increment() {
                    var counter = document.getElementById('counter');
                    counter.innerText = parseInt(counter.innerText) + 1;
                }

                function decrement() {
                    var counter = document.getElementById('counter');
                    counter.innerText = parseInt(counter.innerText) - 1;
                }
            </script>
        </div>
    </div>
</div>
