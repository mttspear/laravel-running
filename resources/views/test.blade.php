<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
        integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vivus/0.4.6/vivus.min.js"
        integrity="sha512-oUUeA7VTcWBqUJD/VYCBB4VeIE0g1pg5aRMiSUOMGnNNeCLRS39OlkcyyeJ0hYx2h3zxmIWhyKiUXKkfZ5Wryg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"
        integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
    <style>
        *,
        *::after,
        *::before {
            box-sizing: border-box;
        }

        body {
            font-family: 'Playfair Display', serif;
            background: rgb(23, 22, 22);
            color: #fff;
        }

        .preloader {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
            background: rgb(23, 22, 22);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            transition: opacity 0.3s linear;
        }

        .page-content {
            max-width: 768px;
            margin: 0 auto;
        }

    </style>
</head>

<body class="homepage">
    <div class="preloader">

        <div class="container">
            <div class="baton-0"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-1"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-2"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-3"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-4"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-5"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-6"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-7"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-8"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-9"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-10"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-11"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-12"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-13"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-14"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-15"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-16"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-17"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-18"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-19"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-20"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-21"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-22"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-23"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-24"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-25"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-26"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-27"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-28"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-29"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-30"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-31"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-32"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-33"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-34"><div class="metronome"><div class="baton"></div></div></div>
            <div class="baton-35"><div class="metronome"><div class="baton"></div></div></div>
      </div>

    </div>
    <div class="page-content">
        <h1>Page title</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti exercitationem, fuga quaerat corrupti
            dolorum
            cupiditate iste at animi alias incidunt?</p>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Asperiores optio inventore ea. Asperiores placeat
            et
            aspernatur quidem dolor, autem deserunt voluptatem. Vel accusantium recusandae, aperiam unde nam ea
            blanditiis ex
            provident cupiditate, minus et consequatur obcaecati amet, rem dolorem quod repellat nisi inventore sit
            eligendi
            voluptatem sequi. Cum, illo qui.</p>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolore vitae deserunt aspernatur minima possimus
            aperiam et quidem libero, sequi, reiciendis, architecto quod? Iure cupiditate laudantium enim suscipit ipsa
            fuga
            velit?</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis molestias dolor dicta ea sed consequuntur?</p>
    </div>

</body>

<script>
    const preloader = document.querySelector('.preloader');

    const fadeEffect = setInterval(() => {
        // if we don't set opacity 1 in CSS, then   //it will be equaled to "", that's why we   // check it
        if (!preloader.style.opacity) {
            preloader.style.opacity = 1;
        }
        if (preloader.style.opacity > 0) {
            preloader.style.opacity -= 0.1;
        } else {
            clearInterval(fadeEffect);
        }
    }, 200);

    window.addEventListener('load', fadeEffect);
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.0.5/gsap.min.js"></script>

<script type="text/javascript" src="{{ asset('js/detector.js') }}"></script>
<script type="module" src="{{ asset('js/homepage.js') }}"></script>

</html>
