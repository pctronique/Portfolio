import * as THREE from "three";

import { FontLoader } from "./../../src/bin/three_js/examples/jsm/loaders/FontLoader.js";
import { TextGeometry } from "./../../src/bin/three_js/examples/jsm/geometries/TextGeometry.js";

function textTitle3D() {

	THREE.Cache.enabled = true;

	let container, stats, permalink, hex;

	let camera1, cameraTarget, scene1, renderer1;

	let group, textMesh1, textMesh2, textGeo, materials;

	let firstLetter = true;

	let text = document.getElementById("text_3d1").value.replace("\\n", "\n"),
	bevelEnabled = true,
	font = undefined,
	fontName = "optimer", // helvetiker, optimer, gentilis, droid sans, droid serif
	fontWeight = "bold"; // normal bold

	const height = 20,
	size = 70,
	hover = 30,
	curveSegments = 4,
	bevelThickness = 2,
	bevelSize = 1.5;

	const mirror = true;

	const fontMap = {
	helvetiker: 0,
	optimer: 1,
	gentilis: 2,
	"droid/droid_sans": 3,
	"droid/droid_serif": 4,
	};

	const weightMap = {
	regular: 0,
	bold: 1,
	};

	const reverseFontMap = [];
	const reverseWeightMap = [];

	for (const i in fontMap) reverseFontMap[fontMap[i]] = i;
	for (const i in weightMap) reverseWeightMap[weightMap[i]] = i;

	let targetRotation = 0;
	let targetRotationOnPointerDown = 0;

	let pointerX = 0;
	let pointerXOnPointerDown = 0;

	function sizeBox3D() {
	return {
		x: document.getElementById("text_3d").offsetWidth,
		y: document.getElementById("text_3d").offsetHeight * 3,
	};
	}
	
	let windowHalfX = sizeBox3D().x / 2;

	let fontIndex = 1;

	init();
	animate();

	function decimalToHex(d) {
	let hex = Number(d).toString(16);
	hex = "000000".substring(0, 6 - hex.length) + hex;
	return hex.toUpperCase();
	}

	function init() {
	container = document.getElementById("text_3d");

	// CAMERA
	camera1 = new THREE.PerspectiveCamera(30, 1, 1, 2500);
	camera1.position.set(0, 0, 1800);

	cameraTarget = new THREE.Vector3(0, -200, 0);

	// SCENE

	scene1 = new THREE.Scene();

	// LIGHTS

	const dirLight = new THREE.DirectionalLight(0xffffff, 0.125);
	dirLight.position.set(0, 0, 1).normalize();
	scene1.add(dirLight);

	const pointLight = new THREE.PointLight(0xffffff, 1.5);
	pointLight.position.set(0, 100, 90);
	scene1.add(pointLight);

	// Get text from hash

	const hash = document.location.hash.slice(1);
	hex = decimalToHex("FFFFFF");

	if (hash.length !== 0) {
		const colorhash = hash.substring(0, 6);
		const fonthash = hash.substring(6, 7);
		const weighthash = hash.substring(7, 8);
		const bevelhash = hash.substring(8, 9);
		const texthash = hash.substring(10);

		pointLight.color.setHex(parseInt(colorhash, 16));

		fontName = reverseFontMap[parseInt(fonthash)];
		fontWeight = reverseWeightMap[parseInt(weighthash)];

		bevelEnabled = parseInt(bevelhash);

		text = decodeURI(texthash);
	} else {
		//pointLight.color.setHSL(255, 1, 0.5 );
	}

	materials = [
		new THREE.MeshPhongMaterial({ color: 0xffffff, flatShading: true }), // front
		new THREE.MeshPhongMaterial({ color: 0xffffff }), // side
	];

	group = new THREE.Group();
	group.position.y = 100;

	scene1.add(group);

	loadFont();

	// RENDERER
	renderer1 = new THREE.WebGLRenderer({ alpha: true });
	renderer1.setPixelRatio(window.devicePixelRatio);
	renderer1.setSize(sizeBox3D().x, sizeBox3D().y);
	container.appendChild(renderer1.domElement);

	// EVENTS

	container.style.touchAction = "none";
	container.addEventListener("pointerdown", onPointerDown);

	/*document.addEventListener("keypress", onDocumentKeyPress);
	document.addEventListener("keydown", onDocumentKeyDown);*/

	hex = decimalToHex("FFFFFF");

	fontName = reverseFontMap[fontIndex % reverseFontMap.length];
	loadFont();

	fontWeight = "regular";

	//

	window.addEventListener("resize", onWindowResize);
	}

	function onWindowResize() {
	windowHalfX = sizeBox3D().x / 2;

	/*camera1.aspect = sizeBox3D().x / sizeBox3D().y;
	camera1.updateProjectionMatrix();*/

	renderer1.setSize(sizeBox3D().x, sizeBox3D().y);
	}

	//

	function boolToNum(b) {
	return b ? 1 : 0;
	}

	function onDocumentKeyDown(event) {
	if (firstLetter) {
		firstLetter = false;
		text = "";
	}

	const keyCode = event.keyCode;

	// backspace

	if (keyCode == 8) {
		event.preventDefault();

		text = text.substring(0, text.length - 1);
		refreshText();

		return false;
	}
	}

	function onDocumentKeyPress(event) {
	const keyCode = event.which;

	// backspace

	if (keyCode == 8) {
		event.preventDefault();
	} else {
		const ch = String.fromCharCode(keyCode);
		text += ch;

		refreshText();
	}
	}

	function loadFont() {
	const loader = new FontLoader();
	loader.load(
		"src/bin/three_js/examples/fonts/" +
		fontName +
		"_" +
		fontWeight +
		".typeface.json",
		function (response) {
		font = response;

		refreshText();
		}
	);
	}

	function createText() {
	textGeo = new TextGeometry(text, {
		font: font,

		size: size,
		height: height,
		curveSegments: curveSegments,

		bevelThickness: bevelThickness,
		bevelSize: bevelSize,
		bevelEnabled: bevelEnabled,
	});

	textGeo.computeBoundingBox();

	const centerOffset =
		-0.5 * (textGeo.boundingBox.max.x - textGeo.boundingBox.min.x);

	textMesh1 = new THREE.Mesh(textGeo, materials);

	textMesh1.position.x = centerOffset;
	textMesh1.position.y = hover;
	textMesh1.position.z = 0;

	textMesh1.rotation.x = 0;
	textMesh1.rotation.y = Math.PI * 2;

	group.add(textMesh1);
	}

	function refreshText() {
	group.remove(textMesh1);
	//if ( mirror ) group.remove( textMesh2 );

	if (!text) return;

	createText();
	}

	function onPointerDown(event) {
	if (event.isPrimary === false) return;

	pointerXOnPointerDown = event.clientX - windowHalfX;
	targetRotationOnPointerDown = targetRotation;

	document.addEventListener("pointermove", onPointerMove);
	document.addEventListener("pointerup", onPointerUp);
	}

	function onPointerMove(event) {
	if (event.isPrimary === false) return;

	pointerX = event.clientX - windowHalfX;

	targetRotation =
		targetRotationOnPointerDown + (pointerX - pointerXOnPointerDown) * 0.02;
	}

	function onPointerUp(event) {
	if (event.isPrimary === false) return;

	document.removeEventListener("pointermove", onPointerMove);
	document.removeEventListener("pointerup", onPointerUp);
	}

	//

	function animate() {
	requestAnimationFrame(animate);

	render();
	}

	function render() {
	group.rotation.y += (targetRotation - group.rotation.y) * 0.05;

	camera1.lookAt(cameraTarget);

	renderer1.clear();
	renderer1.render(scene1, camera1);
	}

}

textTitle3D();
