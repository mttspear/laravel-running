import * as THREE from "three";
const TWEEN = require("@tweenjs/tween.js"); ///home/matt/Development/public_html/example-app/node_modules/three/examples/jsm/libs/tween.module.min.js
import * as BufferGeometryUtils from "three/examples/jsm/utils/BufferGeometryUtils.js";
//Declare three.js variables
var camera,
    scene,
    renderer,
    mesh,
    randomX,
    randomY,
    tween,
    container,
    material,
    stars = [];
var start_time = Date.now();
var mouseX = 0,
    mouseY = 0;

var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;

//assign three.js objects to each variable
function init() {
    //container = document.getElementById("space");
    //document.body.appendChild(container);

    randomY = Math.random() * 6 - 5;
    randomX = Math.random() * 6 - 5;
    //camera
    camera = new THREE.PerspectiveCamera(
        45,
        window.innerWidth / window.innerHeight,
        1,
        1000
    );
    camera.position.z = 5;

    //scene
    scene = new THREE.Scene();

    var loader = new THREE.TextureLoader();
    var material = new THREE.MeshLambertMaterial({
        map: loader.load("img/cat.jpg"),
    });

    // create a plane geometry for the image with a width of 10
    // and a height that preserves the image's aspect ratio
    var pic = new THREE.PlaneGeometry(2, 3 * 0.75);

    // combine our image geometry and material into a mesh
    mesh = new THREE.Mesh(pic, material);

    // set the position of the image mesh in the x,y,z dimensions
    mesh.position.set(0, 0, 0);

    // add the image to the scene
    scene.add(mesh);
    console.log(randomX);
    //tween = new TWEEN.Tween(mesh.position);
    //tween.to({ x: randomX, y: randomY }, 1);
    //tween.start();
    //TWEEN.update();
    //tween.onUpdate(function(object) {
    //    console.log(object.x);
    //});

    // Add a point light with #fff color, .7 intensity, and 0 distance
    var light = new THREE.PointLight(0xffffff, 1, 0);

    // Specify the light's position
    light.position.set(1, 1, 100);

    // Add the light to the scene
    scene.add(light);

    //renderer
    renderer = new THREE.WebGLRenderer();
    //set the size of the renderer
    renderer.setSize(window.innerWidth, window.innerHeight);

    //add the renderer to the html document body
    renderer.domElement.id = 'spaceCanvas';
    container = document.getElementById("space");
    container.appendChild(renderer.domElement);
}

function addSphere() {
    // The loop will move from z position of -1000 to z position 1000, adding a random particle at each position.
    for (var z = -3000; z < -500; z += 3) {
        // Make a sphere (exactly the same as before).
        var geometry = new THREE.SphereGeometry(0.5, 32, 32);
        var material = new THREE.MeshBasicMaterial({ color: 0xffffff });
        var sphere = new THREE.Mesh(geometry, material);

        // This time we give the sphere random x and y positions between -500 and 500
        sphere.position.x = Math.random() * 1000 - 500;
        sphere.position.y = Math.random() * 1000 - 500;

        // Then set the z position to where it is in the loop (distance of camera)
        ///sphere.position.z = Math.random() * 1000 - 500;
        sphere.position.z = z;
        //console.log(sphere.position.z);

        // scale it up a bit
        sphere.scale.x = sphere.scale.y = 2;

        //add the sphere to the scene
        scene.add(sphere);

        //finally push it to the stars array
        stars.push(sphere);
    }
}

function animateStars() {
    // loop through each star
    for (var i = 0; i < stars.length; i++) {
        let star = stars[i];
        // and move it forward dependent on the mouseY position.
        star.position.y += i / 1000;
        // if the particle is too close move it to the back
        if (star.position.y > 500) star.position.y = -500;
    }
}

