@extends('admin.layouts.app')

@section('title', 'Add Project')
@section('page-title', 'Add Project')
@section('page-subtitle', 'Create a new portfolio entry')

@section('content')
    <div class="admin-page-heading d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
        <div>
            <h2 class="fs-3 mb-1">New project</h2>
            <p class="text-secondary mb-0">Add the project details, technology stack, and publishing settings.</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-white"><i class="ti ti-arrow-left me-2"></i>Projects</a>
    </div>

    @include('admin.projects.partials.form', [
        'action' => route('admin.projects.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Project',
    ])
@endsection
