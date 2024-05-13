<!DOCTYPE html>
<html>
<head>
    <title>Football League Platform</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <h1>Welcome to the Football League Platform</h1>
    </header>

    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="">Teams</a></li>
            <li><a href="">Fixtures</a></li>
            <li><a href="">Standings</a></li>
        </ul>
    </nav>

    <main>
        <h2>Latest News</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam euismod, nunc id aliquet lacinia, nisl nunc consequat nunc, id lacinia nunc nisl id nunc.</p>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Football League Platform. All rights reserved.</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>