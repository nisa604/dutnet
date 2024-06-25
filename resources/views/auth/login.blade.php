<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Dutanet</title>
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="auth">
        <main class="main-content  mt-0">
    <section class="min-vh-100 mb-8">
      <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../assets/images/bg/curved8.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5 text-center mx-auto">
              <h1 class="text-white mb-2 mt-5">Selamat Datang!</h1>
              <p class="text-lead text-white">Masukkan email dan password anda untuk masuk ke aplikasi</p>
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
                <form role="form text-left" action="/login" method="post" autocomplete="off">
                  @csrf
                  <div class="mb-3">
                    <h6 class="px-1">Email</h6>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" name="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror  
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
                    <button type="submit" class="btn bg-gradient-info w-100 mb-2">Masuk</button>
                    <p class="text-sm mt-3 mb-0">Belum Punya Akun? <a href="{{ route('register.form') }}" class="text-info text-gradient font-weight-bold">Daftar</a></p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

</body>
</html>
