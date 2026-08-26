@extends('admin.layouts.app')

@section('title', 'Edit Project')
@section('page-title', 'Edit Project')
@section('page-subtitle', $project->name)

@section('content')
    <div class="admin-page-heading d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
        <div>
            <h2 class="fs-3 mb-1">Edit {{ $project->name }}</h2>
            <p class="text-secondary mb-0">Update project information and public visibility.</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-white"><i class="ti ti-arrow-left me-2"></i>Projects</a>
    </div>

    @include('admin.projects.partials.form', [
        'action' => route('admin.projects.update', $project),
        'method' => 'PUT',
        'submitLabel' => 'Save Changes',
        'project' => $project,
    ])
@endsection
