<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ meta('description') }}">
    <meta name="keywords" content="{{ meta('keywords') }}">
    <meta name="author" content="{{ meta('author') }}">

    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://ajifatur.github.io/assets/dist/2.0.0/spandiv.min.css">

    <title>Log in | {{ config('app.name') }}</title>
    <style>
        body, body main {min-height: 100vh; background-color: #eeedf5;}
        .card {border-radius: 1rem;}
        .login-box {min-height: calc(100vh - 200px); text-align: center; width: 75%; margin: auto;}
        .login-image-box {min-height: calc(100vh - 200px); align-items: center; margin-top: .75rem; margin-bottom: .75rem; background-color: #efeef6; border-color: #efeef6;}
        .btn[type=submit] {background-color: #9e60c0; color: #fff;}
        @media(max-width: 575px) {
            .login-box {min-height: calc(100vh - 2px);}
            .container.card {border-radius: 0px;}
        }
    </style>
</head>
<body>
    <main class="d-flex align-items-center">
        <div class="container card shadow">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">
                    <form class="login-box row align-items-center" method="post" action="{{ route('auth.login') }}">
                        <div>
                            @csrf
                            <h1 class="h3 mb-3 fw-normal">Selamat Datang</h1>
                            @if($errors->has('message'))
                            <div class="alert alert-danger" role="alert">{{ $errors->first('message') }}</div>
                            @endif
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'border-danger' : '' }}" value="{{ old('username') }}"  placeholder="{{ setting('allow_login_by_email') == 1 ? 'Email atau Username' : 'Username' }}" autofocus>
                                @if($errors->has('username'))
                                <div class="small text-danger text-start">{{ $errors->first('username') }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'border-danger' : '' }}" placeholder="Password">
                                    <button type="button" class="btn {{ $errors->has('password') ? 'btn-outline-danger' : 'btn-outline-secondary' }} btn-toggle-password"><i class="bi-eye"></i></button>
                                </div>
                                @if($errors->has('password'))
                                <div class="small text-danger text-start">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                            <button class="w-100 btn" type="submit">Masuk</button>
                            @if(setting('socialite') == 1)
                            <p class="mt-3 mb-1">Atau masuk melalui:</p>
                            <div class="btn-group w-100">
                                @if((config('services.google')) != null)
                                <a href="{{ route('auth.login.provider', ['provider' => 'google']) }}" class="btn btn-outline-primary"><i class="bi-google me-2"></i> Google</a>
                                @endif
                                @if((config('services.facebook')) != null)
                                <a href="{{ route('auth.login.provider', ['provider' => 'facebook']) }}" class="btn btn-outline-primary"><i class="bi-facebook me-2"></i> Facebook</a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="col-12 col-lg-6 d-none d-lg-block">
                    <div class="card login-image-box" style="">
                        <img src="{{ asset('assets/images/login/img-login.png') }}" alt="img" class="img-fluid" style="max-width: 90%">
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://ajifatur.github.io/assets/dist/2.0.0/spandiv.min.js"></script>
</body>
</html>