
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | SITAK</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE4/dist/css/adminlte.css') }}">
</head>

<body class="bg-body-secondary">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header text-center bg-primary">
                        <h1 class="text-white">SITAK</h1>
                    </div>
                    <div class="card-body">
                        <p class="login-box-msg">Sign in to start your session</p>
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="Email" value="{{ old('email') }}" required autofocus>
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Password" required>
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="remember" id="remember" 
                                               {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Plugin(popperjs for Bootstrap 5) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('AdminLTE4/dist/js/adminlte.js') }}"></script>
</body>
</html>
