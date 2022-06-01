let body_matrix = document.getElementById("body_matrix");
let ctx = body_matrix.getContext("2d");
let myInterval = undefined;

function matrix() {
	//making the canvas full screen
	body_matrix.height = screen.height;
	body_matrix.width = screen.width;

	if(body_matrix.width < 320) {
		body_matrix.width=320;
	}

	//txt_matrix characters - taken from the unicode charset
	var txt_matrix = "001010100010100101000010001111110001010011110001101";
	//converting the string into an array of single characters
	txt_matrix = txt_matrix.split("");

	var font_size = 10;
	var columns = body_matrix.width/font_size; //number of columns for the rain
	//an array of drops - one per column
	var drops = [];
	//x below is the x coordinate
	//1 = y co-ordinate of the drop(same for every drop initially)
	for(var x = 0; x < columns; x++)
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
		for(var i = 0; i < drops.length; i++)
		{
			//a random txt_matrix character to print
			var text = txt_matrix[Math.floor(Math.random()*txt_matrix.length)];
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

window.addEventListener('resize', function() {
	clearInterval(myInterval);
	matrix();
});
