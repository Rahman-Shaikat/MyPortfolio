@php
    $fileSource = $currentFilePath ? asset('storage/'.$currentFilePath) : '';
    $fileName = $currentFilePath ? basename($currentFilePath) : '';
    $removeCurrentFile = (bool) old($removeInputName, false);
@endphp

<div data-file-uploader>
    <label id="{{ $inputName }}_label" for="{{ $inputName }}" class="form-label">{{ $label }}</label>
    <div
        class="admin-file-upload @error($inputName) is-invalid @enderror"
        role="button"
        tabindex="0"
        aria-labelledby="{{ $inputName }}_label"
        data-file-upload-zone
        data-original-src="{{ $fileSource }}"
        data-original-name="{{ $fileName }}"
    >
        <div class="admin-file-placeholder" data-file-placeholder @if ($fileSource && ! $removeCurrentFile) hidden @endif>
            <span class="admin-preview-placeholder-icon"><i class="ti ti-file-type-pdf"></i></span>
            <strong>Choose PDF resume</strong>
            <span>PDF &middot; 5 MB max</span>
            <button type="button" class="btn btn-white btn-sm mt-2" data-select-file>
                <i class="ti ti-file-upload me-2"></i>Select PDF
            </button>
            @if ($fileSource)
                <button type="button" class="btn btn-link btn-sm" data-restore-file @if (! $removeCurrentFile) hidden @endif>Restore current resume</button>
            @endif
        </div>

        <div class="admin-file-current" data-file-current @if (! $fileSource || $removeCurrentFile) hidden @endif>
            <span class="admin-file-current-icon"><i class="ti ti-file-type-pdf"></i></span>
            <div class="admin-preview-file-meta">
                <strong data-file-name>{{ $fileName }}</strong>
                <span data-file-size>{{ $fileSource ? 'Current resume' : '' }}</span>
            </div>
            <div class="d-flex gap-2 ms-auto">
                <a href="{{ $fileSource }}" target="_blank" rel="noopener noreferrer" class="btn btn-white btn-icon btn-sm" data-open-file aria-label="Open current resume" title="Open current resume" @if (! $fileSource) hidden @endif><i class="ti ti-external-link"></i></a>
                <button type="button" class="btn btn-white btn-icon btn-sm" data-select-file aria-label="Replace resume" title="Replace resume"><i class="ti ti-replace"></i></button>
                <button type="button" class="btn btn-white btn-icon btn-sm text-danger" data-clear-file aria-label="Remove resume" title="Remove resume"><i class="ti ti-trash"></i></button>
            </div>
        </div>
    </div>

    <input id="{{ $inputName }}" name="{{ $inputName }}" type="file" accept="application/pdf,.pdf" class="visually-hidden" data-file-input>
    @error($inputName)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    <div class="invalid-feedback" data-file-upload-error></div>

    @if ($fileSource)
        <input type="hidden" name="{{ $removeInputName }}" value="{{ $removeCurrentFile ? '1' : '0' }}" data-remove-file>
    @endif
</div>
