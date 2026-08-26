@extends('admin.layouts.app')

@section('title', 'Publications')
@section('page-title', 'Publications')
@section('page-subtitle', 'Manage published work')

@section('content')
    <div class="admin-page-heading d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
        <div>
            <h2 class="fs-3 mb-1">Publication library</h2>
            <p class="text-secondary mb-0">{{ $publications->total() }} publication records</p>
        </div>
        <a href="{{ route('admin.publications.create') }}" class="btn btn-primary"><i class="ti ti-plus me-2"></i>Add Publication</a>
    </div>

    <div class="card card-lg">
        <div class="card-body border-bottom">
            <form action="{{ route('admin.publications.index') }}" method="GET" class="admin-project-search d-flex flex-wrap gap-3">
                <div class="input-group admin-project-search-input">
                    <span class="input-group-text bg-transparent"><i class="ti ti-search"></i></span>
                    <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search publications" aria-label="Search publications">
                </div>
                <button type="submit" class="btn btn-dark">Search</button>
                @if ($search !== '')
                    <a href="{{ route('admin.publications.index') }}" class="btn btn-white" aria-label="Clear search" title="Clear search"><i class="ti ti-x"></i></a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 admin-project-table">
                <thead>
                    <tr>
                        <th scope="col">Order</th>
                        <th scope="col">Publication</th>
                        <th scope="col">Publisher</th>
                        <th scope="col">Published</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($publications as $publication)
                        <tr>
                            <td class="fw-semibold">{{ $publication->sort_order }}</td>
                            <td class="admin-project-name-cell">
                                <div class="d-flex align-items-start gap-3">
                                    @if ($publication->image)
                                        <img src="{{ asset('storage/'.$publication->image) }}" class="admin-project-index-thumbnail" alt="{{ $publication->title }} image">
                                    @else
                                        <div class="admin-project-index-icon"><i class="ti ti-news"></i></div>
                                    @endif
                                    <div>
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <h3 class="fs-6 mb-0">{{ $publication->title }}</h3>
                                            @if ($publication->url)
                                                <a href="{{ $publication->url }}" target="_blank" rel="noopener noreferrer" class="text-secondary" aria-label="Open {{ $publication->title }}" title="Open publication"><i class="ti ti-external-link"></i></a>
                                            @endif
                                        </div>
                                        <p class="text-secondary small mb-0 mt-1">{{ str($publication->description)->limit(90) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $publication->publisher ?: 'Not specified' }}</td>
                            <td>{{ $publication->published_at?->format('M j, Y') ?: 'Not specified' }}</td>
                            <td>
                                <span class="badge {{ $publication->status ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis' }}">
                                    {{ $publication->status ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 admin-table-actions">
                                    <a href="{{ route('admin.publications.edit', $publication) }}" class="btn btn-white btn-icon btn-sm" aria-label="Edit {{ $publication->title }}" title="Edit publication"><i class="ti ti-pencil"></i></a>
                                    <form action="{{ route('admin.publications.destroy', $publication) }}" method="POST" data-confirm-delete="Delete {{ $publication->title }}?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-white btn-icon btn-sm text-danger" aria-label="Delete {{ $publication->title }}" title="Delete publication"><i class="ti ti-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8">
                                <div class="admin-empty-icon mx-auto mb-3"><i class="ti ti-book-off"></i></div>
                                <h3 class="fs-5 mb-1">No publications found</h3>
                                <p class="text-secondary mb-4">There are no publication records matching the current search.</p>
                                <a href="{{ route('admin.publications.create') }}" class="btn btn-primary">Add Publication</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($publications->hasPages())
            <div class="card-body border-top d-flex flex-wrap align-items-center justify-content-between gap-3 admin-pagination-shell">
                <p class="text-secondary small mb-0">Showing {{ $publications->firstItem() }}-{{ $publications->lastItem() }} of {{ $publications->total() }}</p>
                {{ $publications->links() }}
            </div>
        @endif
    </div>
@endsection
