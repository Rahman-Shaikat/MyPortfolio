<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-5">
        <div class="col-lg-8">
            <div class="card card-lg">
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="title" class="form-label">Publication title</label>
                            <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $publication->title ?? '') }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-7">
                            <label for="publisher" class="form-label">Publisher</label>
                            <input id="publisher" name="publisher" type="text" class="form-control @error('publisher') is-invalid @enderror" value="{{ old('publisher', $publication->publisher ?? '') }}">
                            @error('publisher')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-5">
                            <label for="published_at" class="form-label">Publication date</label>
                            <input id="published_at" name="published_at" type="date" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', isset($publication) ? $publication->published_at?->format('Y-m-d') : '') }}">
                            @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="url" class="form-label">Publication URL</label>
                            <input id="url" name="url" type="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $publication->url ?? '') }}" placeholder="https://example.com/publication">
                            @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            @include('admin.partials.image-uploader', [
                                'inputName' => 'image',
                                'label' => 'Publication image',
                                'currentImagePath' => $publication->image ?? null,
                                'removeInputName' => 'remove_image',
                            ])
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="6" class="form-control @error('description') is-invalid @enderror">{{ old('description', $publication->description ?? '') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                        <input id="sort_order" name="sort_order" type="number" min="0" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $publication->sort_order ?? 0) }}" required>
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <input type="hidden" name="status" value="0">
                    <div class="form-check form-switch mb-0">
                        <input id="status" name="status" class="form-check-input" type="checkbox" value="1" @checked((bool) old('status', $publication->status ?? true))>
                        <label class="form-check-label" for="status">Published</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-end gap-3 mt-5">
        <a href="{{ route('admin.publications.index') }}" class="btn btn-white">Cancel</a>
        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-2"></i>{{ $submitLabel }}</button>
    </div>
</form>
