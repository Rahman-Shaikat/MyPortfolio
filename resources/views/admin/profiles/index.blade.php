@extends('admin.layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile')
@section('page-subtitle', 'Manage frontend information')

@section('content')
    <div class="admin-page-heading d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
        <div>
            <h2 class="fs-3 mb-1">Portfolio profile</h2>
            <p class="text-secondary mb-0">Identity, content, contact information, profile image, and resume.</p>
        </div>
        @if ($profile)
            <a href="{{ route('admin.profiles.edit', $profile) }}" class="btn btn-primary"><i class="ti ti-pencil me-2"></i>Edit Profile</a>
        @else
            <a href="{{ route('admin.profiles.create') }}" class="btn btn-primary"><i class="ti ti-plus me-2"></i>Create Profile</a>
        @endif
    </div>

    @if ($profile)
        <div class="card card-lg">
            <div class="card-body">
                <div class="row align-items-center g-5">
                    <div class="col-lg-auto">
                        <img src="{{ $profile->profile_image ? asset('storage/'.$profile->profile_image) : asset('assets/images/My_Pic.webp') }}" class="admin-profile-avatar" alt="{{ $profile->name }}">
                    </div>
                    <div class="col-lg">
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-2">
                            <h3 class="fs-3 mb-0">{{ $profile->name }}</h3>
                            <span class="badge bg-success-subtle text-success-emphasis">Active profile</span>
                        </div>
                        <p class="fs-5 mb-2">{{ $profile->professional_title }}</p>
                        <p class="text-secondary mb-4">{{ $profile->hero_description }}</p>
                        <div class="d-flex flex-wrap gap-2">
                            @if ($profile->email)<span class="badge bg-secondary-subtle text-secondary-emphasis"><i class="ti ti-mail me-1"></i>{{ $profile->email }}</span>@endif
                            @if ($profile->location)<span class="badge bg-secondary-subtle text-secondary-emphasis"><i class="ti ti-map-pin me-1"></i>{{ $profile->location }}</span>@endif
                            <span class="badge {{ $profile->resume ? 'bg-primary-subtle text-primary-emphasis' : 'bg-warning-subtle text-warning-emphasis' }}"><i class="ti ti-file-type-pdf me-1"></i>{{ $profile->resume ? 'Resume uploaded' : 'Resume missing' }}</span>
                        </div>
                    </div>
                    <div class="col-lg-auto">
                        <div class="d-flex gap-2">
                            <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="btn btn-white btn-icon" aria-label="View portfolio" title="View portfolio"><i class="ti ti-external-link"></i></a>
                            <form action="{{ route('admin.profiles.destroy', $profile) }}" method="POST" data-confirm-delete="Delete the portfolio profile?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-white btn-icon text-danger" aria-label="Delete profile" title="Delete profile"><i class="ti ti-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card card-lg">
            <div class="card-body text-center py-8">
                <div class="admin-empty-icon mx-auto mb-3"><i class="ti ti-user-off"></i></div>
                <h3 class="fs-5 mb-1">No profile configured</h3>
                <p class="text-secondary mb-4">Create the profile that supplies personal information to the frontend.</p>
                <a href="{{ route('admin.profiles.create') }}" class="btn btn-primary">Create Profile</a>
            </div>
        </div>
    @endif
@endsection
