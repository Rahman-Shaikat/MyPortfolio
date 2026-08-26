@extends('admin.layouts.app')

@section('title', 'Create Profile')
@section('page-title', 'Create Profile')
@section('page-subtitle', 'Configure frontend information')

@section('content')
    <div class="admin-page-heading mb-6">
        <h2 class="fs-3 mb-1">Create portfolio profile</h2>
        <p class="text-secondary mb-0">Add the information that will populate the public portfolio.</p>
    </div>

    @include('admin.profiles.partials.form', [
        'action' => route('admin.profiles.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Profile',
    ])
@endsection
