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
    <style>
        body {
            font-family: 'Nunito', sans-serif;

        }

        .second-header {
            position: absolute;
            bottom: 0;
            left: 0;
        }

        #spaceCanvas {
            position: absolute;
            overflow: hidden;
            display: block;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -10;

        }

        #main {
            width: 100%;
        }

        .star-section {
            height: 100vh;
            position: relative;
            overflow: hidden;
            color: whitesmoke;
            z-index: 100;
            max-width: 100%;
        }

        .bottom ::before {
            position: absolute;
            z-index: 1;
            color: #fff;
            top: 0;
            right: 0;
            left: 0;
            background: linear-gradient(to bottom, #000 0%, #3e99d1 92%, #fff 100%);
            background-image: linear-gradient(rgb(0, 0, 0) 0%, rgb(62, 153, 209) 92%, rgb(255, 255, 255) 100%);
        }

        #background-transition {
            background-image: linear-gradient(rgb(0, 0, 0) 0%, rgb(62, 153, 209) 92%, rgb(255, 255, 255) 100%);
        }

        body.homepage .transition-section:before {
            position: absolute;
            z-index: 1;
            top: 0;
            right: 0;
            left: 0;
            content: '';
        }

        .transition-section {
            position: relative;
            z-index: 1;
            color: #fff;
            height: auto;
            background-image: linear-gradient(rgb(0, 0, 0) 0%, rgb(62, 153, 209) 92%, rgb(255, 255, 255) 100%);
        }

        body.homepage .transition-section {
            min-height: 150vh;
            padding: 11% 0 18%;
            max-width: 100%;
        }

        #transition {
            min-height: 50vh;
            color: whitesmoke;
            padding-top: 100px;
            max-width: 100%;
        }

        #clouds canvas {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
        }

        #clouds {
            position: absolute;
            z-index: 1;
            bottom: -14%;
            left: 0;
            width: 100%;
        }

        #white-div {
            min-height: 100vh;
            max-width: 100%;
        }

        #clouds:after {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            content: '';
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, .82) 50%, white 100%);
        }

        .bottom-content {
            padding: 40vh 0 122px;
        }

        .gg {
            display: flex;
            height: 14px;
            margin-bottom: 11px;
        }

        .gg-symbol {
            height: 14px;
            width: 14px;
            background: #969696;
            margin-right: 14px;
        }

        .gg-symbol--2 {
            width: 56px;
        }

        .gg-symbol--3 {
            width: 84px;
        }

        .gg-symbol--5 {
            width: 140px;
        }

        .gg-symbol--8 {
            width: 224px;
        }

        .gg-symbol--disc {
            border-radius: 14px;
        }


        .mt-10 {
            margin-top: 10rem !important;
        }

        @import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        *:focus,
        *:active {
            outline: none !important;
            -webkit-tap-highlight-color: transparent;
        }

        /*        html,
        body {
            display: grid;
            height: 100%;
            width: 100%;
            font-family: "Poppins", sans-serif;
            place-items: center;
            background: linear-gradient(315deg, #ffffff, #d7e1ec);
        }*/

        /*ICONS */

        .wrapper {
            display: inline-flex;
        }

        .wrapper .icon {
            position: relative;
            background-color: #ffffff;
            border-radius: 50%;
            padding: 15px;
            margin: 10px;
            width: 50px;
            height: 50px;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .wrapper .tooltip {
            position: absolute;
            top: 0;
            font-size: 14px;
            background-color: #ffffff;
            color: #ffffff;
            padding: 5px 8px;
            border-radius: 5px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .wrapper .tooltip::before {
            position: absolute;
            content: "";
            height: 8px;
            width: 8px;
            background-color: #ffffff;
            bottom: -3px;
            left: 50%;
            transform: translate(-50%) rotate(45deg);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .wrapper .icon:hover .tooltip {
            top: -45px;
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .wrapper .icon:hover span,
        .wrapper .icon:hover .tooltip {
            text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.1);
        }

        .wrapper .github:hover,
        .wrapper .github:hover .tooltip,
        .wrapper .github:hover .tooltip::before {
            background-color: #333333;
            color: #ffffff;
        }

        .wrapper .linkedin:hover,
        .wrapper .linkedin:hover .tooltip,
        .wrapper .linkedin:hover .tooltip::before {
            background-color: #0e76A8;
            color: #ffffff;
        }

        .wrapper .upwork:hover,
        .wrapper .upwork:hover .tooltip,
        .wrapper .upwork:hover .tooltip::before {
            background-color: #73bb44;
            color: #ffffff;
        }

        .linkedin {
            color: black
        }

        .github {
            color: black;
        }

        /*BUTTON */
        .glow-on-hover {
            width: 220px;
            height: 50px;
            /*border: none;*/
            outline: none;
            color: #111;
            background: #111;
            cursor: pointer;
            position: relative;
            z-index: 0;
            border-radius: 10px;
        }

        .glow-on-hover:before {
            content: '';
            background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
            position: absolute;
            top: -2px;
            left: -2px;
            background-size: 400%;
            z-index: -1;
            filter: blur(5px);
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            animation: glowing 20s linear infinite;
            opacity: 0;
            transition: opacity .3s ease-in-out;
            border-radius: 10px;
        }

        .glow-on-hover:active {
            color: black
        }

        .glow-on-hover:active:after {
            background: transparent;
        }

        .glow-on-hover:hover:before {
            opacity: 1;
        }

        .glow-on-hover:after {
            z-index: -1;
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: white;
            left: 0;
            top: 0;
            border-radius: 10px;
        }

        @keyframes glowing {
            0% {
                background-position: 0 0;
            }

            50% {
                background-position: 400% 0;
            }

            100% {
                background-position: 0 0;
            }
        }

    </style>
</head>

<body class="homepage">
    <div>
        <div id="main">
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
            <section class="star-section">
                <div class="container star-container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1>OCJogger.com</h1>
                        </div>

                        <div class="gg">
                            <div class="gg-symbol gg-symbol--rect gg-symbol--5 gg-symbol--gradient"
                                style="background: linear-gradient(90deg, rgb(255, 218, 122) 0%, rgb(255, 105, 105) 100%); opacity: 1; transform: translate(0px, 0px);">
                            </div>
                            <div class="gg-symbol gg-symbol--disc" style="opacity: 1; transform: translate(0px, 0px);">
                            </div>
                        </div>

                        <div class="gg">
                            <div class="gg-symbol gg-symbol--rect gg-symbol--8 gg-symbol--gradient"
                                style="background: linear-gradient(90deg, rgb(242, 159, 255) 0%, rgb(124, 153, 255) 100%); opacity: 1; transform: translate(0px, 0px);">
                            </div>
                        </div>

                        <div class="gg">
                            <div class="gg-symbol gg-symbol--rect gg-symbol--3 gg-symbol--gradient"
                                style="background: linear-gradient(90deg, rgb(100, 145, 214) 0%, rgb(67, 240, 199) 100%); opacity: 1; transform: translate(0px, 0px);">
                            </div>
                            <div class="gg-symbol gg-symbol--square"
                                style="opacity: 1; transform: translate(0px, 0px);"></div>
                            <div class="gg-symbol gg-symbol--rect gg-symbol--2"
                                style="opacity: 1; transform: translate(0px, 0px);"></div>
                            <div class="gg-symbol gg-symbol--rect gg-symbol--5 gg-symbol--gradient"
                                style="background: linear-gradient(90deg, rgb(100, 145, 214) 0%, rgb(67, 240, 199) 100%); opacity: 1; transform: translate(0px, 0px);">
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div id="second-header" class="second-header align-self-end text-end">
                            <h2>App Development. Web Development. Python Analysis and Scripting</h2>
                        </div>


                    </div>


                </div>
                <div id="space"></div>

            </section>
            <section class="transition-section">
                <div class="container">
                    <div class="row text-center mt-10">
                        <h2>Hand crafted digital solutions for your buisness needs</h2>
                        <p>Expert in Laravel, SQL, PHP, Excel</p>
                    </div>
                </div>
                <div id="clouds" class="container-row"></div>
            </section>

            <div class="container" id="white-div">
                <div class="row bottom-content">
                    <div class="col-md-4  offset-md-4">
                        <div class="gg">
                            <div class="gg-symbol gg-symbol--rect gg-symbol--5 gg-symbol--gradient"
                                style="background: linear-gradient(90deg, rgb(242, 159, 255) 0%, rgb(124, 153, 255) 100%); opacity: 1; transform: translate(0px, 0px);">
                            </div>
                            <div class="gg-symbol gg-symbol--disc" style="opacity: 1; transform: translate(0px, 0px);">
                            </div>
                        </div>
                        <div class="gg">
                            <div class="gg-symbol gg-symbol--rect gg-symbol--3 gg-symbol--gradient"
                                style="background: linear-gradient(90deg, rgb(100, 145, 214) 0%, rgb(67, 240, 199) 100%); opacity: 1; transform: translate(0px, 0px);">
                            </div>
                            <div class="gg-symbol gg-symbol--square"
                                style="opacity: 1; transform: translate(0px, 0px);"></div>
                            <div class="gg-symbol gg-symbol--rect gg-symbol--2"
                                style="opacity: 1; transform: translate(0px, 0px);"></div>
                            <div class="gg-symbol gg-symbol--rect gg-symbol--5 gg-symbol--gradient"
                                style="background: linear-gradient(90deg, rgb(100, 145, 214) 0%, rgb(67, 240, 199) 100%); opacity: 1; transform: translate(0px, 0px);">
                            </div>
                        </div>

                        <h2>Project Examples and Links</h2>
                        <div class="gg">
                            <div class="gg-symbol gg-symbol--rect gg-symbol--8 gg-symbol--gradient"
                                style="background: linear-gradient(90deg, rgb(242, 159, 255) 0%, rgb(124, 153, 255) 100%); opacity: 1; transform: translate(0px, 0px);">
                            </div>
                        </div>
                        <div class="gg">
                            <div class="gg-symbol gg-symbol--rect gg-symbol--5 gg-symbol--gradient"
                                style="background: linear-gradient(90deg, rgb(255, 218, 122) 0%, rgb(255, 105, 105) 100%); opacity: 1; transform: translate(0px, 0px);">
                            </div>
                            <div class="gg-symbol gg-symbol--disc" style="opacity: 1; transform: translate(0px, 0px);">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="card border-0">
                            <div class="card-body text-center">
                                <h5 class="card-title">Sample Laravel Application</h5>
                                <p class="card-text text-start">Built using Laravel, Vue, Websockets and API's this game
                                    allows two players to pick an artist then go back and forth naming songs by selected
                                    artist. First to ten wins.</p>
                                    <button class="glow-on-hover" type="button">View Game</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card border-0">
                            <div class="card-body text-center">
                                <h5 class="card-title">Running Analysis</h5>
                                <p class="card-text text-start">Built using Python, Jupyter, and Pandas this project looks at
                                    the top 1,000 times for track events to draw a number of conclusions about the data.
                                </p>
                                <button class="glow-on-hover" type="button">View Notebook</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-0">
                            <div class="card-body text-center">
                                <h5 class="card-title">Resin Projects</h5>
                                <p class="card-text text-start">Built using Masonry.js this custom site displays photography
                                    and videography.</p>
                                    <button class="glow-on-hover" type="button">View Site</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="wrapper">
                            <a href="https://www.upwork.com/freelancers/~01d673de10ec509b4a" target=”_blank”>
                                <div class="icon upwork">

                                    <div class="tooltip">Upwork</div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.7 56.7">
                                        <!--! Font Awesome Free 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M0 0v56.7h56.7V0H0zm20.3 14.6h5.6a48.4 48.4 0 0 0 5.6 12.1c1.6-5.5 5.6-9 10.9-9a11.3 11.3 0 0 1 0 22.5 14 14 0 0 1-7.7-2.2l-2.4 11.9h-5.7l3.5-16.3a51.5 51.5 0 0 1-4-6.7v2.5a10.9 10.9 0 0 1-21.8 0V14.7h5.4v14.6a5.3 5.3 0 1 0 10.6 0V14.6zm22.2 8.8c-4.1 0-5.4 4-5.8 6.4v.1l-.6 2.2a10.2 10.2 0 0 0 6.3 2.5 5.9 5.9 0 0 0 5.7-5.6 5.6 5.6 0 0 0-5.6-5.6z" />
                                    </svg>

                                </div>
                            </a>
                            <a href="https://github.com/mttspear" target=”_blank”>
                                <div class="icon github">
                                    <div class="tooltip">Github</div>
                                    <span><i class="fab fa-github"></i></span>
                                </div>
                            </a>
                            <a href="https://www.linkedin.com/in/matt-spear-b2949064/" target=”_blank”>
                                <div class="icon linkedin">
                                    <div class="tooltip">LinkedIn</div>
                                    <span><i class="fab fa-linkedin-in"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script id="vs" type="x-shader/x-vertex">

    varying vec2 vUv;

    void main() {

        vUv = uv;
        gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );

    }

</script>
<script id="fs" type="x-shader/x-fragment">

    uniform sampler2D map;

    uniform vec3 fogColor;
    uniform float fogNear;
    uniform float fogFar;

    varying vec2 vUv;

    void main() {

        float depth = gl_FragCoord.z / gl_FragCoord.w;
        float fogFactor = smoothstep( fogNear, fogFar, depth );

        gl_FragColor = texture2D( map, vUv );
        gl_FragColor.w *= pow( gl_FragCoord.z, 20.0 );
        gl_FragColor = mix( gl_FragColor, vec4( fogColor, gl_FragColor.w ), fogFactor );

    }

</script>

<script>
    var header = document.getElementById('second-header');

    function fadeOutOnScroll(element) {
        if (!element) {
            return;
        }

        var distanceToTop = window.pageYOffset + element.getBoundingClientRect().top - 400;
        var elementHeight = element.offsetHeight;
        var scrollTop = document.documentElement.scrollTop;


        var opacity = 1;

        if (scrollTop > distanceToTop) {
            opacity = 1 - (scrollTop - distanceToTop) / elementHeight;
        }

        if (opacity >= 0) {
            element.style.opacity = opacity;
        }
    }

    function scrollHandler() {
        fadeOutOnScroll(header);
    }

    window.addEventListener('scroll', scrollHandler);
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.0.5/gsap.min.js"></script>

<script type="text/javascript" src="{{ asset('js/detector.js') }}"></script>
<script type="module" src="{{ asset('js/homepage.js') }}"></script>

</html>
