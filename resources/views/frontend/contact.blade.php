<x-frontend::layout :profile="$profile" :seo="$seo">
    <section class="section-pad contact-band page-hero" aria-labelledby="contact-page-title">
        <div class="container contact-grid">
            <div class="contact-copy reveal">
                <p class="eyebrow">Contact</p>
                <h1 id="contact-page-title" class="page-title">Discuss a Laravel product, API, or production challenge.</h1>
                <p>{{ $profile->contact_description }}</p>
                <div class="contact-list">
                    @if ($profile->email)<a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>@endif
                    @if ($profile->phone)<a href="tel:{{ preg_replace('/[^+0-9]/', '', $profile->phone) }}">{{ $profile->phone }}</a>@endif
                    @if ($profile->location)<span>{{ $profile->location }}</span>@endif
                </div>
            </div>
            <form class="contact-form reveal" action="{{ $profile->email ? 'mailto:'.$profile->email : '#contact-page-title' }}" method="post" enctype="text/plain" data-contact-form>
                <label class="contact-name"><span class="sr-only">Name</span><input type="text" name="name" placeholder="Your name" autocomplete="name" required><span class="name-placeholder" data-text="Your name" aria-hidden="true"></span></label>
                <label><span class="sr-only">Email</span><input type="email" name="email" placeholder="you@example.com" autocomplete="email" required></label>
                <label><span class="sr-only">Project type</span><select name="project_type" required><option value="" disabled selected>Project type</option><option>Laravel application</option><option>API or integration</option><option>E-commerce system</option><option>Maintenance or optimization</option></select></label>
                <label><span class="sr-only">Message</span><textarea name="message" rows="3" placeholder="Tell me about your project." required></textarea></label>
                <button class="button contact-submit" type="submit">Send inquiry</button>
                <p class="form-note" data-form-note>Form opens your email client.</p>
            </form>
        </div>
    </section>
</x-frontend::layout>
