@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg py-12">
  <h1 class="text-2xl font-bold mb-4">Verify Your Email Address</h1>

  @if (session('status') === 'verification-link-sent')
  <div class="mb-4 rounded border border-green-200 bg-green-100 p-4 text-green-800">
    A fresh verification link has been sent to your email address.
  </div>
  @endif

  <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
    @csrf
    <button type="submit" class="rounded bg-blue-600 px-4 py-2 font-semibold text-white hover:cursor-pointer">
      Resend Verification Email
    </button>
  </form>

  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit"
      class="rounded bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:cursor-pointer">
      Logout
    </button>
  </form>
</div>
@endsection