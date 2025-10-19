<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
</head>
<body>
    <h1>Welcome to Laravel</h1>
    @auth
    <h2>You are logged in!</h2>
    <h2>Hello, {{ auth()->user()->name }}</h2>
    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Log out</button>
    </form>
    @else
    <div style="border: 1px solid black" id="register">
            <h2>Register</h2>
            <form method="POST" action="/register">
                @csrf
                <input type="text" id="name" name="name" placeholder="name" required>
                <input type="text" id="email" name="email" placeholder="email" required>
                <input type="password" id="password" name="password" placeholder="password" required>
                <button type="submit">Register</button>
            </form>
        </div>

        <div style="border: 1px solid black; margin-top: 5px" id="login">
            <h2>Log in</h2>
            <form method="POST" action="/login">
                @csrf
                <input type="text" id="name" name="loginname" required>
                <input type="password" id="password" name="loginpassword" required>
                <button type="submit">Log in</button>
            </form>
        </div>
    @endauth

</body>
</html>