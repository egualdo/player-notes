@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
<div class="flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold">Bienvenido a {{ config('app.name') }}</h1>
        <p class="mt-2 text-gray-600">Esta es la aplicación de notas de jugadores.</p>
    </div>
</div>
@endsection
