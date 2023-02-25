<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>OC Joggers - @yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"
        integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/static.css') }}" rel="stylesheet" type="text/css">

</head>

@include('layouts.google')

<body>
    <div class="container-fluid sticky-top">
        <div id="top-row" class="row">
            <div class="col-md-8 offset-md-2">
                <header id="blog-header" class="blog-header py-3">
                    <div class="row flex-nowrap align-items-left">
                        <div class="col-4 text-center">
                            <h2 class="blog-header-logo text-dark" href="{{ route('index') }}">OC Joggers
                                <a href="{{ route('index') }}" class="stretched-link"></a>
                            </h2>
                        </div>
                    </div>
                </header>

                <div id="navbar" class="nav-scroller py-1 mb-2">
                    <nav class="nav d-flex">
                        <a class="p-2 link-secondary" href="{{ route('index') }}">Home</a>
                        <a class="p-2 link-secondary" href="/#projects">Projects</a>
                        <a class="p-2 link-secondary" href="/#about">About Me</a>
                        
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-4 offset-md-4">
                @yield('content')
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script>
        window.onscroll = function() {
            var currentScrollPos = window.pageYOffset;
            if (document.body.scrollTop === 0) {
                document.getElementById("navbar").style.display = "inherit";
                document.getElementById("top-row").style.borderBottom = "0px";
                document.getElementById("blog-header").style.borderBottom = "2px solid #3c3c3c";
            } else {
                document.getElementById("navbar").style.display = "none";
                document.getElementById("top-row").style.borderBottom = "2px solid #3c3c3c";
                document.getElementById("blog-header").style.borderBottom = "0px";
            }
        }
    </script>
</body>

</html>
