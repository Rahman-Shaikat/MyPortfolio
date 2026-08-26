@extends('admin.layouts.app')

@section('title', 'Add Publication')
@section('page-title', 'Add Publication')
@section('page-subtitle', 'Create a new publication entry')

@section('content')
    <div class="admin-page-heading d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
        <div>
            <h2 class="fs-3 mb-1">New publication</h2>
            <p class="text-secondary mb-0">Add publication details, artwork, and publishing settings.</p>
        </div>
        <a href="{{ route('admin.publications.index') }}" class="btn btn-white"><i class="ti ti-arrow-left me-2"></i>Publications</a>
    </div>

    @include('admin.publications.partials.form', [
        'action' => route('admin.publications.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Publication',
    ])
@endsection
