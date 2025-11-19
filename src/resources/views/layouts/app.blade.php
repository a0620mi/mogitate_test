<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mogitate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>

<body>
    @yield('css')
    <header class="header">
        <header class="header__inner">
            <h1 class="header__ttl">mogitate</h1>
        </header>
    </header>

    <main class="main">
        @yield('content')
    </main>
</body>

</html>