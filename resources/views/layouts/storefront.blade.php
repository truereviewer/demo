<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Reviewer Demo</title>
    <meta
        name="description"
        content="Reviewer demo built with Lunar."
    >
    <link
        href="{{ asset('css/app.css') }}"
        rel="stylesheet"
    >

    <link
        rel="icon"
        href="{{ asset('favicon.png') }}"
    >

    @livewireStyles
    @reviewerStyles

    @vite(['resources/css/app.css'])
</head>

<body class="antialiased">
@livewire('components.navigation')

<main id="reviewer">
    {{ $slot }}
</main>


<x-footer/>

@livewireScripts
@reviewerScripts

@stack('scripts')
</body>

</html>
