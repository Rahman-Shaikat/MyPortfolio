@php
    $heroMetrics = old('hero_metrics', $profile->hero_metrics ?? []);
    $aboutHighlights = old('about_highlights', $profile->about_highlights ?? []);
    $services = old('services', $profile->services ?? []);
    $experiences = old('experiences', $profile->experiences ?? []);
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-5">
        <div class="col-xl-8">
            <div class="d-grid gap-5">
                <section class="card card-lg">
                    <div class="card-body">
                        <div class="mb-5">
                            <h2 class="fs-5 mb-1">Identity and contact</h2>
                            <p class="text-secondary small mb-0">Primary information used across the header, footer, metadata, and contact section.</p>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label for="name" class="form-label">Full name</label>
                                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $profile->name ?? '') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="brand_initials" class="form-label">Brand initials</label>
                                <input id="brand_initials" name="brand_initials" type="text" maxlength="3" class="form-control @error('brand_initials') is-invalid @enderror" value="{{ old('brand_initials', $profile->brand_initials ?? '') }}" placeholder="SR">
                                @error('brand_initials')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="professional_title" class="form-label">Professional title</label>
                                <input id="professional_title" name="professional_title" type="text" class="form-control @error('professional_title') is-invalid @enderror" value="{{ old('professional_title', $profile->professional_title ?? '') }}" required>
                                @error('professional_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="header_subtitle" class="form-label">Header subtitle</label>
                                <input id="header_subtitle" name="header_subtitle" type="text" class="form-control @error('header_subtitle') is-invalid @enderror" value="{{ old('header_subtitle', $profile->header_subtitle ?? '') }}">
                                @error('header_subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="availability_text" class="form-label">Availability text</label>
                                <input id="availability_text" name="availability_text" type="text" class="form-control @error('availability_text') is-invalid @enderror" value="{{ old('availability_text', $profile->availability_text ?? '') }}">
                                @error('availability_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $profile->email ?? '') }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $profile->phone ?? '') }}">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="location" class="form-label">Location or availability</label>
                                <input id="location" name="location" type="text" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $profile->location ?? '') }}">
                                @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="facebook_url" class="form-label">Facebook URL</label>
                                <input id="facebook_url" name="facebook_url" type="url" class="form-control @error('facebook_url') is-invalid @enderror" value="{{ old('facebook_url', $profile->facebook_url ?? '') }}">
                                @error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="instagram_url" class="form-label">Instagram URL</label>
                                <input id="instagram_url" name="instagram_url" type="url" class="form-control @error('instagram_url') is-invalid @enderror" value="{{ old('instagram_url', $profile->instagram_url ?? '') }}">
                                @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="github_url" class="form-label">GitHub URL</label>
                                <input id="github_url" name="github_url" type="url" class="form-control @error('github_url') is-invalid @enderror" value="{{ old('github_url', $profile->github_url ?? '') }}">
                                @error('github_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                <input id="linkedin_url" name="linkedin_url" type="url" class="form-control @error('linkedin_url') is-invalid @enderror" value="{{ old('linkedin_url', $profile->linkedin_url ?? '') }}">
                                @error('linkedin_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="medium_url" class="form-label">Medium URL</label>
                                <input id="medium_url" name="medium_url" type="url" class="form-control @error('medium_url') is-invalid @enderror" value="{{ old('medium_url', $profile->medium_url ?? '') }}">
                                @error('medium_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="x_url" class="form-label">X URL</label>
                                <input id="x_url" name="x_url" type="url" class="form-control @error('x_url') is-invalid @enderror" value="{{ old('x_url', $profile->x_url ?? '') }}">
                                @error('x_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="seo_description" class="form-label">SEO description</label>
                                <textarea id="seo_description" name="seo_description" rows="3" class="form-control @error('seo_description') is-invalid @enderror">{{ old('seo_description', $profile->seo_description ?? '') }}</textarea>
                                @error('seo_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </section>

                <section class="card card-lg">
                    <div class="card-body">
                        <div class="mb-5">
                            <h2 class="fs-5 mb-1">Hero section</h2>
                            <p class="text-secondary small mb-0">Headline, profile caption, engineering focus, and top-level metrics.</p>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="hero_title_line_one" class="form-label">Headline line one</label>
                                <input id="hero_title_line_one" name="hero_title_line_one" type="text" class="form-control @error('hero_title_line_one') is-invalid @enderror" value="{{ old('hero_title_line_one', $profile->hero_title_line_one ?? '') }}">
                                @error('hero_title_line_one')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="hero_title_line_two" class="form-label">Headline line two</label>
                                <input id="hero_title_line_two" name="hero_title_line_two" type="text" class="form-control @error('hero_title_line_two') is-invalid @enderror" value="{{ old('hero_title_line_two', $profile->hero_title_line_two ?? '') }}">
                                @error('hero_title_line_two')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="hero_description" class="form-label">Hero description</label>
                                <textarea id="hero_description" name="hero_description" rows="4" class="form-control @error('hero_description') is-invalid @enderror">{{ old('hero_description', $profile->hero_description ?? '') }}</textarea>
                                @error('hero_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="profile_caption" class="form-label">Profile caption</label>
                                <input id="profile_caption" name="profile_caption" type="text" class="form-control @error('profile_caption') is-invalid @enderror" value="{{ old('profile_caption', $profile->profile_caption ?? '') }}">
                                @error('profile_caption')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="current_focus" class="form-label">Current focus</label>
                                <input id="current_focus" name="current_focus" type="text" class="form-control @error('current_focus') is-invalid @enderror" value="{{ old('current_focus', $profile->current_focus ?? '') }}">
                                @error('current_focus')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="core_strengths" class="form-label">Core strengths</label>
                                <input id="core_strengths" name="core_strengths" type="text" class="form-control @error('core_strengths') is-invalid @enderror" value="{{ old('core_strengths', $profile->core_strengths ?? '') }}">
                                @error('core_strengths')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="orbit_skills" class="form-label">Orbit skills (comma separated)</label>
                                <input id="orbit_skills" name="orbit_skills" type="text" class="form-control @error('orbit_skills') is-invalid @enderror" value="{{ collect(old('orbit_skills', $profile->orbit_skills ?? []))->join(', ') }}" placeholder="PHP, MySQL, REST, Vite">
                                @error('orbit_skills')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mt-5" data-repeater data-next-index="{{ count($heroMetrics) }}">
                            <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                                <h3 class="fs-6 mb-0">Hero metrics</h3>
                                <button type="button" class="btn btn-white btn-sm" data-repeater-add><i class="ti ti-plus me-2"></i>Add Metric</button>
                            </div>
                            <div class="admin-repeater-items" data-repeater-items>
                                @foreach ($heroMetrics as $index => $metric)
                                    <div class="admin-repeater-item" data-repeater-item>
                                        <button type="button" class="btn btn-white btn-icon btn-sm text-danger admin-repeater-remove" data-repeater-remove aria-label="Remove metric" title="Remove metric"><i class="ti ti-trash"></i></button>
                                        <div class="row g-3 pe-5">
                                            <div class="col-md-4"><label class="form-label">Value</label><input name="hero_metrics[{{ $index }}][value]" class="form-control" value="{{ $metric['value'] ?? '' }}"></div>
                                            <div class="col-md-8"><label class="form-label">Label</label><input name="hero_metrics[{{ $index }}][label]" class="form-control" value="{{ $metric['label'] ?? '' }}"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <template data-repeater-template>
                                <div class="admin-repeater-item" data-repeater-item>
                                    <button type="button" class="btn btn-white btn-icon btn-sm text-danger admin-repeater-remove" data-repeater-remove aria-label="Remove metric" title="Remove metric"><i class="ti ti-trash"></i></button>
                                    <div class="row g-3 pe-5">
                                        <div class="col-md-4"><label class="form-label">Value</label><input name="hero_metrics[__INDEX__][value]" class="form-control"></div>
                                        <div class="col-md-8"><label class="form-label">Label</label><input name="hero_metrics[__INDEX__][label]" class="form-control"></div>
                                    </div>
                                </div>
                            </template>
                            @if ($message = $errors->first('hero_metrics.*'))<div class="invalid-feedback d-block">{{ $message }}</div>@endif
                        </div>
                    </div>
                </section>

                <section class="card card-lg">
                    <div class="card-body">
                        <div class="mb-5"><h2 class="fs-5 mb-1">About section</h2><p class="text-secondary small mb-0">Professional summary and supporting strengths.</p></div>
                        <div class="row g-4">
                            <div class="col-12"><label for="about_title" class="form-label">Section title</label><textarea id="about_title" name="about_title" rows="2" class="form-control @error('about_title') is-invalid @enderror">{{ old('about_title', $profile->about_title ?? '') }}</textarea>@error('about_title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-12"><label for="about_paragraph_one" class="form-label">First paragraph</label><textarea id="about_paragraph_one" name="about_paragraph_one" rows="4" class="form-control @error('about_paragraph_one') is-invalid @enderror">{{ old('about_paragraph_one', $profile->about_paragraph_one ?? '') }}</textarea>@error('about_paragraph_one')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-12"><label for="about_paragraph_two" class="form-label">Second paragraph</label><textarea id="about_paragraph_two" name="about_paragraph_two" rows="4" class="form-control @error('about_paragraph_two') is-invalid @enderror">{{ old('about_paragraph_two', $profile->about_paragraph_two ?? '') }}</textarea>@error('about_paragraph_two')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        </div>

                        <div class="mt-5" data-repeater data-next-index="{{ count($aboutHighlights) }}">
                            <div class="d-flex align-items-center justify-content-between gap-3 mb-3"><h3 class="fs-6 mb-0">About highlights</h3><button type="button" class="btn btn-white btn-sm" data-repeater-add><i class="ti ti-plus me-2"></i>Add Highlight</button></div>
                            <div class="admin-repeater-items" data-repeater-items>
                                @foreach ($aboutHighlights as $index => $highlight)
                                    <div class="admin-repeater-item" data-repeater-item>
                                        <button type="button" class="btn btn-white btn-icon btn-sm text-danger admin-repeater-remove" data-repeater-remove aria-label="Remove highlight" title="Remove highlight"><i class="ti ti-trash"></i></button>
                                        <div class="row g-3 pe-5"><div class="col-12"><label class="form-label">Title</label><input name="about_highlights[{{ $index }}][title]" class="form-control" value="{{ $highlight['title'] ?? '' }}"></div><div class="col-12"><label class="form-label">Description</label><textarea name="about_highlights[{{ $index }}][description]" rows="2" class="form-control">{{ $highlight['description'] ?? '' }}</textarea></div></div>
                                    </div>
                                @endforeach
                            </div>
                            <template data-repeater-template><div class="admin-repeater-item" data-repeater-item><button type="button" class="btn btn-white btn-icon btn-sm text-danger admin-repeater-remove" data-repeater-remove aria-label="Remove highlight" title="Remove highlight"><i class="ti ti-trash"></i></button><div class="row g-3 pe-5"><div class="col-12"><label class="form-label">Title</label><input name="about_highlights[__INDEX__][title]" class="form-control"></div><div class="col-12"><label class="form-label">Description</label><textarea name="about_highlights[__INDEX__][description]" rows="2" class="form-control"></textarea></div></div></div></template>
                            @if ($message = $errors->first('about_highlights.*'))<div class="invalid-feedback d-block">{{ $message }}</div>@endif
                        </div>
                    </div>
                </section>

                <section class="card card-lg">
                    <div class="card-body">
                        <div class="mb-5"><h2 class="fs-5 mb-1">Skills and projects</h2><p class="text-secondary small mb-0">Technical stack and the projects section introduction.</p></div>
                        <div class="row g-4">
                            <div class="col-12"><label for="skills_title" class="form-label">Skills section title</label><textarea id="skills_title" name="skills_title" rows="2" class="form-control @error('skills_title') is-invalid @enderror">{{ old('skills_title', $profile->skills_title ?? '') }}</textarea>@error('skills_title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-12"><label for="skills" class="form-label">Skills (comma separated)</label><textarea id="skills" name="skills" rows="3" class="form-control @error('skills') is-invalid @enderror">{{ collect(old('skills', $profile->skills ?? []))->join(', ') }}</textarea>@error('skills')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-12"><label for="projects_title" class="form-label">Projects section title</label><textarea id="projects_title" name="projects_title" rows="2" class="form-control @error('projects_title') is-invalid @enderror">{{ old('projects_title', $profile->projects_title ?? '') }}</textarea>@error('projects_title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        </div>
                    </div>
                </section>

                <section class="card card-lg">
                    <div class="card-body">
                        <div class="mb-5"><h2 class="fs-5 mb-1">Services</h2><p class="text-secondary small mb-0">Service section title and individual offerings.</p></div>
                        <label for="services_title" class="form-label">Section title</label>
                        <textarea id="services_title" name="services_title" rows="2" class="form-control @error('services_title') is-invalid @enderror">{{ old('services_title', $profile->services_title ?? '') }}</textarea>
                        @error('services_title')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        <div class="mt-5" data-repeater data-next-index="{{ count($services) }}">
                            <div class="d-flex align-items-center justify-content-between gap-3 mb-3"><h3 class="fs-6 mb-0">Service items</h3><button type="button" class="btn btn-white btn-sm" data-repeater-add><i class="ti ti-plus me-2"></i>Add Service</button></div>
                            <div class="admin-repeater-items" data-repeater-items>
                                @foreach ($services as $index => $service)
                                    <div class="admin-repeater-item" data-repeater-item><button type="button" class="btn btn-white btn-icon btn-sm text-danger admin-repeater-remove" data-repeater-remove aria-label="Remove service" title="Remove service"><i class="ti ti-trash"></i></button><div class="row g-3 pe-5"><div class="col-12"><label class="form-label">Title</label><input name="services[{{ $index }}][title]" class="form-control" value="{{ $service['title'] ?? '' }}"></div><div class="col-12"><label class="form-label">Description</label><textarea name="services[{{ $index }}][description]" rows="3" class="form-control">{{ $service['description'] ?? '' }}</textarea></div></div></div>
                                @endforeach
                            </div>
                            <template data-repeater-template><div class="admin-repeater-item" data-repeater-item><button type="button" class="btn btn-white btn-icon btn-sm text-danger admin-repeater-remove" data-repeater-remove aria-label="Remove service" title="Remove service"><i class="ti ti-trash"></i></button><div class="row g-3 pe-5"><div class="col-12"><label class="form-label">Title</label><input name="services[__INDEX__][title]" class="form-control"></div><div class="col-12"><label class="form-label">Description</label><textarea name="services[__INDEX__][description]" rows="3" class="form-control"></textarea></div></div></div></template>
                            @if ($message = $errors->first('services.*'))<div class="invalid-feedback d-block">{{ $message }}</div>@endif
                        </div>
                    </div>
                </section>

                <section class="card card-lg">
                    <div class="card-body">
                        <div class="mb-5"><h2 class="fs-5 mb-1">Experience</h2><p class="text-secondary small mb-0">Timeline heading and professional history.</p></div>
                        <label for="experience_title" class="form-label">Section title</label>
                        <textarea id="experience_title" name="experience_title" rows="2" class="form-control @error('experience_title') is-invalid @enderror">{{ old('experience_title', $profile->experience_title ?? '') }}</textarea>
                        @error('experience_title')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        <div class="mt-5" data-repeater data-next-index="{{ count($experiences) }}">
                            <div class="d-flex align-items-center justify-content-between gap-3 mb-3"><h3 class="fs-6 mb-0">Experience items</h3><button type="button" class="btn btn-white btn-sm" data-repeater-add><i class="ti ti-plus me-2"></i>Add Experience</button></div>
                            <div class="admin-repeater-items" data-repeater-items>
                                @foreach ($experiences as $index => $experience)
                                    <div class="admin-repeater-item" data-repeater-item><button type="button" class="btn btn-white btn-icon btn-sm text-danger admin-repeater-remove" data-repeater-remove aria-label="Remove experience" title="Remove experience"><i class="ti ti-trash"></i></button><div class="row g-3 pe-5"><div class="col-md-4"><label class="form-label">Period</label><input name="experiences[{{ $index }}][period]" class="form-control" value="{{ $experience['period'] ?? '' }}"></div><div class="col-md-8"><label class="form-label">Title</label><input name="experiences[{{ $index }}][title]" class="form-control" value="{{ $experience['title'] ?? '' }}"></div><div class="col-12"><label class="form-label">Description</label><textarea name="experiences[{{ $index }}][description]" rows="3" class="form-control">{{ $experience['description'] ?? '' }}</textarea></div></div></div>
                                @endforeach
                            </div>
                            <template data-repeater-template><div class="admin-repeater-item" data-repeater-item><button type="button" class="btn btn-white btn-icon btn-sm text-danger admin-repeater-remove" data-repeater-remove aria-label="Remove experience" title="Remove experience"><i class="ti ti-trash"></i></button><div class="row g-3 pe-5"><div class="col-md-4"><label class="form-label">Period</label><input name="experiences[__INDEX__][period]" class="form-control"></div><div class="col-md-8"><label class="form-label">Title</label><input name="experiences[__INDEX__][title]" class="form-control"></div><div class="col-12"><label class="form-label">Description</label><textarea name="experiences[__INDEX__][description]" rows="3" class="form-control"></textarea></div></div></div></template>
                            @if ($message = $errors->first('experiences.*'))<div class="invalid-feedback d-block">{{ $message }}</div>@endif
                        </div>
                    </div>
                </section>

                <section class="card card-lg">
                    <div class="card-body">
                        <div class="mb-5"><h2 class="fs-5 mb-1">Contact call to action</h2><p class="text-secondary small mb-0">Closing message shown beside the contact form.</p></div>
                        <div class="row g-4">
                            <div class="col-12"><label for="contact_title" class="form-label">Contact title</label><textarea id="contact_title" name="contact_title" rows="2" class="form-control @error('contact_title') is-invalid @enderror">{{ old('contact_title', $profile->contact_title ?? '') }}</textarea>@error('contact_title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-12"><label for="contact_description" class="form-label">Contact description</label><textarea id="contact_description" name="contact_description" rows="4" class="form-control @error('contact_description') is-invalid @enderror">{{ old('contact_description', $profile->contact_description ?? '') }}</textarea>@error('contact_description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="d-grid gap-5 admin-profile-media">
                <section class="card card-lg">
                    <div class="card-body">
                        <h2 class="fs-5 mb-4">Profile media</h2>
                        @include('admin.partials.image-uploader', [
                            'inputName' => 'profile_image',
                            'label' => 'Profile image',
                            'currentImagePath' => $profile->profile_image ?? null,
                            'removeInputName' => 'remove_profile_image',
                        ])
                        <div class="mt-5">
                            @include('admin.partials.file-uploader', [
                                'inputName' => 'resume',
                                'label' => 'Resume PDF',
                                'currentFilePath' => $profile->resume ?? null,
                                'removeInputName' => 'remove_resume',
                            ])
                        </div>
                    </div>
                </section>

                <section class="card card-lg">
                    <div class="card-body d-grid gap-3">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-2"></i>{{ $submitLabel }}</button>
                        <a href="{{ route('admin.profiles.index') }}" class="btn btn-white">Cancel</a>
                    </div>
                </section>
            </div>
        </div>
    </div>
</form>
