function setup() {
	createCanvas(windowWidth, windowHeight);
	background(204,204,204)
	
}

	function draw() {
	if (mouseButton == LEFT){
		ellipse(mouseX, mouseY, 40, 40);
	}
	if(mouseButton == RIGHT){
		ellipse(mouseX,mouseY, 50,50);
		
	}
	if(mouseButton == CENTER){
		noLoop()
	}
	
 }