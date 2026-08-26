<!DOCTYPE html>
<html lang="en" class="expanded">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Shamsur Rahman">
    <title>Admin Dashboard | Shamsur Rahman</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/assets/images/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/assets/images/favicon/favicon-32x32.png') }}">
    <script src="{{ asset('admin/assets/js/vendors/color-modes.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.45.0/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/admin-portfolio.css') }}">
</head>
<body>
    <aside id="miniSidebar">
        <div class="brand-logo">
            <a class="d-none d-md-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('admin/assets/images/brand/logo/logo-icon.svg') }}" class="admin-sidebar-logo" alt="Admin">
                <span class="fw-bold fs-4 site-logo-text">Portfolio</span>
            </a>
        </div>

        <ul class="navbar-nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 4h6v8h-6z"/>
                            <path d="M14 4h6v5h-6z"/>
                            <path d="M14 13h6v7h-6z"/>
                            <path d="M4 16h6v4h-6z"/>
                        </svg>
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <div class="nav-heading">Portfolio</div>
                <hr class="mx-5 nav-line mb-1">
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('projects.index') }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"/>
                            <path d="M8 9h8"/>
                            <path d="M8 13h6"/>
                        </svg>
                    </span>
                    <span class="text">Projects</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}#contact">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 7l9 6l9 -6"/>
                            <path d="M5 5h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2z"/>
                        </svg>
                    </span>
                    <span class="text">Messages</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}" target="_blank">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"/>
                            <path d="M11 13l9 -9"/>
                            <path d="M15 4h5v5"/>
                        </svg>
                    </span>
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

    <div class="offcanvasNav offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <a class="d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('admin/assets/images/brand/logo/logo-icon.svg') }}" class="admin-sidebar-logo" alt="Admin">
                <span class="fw-bold fs-4 site-logo-text">Portfolio</span>
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <a class="nav-link active d-flex align-items-center gap-2 mb-3" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="nav-link d-flex align-items-center gap-2 mb-3" href="{{ route('projects.index') }}">Projects</a>
            <a class="nav-link d-flex align-items-center gap-2 mb-3" href="{{ route('home') }}">View Site</a>
        </div>
    </div>

    <main id="content" class="position-relative h-100">
        <nav class="navbar-glass navbar navbar-expand-lg px-0 px-lg-4">
            <div class="container-fluid px-lg-0">
                <div class="d-flex align-items-center gap-4">
                    <div class="d-block d-lg-none">
                        <a class="text-inherit" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" aria-label="Open navigation">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 6h16"/>
                                <path d="M4 12h16"/>
                                <path d="M4 18h16"/>
                            </svg>
                        </a>
                    </div>
                    <div class="d-none d-lg-block">
                        <a class="sidebar-toggle d-flex texttooltip p-3" href="javascript:void(0)" aria-label="Toggle sidebar">
                            <span class="collapse-mini"><i class="ti ti-arrow-bar-left text-secondary fs-5"></i></span>
                            <span class="collapse-expanded"><i class="ti ti-arrow-bar-right text-secondary fs-5"></i></span>
                        </a>
                    </div>
                    <div>
                        <h1 class="fs-5 mb-0">Admin Dashboard</h1>
                        <span class="text-secondary small">Portfolio overview</span>
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
                                <a href="{{ route('home') }}" class="dropdown-item d-flex align-items-center gap-2">View Portfolio</a>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2">Logout</button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="custom-container">
            <section class="row mb-6 g-6">
                <div class="col-xl-8 col-lg-7">
                    <div class="admin-dashboard-hero bg-gradient-mixed p-8 py-10 rounded-3 p-lg-7">
                        <h2 class="fs-3 mb-3">Welcome back, Shamsur.</h2>
                        <p class="mb-1">Manage project highlights, review portfolio activity, and keep your Software Engineer profile ready for clients.</p>
                        <p class="mb-5">This admin area uses the Dasher dashboard resources integrated into Laravel Blade.</p>
                        <a href="{{ route('projects.index') }}" class="btn btn-dark">Review Projects</a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="card card-lg h-100">
                        <div class="card-body">
                            <h3 class="fs-5 mb-4">Quick Actions</h3>
                            <div class="d-grid gap-3">
                                <a href="{{ route('home') }}#contact" class="btn btn-white justify-content-start">Check contact section</a>
                                <a href="{{ route('projects.index') }}" class="btn btn-white justify-content-start">Open projects page</a>
                                <a href="{{ route('home') }}" class="btn btn-primary justify-content-start">View live portfolio</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="row row-cols-1 row-cols-xl-3 row-cols-md-3 mb-6 g-6">
                <div class="col">
                    <div class="card card-lg h-100">
                        <div class="card-body d-flex flex-column gap-8">
                            <div class="d-flex align-items-center gap-3">
                                <div class="admin-stat-icon icon-shape icon-lg rounded-circle bg-warning-darker text-warning-lighter"><i class="ti ti-folders fs-4"></i></div>
                                <div>Published Projects</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center lh-1">
                                <div class="fs-3 fw-bold">6</div>
                                <div class="text-success small">Ready</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-lg h-100">
                        <div class="card-body d-flex flex-column gap-8">
                            <div class="d-flex align-items-center gap-3">
                                <div class="admin-stat-icon icon-shape icon-lg rounded-circle bg-success-darker text-success-lighter"><i class="ti ti-code fs-4"></i></div>
                                <div>Core Services</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center lh-1">
                                <div class="fs-3 fw-bold">7</div>
                                <div class="text-success small">Visible</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-lg h-100">
                        <div class="card-body d-flex flex-column gap-8">
                            <div class="d-flex align-items-center gap-3">
                                <div class="admin-stat-icon icon-shape icon-lg rounded-circle bg-info-darker text-info-lighter"><i class="ti ti-mail fs-4"></i></div>
                                <div>Contact Status</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center lh-1">
                                <div class="fs-3 fw-bold">Active</div>
                                <div class="text-success small">Online</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="row g-6 mb-6">
                <div class="col-xl-8">
                    <div class="card card-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-5">
                                <div>
                                    <h3 class="fs-5 mb-1">Recent Portfolio Items</h3>
                                    <p class="mb-0 text-secondary">Featured work currently shown to visitors.</p>
                                </div>
                                <a href="{{ route('projects.index') }}" class="btn btn-white btn-sm">All Projects</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Project</th>
                                            <th scope="col">Stack</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ asset('admin/assets/images/ecommerce/product-1.jpg') }}" class="rounded admin-table-avatar" alt="Project thumbnail">
                                                    <div>
                                                        <h4 class="fs-6 mb-0">Commerce Operations Platform</h4>
                                                        <span class="text-secondary small">Laravel eCommerce back office</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Laravel, MySQL</td>
                                            <td><span class="badge bg-success-subtle text-success-emphasis">Featured</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ asset('admin/assets/images/ecommerce/product-2.jpg') }}" class="rounded admin-table-avatar" alt="Project thumbnail">
                                                    <div>
                                                        <h4 class="fs-6 mb-0">API Integration Hub</h4>
                                                        <span class="text-secondary small">Webhook and REST API service</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>REST API, Queues</td>
                                            <td><span class="badge bg-primary-subtle text-primary-emphasis">Published</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ asset('admin/assets/images/ecommerce/product-3.jpg') }}" class="rounded admin-table-avatar" alt="Project thumbnail">
                                                    <div>
                                                        <h4 class="fs-6 mb-0">Analytics Admin Dashboard</h4>
                                                        <span class="text-secondary small">Reporting and filtered metrics</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Blade, JavaScript</td>
                                            <td><span class="badge bg-primary-subtle text-primary-emphasis">Published</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card card-lg h-100">
                        <div class="card-body">
                            <h3 class="fs-5 mb-4">Maintenance Checklist</h3>
                            <div class="d-flex flex-column gap-4">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Done</span>
                                    <span>Portfolio homepage polished</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Done</span>
                                    <span>Projects page with pagination</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Next</span>
                                    <span>Connect real admin authentication</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Next</span>
                                    <span>Add editable project records</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="text-center text-secondary small pb-2">
                Admin dashboard template resources integrated from Dasher.
            </footer>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
    <script src="{{ asset('admin/assets/js/vendors/sidebarnav.js') }}"></script>
</body>
</html>
