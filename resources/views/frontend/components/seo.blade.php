@props([
    'title',
    'description',
    'canonical',
    'robots' => null,
    'ogTitle' => null,
    'ogDescription' => null,
    'ogImage' => null,
    'ogType' => 'website',
    'ogImageWidth' => null,
    'ogImageHeight' => null,
    'twitterTitle' => null,
    'twitterDescription' => null,
    'twitterImage' => null,
    'structuredData' => null,
])

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $robots ?: config('seo.robots') }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:type" content="{{ $ogType }}">
<meta property="og:title" content="{{ $ogTitle ?: $title }}">
<meta property="og:description" content="{{ $ogDescription ?: $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
@if ($ogImageWidth)<meta property="og:image:width" content="{{ $ogImageWidth }}">@endif
@if ($ogImageHeight)<meta property="og:image:height" content="{{ $ogImageHeight }}">@endif
<meta property="og:site_name" content="{{ config('seo.site_name') }}">
<meta property="og:locale" content="en_US">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $twitterTitle ?: $ogTitle ?: $title }}">
<meta name="twitter:description" content="{{ $twitterDescription ?: $ogDescription ?: $description }}">
<meta name="twitter:image" content="{{ $twitterImage ?: $ogImage }}">

@if (config('seo.verification.google'))
    <meta name="google-site-verification" content="{{ config('seo.verification.google') }}">
@endif
@if (config('seo.verification.bing'))
    <meta name="msvalidate.01" content="{{ config('seo.verification.bing') }}">
@endif

@if ($structuredData)
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endif
