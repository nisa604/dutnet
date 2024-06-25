<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar akun Dutanet</title>
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="auth">
        <main class="main-content  mt-0">
            <section class="min-vh-100 mb-8">
                <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('{{ asset('assets/images/bg/curved14.jpg') }}');">
                    <span class="mask bg-gradient-dark opacity-6"></span>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5 text-center mx-auto">
                                <h1 class="text-white mb-2 mt-5">Daftar Akun</h1>
                                <p class="text-lead text-white">Masukkan email, nama, dan password anda untuk mendaftar</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row mt-lg-n10 ">
                        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                            <div class="card z-index-0">
                                <div class="card-body">
                                    <!-- <h5 class="text-center">Daftar Akun</h5> -->
                                    <br>
                                    @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <form role="form text-left" action="{{ route('register.post') }}" method="post" autocomplete="off">
                                        @csrf
                                        <div class="mb-3">
                                            <h6 class="px-1">Nama</h6>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama" name="name" value="{{ old('name') }}">
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="px-1">Email</h6>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" name="email" value="{{ old('email') }}">
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <input type="hidden" id="role" name="role" value="User">
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="px-1">Password</h6>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password" name="password">
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-check form-check-info text-left">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-dark w-100 mb-2">Daftar</button>
                                            <p class="text-sm mt-3 mb-0">Sudah Punya Akun? <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Masuk</a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
