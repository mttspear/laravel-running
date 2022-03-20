import * as THREE from "three";
const TWEEN = require("@tweenjs/tween.js"); ///home/matt/Development/public_html/example-app/node_modules/three/examples/jsm/libs/tween.module.min.js
import * as BufferGeometryUtils from "three/examples/jsm/utils/BufferGeometryUtils.js";
//Declare three.js variables
var cloudCamera,
    spaceCamera,
    spaceScene,
    cloudScene,
    spaceRenderer,
    cloudRenderer,
    spaceMesh,
    randomX,
    randomY,
    tween,
    spaceContainer,
    cloudContainer,
    material,
    stars = [];

var start_time = Date.now();
var mouseX = 0,
    mouseY = 0;

var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;

//assign three.js objects to each variable
function initSpace() {
    randomY = Math.random() * 6 - 5;
    randomX = Math.random() * 6 - 5;
    //camera
    spaceCamera = new THREE.PerspectiveCamera(
        45,
        window.innerWidth / window.innerHeight,
        1,
        1000
    );
    spaceCamera.position.z = 5;

    //scene
    spaceScene = new THREE.Scene();

    var loader = new THREE.TextureLoader();
    var material = new THREE.MeshLambertMaterial({
        map: loader.load("img/cat.jpg"),
    });

    // create a plane geometry for the image with a width of 10
    // and a height that preserves the image's aspect ratio
    var pic = new THREE.PlaneGeometry(2, 3 * 0.75);

    // combine our image geometry and material into a mesh
    spaceMesh = new THREE.Mesh(pic, material);

    // set the position of the image mesh in the x,y,z dimensions
    spaceMesh.position.set(0, 0, 0);

    // add the image to the scene
    spaceScene.add(spaceMesh);

    var light = new THREE.PointLight(0xffffff, 1, 0);

    // Specify the light's position
    light.position.set(1, 1, 100);

    // Add the light to the scene
    spaceScene.add(light);

    //renderer
    spaceRenderer = new THREE.WebGLRenderer();
    //set the size of the renderer
    spaceRenderer.setSize(window.innerWidth, window.innerHeight);

    //add the renderer to the html document body
    spaceRenderer.domElement.id = "spaceCanvas";
    spaceContainer = document.getElementById("space");
    spaceContainer.appendChild(spaceRenderer.domElement);
}

function addSphere() {
    for (var z = -3000; z < -500; z += 2) {
        var geometry = new THREE.SphereGeometry(0.5, 32, 32);
        var material = new THREE.MeshBasicMaterial({ color: 0xffffff });
        var sphere = new THREE.Mesh(geometry, material);

        // This time we give the sphere random x and y positions between -500 and 500
        sphere.position.x = Math.random() * 2000 - 1000;
        sphere.position.y = Math.random() * 1000 - 500;
        sphere.position.z = z;

        sphere.scale.x = sphere.scale.y = 2;

        spaceScene.add(sphere);

        stars.push(sphere);
    }
}

function animateStars() {
    for (var i = 0; i < stars.length; i++) {
        let star = stars[i];
        star.position.y += i / 3000; // this controlls the fall speed
        if (star.position.y > 500) star.position.y = -500;
    }
}

function animateImage() {
    var timeline = gsap.timeline({ onComplete: animateImage });
    var speed = 400;
    var xTo = Math.floor(Math.random() * 10 - 5);
    var yTo = Math.floor(Math.random() * 4 - 0); //4 is max 0 is min
    var zTo = Math.floor(Math.random() * 18 - 14);
    var toVector = new THREE.Vector3(xTo, yTo, zTo);
    var distance = toVector.distanceTo(spaceMesh.position);
    var duration = (distance / speed) * 1000; // in milliseconds

    timeline.to(
        spaceMesh.position, {
            x: xTo,
            y: yTo,
            z: zTo,
            duration: duration,
            ease: "Circular",
        },
        0
    );
}

function renderSpace() {
    //get the frame
    requestAnimationFrame(renderSpace);
    animateStars();
    //render the scene
    spaceRenderer.render(spaceScene, spaceCamera);
}

