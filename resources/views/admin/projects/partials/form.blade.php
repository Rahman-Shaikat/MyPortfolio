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
                        <div class="col-md-6">
                            <label for="role" class="form-label">My role</label>
                            <input id="role" name="role" type="text" class="form-control @error('role') is-invalid @enderror" value="{{ old('role', $project->role ?? '') }}" placeholder="Backend Developer">
                            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="contribution_type" class="form-label">Structured-data relationship</label>
                            <select id="contribution_type" name="contribution_type" class="form-select @error('contribution_type') is-invalid @enderror">
                                <option value="contributor" @selected(old('contribution_type', $project->contribution_type ?? 'contributor') === 'contributor')>Contributor</option>
                                <option value="creator" @selected(old('contribution_type', $project->contribution_type ?? 'contributor') === 'creator')>Creator</option>
                            </select>
                            @error('contribution_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="contribution" class="form-label">Actual contribution</label>
                            <textarea id="contribution" name="contribution" rows="4" class="form-control @error('contribution') is-invalid @enderror">{{ old('contribution', $project->contribution ?? '') }}</textarea>
                            @error('contribution')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="responsibilities" class="form-label">Responsibilities (comma separated)</label>
                            <input id="responsibilities" name="responsibilities" type="text" class="form-control @error('responsibilities') is-invalid @enderror" value="{{ old('responsibilities', isset($project) ? collect($project->responsibilities)->join(', ') : '') }}" placeholder="Backend development, Database design, API integration">
                            @error('responsibilities')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @error('responsibilities.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="challenges" class="form-label">Technical challenges</label>
                            <textarea id="challenges" name="challenges" rows="4" class="form-control @error('challenges') is-invalid @enderror">{{ old('challenges', $project->challenges ?? '') }}</textarea>
                            @error('challenges')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="outcome" class="form-label">Outcome</label>
                            <textarea id="outcome" name="outcome" rows="4" class="form-control @error('outcome') is-invalid @enderror">{{ old('outcome', $project->outcome ?? '') }}</textarea>
                            @error('outcome')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
