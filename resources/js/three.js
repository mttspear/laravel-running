import * as THREE from "three";
const TWEEN = require("@tweenjs/tween.js"); ///home/matt/Development/public_html/example-app/node_modules/three/examples/jsm/libs/tween.module.min.js
//Declare three.js variables
var camera,
    scene,
    renderer,
    mesh,
    randomX,
    randomY,
    tween,
    container,
    stars = [];

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