<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        /*#space {
            overflow: hidden;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }*/

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

        }

        .middle {
            background: linear-gradient(to bottom, #000 0%, #3e99d1 92%, #fff 100%);
            position: absolute;
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
            min-height: 100vh;
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

    </style>
</head>

<body class="homepage">
    <div>
        <div id="main">
            <section class="star-section">
                <div class="container star-container">
                    <div class="row">
                        <div class="col-xs-12">
                            <p>hello top of page</p>
                        </div>
                    </div>
                </div>
                <div id="space"></div>

            </section>
            <section class="transition-section">
                <div class="container">
                    <div class="row">
                        <h2>hello middle</h2>
                    </div>
                </div>

                <div id="clouds" class="container-row"></div>


            </section>

            <div class="container" id="white-div">
                <div class="row">
                    <div class="col-xs-12 text-center"></div>
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



<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.0.5/gsap.min.js"></script>
<script type="text/javascript" src="{{ asset('js/detector.js') }}"></script>
<script type="module" src="{{ asset('js/homepage.js') }}"></script>

</html>
