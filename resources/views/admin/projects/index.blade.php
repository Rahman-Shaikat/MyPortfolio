@extends('admin.layouts.app')

@section('title', 'Projects')
@section('page-title', 'Projects')
@section('page-subtitle', 'Manage portfolio work')

@section('content')
    <div class="admin-page-heading d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
        <div>
            <h2 class="fs-3 mb-1">Project library</h2>
            <p class="text-secondary mb-0">{{ $projects->count() }} project records</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary"><i class="ti ti-plus me-2"></i>Add Project</a>
    </div>

    <div class="card card-lg">
        <div class="card-body border-bottom">
            <form action="{{ route('admin.projects.index') }}" method="GET" class="admin-project-search d-flex flex-wrap gap-3">
                <div class="input-group admin-project-search-input">
                    <span class="input-group-text bg-transparent"><i class="ti ti-search"></i></span>
                    <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search projects" aria-label="Search projects">
                </div>
                <button type="submit" class="btn btn-dark">Search</button>
                @if ($search !== '')
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-white" aria-label="Clear search" title="Clear search"><i class="ti ti-x"></i></a>
                @endif
            </form>
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-3">
                <p class="text-secondary small mb-0">
                    @if ($search === '')
                        <i class="ti ti-grip-vertical me-1" aria-hidden="true"></i>Drag projects to change their display order.
                    @else
                        Clear the search to change project order.
                    @endif
                </p>
                <span class="admin-sort-status small" data-project-sort-status aria-live="polite"></span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 admin-project-table">
                <thead>
                    <tr>
                        <th scope="col"><span class="visually-hidden">Reorder</span></th>
                        <th scope="col">Project</th>
                        <th scope="col">Technologies</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody @if ($search === '') data-project-sortable data-reorder-url="{{ route('admin.projects.reorder') }}" @endif>
                    @forelse ($projects as $project)
                        <tr data-project-id="{{ $project->id }}">
                            <td class="admin-project-drag-cell">
                                @if ($search === '')
                                    <button type="button" class="admin-project-drag-handle" aria-label="Move {{ $project->name }}" title="Drag to reorder">
                                        <i class="ti ti-grip-vertical" aria-hidden="true"></i>
                                    </button>
                                @endif
                            </td>
                            <td class="admin-project-name-cell">
                                <div class="d-flex align-items-start gap-3">
                                    @if ($project->preview_image)
                                        <img src="{{ asset('storage/'.$project->preview_image) }}" class="admin-project-index-thumbnail" alt="{{ $project->name }} preview">
                                    @else
                                        <div class="admin-project-index-icon"><i class="ti ti-code"></i></div>
                                    @endif
                                    <div>
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <h3 class="fs-6 mb-0">{{ $project->name }}</h3>
                                            @if ($project->url)
                                                <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer" class="text-secondary" aria-label="Visit {{ $project->name }}" title="Visit project"><i class="ti ti-external-link"></i></a>
                                            @endif
                                        </div>
                                        <p class="text-secondary small mb-0 mt-1">{{ str($project->description)->limit(80) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1 admin-tech-list">
                                    @foreach (collect($project->technologies)->take(3) as $technology)
                                        <span class="badge bg-primary-subtle text-primary-emphasis">{{ $technology }}</span>
                                    @endforeach
                                    @if (collect($project->technologies)->count() > 3)
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis">+{{ collect($project->technologies)->count() - 3 }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $project->is_personal ? 'bg-info-subtle text-info-emphasis' : 'bg-secondary-subtle text-secondary-emphasis' }}">
                                    {{ $project->is_personal ? 'Personal' : 'Professional' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $project->status ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis' }}">
                                    {{ $project->status ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 admin-table-actions">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-white btn-icon btn-sm" aria-label="Edit {{ $project->name }}" title="Edit project"><i class="ti ti-pencil"></i></a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" data-confirm-delete="Delete {{ $project->name }}?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-white btn-icon btn-sm text-danger" aria-label="Delete {{ $project->name }}" title="Delete project"><i class="ti ti-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8">
                                <div class="admin-empty-icon mx-auto mb-3"><i class="ti ti-folder-off"></i></div>
                                <h3 class="fs-5 mb-1">No projects found</h3>
                                <p class="text-secondary mb-4">There are no records matching the current search.</p>
                                <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Add Project</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection

@push('scripts')
    @vite('resources/js/admin-project-sortable.js')
@endpush
