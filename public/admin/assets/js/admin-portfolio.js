document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-password-toggle]').forEach((button) => {
    const input = document.querySelector(button.dataset.passwordToggle);
    const icon = button.querySelector('[data-password-toggle-icon]');

    if (!input || !icon) {
      return;
    }

    button.addEventListener('click', () => {
      const isHidden = input.getAttribute('type') === 'password';

      input.setAttribute('type', isHidden ? 'text' : 'password');
      icon.classList.toggle('ti-eye', isHidden);
      icon.classList.toggle('ti-eye-off', !isHidden);
    });
  });

  document.querySelectorAll('[data-project-form]').forEach((form) => {
    const nameInput = form.querySelector('[data-slug-source]');
    const slugInput = form.querySelector('[data-slug-target]');

    if (form.dataset.autoSlug === 'true' && nameInput && slugInput) {
      nameInput.addEventListener('input', () => {
        slugInput.value = nameInput.value
          .trim()
          .toLowerCase()
          .replace(/[^a-z0-9]+/g, '-')
          .replace(/^-+|-+$/g, '');
      });
    }
  });

  document.querySelectorAll('[data-image-uploader]').forEach((uploader) => {
    const uploadZone = uploader.querySelector('[data-preview-upload-zone]');
    const previewInput = uploader.querySelector('[data-preview-image-input]');
    const previewImage = uploader.querySelector('[data-preview-image]');
    const previewPlaceholder = uploader.querySelector('[data-preview-image-placeholder]');
    const previewToolbar = uploader.querySelector('[data-preview-toolbar]');
    const previewFileName = uploader.querySelector('[data-preview-file-name]');
    const previewFileSize = uploader.querySelector('[data-preview-file-size]');
    const previewError = uploader.querySelector('[data-preview-upload-error]');
    const clearPreviewButton = uploader.querySelector('[data-clear-preview-image]');
    const restorePreviewButton = uploader.querySelector('[data-restore-preview-image]');
    const removePreviewInput = uploader.querySelector('[data-remove-preview-image]');

    if (!uploadZone || !previewInput || !previewImage || !previewPlaceholder || !previewToolbar) {
      return;
    }

    const originalSource = uploadZone.dataset.originalSrc;
    const originalName = uploadZone.dataset.originalName;
    const acceptedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    const acceptedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    const maximumFileSize = 2 * 1024 * 1024;
    let previewObjectUrl = null;

    const revokePreviewObjectUrl = () => {
      if (previewObjectUrl) {
        URL.revokeObjectURL(previewObjectUrl);
        previewObjectUrl = null;
      }
    };

    const formatFileSize = (bytes) => {
      if (bytes < 1024 * 1024) {
        return `${Math.max(1, Math.round(bytes / 1024))} KB`;
      }

      return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
    };

    const setUploadError = (message = '') => {
      uploadZone.classList.toggle('is-invalid', Boolean(message));
      previewError.textContent = message;
      previewError.classList.toggle('d-block', Boolean(message));
    };

    const showPreview = (source, name, detail) => {
      previewImage.src = source;
      previewImage.alt = `Preview of ${name}`;
      previewImage.hidden = false;
      previewPlaceholder.hidden = true;
      previewToolbar.hidden = false;
      previewFileName.textContent = name;
      previewFileSize.textContent = detail;
      restorePreviewButton?.setAttribute('hidden', '');
    };

    const showPlaceholder = (canRestore = false) => {
      previewImage.hidden = true;
      previewPlaceholder.hidden = false;
      previewToolbar.hidden = true;
      restorePreviewButton?.toggleAttribute('hidden', !canRestore);
    };

    const restoreOriginalPreview = () => {
      revokePreviewObjectUrl();
      previewInput.value = '';

      if (removePreviewInput) {
        removePreviewInput.value = '0';
      }

      if (originalSource) {
        showPreview(originalSource, originalName, 'Current image');
      } else {
        showPlaceholder();
      }

      setUploadError();
    };

    const validatePreviewFile = (file) => {
      const extension = file.name.split('.').pop()?.toLowerCase();

      if (!acceptedTypes.includes(file.type) && !acceptedExtensions.includes(extension)) {
        return 'Select a JPG, PNG, or WebP image.';
      }

      if (file.size > maximumFileSize) {
        return 'The preview image must not exceed 2 MB.';
      }

      return '';
    };

    const applyPreviewFile = (file) => {
      const validationMessage = validatePreviewFile(file);

      if (validationMessage) {
        previewInput.value = '';
        setUploadError(validationMessage);
        return;
      }

      revokePreviewObjectUrl();
      previewObjectUrl = URL.createObjectURL(file);
      showPreview(previewObjectUrl, file.name, formatFileSize(file.size));
      setUploadError();

      if (removePreviewInput) {
        removePreviewInput.value = '0';
      }
    };

    previewInput.addEventListener('change', () => {
      const [file] = previewInput.files;

      if (file) {
        applyPreviewFile(file);
      }
    });

    uploadZone.addEventListener('click', (event) => {
      if (event.target.closest('[data-clear-preview-image], [data-restore-preview-image]')) {
        return;
      }

      previewInput.click();
    });

    uploadZone.addEventListener('keydown', (event) => {
      if (event.target === uploadZone && ['Enter', ' '].includes(event.key)) {
        event.preventDefault();
        previewInput.click();
      }
    });

    ['dragenter', 'dragover'].forEach((eventName) => {
      uploadZone.addEventListener(eventName, (event) => {
        event.preventDefault();
        uploadZone.classList.add('is-dragging');
      });
    });

    ['dragleave', 'drop'].forEach((eventName) => {
      uploadZone.addEventListener(eventName, (event) => {
        event.preventDefault();
        uploadZone.classList.remove('is-dragging');
      });
    });

    uploadZone.addEventListener('drop', (event) => {
      const [file] = event.dataTransfer.files;

      if (!file) {
        return;
      }

      const transfer = new DataTransfer();
      transfer.items.add(file);
      previewInput.files = transfer.files;
      applyPreviewFile(file);
    });

    clearPreviewButton?.addEventListener('click', (event) => {
      event.stopPropagation();

      if (previewInput.files.length) {
        restoreOriginalPreview();
        return;
      }

      if (originalSource && removePreviewInput) {
        removePreviewInput.value = '1';
        showPlaceholder(true);
      } else {
        showPlaceholder();
      }

      setUploadError();
    });

    restorePreviewButton?.addEventListener('click', (event) => {
      event.stopPropagation();
      restoreOriginalPreview();
    });
  });

  document.querySelectorAll('[data-file-uploader]').forEach((uploader) => {
    const uploadZone = uploader.querySelector('[data-file-upload-zone]');
    const fileInput = uploader.querySelector('[data-file-input]');
    const placeholder = uploader.querySelector('[data-file-placeholder]');
    const currentFile = uploader.querySelector('[data-file-current]');
    const fileName = uploader.querySelector('[data-file-name]');
    const fileSize = uploader.querySelector('[data-file-size]');
    const openFile = uploader.querySelector('[data-open-file]');
    const clearFileButton = uploader.querySelector('[data-clear-file]');
    const restoreFileButton = uploader.querySelector('[data-restore-file]');
    const removeFileInput = uploader.querySelector('[data-remove-file]');
    const uploadError = uploader.querySelector('[data-file-upload-error]');

    if (!uploadZone || !fileInput || !placeholder || !currentFile || !fileName || !fileSize || !uploadError) {
      return;
    }

    const originalSource = uploadZone.dataset.originalSrc;
    const originalName = uploadZone.dataset.originalName;
    const maximumFileSize = 5 * 1024 * 1024;

    const setUploadError = (message = '') => {
      uploadZone.classList.toggle('is-invalid', Boolean(message));
      uploadError.textContent = message;
      uploadError.classList.toggle('d-block', Boolean(message));
    };

    const showCurrentFile = (name, detail, canOpen = false) => {
      placeholder.hidden = true;
      currentFile.hidden = false;
      fileName.textContent = name;
      fileSize.textContent = detail;
      openFile?.toggleAttribute('hidden', !canOpen);
      restoreFileButton?.setAttribute('hidden', '');
    };

    const showPlaceholder = (canRestore = false) => {
      placeholder.hidden = false;
      currentFile.hidden = true;
      restoreFileButton?.toggleAttribute('hidden', !canRestore);
    };

    const restoreOriginalFile = () => {
      fileInput.value = '';

      if (removeFileInput) {
        removeFileInput.value = '0';
      }

      if (originalSource) {
        showCurrentFile(originalName, 'Current resume', true);
      } else {
        showPlaceholder();
      }

      setUploadError();
    };

    const applyFile = (file) => {
      const extension = file.name.split('.').pop()?.toLowerCase();

      if (file.type !== 'application/pdf' && extension !== 'pdf') {
        fileInput.value = '';
        setUploadError('Select a PDF document.');
        return;
      }

      if (file.size > maximumFileSize) {
        fileInput.value = '';
        setUploadError('The resume must not exceed 5 MB.');
        return;
      }

      const displaySize = file.size < 1024 * 1024
        ? `${Math.max(1, Math.round(file.size / 1024))} KB`
        : `${(file.size / (1024 * 1024)).toFixed(1)} MB`;

      showCurrentFile(file.name, displaySize);
      setUploadError();

      if (removeFileInput) {
        removeFileInput.value = '0';
      }
    };

    fileInput.addEventListener('change', () => {
      const [file] = fileInput.files;

      if (file) {
        applyFile(file);
      }
    });

    uploadZone.addEventListener('click', (event) => {
      if (event.target.closest('[data-clear-file], [data-restore-file], [data-open-file]')) {
        return;
      }

      fileInput.click();
    });

    uploadZone.addEventListener('keydown', (event) => {
      if (event.target === uploadZone && ['Enter', ' '].includes(event.key)) {
        event.preventDefault();
        fileInput.click();
      }
    });

    ['dragenter', 'dragover'].forEach((eventName) => {
      uploadZone.addEventListener(eventName, (event) => {
        event.preventDefault();
        uploadZone.classList.add('is-dragging');
      });
    });

    ['dragleave', 'drop'].forEach((eventName) => {
      uploadZone.addEventListener(eventName, (event) => {
        event.preventDefault();
        uploadZone.classList.remove('is-dragging');
      });
    });

    uploadZone.addEventListener('drop', (event) => {
      const [file] = event.dataTransfer.files;

      if (!file) {
        return;
      }

      const transfer = new DataTransfer();
      transfer.items.add(file);
      fileInput.files = transfer.files;
      applyFile(file);
    });

    clearFileButton?.addEventListener('click', (event) => {
      event.stopPropagation();

      if (fileInput.files.length) {
        restoreOriginalFile();
        return;
      }

      if (originalSource && removeFileInput) {
        removeFileInput.value = '1';
        showPlaceholder(true);
      } else {
        showPlaceholder();
      }

      setUploadError();
    });

    restoreFileButton?.addEventListener('click', (event) => {
      event.stopPropagation();
      restoreOriginalFile();
    });
  });

  document.querySelectorAll('[data-repeater]').forEach((repeater) => {
    const items = repeater.querySelector('[data-repeater-items]');
    const template = repeater.querySelector('[data-repeater-template]');
    const addButton = repeater.querySelector('[data-repeater-add]');
    let nextIndex = Number(repeater.dataset.nextIndex || 0);

    if (!items || !template || !addButton) {
      return;
    }

    addButton.addEventListener('click', () => {
      items.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__', String(nextIndex)));
      nextIndex += 1;
    });

    repeater.addEventListener('click', (event) => {
      const removeButton = event.target.closest('[data-repeater-remove]');

      if (removeButton) {
        removeButton.closest('[data-repeater-item]')?.remove();
      }
    });
  });

  document.querySelectorAll('[data-confirm-delete]').forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!window.confirm(form.dataset.confirmDelete)) {
        event.preventDefault();
      }
    });
  });
});
