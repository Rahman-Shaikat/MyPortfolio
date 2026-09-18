@php
    $isHome = request()->routeIs('home');
    $homeUrl = route('home');
    $sectionUrl = fn (string $section): string => $isHome ? "#{$section}" : "{$homeUrl}#{$section}";
@endphp

<header class="site-header" data-header>
    <nav class="nav-shell" aria-label="Primary navigation">
        <a class="brand" href="{{ $sectionUrl('home') }}" aria-label="{{ $profile->name }} portfolio home">
            <img class="brand-logo" src="{{ asset('assets/images/logo-520.webp') }}" alt="{{ $profile->name }}" width="520" height="130" decoding="async">
        </a>

        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-menu" data-menu-toggle>
            <span></span>
            <span></span>
            <span></span>
            <span class="sr-only">Toggle navigation</span>
        </button>

        <div class="nav-menu" id="primary-menu" data-menu>
            <a class="nav-link" href="{{ $sectionUrl('home') }}">Home</a>
            <a class="nav-link" href="{{ $sectionUrl('about') }}">About</a>
            <a class="nav-link" href="{{ $sectionUrl('experience') }}">Experience</a>
            <a class="nav-link" href="{{ $sectionUrl('skills') }}">Skills</a>
            <a class="nav-link {{ request()->routeIs('projects.*') ? 'is-active' : '' }}" href="{{ $sectionUrl('projects') }}">Projects</a>
            <a class="nav-link" href="{{ $sectionUrl('research') }}">Research</a>
            <a class="nav-link" href="{{ $sectionUrl('services') }}">Services</a>
            <a class="nav-link nav-link-cta {{ request()->routeIs('contact') ? 'is-active' : '' }}" href="{{ route('contact') }}">
                Let's talk
                <span aria-hidden="true">&#8599;</span>
            </a>
        </div>
    </nav>
</header>
