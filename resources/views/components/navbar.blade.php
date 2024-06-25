{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg py-2 navbar-dark position-relative" data-aos-once="true" data-aos="fade-down"
    data-aos-duration="1000" style="margin: 1rem; border-radius: 0.5rem; margin-left: 20px ">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand" href="#home">
            <img src="{{ asset('assets/img/logo/dutanet.png') }}" alt="Logo Brand" style="height: 30px; width: auto;">
        </a>
        <div class="collapse navbar-collapse order-lg-2 order-3" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto" style="gap: 1rem;">
                @php
                    $currentUrl = url()->current();
                @endphp
                <a class="nav-link py-1 py-lg-0 px-lg-3 {{ $currentUrl == url('/dashboard') ? 'active' : '' }}"
                    href="/dashboard">Home</a>
                <a class="nav-link py-1 py-lg-0 px-lg-3 {{ in_array($currentUrl, [url('/beli'), url('/keranjang'), url('/showcheckout'), url('/pembayaran'), url('/bayar-transaksi')]) ? 'active' : '' }}"
                    href="/beli">Beli</a>
                <a class="nav-link py-1 py-lg-0 px-lg-3 {{ $currentUrl == url('/riwayat-transaksi') ? 'active' : '' }}"
                    href="/riwayat-transaksi">Riwayat</a>
                <form action="{{ url('/logout') }}" class="nav-link py-1 py-lg-0 px-lg-3" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link p-0">
                        <img src="{{ asset('/assets/img/icon/logout.png') }}" alt="Logout Icon">
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
{{-- END NAVBAR --}}
