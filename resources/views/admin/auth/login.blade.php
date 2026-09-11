<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Shamsur Rahman">
    <meta name="robots" content="noindex,nofollow,noarchive">
    <title>Admin Login | Shamsur Rahman</title>
    <x-frontend::favicons />
    <script src="{{ asset('admin/assets/js/vendors/color-modes.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.45.0/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/admin-portfolio.css') }}">
</head>
<body class="admin-auth-body">
    <main class="admin-auth-shell d-flex align-items-center justify-content-center">
        <section class="admin-auth-card card card-lg">
            <div class="card-body p-6 p-md-8">
                <div class="text-center mb-6">
                    <a href="{{ route('home') }}" class="d-inline-flex align-items-center justify-content-center mb-4" aria-label="Back to portfolio">
                        <img src="{{ asset('admin/assets/images/brand/logo/logo-icon.svg') }}" class="admin-auth-logo" alt="Admin logo">
                    </a>
                    <h1 class="mb-2 fs-3 fw-bold">Admin Login</h1>
                    <p class="mb-0 text-secondary">Sign in to manage portfolio content and dashboard activity.</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Please check the email and password fields.
                    </div>
                @endif

                <form class="needs-validation" action="{{ route('admin.login.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">Email address</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="admin@example.com"
                            autocomplete="email"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Enter a valid email address.</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control fakePassword @error('password') is-invalid @enderror"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                            >
                            <button class="btn btn-outline-secondary admin-password-toggle" type="button" data-password-toggle="#password" aria-label="Toggle password visibility">
                                <i class="ti ti-eye-off" data-password-toggle-icon></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Password is required.</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-5">
                        <div class="form-check">
                            <input id="remember" name="remember" class="form-check-input" type="checkbox" value="1">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="{{ route('home') }}" class="text-secondary small">Back to site</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
    <script src="{{ asset('admin/assets/js/admin-portfolio.js') }}"></script>
</body>
</html>
