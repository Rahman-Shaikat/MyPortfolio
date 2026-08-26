<!DOCTYPE html>
<html lang="en" class="expanded">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Shamsur Rahman">
    <meta name="robots" content="noindex,nofollow,noarchive">
    <title>@yield('title', 'Admin') | Shamsur Rahman</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/assets/images/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/assets/images/favicon/favicon-32x32.png') }}">
    <script src="{{ asset('admin/assets/js/vendors/color-modes.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.45.0/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/admin-portfolio.css') }}?v={{ filemtime(public_path('admin/assets/css/admin-portfolio.css')) }}">
</head>
<body>
    <aside id="miniSidebar">
        <div class="brand-logo">
            <a class="d-none d-md-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('admin/assets/images/brand/logo/logo-icon.svg') }}" class="admin-sidebar-logo" alt="Admin">
                <span id="adminNavigationLabel" class="fw-bold fs-4 site-logo-text">Portfolio</span>
            </a>
        </div>

        <ul class="navbar-nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon"><i class="ti ti-layout-dashboard fs-5"></i></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <div class="nav-heading">Portfolio</div>
                <hr class="mx-5 nav-line mb-1">
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.profiles.*') ? 'active' : '' }}" href="{{ route('admin.profiles.index') }}">
                    <span class="nav-icon"><i class="ti ti-user-circle fs-5"></i></span>
                    <span class="text">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">
                    <span class="nav-icon"><i class="ti ti-folders fs-5"></i></span>
                    <span class="text">Projects</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.publications.*') ? 'active' : '' }}" href="{{ route('admin.publications.index') }}">
                    <span class="nav-icon"><i class="ti ti-news fs-5"></i></span>
                    <span class="text">Publications</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}#contact">
                    <span class="nav-icon"><i class="ti ti-mail fs-5"></i></span>
                    <span class="text">Messages</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">
                    <span class="nav-icon"><i class="ti ti-external-link fs-5"></i></span>
                    <span class="text">View Site</span>
                </a>
            </li>
        </ul>

        <div class="admin-sidebar-profile text-center">
            <img src="{{ asset('admin/assets/images/avatar/avatar-1.jpg') }}" alt="Admin user" class="avatar avatar-md rounded-circle mb-3">
            <h5 class="mb-1 fs-6">Shamsur Rahman</h5>
            <span class="text-secondary small">Software Engineer</span>
        </div>
    </aside>

    <div class="offcanvasNav offcanvas offcanvas-start" tabindex="-1" id="adminNavigation" aria-labelledby="adminNavigationLabel">
        <div class="offcanvas-header">
            <a class="d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('admin/assets/images/brand/logo/logo-icon.svg') }}" class="admin-sidebar-logo" alt="Admin">
                <span class="fw-bold fs-4 site-logo-text">Portfolio</span>
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column gap-3">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="nav-link {{ request()->routeIs('admin.profiles.*') ? 'active' : '' }}" href="{{ route('admin.profiles.index') }}">Profile</a>
            <a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">Projects</a>
            <a class="nav-link {{ request()->routeIs('admin.publications.*') ? 'active' : '' }}" href="{{ route('admin.publications.index') }}">Publications</a>
            <a class="nav-link" href="{{ route('home') }}">View Site</a>
        </div>
    </div>

    <main id="content" class="position-relative h-100">
        <nav class="navbar-glass navbar navbar-expand-lg px-0 px-lg-4">
            <div class="container-fluid px-lg-0">
                <div class="d-flex align-items-center gap-4">
                    <div class="d-block d-lg-none">
                        <a class="text-inherit" data-bs-toggle="offcanvas" href="#adminNavigation" role="button" aria-controls="adminNavigation" aria-label="Open navigation">
                            <i class="ti ti-menu-2 fs-4"></i>
                        </a>
                    </div>
                    <div class="d-none d-lg-block">
                        <a class="sidebar-toggle d-flex texttooltip p-3" href="javascript:void(0)" aria-label="Toggle sidebar">
                            <span class="collapse-mini"><i class="ti ti-arrow-bar-left text-secondary fs-5"></i></span>
                            <span class="collapse-expanded"><i class="ti ti-arrow-bar-right text-secondary fs-5"></i></span>
                        </a>
                    </div>
                    <div>
                        <h1 class="fs-5 mb-0">@yield('page-title', 'Admin Dashboard')</h1>
                        <span class="text-secondary small">@yield('page-subtitle', 'Portfolio overview')</span>
                    </div>
                </div>

                <ul class="list-unstyled d-flex align-items-center mb-0 gap-2">
                    <li>
                        <div class="dropdown">
                            <button class="btn btn-ghost btn-icon rounded-circle d-flex align-items-center" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme">
                                <i class="ti theme-icon-active lh-1 fs-5"><i class="ti theme-icon ti-sun"></i></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light" aria-pressed="true"><i class="ti theme-icon ti-sun"></i><span class="ms-2">Light</span></button></li>
                                <li><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false"><i class="ti theme-icon ti-moon-stars"></i><span class="ms-2">Dark</span></button></li>
                                <li><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" aria-pressed="false"><i class="ti theme-icon ti-circle-half-2"></i><span class="ms-2">Auto</span></button></li>
                            </ul>
                        </div>
                    </li>
                    <li class="ms-2 dropdown">
                        <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('admin/assets/images/avatar/avatar-1.jpg') }}" alt="Admin user" class="avatar avatar-sm rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-0">
                            <div class="d-flex gap-3 align-items-center border-dashed border-bottom px-4 py-4">
                                <img src="{{ asset('admin/assets/images/avatar/avatar-1.jpg') }}" alt="Admin user" class="avatar avatar-md rounded-circle">
                                <div>
                                    <h4 class="mb-0 fs-5">Shamsur Rahman</h4>
                                    <p class="mb-0 text-secondary small">Portfolio Admin</p>
                                </div>
                            </div>
                            <div class="p-3">
                                <a href="{{ route('home') }}" class="dropdown-item d-flex align-items-center gap-2"><i class="ti ti-world"></i>View Portfolio</a>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2"><i class="ti ti-logout"></i>Logout</button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="custom-container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')

            <footer class="text-center text-secondary small pb-2 mt-6">
                Portfolio administration
            </footer>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
    <script src="{{ asset('admin/assets/js/vendors/sidebarnav.js') }}"></script>
    <script src="{{ asset('admin/assets/js/admin-portfolio.js') }}?v={{ filemtime(public_path('admin/assets/js/admin-portfolio.js')) }}"></script>
</body>
</html>
