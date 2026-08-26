@extends('admin.layouts.app')

@section('title', 'Edit Publication')
@section('page-title', 'Edit Publication')
@section('page-subtitle', $publication->title)

@section('content')
    <div class="admin-page-heading d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
        <div>
            <h2 class="fs-3 mb-1">Edit {{ $publication->title }}</h2>
            <p class="text-secondary mb-0">Update publication information and public visibility.</p>
        </div>
        <a href="{{ route('admin.publications.index') }}" class="btn btn-white"><i class="ti ti-arrow-left me-2"></i>Publications</a>
    </div>

    @include('admin.publications.partials.form', [
        'action' => route('admin.publications.update', $publication),
        'method' => 'PUT',
        'submitLabel' => 'Save Changes',
        'publication' => $publication,
    ])
@endsection
