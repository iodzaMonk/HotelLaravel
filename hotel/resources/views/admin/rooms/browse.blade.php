@extends('layouts.app')

@section('title', 'Browse Rooms')

@section('content')

  <a href={{ route('admin.dashboard') }} class="py-4 px-8 bg-blue-600 text-lg text-white rounded-full">Back</a>
  <section class="grid gap-6 mt-10 md:grid-cols-2 xl:grid-cols-3">
    @forelse ($rooms as $room)
      <article class="rounded-2xl bg-white p-6 shadow ring-1 ring-black/5">
        <h3 class="text-xl font-semibold text-slate-900">{{ $room->room_nb}}</h3>
        <p class="mt-2 text-slate-600">{{ $room->room_type }}</p>
        <a href="#" class="mt-4 inline-flex items-center gap-2 font-semibold text-blue-600 hover:text-blue-700">
          View details <span aria-hidden="true">&rarr;</span>
        </a>
      </article>
    @empty
      <p class="col-span-full text-center text-slate-500">No rooms available yet.</p>
    @endforelse
  </section>

@endsection