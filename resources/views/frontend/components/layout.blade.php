@props(['profile', 'seo'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <x-frontend::seo
            :title="$seo['title']"
            :description="$seo['description']"
            :canonical="$seo['canonical']"
            :robots="$seo['robots'] ?? null"
            :og-title="$seo['ogTitle'] ?? null"
            :og-description="$seo['ogDescription'] ?? null"
            :og-image="$seo['ogImage']"
            :og-type="$seo['ogType'] ?? 'website'"
            :og-image-width="$seo['ogImageWidth'] ?? null"
            :og-image-height="$seo['ogImageHeight'] ?? null"
            :twitter-title="$seo['twitterTitle'] ?? null"
            :twitter-description="$seo['twitterDescription'] ?? null"
            :twitter-image="$seo['twitterImage'] ?? null"
            :structured-data="$seo['structuredData'] ?? null"
        />

        <x-frontend::favicons />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <a class="skip-link" href="#main">Skip to content</a>

        @include('frontend.partials.site-header')

        <main id="main">
            {{ $slot }}
        </main>

        @include('frontend.partials.site-footer')
    </body>
</html>
