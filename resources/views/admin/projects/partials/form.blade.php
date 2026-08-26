<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="needs-validation" data-project-form data-auto-slug="{{ isset($project) ? 'false' : 'true' }}" novalidate>
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-5">
        <div class="col-lg-8">
            <div class="card card-lg">
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-7">
                            <label for="name" class="form-label">Project name</label>
                            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $project->name ?? '') }}" data-slug-source required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-5">
                            <label for="slug" class="form-label">Slug</label>
                            <input id="slug" name="slug" type="text" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $project->slug ?? '') }}" data-slug-target required>
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="url" class="form-label">Project URL</label>
                            <input id="url" name="url" type="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $project->url ?? '') }}" placeholder="https://example.com">
                            @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            @include('admin.partials.image-uploader', [
                                'inputName' => 'preview_image',
                                'label' => 'Preview image',
                                'currentImagePath' => $project->preview_image ?? null,
                                'removeInputName' => 'remove_preview_image',
                            ])
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="6" class="form-control @error('description') is-invalid @enderror">{{ old('description', $project->description ?? '') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="technologies" class="form-label">Technologies (comma separated)</label>
                            <input id="technologies" name="technologies" type="text" class="form-control @error('technologies') is-invalid @enderror" value="{{ old('technologies', isset($project) ? collect($project->technologies)->join(', ') : '') }}" placeholder="Laravel, PHP, MySQL">
                            @error('technologies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @error('technologies.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-lg admin-project-settings">
                <div class="card-body">
                    <h2 class="fs-5 mb-4">Publishing</h2>
                    <div class="mb-5">
                        <label for="sort_order" class="form-label">Sort order</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $project->sort_order ?? 0) }}" required>
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <input type="hidden" name="is_personal" value="0">
                    <div class="form-check form-switch mb-4">
                        <input id="is_personal" name="is_personal" class="form-check-input" type="checkbox" value="1" @checked((bool) old('is_personal', $project->is_personal ?? false))>
                        <label class="form-check-label" for="is_personal">Personal project</label>
                    </div>

                    <input type="hidden" name="status" value="0">
                    <div class="form-check form-switch mb-0">
                        <input id="status" name="status" class="form-check-input" type="checkbox" value="1" @checked((bool) old('status', $project->status ?? true))>
                        <label class="form-check-label" for="status">Published</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-end gap-3 mt-5">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-white">Cancel</a>
        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-2"></i>{{ $submitLabel }}</button>
    </div>
</form>
