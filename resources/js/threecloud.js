//import * as THREE from "three";

import * as BufferGeometryUtils from "three/examples/jsm/utils/BufferGeometryUtils.js";
import * as THREE from "three";

import Stats from "three/examples/jsm/libs/stats.module.js";

import { FirstPersonControls } from "three/examples/jsm/controls/FirstPersonControls.js";

import { GUI } from "three/examples/jsm/libs/dat.gui.module.js";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";
import { Water } from "three/examples/jsm/objects/Water.js";
import { add } from "lodash";

if (!Detector.webgl) Detector.addGetWebGLMessage();

var container;
var camera, scene, renderer;
var mesh, geometry, material;

var mouseX = 0,
    mouseY = 0;
var start_time = Date.now();

var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;

//init();

function init() {
    container = document.createElement("div");
    document.body.appendChild(container);

    // Bg gradient

    var canvas = document.createElement("canvas");
    canvas.width = 32;
    canvas.height = window.innerHeight;

    var context = canvas.getContext("2d");

    var gradient = context.createLinearGradient(0, 0, 0, canvas.height);
    gradient.addColorStop(0, "#1e4877");
    gradient.addColorStop(0.5, "#4584b4");

    context.fillStyle = gradient;
    context.fillRect(0, 0, canvas.width, canvas.height);

    container.style.background = "url(" + canvas.toDataURL("image/png") + ")";
    container.style.backgroundSize = "32px 100%";

    var loader = new THREE.TextureLoader();
    var backgroundTexture = loader.load("https://i.imgur.com/upWSJlY.jpg");

    //

    camera = new THREE.PerspectiveCamera(
        30,
        window.innerWidth / window.innerHeight,
        1,
        3000
    );
    camera.position.z = 6000;

    scene = new THREE.Scene();
    scene.background = backgroundTexture;

    geometry = new THREE.BufferGeometry();

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

    var plane = new THREE.Mesh(new THREE.PlaneGeometry(64, 64));

    //TEST BELOW

    var clouds = [];
    var planeBuffer = new THREE.PlaneBufferGeometry(25, 25, 25);

    var geo = new THREE.PlaneBufferGeometry(25, 25, 25);

    for (var i = 0; i < 1000; i++) {
        // instead of creating a new geometry, we just clone the bufferGeometry instance
        var geometry = geo.clone();
        geometry.applyMatrix4(
            new THREE.Matrix4().makeTranslation(
                Math.random() * 1000 - 500,
                Math.random() * 1000 - 500,
                0
            )
        );
        geometry.rotateX(Math.random() * 1);
        geometry.rotateY(Math.random() * 1);
        // then, we push this bufferGeometry instance in our array
        clouds.push(geometry);
    }
    // Here is the big boy in action
    var geometriesCubes = BufferGeometryUtils.mergeBufferGeometries(clouds);

    // now we got 1 mega big mesh with 10 000 cubes in it
    var mesh = new THREE.Mesh(geometriesCubes, material);
    scene.add(mesh);

    //TEST UP

    for (var i = 0; i < 8000; i++) {
        plane.position.x = Math.random() * 1000 - 500;
        plane.position.y = -Math.random() * Math.random() * 200 - 15;
        plane.position.z = i;
        plane.rotation.z = Math.random() * Math.PI;
        plane.scale.x = plane.scale.y =
            Math.random() * Math.random() * 1.5 + 0.5;

        //BufferGeometryUtils.mergeBufferGeometries(geometry, plane);
    }

    mesh = new THREE.Mesh(geometry, material);
    scene.add(mesh);

    mesh = new THREE.Mesh(geometry, material);
    mesh.position.z = -8000;
    scene.add(mesh);

    renderer = new THREE.WebGLRenderer({ antialias: false });
    renderer.setSize(window.innerWidth, window.innerHeight);
    //document.body.appendChild(renderer.domElement);
    container.appendChild(renderer.domElement);

    /*
    document.addEventListener("mousemove", onDocumentMouseMove, false);
    window.addEventListener("resize", onWindowResize, false);
    */
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

function animate() {
    requestAnimationFrame(animate);

    var position = ((Date.now() - start_time) * 0.00003) % 8000;

    //camera.position.x += (mouseX - camera.position.x) * 0.01;
    //camera.position.y += (-mouseY - camera.position.y) * 0.01;
    //camera.position.z = -position + 0.01;

    renderer.render(scene, camera);
}

init();

var cubes = [];

function addCube() {
    var geo = new THREE.PlaneBufferGeometry(25, 25, 25);

    for (var i = 0; i < 1000; i++) {
        // instead of creating a new geometry, we just clone the bufferGeometry instance
        var geometry = geo.clone();
        geometry.applyMatrix4(
            new THREE.Matrix4().makeTranslation(
                Math.random() * 1000 - 500,
                Math.random() * 1000 - 500,
                0
            )
        );
        geometry.rotateX(Math.random() * 1);
        geometry.rotateY(Math.random() * 1);
        // then, we push this bufferGeometry instance in our array
        cubes.push(geometry);
    }
    // Here is the big boy in action
    var geometriesCubes = BufferGeometryUtils.mergeBufferGeometries(cubes);

    // now we got 1 mega big mesh with 10 000 cubes in it
    var mesh = new THREE.Mesh(geometriesCubes, new THREE.MeshNormalMaterial());
    scene.add(mesh);
}

var geometry = new THREE.BoxGeometry(10, 10, 10);

var texture = new THREE.TextureLoader("img/cloud10.png", null, animate);
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

const uniforms = {
    time: { value: 1.0 },
};

const materialz = new THREE.ShaderMaterial({
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
    //transparent: true,
});

var cube = new THREE.Mesh(geometry, materialz);
//scene.add(cube);

const geometryPlane = new THREE.PlaneGeometry(1, 1);
const materialPlane = new THREE.MeshBasicMaterial({
    color: 0xffff00,
    side: THREE.DoubleSide,
});
const plane = new THREE.Mesh(geometryPlane, materialPlane);
//scene.add(plane);

camera.position.z = 100;
//addCube();
animate();
