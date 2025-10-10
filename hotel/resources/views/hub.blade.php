@extends('layouts.app')

@section('title', __('hub.title'))

@section('content')
<div class="flex flex-1 flex-col space-y-16">
  <section class="relative overflow-hidden rounded-3xl bg-slate-900 text-white shadow-xl admin-card"
    style="--admin-card-bg: url({{ asset('/img/hero-image.jpg') }})">
    <span class="absolute inset-0 bg-slate-900/60"></span>
    <div class="relative px-8 py-16 md:px-14 lg:px-20">
      <span
        class="inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-1 text-sm uppercase tracking-[0.3em]">{{ __('hub.hero.kicker') }}</span>
      <h2 class="mt-6 text-4xl font-bold leading-tight sm:text-5xl">{{ __('hub.hero.heading') }}</h2>
      <p class="mt-4 max-w-2xl text-lg text-slate-200">{{ __('hub.hero.body') }}</p>
      <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-center">
        <a href="#"
          class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-6 py-3 font-semibold text-slate-900 shadow-sm transition hover:bg-slate-100 sm:justify-start">
          {{ __('hub.hero.primary_cta') }}
          <span aria-hidden="true">&rarr;</span>
        </a>
        <a href="#offers"
          class="inline-flex items-center justify-center gap-2 rounded-full border border-white/60 px-6 py-3 text-white transition hover:bg-white/10 sm:justify-start">
          {{ __('hub.hero.secondary_cta') }}
        </a>
      </div>
    </div>
  </section>

  <form
    class="relative z-10 grid gap-4 rounded-2xl bg-white p-6 shadow-lg ring-1 ring-black/5 overflow-hidden sm:grid-cols-2 lg:grid-cols-[3fr_repeat(2,_1.5fr)_1fr_auto] lg:items-end"
    action="">
    <label class="flex flex-col gap-2">
      <span class="text-sm font-semibold text-slate-600">{{ __('hub.search.destination') }}</span>
      <input placeholder="{{ __('hub.search.destination_placeholder') }}" type="text"
        class="rounded-xl border border-slate-200 px-4 py-3 text-base shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
    </label>
    <label class="flex flex-col gap-2 lg:min-w-[12rem]">
      <span class="text-sm font-semibold text-slate-600">{{ __('hub.search.check_in') }}</span>
      <input id="check-in" type="text" placeholder="{{ __('hub.search.date_placeholder') }}" autocomplete="off"
        class="rounded-xl border border-slate-200 px-4 py-3 text-base shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
    </label>
    <label class="flex flex-col gap-2 lg:min-w-[12rem]">
      <span class="text-sm font-semibold text-slate-600">{{ __('hub.search.check_out') }}</span>
      <input id="check-out" type="text" placeholder="{{ __('hub.search.date_placeholder') }}" autocomplete="off"
        class="rounded-xl border border-slate-200 px-4 py-3 text-base shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
    </label>
    <label class="flex flex-col gap-2 lg:min-w-[9rem]">
      <span class="text-sm font-semibold text-slate-600">{{ __('hub.search.guests') }}</span>
      <input type="number" min="1" value="2"
        class="rounded-xl border border-slate-200 px-4 py-3 text-base shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
    </label>
    <button
      class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white shadow-md transition hover:bg-blue-700 sm:col-span-2 lg:col-span-1 lg:w-auto"
      type="submit">
      {{ __('hub.search.submit') }}
    </button>
  </form>

  <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
    <section class="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-black/5">
      <h3 class="text-xl font-semibold text-slate-900">{{ __('hub.collections.heading') }}</h3>
      <p class="mt-3 text-slate-600">{{ __('hub.collections.body') }}</p>
      <a class="mt-5 inline-flex items-center gap-2 font-semibold text-blue-600 transition hover:text-blue-700"
        href="#">
        {{ __('hub.collections.cta') }}
        <span aria-hidden="true">&rarr;</span>
      </a>
    </section>

    <section id="offers" class="rounded-2xl bg-gradient-to-br from-blue-600 to-blue-500 p-6 text-white shadow-lg">
      <h3 class="text-xl font-semibold">{{ __('hub.offers.heading') }}</h3>
      <p class="mt-3 text-blue-100">{{ __('hub.offers.body') }}</p>
      <div class="mt-5 flex flex-wrap items-center gap-3 text-sm uppercase tracking-[0.25em] text-blue-100/80">
        <span
          class="inline-flex items-center rounded-full bg-white/10 px-3 py-1">{{ __('hub.offers.badges.discount') }}</span>
        <span>{{ __('hub.offers.badges.breakfast') }}</span>
        <span>{{ __('hub.offers.badges.checkout') }}</span>
      </div>
    </section>

    <section class="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-black/5">
      <h3 class="text-xl font-semibold text-slate-900">{{ __('hub.testimonials.heading') }}</h3>
      <ul class="mt-4 space-y-3 text-slate-600">
        @foreach (__('hub.testimonials.items') as $item)
        <p>{{$item}}</p>
        @endforeach
      </ul>
    </section>
  </div>
</div>
@endsection