function initCloud() {
    cloudContainer = document.getElementById("clouds");

    var loader = new THREE.TextureLoader();
    var backgroundTexture = loader.load("img/sky2.jpg");

    // Bg gradient

    var canvas = document.createElement("canvas");
    canvas.width = 32;
    canvas.height = window.innerHeight;

    var context = canvas.getContext("2d");

    var gradient = context.createLinearGradient(0, 0, 0, canvas.height);

    context.fillStyle = gradient;
    context.fillRect(0, 0, canvas.width, canvas.height);

    cloudContainer.style.background =
        "url(" + canvas.toDataURL("image/png") + ")";
    cloudContainer.style.backgroundSize = "32px 100%";

    cloudCamera = new THREE.PerspectiveCamera(
        50,
        window.innerWidth / window.innerHeight,
        1,
        3000
    );
    cloudCamera.position.z = 6000;
    cloudCamera.position.y = 50;

    cloudScene = new THREE.Scene();

    var texture = new THREE.TextureLoader().load("img/cloud10.png");
    texture.magFilter = THREE.LinearMipMapLinearFilter;
    texture.minFilter = THREE.LinearMipMapLinearFilter;

    var fog = new THREE.Fog(0x4584b4, -100, 3000);

    material = new THREE.ShaderMaterial({
        uniforms: {
            map: { type: "t", value: texture },
            fogColor: { type: "c", value: fog.color },
            fogNear: { type: "f", value: fog.near },
            fogFar: { type: "f", value: fog.far },
        },
        vertexShader: document.getElementById("vs").textContent,
        fragmentShader: document.getElementById("fs").textContent,
        depthWrite: false,
        depthTest: false,
        transparent: true,
    });

    var clouds = [];
    var geo = new THREE.PlaneBufferGeometry(64, 64);

    for (var i = 0; i < 8000; i++) {
        // instead of creating a new geometry clone the bufferGeometry instance
        var geometry = geo.clone();
        geometry.rotateZ(Math.random() * Math.PI);
        geometry.applyMatrix4(
            new THREE.Matrix4().makeTranslation(
                Math.random() * 1000 - 500, -Math.random() * Math.random() * 200 - 15,
                i
            )
        );

        var scale = Math.random() * Math.random() * 1.5 + 0.5;

        geometry.applyMatrix4(new THREE.Matrix4().makeScale(scale, scale, 1));

        clouds.push(geometry);
    }
    var geometriesCubes = BufferGeometryUtils.mergeBufferGeometries(clouds);

    var mesh = new THREE.Mesh(geometriesCubes, material);
    cloudScene.add(mesh);

    mesh = new THREE.Mesh(geometry, material);
    mesh.position.z = -8000;
    cloudScene.add(mesh);

    cloudRenderer = new THREE.WebGLRenderer({ antialias: false, alpha: true });
    cloudRenderer.setSize(
        document.documentElement.clientWidth,
        window.innerHeight
    );
    cloudRenderer.domElement.id = "cloudCanvas";

    cloudContainer.appendChild(cloudRenderer.domElement);

    document.addEventListener("mousemove", onDocumentMouseMove, false);
    window.addEventListener("resize", onWindowResize, false);
}

function onDocumentMouseMove(event) {
    mouseX = (event.clientX - windowHalfX) * 0.05;
    mouseY = (event.clientY - windowHalfY) * 0.005;
}

function onWindowResize(event) {
    cloudCamera.aspect = window.innerWidth / window.innerHeight;
    cloudCamera.updateProjectionMatrix();

    cloudRenderer.setSize(window.innerWidth, window.innerHeight);
}

function animateCloud() {
    requestAnimationFrame(animateCloud);
    var position = ((Date.now() - start_time) * 0.03) % 8000;

    cloudCamera.position.x += (mouseX - cloudCamera.position.x) * 0.01;
    cloudCamera.position.y += (-mouseY - cloudCamera.position.y) * 0.0025;
    cloudCamera.position.z = -position + 8000;

    cloudRenderer.render(cloudScene, cloudCamera);
}

window.addEventListener("load", function() {
    initSpace();
    initCloud();

    animateCloud();

    addSphere();
    renderSpace();
    animateImage();
});