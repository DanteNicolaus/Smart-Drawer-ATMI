<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Smart Drawer')</title>
 <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-blue-900 text-white px-6 py-4 flex justify-between">
    <h1 class="font-bold">Smart Drawer ATMI</h1>

    <div class="space-x-4">
        @auth
            <a href="/dashboard">Dashboard</a>
            <a href="/logout">Logout</a>
        @else
            <a href="/login">Login</a>
        @endauth
    </div>
</nav>

<main class="p-6">
    @yield('content')
</main>

</body>
</html>
