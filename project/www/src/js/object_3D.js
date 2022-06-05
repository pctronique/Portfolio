let rotationForceObject3D = 2;

function posObject3D() {
    return {
        x: 0,
        y: 0
    }
}

function dimBox3D(itemMain) {
    return {
        width: itemMain.querySelector(".box-3D-front").offsetWidth,
        height: itemMain.querySelector(".box-3D-front").offsetHeight
    }
}

let mouseObject3D = posObject3D();

let positionObject3D = posObject3D();

let mouseStartObject3D = posObject3D();

let targetObject = undefined;

function object_move(e) {
    if(targetObject !== undefined) {
        let diffPosObject3D = posObject3D();
        diffPosObject3D.x = mouseObject3D.x-mouseStartObject3D.x;
        diffPosObject3D.y = mouseObject3D.y-mouseStartObject3D.y;
        
        positionObject3D.y += (diffPosObject3D.x*rotationForceObject3D);
        positionObject3D.x -= (diffPosObject3D.y*rotationForceObject3D);

        mouseStartObject3D.x = mouseObject3D.x;
        mouseStartObject3D.y = mouseObject3D.y;
        
        targetObject.querySelector(".object-3D").style.transform = 'rotateX(' + positionObject3D.x + 'deg) rotateY(' + positionObject3D.y + 'deg)';
    }
}

let depth3D = 60;
let radius3D = 20; // ne pas modifier
let heightRadius3D = 5;

function frontBox3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.width = width+"px";
    item.style.height = height+"px";
    item.style.borderRadius = radius3D+"px";
    item.style.transform = "translateZ("+(depth3D/2)+"px)";
}

function backBox3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.width = width+"px";
    item.style.height = height+"px";
    item.style.borderRadius = radius3D+"px";
    item.style.transform = "translateZ(-"+(depth3D/2)+"px)";
}

function topBox3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.marginLeft = radius3D+"px";
    item.style.width = (width-(radius3D*2))+"px";
    item.style.height = depth3D+"px";
    item.style.transform = "rotateX(-90deg) translateZ(-"+(depth3D/2)+"px)";
}

function bottomBox3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.marginLeft = radius3D+"px";
    item.style.width = (width-(radius3D*2))+"px";
    item.style.height = depth3D+"px";
    item.style.transform = "rotateX(-90deg) translateZ("+((height)-(depth3D/2))+"px)";
}

function leftBox3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.marginTop = radius3D+"px";
    item.style.width = depth3D+"px";
    item.style.height = (height-(radius3D*2))+"px";
    item.style.transform = "rotateY(-90deg) translateZ("+(depth3D/2)+"px)";
}

function rightBox3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.marginTop = radius3D+"px";
    item.style.width = depth3D+"px";
    item.style.height = (height-(radius3D*2))+"px";
    item.style.transform = "rotateY(-90deg) translateZ(-"+((width)-(depth3D/2))+"px)";
}

function border1Box3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.marginTop = (radius3D-((radius3D/32)*0)+0.5)+"px";
    item.style.width = depth3D+"px";
    item.style.height = (radius3D/3)+"px";
    item.style.transform = "rotateY(-90deg) rotateX(15deg) translateZ("+(depth3D/2)+"px)";
}

function border2Box3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.marginTop = (radius3D-((radius3D/32)*1)+0.5)+"px";
    item.style.marginLeft = (((radius3D/32)*1)-0.5)+"px";
    item.style.width = depth3D+"px";
    item.style.height = ((radius3D/3)+2.5)+"px";
    item.style.transform = "rotateY(-90deg) rotateX(30deg) translateZ("+((depth3D/2))+"px)";
}

function border3Box3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.marginLeft = (radius3D-((radius3D/32)*0)+0.5)+"px";
    item.style.width = (radius3D/3)+"px";
    item.style.height = depth3D+"px";
    item.style.transform = "rotateX(-90deg) rotateY(15deg) translateZ(-"+(depth3D/2)+"px)";
}

function border4Box3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.marginLeft = (radius3D-((radius3D/32)*1)+0.5)+"px";
    item.style.marginTop = (((radius3D/32)*1)-0.5)+"px";
    item.style.width = ((radius3D/3)+2.5)+"px";
    item.style.height = depth3D+"px";
    item.style.transform = "rotateX(-90deg) rotateY(30deg) translateZ(-"+(depth3D/2)+"px)";
}

