<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', __('hotel.brand'))</title>
</head>

<body class="min-h-screen flex flex-col bg-slate-50 text-slate-900 antialiased">
  <header class="border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6">
      <div class="flex items-center gap-10">
        <a href="/" class="text-3xl font-black text-blue-700">{{ __('hotel.brand') }}</a>

        <nav class="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex">
          @admin
          <a class="transition hover:text-slate-900"
            href="{{ route('admin.dashboard') }}">{{ __('hotel.nav.explore') }}</a>
          @endadmin
        </nav>
      </div>
      @auth
      <div>
        Hi there, {{ Auth::user()->name }}
      </div>
      @endauth
      <div class="flex items-center gap-4">
        <div class="flex gap-2 text-xs font-semibold uppercase text-slate-500">
          @foreach (config('app.available_locales') as $lang)
          <a href="{{ route('locale.switch', ['locale' => $lang])  }}"
            class=" {{ app()->getLocale() === $lang ? 'text-blue-600' : 'hover:text-slate-900' }}">
            {{ strtoupper($lang) }}
          </a>
          @endforeach
        </div>
        @guest
        <a href="{{ route("show.login") }}"
          class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">{{ __('hotel.nav.login') }}</a>
        <a href="{{ route("show.register") }}"
          class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">{{ __('Register') }}</a>
        @endguest
        @auth
        <form action="{{ route('logout') }}" method="POST" class="m-0">
          @csrf
          <button
            class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Logout</button>
        </form>
        @endauth
      </div>
    </div>
  </header>

  <main class="flex-1 w-full max-w-6xl mx-auto px-6 py-12">
    @yield('content')
  </main>

  <footer class="border-t border-slate-200 bg-white py-8 text-sm text-slate-600">
    <div class="mx-auto flex max-w-7xl flex-col gap-3 px-6 md:flex-row md:items-center md:justify-between">
      <p class="font-semibold text-slate-700">{{ __('hotel.brand') }}</p>
      <p>&copy; {{ date('Y') }} {{ __('hotel.brand') }}. {{ __('hotel.footer.all_rights_reserved') }}</p>
    </div>
  </footer>
</body>

</html>