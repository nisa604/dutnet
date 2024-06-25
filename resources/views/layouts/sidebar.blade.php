<div class="sidebar-menu">
    <style>
        /* CSS untuk sidebar */
        .sidebar-menu {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 260px;
            background-color: white;
            border-radius: 25px;
            padding: 20px;
            margin-right: 20px;
            /* Menambahkan margin di sisi kanan */
            margin-top: 20px;
            /* Menambahkan margin di bagian atas */
            transform: translateX(20px);
            /* Menggeser sidebar ke kanan */
        }

        .sidebar-menu .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar-menu .logo img {
            width: 60px;
            height: 60px;
        }

        .sidebar-menu .menu {
            list-style-type: none;
            padding: 0;
        }

        .sidebar-menu .menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu .menu li a {
            display: block;
            color: #5D37E1;
            text-decoration: none;
            padding: 10px;
            border-radius: 15px;
            margin-top: 10%;
        }

        .sidebar-menu .menu li a:hover {
            background-color: #F4F4F4;
        }

        .menu-icon {
            margin-right: 10px;
            /* Adjust the space as needed */
        }
    </style>

    <div class="logo">
        <img src="{{ asset('assets/img/logo/dutanet.png') }}" alt="Logo Brand">
    </div>

    <hr class="custom-hr">
    <ul class="menu">
        <li><a href="/dashboard"><img src="{{ asset('assets/images/icon/dasbor.png') }}" alt="Dashboard Icon"
                    class="menu-icon" /> Dashboard</a>
        </li>
        <li><a href="/datapelanggan"><img src="{{ asset('assets/images/icon/akun.png') }}" alt="Users Icon"
                    class="menu-icon" />
                Akun Pelanggan</a>
        </li>
        <li><a href="/stokvoucher"><img src="{{ asset('assets/images/icon/stok.png') }}" alt="Boxes Icon"
                    class="menu-icon" /> Stok Voucher</a>
        </li>
        <li><a href="/rekappenjualan"><img src="{{ asset('assets/images/icon/rekap.png') }}" alt="Chart Line Icon"
                    class="menu-icon" /> Rekap
                Penjualan</a></li>
        <li><a href="/reward"><img src="{{ asset('assets/images/icon/reward.png') }}" alt="Reward Icon"
                    class="menu-icon" width="40" height="40" /> Data Reward</a></li>
    </ul>
</div>
