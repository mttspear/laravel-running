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
        /*

        #main {
            width: 100%;
        }

        .star-section {
            height: 100vh;
            position: relative;
            overflow: hidden;
            color: whitesmoke;
            z-index: 100;

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
        }

        #transition {
            min-height: 50vh;
            color: whitesmoke;
            padding-top: 100px;
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
        
*/
        #white-div {
            min-height: 20%;
        }


        #clouds:after {
            position: absolute;
            bottom: 0;
            left: 0;
            /*width: 100%; */
            height: 100px;
            content: '';
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, .82) 50%, white 100%);
        }

        .bottom-content {
            /*padding: 40vh 0 122px;*/
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

    </style>
</head>

<body class="homepage">
    <div>
        <div id="main">
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
                        <div class="second-header align-self-end text-end">
                            <h2>App Development. Web Development. Python Analysis and Scripting</h2>
                        </div>


                    </div>


                </div>
                <div id="space"></div>

            </section>
            <section class="transition-section">
                <div class="container">
                    <div class="row text-center">
                        <h2>Hand crafted digital solutions for your buisness needs</h2>
                        <p>Experts in Laravel, SQL, </p>
                    </div>
                </div>
                <div id="clouds" class="container-row"></div>
            </section>

            <div class="container" id="white-div">
                <div class="row bottom-content">
                    <div class="col-xs-12 text-center">
                        <p>And the sky is the limits</p>
                    </div>

                </div>
                <ul class="list">
                    <li class="list-item one">https://github.com/mttspear</li>
                    <li class="list-item two">https://www.upwork.com/freelancers/~01d673de10ec509b4a</li>
                    <li class="list-item three">https://www.linkedin.com/in/matt-spear-b2949064/</li>
                    <li class="list-item four">Laravel Sample link</li>
                    <li class="list-item four">Running Analysis</li>
                    <li class="list-item four">Resin Projects</li>
                </ul>

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



<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.0.5/gsap.min.js"></script>
<script type="text/javascript" src="{{ asset('js/detector.js') }}"></script>
<script type="module" src="{{ asset('js/homepage.js') }}"></script>

</html>
