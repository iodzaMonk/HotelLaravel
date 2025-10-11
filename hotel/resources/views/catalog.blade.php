@extends('layouts.app')

@section('title', 'Explore Stays')

@section('content')
@php($filter = trim((string) ($destination ?? '')))
<section class="mb-12 text-center space-y-4">
  <span class="inline-flex items-center rounded-full bg-blue-50 px-4 py-1 text-sm font-semibold text-blue-600">
    Explore stays
  </span>
  <h1 class="text-4xl font-bold tracking-tight text-slate-900">Find your next getaway</h1>
  <p class="mx-auto max-w-2xl text-base text-slate-600">
    Browse our curated collection of hotels, each with its own personality and story. Book a room that suits your style,
    whether it is a city escape, a beach retreat, or a mountain sanctuary.
  </p>
  <form method="GET" action="{{ route('hotels.catalog') }}" class="mx-auto flex max-w-lg gap-3 pt-4">
    <input type="text" name="destination" value="{{ $filter }}"
      placeholder="Search hotels or locations" class="flex-1 rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
    <button type="submit"
      class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 font-semibold text-white shadow-sm transition hover:bg-blue-700">
      Search
    </button>
  </form>
  @if ($filter !== '')
  <p class="text-sm text-slate-500">
    Showing results for <span class="font-semibold text-slate-700">"{{ $filter }}"</span>
  </p>
  @endif
</section>

<section class="grid gap-8 sm:grid-cols-2 xl:grid-cols-3">
  @forelse ($hotels as $hotel)
  <article
    class="group flex h-full flex-col overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-lg">
    @php($image = $hotel->temporary_image_url ?? $hotel->image_url)
    <figure class="relative h-56 w-full overflow-hidden bg-slate-100">
      @if ($image)
        <img src="{{ $image }}" alt="{{ $hotel->hotel_name }}"
          class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
      @else
        <div
          class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-100 via-slate-100 to-indigo-100 text-blue-500">
          <span class="text-sm font-semibold uppercase tracking-[0.3em]">No image</span>
        </div>
      @endif

      <div
        class="absolute inset-x-4 bottom-4 flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-slate-600 shadow">
        <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
        Available rooms
      </div>
    </figure>

    <div class="flex flex-1 flex-col gap-4 p-6">
      <div class="space-y-2">
        <h2 class="text-xl font-semibold text-slate-900">{{ $hotel->hotel_name }}</h2>
        <p class="line-clamp-2 text-sm text-slate-500">{{ $hotel->hotel_address }}</p>
      </div>

      <div class="mt-auto flex items-center justify-between text-sm font-medium text-slate-600">
        <span>{{ $hotel->rooms()->count() }} rooms</span>
        <a href="{{ route('admin.hotels.show', $hotel->id) }}"
          class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
          View details
          <span aria-hidden="true">&rarr;</span>
        </a>
      </div>
    </div>
  </article>
  @empty
  <div
    class="col-span-full flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-white/60 p-16 text-center">
    <h2 class="text-2xl font-semibold text-slate-800">No hotels yet</h2>
    <p class="mt-2 text-sm text-slate-500">We are curating new destinations. Check back soon for fresh stays.</p>
  </div>
  @endforelse
</section>
@endsection
