<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link rel="icon" type="image/x-icon" href="{{ asset("cwup-icon.png") }}">
        <meta name="title" content="{{ $pageTitle }}">
        @vite("resources/js/app.js")
        @inertiaHead
    </head>
    <body class="h-full">
        @inertia
    </body>
</html>
