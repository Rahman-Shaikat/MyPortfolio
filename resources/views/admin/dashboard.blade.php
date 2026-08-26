@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Portfolio overview')

@section('content')
    <section class="row mb-6 g-6">
        <div class="col-xl-8 col-lg-7">
            <div class="admin-dashboard-hero bg-gradient-mixed p-8 py-10 rounded-3 p-lg-7">
                <h2 class="fs-3 mb-3">Welcome back, Shamsur.</h2>
                <p class="mb-1">Manage project highlights, review portfolio activity, and keep your Software Engineer profile ready for clients.</p>
                <p class="mb-5">Your published project records feed the homepage and complete projects page.</p>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-dark">Manage Projects</a>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card card-lg h-100">
                <div class="card-body">
                    <h3 class="fs-5 mb-4">Quick Actions</h3>
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.profiles.index') }}" class="btn btn-primary justify-content-start"><i class="ti ti-user-circle me-2"></i>Manage profile</a>
                        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary justify-content-start"><i class="ti ti-plus me-2"></i>Add project</a>
                        <a href="{{ route('admin.publications.create') }}" class="btn btn-white justify-content-start"><i class="ti ti-news me-2"></i>Add publication</a>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-white justify-content-start"><i class="ti ti-folders me-2"></i>Manage projects</a>
                        <a href="{{ route('home') }}" class="btn btn-white justify-content-start" target="_blank" rel="noopener noreferrer"><i class="ti ti-external-link me-2"></i>View portfolio</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row row-cols-1 row-cols-xl-4 row-cols-md-2 mb-6 g-6">
        <div class="col">
            <div class="card card-lg h-100">
                <div class="card-body d-flex flex-column gap-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="admin-stat-icon icon-shape icon-lg rounded-circle bg-warning-darker text-warning-lighter"><i class="ti ti-folders fs-4"></i></div>
                        <div>Published Projects</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center lh-1">
                        <div class="fs-3 fw-bold">{{ $activeProjectCount }}</div>
                        <div class="text-success small">Live</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-lg h-100">
                <div class="card-body d-flex flex-column gap-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="admin-stat-icon icon-shape icon-lg rounded-circle bg-primary-darker text-primary-lighter"><i class="ti ti-news fs-4"></i></div>
                        <div>Publications</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center lh-1">
                        <div class="fs-3 fw-bold">{{ $publishedPublicationCount }}</div>
                        <div class="text-success small">Published</div>
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
                        <div class="admin-stat-icon icon-shape icon-lg rounded-circle bg-info-darker text-info-lighter"><i class="ti ti-world fs-4"></i></div>
                        <div>Portfolio Status</div>
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
                            <h3 class="fs-5 mb-1">Featured Portfolio Items</h3>
                            <p class="mb-0 text-secondary">The first three published projects by sort order.</p>
                        </div>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-white btn-sm">Manage</a>
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
                                @forelse ($featuredProjects as $project)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $project->preview_image ? asset('storage/'.$project->preview_image) : asset('admin/assets/images/ecommerce/product-'.$loop->iteration.'.jpg') }}" class="rounded admin-table-avatar" alt="{{ $project->name }} thumbnail">
                                                <div>
                                                    <h4 class="fs-6 mb-0">{{ $project->name }}</h4>
                                                    <span class="text-secondary small">{{ str($project->description)->limit(54) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ collect($project->technologies)->take(2)->join(', ') }}</td>
                                        <td><span class="badge bg-success-subtle text-success-emphasis">Published</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-5 text-center text-secondary">No published projects found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card card-lg h-100">
                <div class="card-body">
                    <h3 class="fs-5 mb-4">Portfolio Checklist</h3>
                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex align-items-center gap-3"><span class="badge bg-success-subtle text-success-emphasis rounded-pill">Done</span><span>Responsive public portfolio</span></div>
                        <div class="d-flex align-items-center gap-3"><span class="badge bg-success-subtle text-success-emphasis rounded-pill">Done</span><span>Database project catalogue</span></div>
                        <div class="d-flex align-items-center gap-3"><span class="badge bg-success-subtle text-success-emphasis rounded-pill">Done</span><span>Project CRUD management</span></div>
                        <div class="d-flex align-items-center gap-3"><span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Next</span><span>Database-backed admin authentication</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
