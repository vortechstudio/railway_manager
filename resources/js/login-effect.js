import * as THREE from 'three';
import {OrbitControls} from 'three/addons/controls/OrbitControls.js';
import {GLTFLoader} from 'three/addons/loaders/GLTFLoader.js';

let scene = new THREE.Scene();
let camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.z = 5;

let renderer = new THREE.WebGLRenderer({alpha: true});
renderer.setSize(window.innerWidth, window.innerHeight);
document.getElementById('smoke-effect').appendChild(renderer.domElement);

let particles = 100;
let smokeTexture = new THREE.TextureLoader().load('/images/smoke_1.png')
let smokeGeometry = new THREE.PlaneGeometry(300,300);
let smokeMaterial = new THREE.MeshLambertMaterial({
    map: smokeTexture,
    opacity: 0.7,

});
let smokeParticles = [];

for (let p = 0; p < particles; p++) {
    let particle = new THREE.Mesh(smokeGeometry, smokeMaterial);
    particle.position.set(Math.random() - 0.5, Math.random() - 0.5, Math.random() - 0.5);
    scene.add(particle)
    smokeParticles.push(particle);
}

function animate() {
    requestAnimationFrame(animate);
    smokeParticles.forEach(particle => {
        particle.rotation.z -= 0.006;
    });
    renderer.render(scene, camera);
}
animate();
