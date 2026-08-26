@php
    $imageSource = $currentImagePath ? asset('storage/'.$currentImagePath) : '';
    $imageName = $currentImagePath ? basename($currentImagePath) : '';
    $removeCurrentImage = (bool) old($removeInputName, false);
@endphp

<div data-image-uploader>
    <label id="{{ $inputName }}_label" for="{{ $inputName }}" class="form-label">{{ $label }}</label>
    <div
        class="admin-preview-upload @error($inputName) is-invalid @enderror"
        role="button"
        tabindex="0"
        aria-labelledby="{{ $inputName }}_label"
        data-preview-upload-zone
        data-original-src="{{ $imageSource }}"
        data-original-name="{{ $imageName }}"
    >
        <img
            src="{{ $imageSource }}"
            class="admin-preview-image"
            alt="{{ $label }}"
            data-preview-image
            @if (! $imageSource || $removeCurrentImage) hidden @endif
        >
        <div class="admin-preview-placeholder" data-preview-image-placeholder @if ($imageSource && ! $removeCurrentImage) hidden @endif>
            <span class="admin-preview-placeholder-icon"><i class="ti ti-cloud-upload"></i></span>
            <strong>Choose {{ str($label)->lower() }}</strong>
            <span>JPG, PNG or WebP &middot; 2 MB max</span>
            <button type="button" class="btn btn-white btn-sm mt-2" data-select-preview-image>
                <i class="ti ti-photo-plus me-2"></i>Select Image
            </button>
            @if ($imageSource)
                <button type="button" class="btn btn-link btn-sm" data-restore-preview-image @if (! $removeCurrentImage) hidden @endif>Restore current image</button>
            @endif
        </div>

        <div class="admin-preview-toolbar" data-preview-toolbar @if (! $imageSource || $removeCurrentImage) hidden @endif>
            <div class="admin-preview-file-meta">
                <strong data-preview-file-name>{{ $imageName }}</strong>
                <span data-preview-file-size>{{ $imageSource ? 'Current image' : '' }}</span>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-white btn-icon btn-sm" data-select-preview-image aria-label="Replace {{ str($label)->lower() }}" title="Replace {{ str($label)->lower() }}"><i class="ti ti-replace"></i></button>
                <button type="button" class="btn btn-white btn-icon btn-sm text-danger" data-clear-preview-image aria-label="Remove {{ str($label)->lower() }}" title="Remove {{ str($label)->lower() }}"><i class="ti ti-trash"></i></button>
            </div>
        </div>
    </div>

    <input id="{{ $inputName }}" name="{{ $inputName }}" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="visually-hidden" data-preview-image-input>
    @error($inputName)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    <div class="invalid-feedback" data-preview-upload-error></div>

    @if ($imageSource)
        <input type="hidden" name="{{ $removeInputName }}" value="{{ $removeCurrentImage ? '1' : '0' }}" data-remove-preview-image>
    @endif
</div>
