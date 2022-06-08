// A partir du code : https://codepen.io/P3R0/pen/MwgoKv

let body_matrix = document.getElementById("body_matrix");
let ctx = body_matrix.getContext("2d");
let myInterval = undefined;

let choice_display = 0;

let choice_background = getCookie("choice_background");

if(choice_background != undefined) {
	choice_display = parseInt(choice_background);
}

let tabNamesCode = [
	"BINARY",
	"HEXADECIMAL",
	"ASCII"
];

function ascii_to_hexa(str){
	let arr1 = [];
	let start = "";
	for (let n = 0, l = str.length; n < l; n ++) 
     {
		let hex = Number(str.charCodeAt(n)).toString(16);
		for(let a = hex.length; a < 2; a++) {
			start += "0";
		}
		arr1.push(start+hex.toUpperCase());
	 }
	return arr1.join('');
}

function ascii_to_bin(str){
	let arr1 = [];
	let start = "";
	for (let n = 0, l = str.length; n < l; n ++) 
     {
		let hex = Number(str.charCodeAt(n)).toString(2);
		for(let a = hex.length; a < 8; a++) {
			start += "0";
		}
		arr1.push(start+hex);
	 }
	return arr1.join('');
}

let text_display = [];

function tabTxtMatrix(txt) {
	text_display = [
		ascii_to_bin(txt),
		ascii_to_hexa(txt),
		txt
	];
}

tabTxtMatrix("PCTRONIQUE");

if(document.querySelector("#txt_matrix") != undefined) {
	tabTxtMatrix(document.getElementById("txt_matrix").innerText);
}

function matrix() {
	let header_main = document.getElementById('header-main').offsetHeight;
	let footer_main = document.getElementById('footer-main');
	let contenu_main = document.getElementById('contenu-main');
	//making the canvas full screen
	body_matrix.height = contenu_main.offsetHeight;
	body_matrix.width = window.innerWidth;
	let windowHeight = window.innerHeight-footer_main.offsetHeight;
	if(screen.height < window.innerHeight) {
		windowHeight = screen.height-footer_main.offsetHeight;
	}
	if(contenu_main.offsetHeight < windowHeight) {
		body_matrix.height = windowHeight;
	}
	if(screen.width < window.innerWidth) {
		body_matrix.width = screen.width;
	}

	/*document.querySelectorAll(".contenu_main").forEach(element => {
		element.height = body_matrix.height+"px";
		element.width = body_matrix.width+"px";
	});*/

	// si l'ecran est trop petit, mettre a une taille fixe
	if(body_matrix.width < 320) {
		body_matrix.width=320;
	}

	//txt_matrix characters - taken from the unicode charset
	let txt_matrix = text_display[choice_display];
	//let txt_matrix = "4E41554C4F54204C75646F766963";
	if(txt_matrix == undefined) {
		choice_display = 0;
		txt_matrix = text_display[choice_display];
	}
	//converting the string into an array of single characters
	txt_matrix = txt_matrix.split("");

	let font_size = 10;
	let columns = body_matrix.width/font_size; //number of columns for the rain
	//an array of drops - one per column
	let drops = [];
	//x below is the x coordinate
	//1 = y co-ordinate of the drop(same for every drop initially)
	for(let x = 0; x < columns; x++)
		drops[x] = 1; 

	//drawing the characters
	function draw()
	{
		//Black BG for the canvas
		//translucent BG to show trail
		ctx.fillStyle = "rgba(0, 0, 0, 0.05)";
		ctx.fillRect(0, 0, body_matrix.width, body_matrix.height);
		
		ctx.fillStyle = "#0F0"; //green text
		ctx.font = font_size + "px arial";
		//looping over drops
		for(let i = 0; i < drops.length; i++)
		{
			//a random txt_matrix character to print
			let text = txt_matrix[Math.floor(Math.random()*txt_matrix.length)];
			//x = i*font_size, y = value of drops[i]*font_size
			ctx.fillText(text, i*font_size, drops[i]*font_size);
			
			//sending the drop back to the top randomly after it has crossed the screen
			//adding a randomness to the reset to make the drops scattered on the Y axis
			if(drops[i]*font_size > body_matrix.height && Math.random() > 0.975)
				drops[i] = 0;
			
			//incrementing Y coordinate
			drops[i]++;
		}
	}

	myInterval = setInterval(draw, 33);
}

matrix();

function modifBackground() {
	choice_display++;
	if(text_display.length <= choice_display) {
		choice_display=0;
	}
	clearInterval(myInterval);
	matrix();
}

/*document.querySelectorAll("section").forEach(element => {
	element.addEventListener("click", function() {
		modifBackground();
	});
});*/

document.querySelectorAll("#choix-background").forEach(element => {
	element.innerText = tabNamesCode[choice_display];
	element.addEventListener("click", function() {
		modifBackground();
		setCookie("choice_background",choice_display);
		element.innerText = tabNamesCode[choice_display];
	});
});

/*body_matrix.addEventListener("click", function() {
	modifBackground();
});*/

window.addEventListener('resize', function() {
	clearInterval(myInterval);
	matrix();
});