function animateImage() {

    // just use tweens.
    //gsap.to(mesh.position, {x: Math.floor((Math.random() * 600) - 300), duration: 5, ease: "elastic"});
    //gsap.to(mesh.position, {y: Math.floor((Math.random() * 600) - 300), duration: 5, ease: "elastic"});
    //gsap.to(mesh.position, {z: Math.floor((Math.random() * 600) - 300), duration: 5, ease: "elastic"});

    // use a timeline (and call this function again on complete).
    // This uses GSAP V3
    var timeline = gsap.timeline({ onComplete: animateImage });

    // animate mesh.position.x,
    // a random number between -300 and 300,
    // for 2 seconds.
    /*
    timeline.to(
        mesh.position, { x: Math.floor((Math.random() * 10) - 5), duration: 10, ease: "Quintic.InOut" },
        0
    );*/
    var speed = 150;

    var xTo = Math.floor((Math.random() * 10) - 5);
    var yTo = Math.floor((Math.random() * 6) - 3);
    var zTo = Math.floor((Math.random() * 18) - 14);

    var toVector = new THREE.Vector3(xTo, yTo, zTo);
    var distance = toVector.distanceTo(mesh.position);
    var duration = (distance / speed) * 1000; // in milliseconds

    timeline.to(
        mesh.position, {
            x: xTo,
            y: yTo,
            z: zTo,
            duration: duration,
            ease: "Easing.Linear"
        },
        0
    );
}


function render() {
    //get the frame
    requestAnimationFrame(render);
    animateStars();
    //render the scene
    renderer.render(scene, camera);
}



//window.onload = function() {
init();
addSphere();
render();
animateImage();
//}

function initCloud() {
    //container = document.createElement("div");
    //document.body.appendChild(container);

    container = document.getElementById("clouds");


    var loader = new THREE.TextureLoader();
    var backgroundTexture = loader.load("img/sky2.jpg");

    // Bg gradient

    var canvas = document.createElement('canvas');
    canvas.width = 32;
    canvas.height = window.innerHeight;

    var context = canvas.getContext('2d');

    var gradient = context.createLinearGradient(0, 0, 0, canvas.height);
    //gradient.addColorStop(0, "#1e4877");
    //gradient.addColorStop(0.5, "#4584b4");

    context.fillStyle = gradient;
    context.fillRect(0, 0, canvas.width, canvas.height);

    container.style.background = 'url(' + canvas.toDataURL('image/png') + ')';
    container.style.backgroundSize = '32px 100%';

    //

    camera = new THREE.PerspectiveCamera(
        50,
        window.innerWidth / window.innerHeight,
        1,
        3000
    );
    camera.position.z = 6000;

    scene = new THREE.Scene();
    //scene.background = backgroundTexture;

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
        // instead of creating a new geometry, we just clone the bufferGeometry instance
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
    // Here is the big boy in action
    var geometriesCubes = BufferGeometryUtils.mergeBufferGeometries(clouds);

    // now we got 1 mega big mesh with 10 000 cubes in it
    var mesh = new THREE.Mesh(geometriesCubes, material);
    scene.add(mesh);

    mesh = new THREE.Mesh(geometry, material);
    mesh.position.z = -8000;
    scene.add(mesh);

    renderer = new THREE.WebGLRenderer({ antialias: false, alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    //document.body.appendChild(renderer.domElement);
    renderer.domElement.id = 'cloudCanvas';

    container.appendChild(renderer.domElement);

    document.addEventListener("mousemove", onDocumentMouseMove, false);
    window.addEventListener("resize", onWindowResize, false);
}

function onDocumentMouseMove(event) {
    mouseX = (event.clientX - windowHalfX) * 0.25;
    mouseY = (event.clientY - windowHalfY) * 0.15;
}

function onWindowResize(event) {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();

    renderer.setSize(window.innerWidth, window.innerHeight);
}

function animateCloud() {
    requestAnimationFrame(animateCloud);
    var position = ((Date.now() - start_time) * 0.03) % 8000;

    camera.position.x += (mouseX - camera.position.x) * 0.01;
    camera.position.y += (-mouseY - camera.position.y) * 0.01;
    camera.position.z = -position + 8000;

    renderer.render(scene, camera);
}
window.onload = function() {

}

window.addEventListener('load', function() {
    initCloud();
    animateCloud();
});