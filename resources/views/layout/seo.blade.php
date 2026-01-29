@php
    $title = $title ?? 'Kedai Cendana';
    $description =
        $description ??
        'Kedai Cendana - Pempek dan bakmi ayam yang lezat dan enak.';
    $keywords =
        $keywords ??
        'kedai cendana, pempek, bakmi ayam, tangerang, pondok bahar, pempek cendana, bakmi cendana';
    $image = $image ?? asset('images/kedai-cendana-rounded.webp');
    $url = url()->current();
@endphp

<!-- Primary Meta Tags -->
<title>{{ $title }}</title>
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="Kedai Cendana">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $url }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $url }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ $image }}">

<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('images/kedai-cendana-rounded.webp') }}" type="image/x-icon">
<link rel="canonical" href="{{ $url }}">
