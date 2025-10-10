@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="grid gap-10 lg:grid-cols-[minmax(0,1.1fr),minmax(0,0.9fr)] lg:items-center">
  <div class="space-y-6">
    <span
      class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-xs font-semibold uppercase text-blue-600">
      {{ __('hotel.brand') }}
      <span class="h-1 w-1 rounded-full bg-blue-400"></span>
      {{ __('Welcome back') }}
    </span>
    <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
      {{ __('Ready for your next stay?') }}
    </h1>
    <p class="text-lg leading-relaxed text-slate-600">
      {{ __('Sign in to pick up where you left off, review reservations, and unlock curated offers crafted for your travels.') }}
    </p>

    <ul class="grid gap-4 text-sm text-slate-600 sm:grid-cols-2">
      <li class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600/10 text-blue-600">✓</span>
        {{ __('Securely manage bookings from any device.') }}
      </li>
      <li class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600/10 text-blue-600">✓</span>
        {{ __('Access saved preferences for smoother check-ins.') }}
      </li>
    </ul>
  </div>

  <div class="relative">
    <div
      class="absolute -inset-1 rounded-[28px] bg-gradient-to-br from-blue-500/25 via-blue-400/20 to-purple-400/20 blur-lg">
    </div>

    <form method="POST" action="{{ route('login')}}"
      class="relative rounded-[26px] bg-white/90 p-10 shadow-2xl ring-1 ring-slate-200 backdrop-blur">
      @csrf

      @if ($errors->any())
      <div class="mb-6 rounded-2xl border border-red-200 bg-red-50/80 p-5 text-sm text-red-700">
        <p class="font-semibold">{{ __('We could not sign you in') }}</p>
        <ul class="mt-2 list-inside list-disc space-y-1">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <div class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-semibold text-slate-700">{{ __('Email address') }}</label>
          <input id="email" name="email" value="{{ old('email') }}" type="email" autocomplete="email" required
            placeholder="you@email.com"
            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 placeholder:text-slate-400">
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="text-sm font-semibold text-slate-700">{{ __('Password') }}</label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
              {{ __('Forgot password?') }}
            </a>
            @endif
          </div>
          <input id="password" name="password" type="password" autocomplete="current-password" required
            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 placeholder:text-slate-400">
        </div>

        <label class="flex items-center gap-3 text-sm text-slate-600">
          <input type="checkbox" name="remember"
            class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
          <span>{{ __('Keep me signed in on this device') }}</span>
        </label>
      </div>

      <button type="submit"
        class="mt-8 inline-flex w-full items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-blue-500/30 transition hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
        {{ __('Sign in') }}
      </button>

      <p class="mt-6 text-center text-sm text-slate-600">
        {{ __('Need an account?') }}
        <a href="{{ route('show.register') }}" class="font-semibold text-blue-600 transition hover:text-blue-700">
          {{ __('Create one now') }}
        </a>
      </p>
    </form>
  </div>
</div>
@endsection