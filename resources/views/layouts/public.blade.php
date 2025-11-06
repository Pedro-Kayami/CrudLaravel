@extends('layouts.base')

@section('body')
    @include('partials.public-nav')

    <main class="container py-5 flex-grow-1">
        @yield('content')
    </main>

    @include('partials.public-footer')
@endsection
