@extends('layouts.app')

@section('title', 'Admin Menu')

@section('content')
<section class="mx-auto max-w-4xl">
  <h2 class="text-3xl font-semibold text-slate-900">Admin Controls</h2>
  <p class="mt-2 text-slate-600">Quickly jump to the area you want to manage.</p>

  <div class="mt-8 grid gap-6 md:grid-cols-2">
    <a href={{ route('admin.hotels.index') }}
      class="admin-card group relative flex aspect-[4/3] items-center justify-center overflow-hidden rounded-3xl bg-slate-900 text-white shadow-lg transition-transform hover:-translate-y-1 hover:shadow-xl"
      style="--admin-card-bg: url({{ asset('img/hero-image.jpg') }});">
      <span class="absolute inset-0 bg-slate-900/60 transition-opacity group-hover:bg-slate-900/45"></span>
      <div class="relative flex flex-col items-center gap-2 text-center">
        <span
          class="inline-flex items-center justify-center rounded-full bg-white/20 px-4 py-1 text-xs font-semibold uppercase tracking-[0.25em]">Hotels</span>
        <p class="text-xl font-semibold">Manage properties</p>
        <span class="inline-flex items-center text-sm text-blue-100 transition group-hover:text-white">
          Enter dashboard
          <span aria-hidden="true" class="ml-2">&rarr;</span>
        </span>
      </div>
    </a>

    <a href={{ route('admin.rooms.index') }}
      class="admin-card group relative flex aspect-[4/3] items-center justify-center overflow-hidden rounded-3xl bg-slate-900 text-white shadow-lg transition-transform hover:-translate-y-1 hover:shadow-xl"
      style="--admin-card-bg: url({{ asset('img/rooms.jpg') }});">
      <span class="absolute inset-0 bg-slate-900/60 transition-opacity group-hover:bg-slate-900/45"></span>
      <div class="relative flex flex-col items-center gap-2 text-center">
        <span
          class="inline-flex items-center justify-center rounded-full bg-white/20 px-4 py-1 text-xs font-semibold uppercase tracking-[0.25em]">Rooms</span>
        <p class="text-xl font-semibold">Set availability</p>
        <span class="inline-flex items-center text-sm text-blue-100 transition group-hover:text-white">
          Enter dashboard
          <span aria-hidden="true" class="ml-2">&rarr;</span>
        </span>
      </div>
    </a>
  </div>
</section>
@endsection