function addborder(item) {
    let dim2d = dimBox3D(item);
    let border1 = item.querySelector(".box-3D-border-1");
    let border2 = item.querySelector(".box-3D-border-2");
    let border3 = item.querySelector(".box-3D-border-3");
    let border4 = item.querySelector(".box-3D-border-4");
    let leftBottom = item.querySelector(".border-3D-left-bottom");
    let rightBottom = item.querySelector(".border-3D-right-bottom");
    let rightTop = item.querySelector(".border-3D-right-top");
    leftBottom.style.width = dim2d.width+"px";
    leftBottom.style.height = dim2d.height+"px";
    rightBottom.style.width = dim2d.width+"px";
    rightBottom.style.height = dim2d.height+"px";
    rightTop.style.width = dim2d.width+"px";
    rightTop.style.height = dim2d.height+"px";
    leftBottom.style.marginTop = -dim2d.height+"px";
    rightBottom.style.marginTop = -dim2d.height+"px";
    rightTop.style.marginTop = -dim2d.height+"px";
    leftBottom.appendChild(border1.cloneNode(true));
    rightBottom.appendChild(border1.cloneNode(true));
    rightTop.appendChild(border1.cloneNode(true));
    leftBottom.appendChild(border2.cloneNode(true));
    rightBottom.appendChild(border2.cloneNode(true));
    rightTop.appendChild(border2.cloneNode(true));
    leftBottom.appendChild(border3.cloneNode(true));
    rightBottom.appendChild(border3.cloneNode(true));
    rightTop.appendChild(border3.cloneNode(true));
    leftBottom.appendChild(border4.cloneNode(true));
    rightBottom.appendChild(border4.cloneNode(true));
    rightTop.appendChild(border4.cloneNode(true));
    leftBottom.style.transform = "rotateX(180deg)";
    rightBottom.style.transform = "rotateY(180deg) rotateX(180deg)";
    rightTop.style.transform = "rotateY(180deg)";
}

function createFormeBox3D(item) {
    let dim2d = dimBox3D(item);
    let width = dim2d.width;
    let height = dim2d.height;
    item.querySelector(".object-3D").style.width = width;
    item.querySelector(".object-3D").style.height = height;
    item.querySelector(".object-3D").style.marginTop = (-1*(height/2))+"px";
    item.querySelector(".object-3D").style.marginLeft = (-1*(width/2))+"px";
    item.style.marginTop = (1*(height/2))+"px";
    item.style.marginLeft = (1*(width/2))+"px";
    item.style.width = dim2d.width+"px";
    item.style.height = dim2d.height+"px";
    item.parentNode.style.width = dim2d.width+"px";
    item.parentNode.style.height = dim2d.height+"px";
    frontBox3D(item.querySelector(".box-3D-front"), item);
    backBox3D(item.querySelector(".box-3D-back"), item);
    topBox3D(item.querySelector(".box-3D-top"), item);
    bottomBox3D(item.querySelector(".box-3D-bottom"), item);
    leftBox3D(item.querySelector(".box-3D-left"), item);
    rightBox3D(item.querySelector(".box-3D-right"), item);
    border1Box3D(item.querySelector(".box-3D-border-1"), item);
    border2Box3D(item.querySelector(".box-3D-border-2"), item);
    border3Box3D(item.querySelector(".box-3D-border-3"), item);
    border4Box3D(item.querySelector(".box-3D-border-4"), item);
    addborder(item);
}



function findParent(item) {
    if(item === undefined || item.classList.contains("box-3D")) {
        return item;
    }
    return findParent(item.parentNode);
}

let scale = 1;

function zoom(event) {
    event.preventDefault();
    el = findParent(event.target);
  
    scale += event.deltaY * -0.01;
  
    // Restrict scale
    scale = Math.min(Math.max(.125, scale), 4);
  
    // Apply scale transform
    el.style.transform = `scale(${scale})`;
}


document.querySelectorAll(".box-3D").forEach(element0 => {

    createFormeBox3D(element0);

    element0.addEventListener("pointerdown", function(e) {
        mouseStartObject3D.x = e.clientX;
        mouseStartObject3D.y = e.clientY;
        targetObject = findParent(e.target);
    });

    //element0.addEventListener('mousewheel', zoom);


});

window.addEventListener("pointerup", function(e) {
        mouseStartObject3D.x = 0;
        mouseStartObject3D.y = 0;
        targetObject = undefined;
});

window.addEventListener('pointermove', function (event) {
    mouseObject3D.x = event.clientX;
    mouseObject3D.y = event.clientY;
    
    object_move(event);
});

/*
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
    */