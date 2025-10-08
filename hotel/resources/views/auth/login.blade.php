@extends('layouts.app')

@section('title', 'Login')

@section('content')
<form action="/users" method="post"
  class="bg-white text-2xl flex flex-col ring-1 rounded-md p-5 ring-black/5 shadow-lg">
  @csrf
  <label class="my-2" for="username">Username</label>
  <input type="text" name="username" class="ring-1 ring-black/5 p-2">
  <label class="my-2" for="password">Password</label>
  <input type="password" name="password" class="ring-1 ring-black/5 p-2">
  <button type="submit" class="p-2 w-1/2 rounded-md mx-auto mt-5 bg-green-500">Login</button>
</form>

@endsection