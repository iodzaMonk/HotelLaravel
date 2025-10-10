@extends('layouts.app')

@section('title', 'Register')

@section('content')
  <div class="grid gap-12 lg:grid-cols-[minmax(0,1.1fr),minmax(0,0.9fr)] lg:items-center">
    <div class="space-y-6">
      <span
        class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-xs font-semibold uppercase text-blue-600">
        {{ __('hotel.brand') }}
        <span class="h-1 w-1 rounded-full bg-blue-400"></span>
        {{ __('Create your stay account') }}
      </span>
      <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
        {{ __('Unlock member-only rates in a few clicks') }}
      </h1>
      <p class="text-lg leading-relaxed text-slate-600">
        {{ __('Sign up to manage future bookings, track rewards, and receive offers tailored to your travel style.') }}
      </p>

      <dl class="grid gap-6 sm:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm">
          <dt class="text-sm font-semibold uppercase text-blue-600">{{ __('Flexible changes') }}</dt>
          <dd class="mt-2 text-sm text-slate-600">
            {{ __('Modify your reservations without hidden fees on eligible stays.') }}
          </dd>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm">
          <dt class="text-sm font-semibold uppercase text-blue-600">{{ __('Early check-in perks') }}</dt>
          <dd class="mt-2 text-sm text-slate-600">
            {{ __('Enjoy priority check-in and late checkout when availability allows.') }}
          </dd>
        </div>
      </dl>
    </div>

    <div class="relative">
      <div
        class="absolute -inset-1 rounded-[28px] bg-gradient-to-br from-blue-500/25 via-blue-400/20 to-purple-400/25 blur-lg">
      </div>

      <form method="POST" action="{{ route('register') }}"
        class="relative rounded-[26px] bg-white/90 p-10 shadow-2xl ring-1 ring-slate-200 backdrop-blur">
        @csrf

        @if ($errors->any())
          <div class="mb-6 rounded-2xl border border-red-200 bg-red-50/80 p-5 text-sm text-red-700">
            <p class="font-semibold">{{ __("We couldn't create your account") }}</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="grid gap-6 sm:grid-cols-2">
          <div class="sm:col-span-2">
            <label for="name" class="block text-sm font-semibold text-slate-700">{{ __('Full name') }}</label>
            <input id="name" name="name" value="{{ old('name') }}" type="text" autocomplete="name" required
              placeholder="{{ __('E.g. Jordan Carter') }}"
              class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 placeholder:text-slate-400">
          </div>

          <div class="sm:col-span-2">
            <label for="email" class="block text-sm font-semibold text-slate-700">{{ __('Email address') }}</label>
            <input id="email" name="email" value="{{ old('email') }}" type="email" autocomplete="email" required
              placeholder="you@email.com"
              class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 placeholder:text-slate-400">
          </div>

          <div>
            <label for="password" class="block text-sm font-semibold text-slate-700">{{ __('Password') }}</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required
              class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 placeholder:text-slate-400">
            <p class="mt-2 text-xs text-slate-500">{{ __('Use at least 8 characters with a number and a symbol.') }}</p>
          </div>

          <div>
            <label for="password_confirmation"
              class="block text-sm font-semibold text-slate-700">{{ __('Confirm password') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
              required
              class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 placeholder:text-slate-400">
          </div>
        </div>

        <button type="submit"
          class="mt-8 inline-flex w-full items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-blue-500/30 transition hover:bg-blue-700 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600">
          {{ __('Create account') }}
        </button>

        <p class="mt-6 text-center text-sm text-slate-600">
          {{ __('Already registered?') }}
          <a href="{{ route('show.login') }}" class="font-semibold text-blue-600 transition hover:text-blue-700">
            {{ __('Sign in instead') }}
          </a>
        </p>
      </form>
    </div>
  </div>
@endsection