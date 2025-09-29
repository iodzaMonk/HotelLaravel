@extends('layouts.app')

@section('title', 'Hub')

@section('content')
  <div class="flex flex-1 flex-col space-y-16">
    <section class="relative overflow-hidden rounded-3xl bg-slate-900 text-white shadow-xl"
      style="background-image: linear-gradient(120deg, rgba(15, 23, 42, 0.90), rgba(15, 23, 42, 0.6)), url({{ asset('img/hero-image.jpg') }}); background-size: cover; background-position: center;">
      <div class="relative px-8 py-16 md:px-14 lg:px-20">
        <span
          class="inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-1 text-sm uppercase tracking-[0.3em]">Welcome
          to Hotels</span>
        <h2 class="mt-6 text-4xl font-bold leading-tight sm:text-5xl">Find the stay that fits the way you travel</h2>
        <p class="mt-4 max-w-2xl text-lg text-slate-200">Browse hand-picked hotels across the globe with transparent
          pricing, flexible cancellations, and support whenever you need it.</p>
        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-center">
          <a href="#"
            class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-6 py-3 font-semibold text-slate-900 shadow-sm transition hover:bg-slate-100 sm:justify-start">
            Start exploring
            <span aria-hidden="true">&rarr;</span>
          </a>
          <a href="#offers"
            class="inline-flex items-center justify-center gap-2 rounded-full border border-white/60 px-6 py-3 text-white transition hover:bg-white/10 sm:justify-start">
            View current offers
          </a>
        </div>
      </div>
    </section>

    <form
      class="relative z-10 grid gap-4 rounded-2xl bg-white p-6 shadow-lg ring-1 ring-black/5 sm:grid-cols-2 lg:grid-cols-[2fr_repeat(3,_1fr)_auto] lg:items-end"
      action="">
      <label class="flex flex-col gap-2">
        <span class="text-sm font-semibold text-slate-600">Destination</span>
        <input placeholder="City, landmark, or hotel" type="text"
          class="rounded-xl border border-slate-200 px-4 py-3 text-base shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
      </label>
      <label class="flex flex-col gap-2">
        <span class="text-sm font-semibold text-slate-600">Check-in</span>
        <input id="check-in" type="text" placeholder="Select date" autocomplete="off"
          class="rounded-xl border border-slate-200 px-4 py-3 text-base shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
      </label>
      <label class="flex flex-col gap-2">
        <span class="text-sm font-semibold text-slate-600">Check-out</span>
        <input id="check-out" type="text" placeholder="Select date" autocomplete="off"
          class="rounded-xl border border-slate-200 px-4 py-3 text-base shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
      </label>
      <label class="flex flex-col gap-2 lg:min-w-[9rem]">
        <span class="text-sm font-semibold text-slate-600">Guests</span>
        <input type="number" min="1" value="2"
          class="rounded-xl border border-slate-200 px-4 py-3 text-base shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
      </label>
      <button
        class="inline-flex h-full w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white shadow-md transition hover:bg-blue-700 sm:col-span-2 lg:col-span-1 lg:w-auto lg:self-stretch"
        type="submit">
        Search stays
      </button>
    </form>

    <div class="align-center  justify-center">

        <H1 >Hotels </H1>

        <div class="flex flex-wrap">

            @foreach ($hotels as $hotel)
                <div class="flex flex-wrap  max-w-sm rounded p-4 m-4  ">
                    <!-- <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name }}"> -->
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">{{ $hotel->name }}</div>
                        <p class="text-gray-700 text-base">
                            {{ $hotel->description }}
                        </p>
                        <p class="text-gray-900 font-semibold mt-2">Price per night: ${{ $hotel->price_per_night }}</p>
                        <p class="text-gray-600">Location: {{ $hotel->location }}</p>
                    </div>
              
                </div>
            @endforeach

        </div>


    </div>


    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
      <section class="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-black/5">
        <h3 class="text-xl font-semibold text-slate-900">Curated hotel collections</h3>
        <p class="mt-3 text-slate-600">Explore boutique gems, business-friendly stays, or family favorites tailored to
          your budget and style.</p>
        <a class="mt-5 inline-flex items-center gap-2 font-semibold text-blue-600 transition hover:text-blue-700"
          href="#">
          Browse catalog
          <span aria-hidden="true">&rarr;</span>
        </a>
      </section>

      <section id="offers" class="rounded-2xl bg-gradient-to-br from-blue-600 to-blue-500 p-6 text-white shadow-lg">
        <h3 class="text-xl font-semibold">Limited-time offers</h3>
        <p class="mt-3 text-blue-100">Unlock seasonal promotions and flexible cancellation perks from trusted partners.
        </p>
        <div class="mt-5 flex flex-wrap items-center gap-3 text-sm uppercase tracking-[0.25em] text-blue-100/80">
          <span class="inline-flex items-center rounded-full bg-white/10 px-3 py-1">Up to 30% off</span>
          <span>Free breakfast</span>
          <span>Late checkout</span>
        </div>
      </section>

      <section class="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-black/5">
        <h3 class="text-xl font-semibold text-slate-900">Guest impressions</h3>
        <ul class="mt-4 space-y-3 text-slate-600">
          <li>“Flawless service from booking to checkout.” — Sofia, Madrid</li>
          <li>“Loved the curated recommendations for couples.” — Malik, Dubai</li>
          <li>“Fast support saved our last-minute trip.” — Ava, Toronto</li>
        </ul>
      </section>
    </div>
  </div>
@endsection