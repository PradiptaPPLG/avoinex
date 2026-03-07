<!DOCTYPE html>
<html>
<head>
    <title>404</title>
</head>
<body>
    <h1>404 - Page Not Found</h1>
    <p>Requested Path: {{ request()->path() }}</p>
    <a href="{{ route('home') }}">Back to Home</a>
</body>
</html>
