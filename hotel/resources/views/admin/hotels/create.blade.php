@extends('layouts.app')

@section('title', 'Create Hotel')

@section('content')
  <div class="flex items-center gap-4">
    <a href="{{ route('admin.hotels.index') }}"
      class="inline-flex items-center gap-2 rounded-full border border-transparent bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
      <span aria-hidden="true">&larr;</span>
      Back
    </a>
  </div>

  <section class="mt-10">
    <div class="mx-auto max-w-3xl rounded-3xl bg-white p-10 shadow-xl ring-1 ring-slate-200">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Create a hotel</h1>
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

      <form action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid gap-6 md:grid-cols-2">
          <div class="flex flex-col gap-2">
            <label for="hotel_name" class="text-sm font-semibold text-slate-600">Hotel name</label>
            <input id="hotel_name" name="hotel_name" type="text" value="{{ old('hotel_name') }}"
              placeholder="e.g. Skyline Retreat" required
              class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
          </div>

          <div class="flex flex-col gap-2">
            <label for="hotel_address" class="text-sm font-semibold text-slate-600">Hotel address</label>
            <input id="hotel_address" name="hotel_address" type="text" value="{{ old('hotel_address') }}"
              placeholder="e.g. 123 Ocean Drive, Miami" required
              class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
          </div>
        </div>

        <div class="flex flex-col gap-2">
          <label for="hotel_address" class="text-sm font-semibold text-slate-600">Hotel Image</label>
          <input id="hotel_image" name="hotel_image" type="file" placeholder="e.g. 123 Ocean Drive, Miami"
            required
            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">

        </div>

        <div class="flex items-center justify-end gap-3">
          <a href="{{ route('admin.hotels.index') }}"
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
