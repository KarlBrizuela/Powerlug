
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logs.jpg') }}" alt="logo" class="img-fluid" style="max-width: 200px; height: auto;">
            </div>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

             <div class="mb-3">
    <label for="password" class="form-label fw-semibold">Password</label>
    <div class="input-group">
        <input type="password" id="password" name="password" required
               class="form-control @error('password') is-invalid @enderror">
        <button type="button" class="btn btn-outline-secondary py-2" id="togglePassword" style="font-size: 0.875rem;">
            <i class="bi bi-eye-slash"></i>
        </button>
    </div>
    @error('password')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-decoration-none small">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100">Log In</button>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-primary text-decoration-none">Register</a>
                </small>
            </div>
        </div>
    </div>





    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });
        </script>
</body>
</html>
