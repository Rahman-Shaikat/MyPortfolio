@php
    $isHome = request()->routeIs('home');
    $homeUrl = route('home');
    $sectionUrl = fn (string $section): string => $isHome ? "#{$section}" : "{$homeUrl}#{$section}";
@endphp

<header class="site-header" data-header>
    <nav class="nav-shell" aria-label="Primary navigation">
        <a class="brand" href="{{ $sectionUrl('home') }}" aria-label="Go to home section">
            <span class="brand-mark">SE</span>
            <span class="brand-copy">
                <strong>Shamsur Rahman</strong>
                <small>Laravel and full-stack web</small>
            </span>
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
            <a class="nav-link" href="{{ $sectionUrl('skills') }}">Skills</a>
            <a class="nav-link" href="{{ $sectionUrl('services') }}">Services</a>
            <a class="nav-link {{ request()->routeIs('projects.index') ? 'is-active' : '' }}" href="{{ $isHome ? '#projects' : route('projects.index') }}">Projects</a>
            <a class="nav-link" href="{{ $sectionUrl('experience') }}">Experience</a>
            <a class="nav-link" href="{{ $sectionUrl('thoughts') }}">Thoughts</a>
            <a class="nav-link nav-link-cta" href="{{ $sectionUrl('contact') }}">Contact</a>
        </div>
    </nav>
</header>
