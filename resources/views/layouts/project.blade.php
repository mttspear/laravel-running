@extends('layouts.static')

@section('content')

        <article class="blog-post">
            <h2 class="blog-post-title">@yield('project-title')</h2>
            <p class="blog-post-meta">@yield('date') by <a href="#">Matt Spear</a></p>

            @yield('project')
        </article>

@endsection
