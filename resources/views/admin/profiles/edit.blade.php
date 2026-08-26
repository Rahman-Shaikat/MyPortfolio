@extends('admin.layouts.app')

@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')
@section('page-subtitle', $profile->name)

@section('content')
    <div class="admin-page-heading d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
        <div>
            <h2 class="fs-3 mb-1">Edit portfolio profile</h2>
            <p class="text-secondary mb-0">Changes are reflected across the public frontend after saving.</p>
        </div>
        <a href="{{ route('admin.profiles.index') }}" class="btn btn-white"><i class="ti ti-arrow-left me-2"></i>Profile</a>
    </div>

    @include('admin.profiles.partials.form', [
        'action' => route('admin.profiles.update', $profile),
        'method' => 'PUT',
        'submitLabel' => 'Save Profile',
        'profile' => $profile,
    ])
@endsection
