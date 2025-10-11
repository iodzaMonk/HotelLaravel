@extends('layouts.app')

@section('title', 'Browse Hotels')

@section('content')
  <div class="flex justify-between w-full">
    <a href={{ route('admin.dashboard') }}
      class="py-4 px-8 transition-colors hover:bg-blue-500 bg-blue-600 text-lg text-white rounded-full">Back</a>
    <a href="{{ route('admin.hotels.create') }}"
      class="py-4 px-8 bg-green-600 rounded-full transition-colors text-white hover:bg-green-500">Add hotel</a>
  </div>
  <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3 mt-10">
    @forelse ($hotels as $hotel)
      <article class="rounded-2xl bg-white p-6 shadow ring-1 ring-black/5">
        @php($image = $hotel->temporary_image_url ?? $hotel->image_url)
        @if ($image)
          <img
            src="{{ $image }}"
            alt="{{ $hotel->hotel_name }}"
            class="h-40 w-full rounded-xl object-cover"
          >
        @endif
        <h3 class="text-xl font-semibold text-slate-900">{{ $hotel->hotel_name }}</h3>
        <p class="mt-2 text-slate-600">{{ $hotel->hotel_address }}</p>
        <a href="{{ route('admin.hotels.show', $hotel->id)}}"
          class="mt-4 inline-flex items-center gap-2 font-semibold text-blue-600 hover:text-blue-700">
          View details <span aria-hidden="true">&rarr;</span>
        </a>
      </article>
    @empty
      <p class="col-span-full text-center text-slate-500">No hotels available yet.</p>
    @endforelse
  </section>

@endsection
