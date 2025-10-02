@extends('layouts.app')

@section('title', $hotel->hotel_name . 'Hotel')

@section('content')
@php
$hasEditRoute = \Illuminate\Support\Facades\Route::has('admin.hotels.edit');
$hasDestroyRoute = \Illuminate\Support\Facades\Route::has('admin.hotels.destroy');
@endphp

<div class="flex flex-wrap items-center justify-between gap-4">
  <a href="{{ route('admin.hotels.index') }}"
    class="inline-flex items-center gap-2 rounded-full border border-transparent bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
    <span aria-hidden="true">&larr;</span>
    Back to hotels
  </a>

  <div class="flex items-center gap-3 text-sm text-slate-500">
    <span class="hidden font-semibold text-slate-400 sm:inline">Hotel ID</span>
    <span
      class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-600">#{{ $hotel->id }}</span>
  </div>
</div>

<section class="mt-10">
  <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
    <article class="rounded-3xl bg-white p-10 shadow-xl ring-1 ring-slate-200">
      <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-3">
          <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-500">Hotel profile</p>
          <h1 class="text-4xl font-bold tracking-tight text-slate-900">{{ $hotel->hotel_name }}</h1>
          <p class="text-base text-slate-600">{{ $hotel->hotel_address }}</p>
        </div>

        <dl class="grid gap-6 sm:grid-cols-2">
          <div class="rounded-3xl border border-slate-200 p-6">
            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Created</dt>
            <dd class="mt-2 text-lg font-semibold text-slate-900">
              {{ optional($hotel->created_at)->format('M j, Y g:i A') ?? 'Not available' }}
            </dd>
          </div>

          <div class="rounded-3xl border border-slate-200 p-6">
            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Last updated</dt>
            <dd class="mt-2 text-lg font-semibold text-slate-900">
              {{ optional($hotel->updated_at)->format('M j, Y g:i A') ?? 'Not available' }}
            </dd>
          </div>
        </dl>
      </div>
    </article>

    <aside class="space-y-6">
      <div class="rounded-3xl bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-500 p-8 text-white shadow-xl">
        <h2 class="text-lg font-semibold">Actions</h2>
        <p class="mt-2 text-sm text-blue-100">Manage this listing right from here.</p>
        <div class="mt-6 flex flex-col gap-3">
          @if ($hasEditRoute)
          <a href={{ route('admin.hotels.edit', $hotel->id) }}
            class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-5 py-2 text-sm font-semibold text-blue-600 shadow transition hover:text-blue-700 hover:shadow-md">Edit
            hotel</a>
          @endif

          @if ($hasDestroyRoute)
          <form action="{{ route('admin.hotels.destroy', $hotel->id) }}" method="POST" class="inline-flex">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="inline-flex items-center justify-center gap-2 rounded-full bg-white/10 px-5 py-2 text-sm font-semibold text-white transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/60">
              Delete hotel
            </button>
          </form>
          @else
          <button type="button" disabled
            class="inline-flex items-center justify-center gap-2 rounded-full bg-white/10 px-5 py-2 text-sm font-semibold text-white/70">
            Delete option unavailable
          </button>
          @endif
        </div>
      </div>
    </aside>
  </div>
</section>
@endsection