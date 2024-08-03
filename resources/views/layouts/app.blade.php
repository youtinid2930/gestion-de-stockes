<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
   
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
    @include('layouts.sidebar')
    <section class="home-section">
        @yield('content')
    </section>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>