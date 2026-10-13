@extends('admin.layouts.app')

@section('title', 'Habit Tracker Page Info')
@section('page-title', 'Habit Tracker')
@section('page-subtitle', 'Page Info')

@section('content')
    <div class="admin-page-heading d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
        <h2 class="fs-3 mb-0">Page Info</h2>
        <a href="{{ route('habit-tracker') }}" class="btn btn-white" target="_blank" rel="noopener noreferrer"><i class="ti ti-external-link me-2" aria-hidden="true"></i>Preview Page</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">Please correct the highlighted fields. Reselect any new image uploads before saving again.</div>
    @endif

    <form action="{{ route('admin.habit-tracker.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card mb-5">
            <div class="card-body">
                <h3 class="fs-4 mb-4">App Images</h3>
                <p class="text-secondary">Original illustrations remain visible until you upload an image. Removing an image restores its illustration. Images are displayed without cropping.</p>
                <div class="row g-5">
                    @foreach (\App\Models\HabitTrackerPage::IMAGE_FIELDS as $field => $label)
                        <div class="col-md-6">
                            @include('admin.partials.image-uploader', [
                                'inputName' => $field,
                                'label' => $label,
                                'currentImagePath' => $pageInfo->{$field},
                                'removeInputName' => 'remove_'.$field,
                            ])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card mb-5">
            <div class="card-body">
                <h3 class="fs-4 mb-4">Video Demo</h3>
                <label for="video_url" class="form-label">YouTube video link</label>
                <input id="video_url" name="video_url" type="url" required maxlength="2048" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url', $pageInfo->video_url) }}" aria-describedby="video-url-help">
                @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div id="video-url-help" class="form-text">Use an HTTPS YouTube share, watch, shorts, or embed link. The video must allow embedding.</div>
            </div>
        </div>
        <div class="card mb-5">
            <div class="card-body">
                <h3 class="fs-4 mb-4">Pricing</h3>
                <div class="row g-5">
                    @foreach (['usd' => 'International (USD)', 'bdt' => 'Bangladesh (BDT)'] as $currency => $region)
                        <fieldset class="col-md-6">
                            <legend class="fs-5">{{ $region }}</legend>
                            @foreach (['regular' => 'Regular price', 'offer' => 'Offer price'] as $type => $label)
                                @php($field = $currency.'_'.$type.'_price')
                                <div class="mb-3">
                                    <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                    <input id="{{ $field }}" name="{{ $field }}" type="number" min="0.01" max="999999.99" step="0.01" required class="form-control @error($field) is-invalid @enderror" value="{{ old($field, $pageInfo->{$field}) }}">
                                    @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            @endforeach
                        </fieldset>
                    @endforeach
                </div>
                <p class="form-text mb-0">Discount percentages are calculated automatically. These prices update the product page; purchases currently use the existing inquiry flow.</p>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-2" aria-hidden="true"></i>Save Page Info</button>
    </form>
@endsection
