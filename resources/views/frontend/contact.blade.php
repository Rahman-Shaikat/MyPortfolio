<x-frontend::layout :profile="$profile" :seo="$seo">
    <section class="section-pad contact-band page-hero" aria-labelledby="contact-page-title">
        <div class="container contact-grid">
            <div class="contact-copy reveal">
                <p class="eyebrow">Contact</p>
                <h1 id="contact-page-title" class="page-title">Discuss a Laravel product, API, or production challenge.</h1>
                <p>{{ $profile->contact_description }}</p>
                <div class="contact-list">
                    @if ($profile->email)<span>{{ $profile->email }}</span>@endif
                    @if ($profile->phone)<span>{{ $profile->phone }}</span>@endif
                    @if ($profile->location)<span>{{ $profile->location }}</span>@endif
                </div>
            </div>
            <form class="contact-form reveal" action="{{ route('contact.store') }}" method="POST" data-contact-form>
                @csrf
                <input class="contact-honeypot" type="text" name="website" value="" tabindex="-1" autocomplete="off" aria-hidden="true">
                <label class="contact-name"><span class="sr-only">Name</span><input type="text" name="name" value="{{ old('name') }}" placeholder="Your name" autocomplete="name" required><span class="name-placeholder" data-text="Your name" aria-hidden="true"></span></label>
                <label><span class="sr-only">Email</span><input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required></label>
                <label><span class="sr-only">Project type</span><select name="project_type" required><option value="" disabled @selected(! old('project_type'))>Project type</option><option @selected(old('project_type') === 'Laravel application')>Laravel application</option><option @selected(old('project_type') === 'API or integration')>API or integration</option><option @selected(old('project_type') === 'E-commerce system')>E-commerce system</option><option @selected(old('project_type') === 'Maintenance or optimization')>Maintenance or optimization</option></select></label>
                <label><span class="sr-only">Message</span><textarea name="message" rows="3" placeholder="Tell me about your project." required>{{ old('message') }}</textarea></label>
                <button class="button contact-submit" type="submit">Send inquiry</button>
                <p class="form-note" data-form-note>{{ session('contact_success') ?: ($errors->any() ? 'Please correct the highlighted information.' : 'Your details are sent securely.') }}</p>
            </form>
        </div>
    </section>
</x-frontend::layout>
