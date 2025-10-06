@extends('layouts.app')

@section('title', 'Create room')

@section('content')
<div class="flex items-center gap-4">
  <a href="{{ route('admin.rooms.index') }}"
    class="inline-flex items-center gap-2 rounded-full border border-transparent bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
    <span aria-hidden="true">&larr;</span>
    Back
  </a>
</div>

<section class="mt-10">
  <div class="mx-auto max-w-3xl rounded-3xl bg-white p-10 shadow-xl ring-1 ring-slate-200">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-slate-900">Create a room</h1>
      <p class="mt-2 text-sm text-slate-500">Fill in the details below to add a new room to the collection.</p>
    </div>

    @if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
      <ul class="space-y-1">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-6">
      @csrf
      <div class="grid gap-6 md:grid-cols-2">
        <div class="flex flex-col gap-2">
          <label for="room_type" class="text-sm font-semibold text-slate-600">Room type</label>
          <input id="room_type" name="room_type" type="text" value="{{ old('room_type') }}"
            placeholder="Grand deluxe" required
            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>

        <div class="flex flex-col gap-2">
          <label for="price_per_night" class="text-sm font-semibold text-slate-600">Price per night</label>
          <input id="price_per_night" name="price_per_night" type="text" value="{{ old('price_per_night') }}"
            placeholder="13$" required
            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>

        <div class="flex flex-col gap-2">
          <label for="room_number" class="text-sm font-semibold text-slate-600">Room number</label>
          <input id="room_number" name="price_per_nroom_numberight" type="text" value="{{ old('room_number') }}"
            placeholder="23" required
            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>

        <div class="flex flex-col gap-2">
          <label for="hotel_id" class="text-sm font-semibold text-slate-600">Hotel id</label>
          <input id="hotel_id" name="hotel_id" type="text" value="{{ old('hotel_id') }}"
            placeholder="2" required
            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>

      </div>

      <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.rooms.index') }}"
          class="inline-flex items-center justify-center rounded-full border border-slate-200 px-6 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900">Cancel</a>
        <button type="submit"
          class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
          <span>Create room</span>
        </button>
      </div>
    </form>
  </div>
</section>
@endsection