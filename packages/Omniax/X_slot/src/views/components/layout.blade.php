<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My Application' }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <header class="header">
        {{ $header ?? '' }}
    </header>

    <main class="main">
        {{ $body ?? ''}}
    </main>

    <footer class="footer">
        {{ $footer ?? '' }}
    </footer>
</body>
</html>
