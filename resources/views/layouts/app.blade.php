<!doctype html>
<html lang="en" data-bs-theme="blue-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} | Login</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('dashboard/assets/images/favicon-32x32.png') }}" type="image/png">

    <!-- Fonts (keep external links if not self-hosted) -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Vite compiled CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  @include('dashboard.components.header')
  @include('dashboard.components.sidebar')
   {{ $slot }}

   @include('dashboard.components.footer')
   @include('dashboard.components.foot')
</body>

</html>
