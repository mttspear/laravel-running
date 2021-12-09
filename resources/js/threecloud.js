import * as BufferGeometryUtils from "three/examples/jsm/utils/BufferGeometryUtils.js";
import * as THREE from "three";

if (!Detector.webgl) Detector.addGetWebGLMessage();

var container;
var camera, scene, renderer;
var material;

var mouseX = 0,
    mouseY = 0;
var start_time = Date.now();

var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;

//init();

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
    //initCloud();
    //animateCloud();
});