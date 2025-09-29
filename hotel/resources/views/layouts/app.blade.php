<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'HotelHub')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="/css/app.css">
</head>

<body class="min-h-screen flex flex-col bg-slate-50 text-slate-900 antialiased">
  <header class="border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6">
      <div class="flex items-center gap-10">
        <a href="/" class="text-3xl font-black text-blue-700">HotelHub</a>
        <nav class="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex">
          <a class="transition hover:text-slate-900" href="#">Explore</a>
          <a class="transition hover:text-slate-900" href="#offers">Offers</a>
          <a class="transition hover:text-slate-900" href="#">Support</a>
        </nav>
      </div>
      <div class="flex items-center gap-4">
        <a href="#" class="text-sm font-semibold text-slate-600 transition hover:text-slate-900">Contact</a>
        <a href="/login" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Login</a>
      </div>
    </div>
  </header>

  <main class="flex-1 w-full max-w-6xl mx-auto px-6 py-12">
    @yield('content')
  </main>

  <footer class="border-t border-slate-200 bg-white py-8 text-sm text-slate-600">
    <div class="mx-auto flex max-w-7xl flex-col gap-3 px-6 md:flex-row md:items-center md:justify-between">
      <p class="font-semibold text-slate-700">HotelHub</p>
      <p>&copy; {{ date('Y') }} HotelHub. All rights reserved.</p>
    </div>
  </footer>
</body>

</html>