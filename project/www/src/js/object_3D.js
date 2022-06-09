let rotationForceObject3D = 2;

function posObject3D() {
    return {
        x: 0,
        y: 0,
        z: 0
    }
}

let sizeBoxDefault = 0;

function dimBox3D(itemMain) {
    let height = itemMain.querySelector(".box-3D-size").offsetHeight;
    let width = itemMain.querySelector(".box-3D-size").offsetWidth;
    itemMain.querySelectorAll(".box-3D-main-size").forEach(element => {
        height = element.offsetHeight;
        width = element.offsetWidth;
    });
    itemMain.querySelectorAll(".box-3D-maxHeight").forEach(element => {
        let maxWidth = itemMain.querySelector(".box-3D-maxWidth").value;
        let maxHeight = itemMain.querySelector(".box-3D-maxHeight").value;
        height = maxHeight/(maxWidth/itemMain.querySelector(".box-3D-size").offsetWidth);
    });
    let windowWidth = window.innerWidth;
	if(screen.width < window.innerWidth) {
		windowWidth = screen.width;
	}
    if(windowWidth < 320) {
        windowWidth = 320;
    }
    return {
        width: (windowWidth < sizeBoxDefault) ? windowWidth : sizeBoxDefault,
        height: height
    }
}

let mouseObject3D = posObject3D();

let positionObject3D = posObject3D();

let mouseStartObject3D = posObject3D();

let targetObject = undefined;

function recupererAngle(e) {
    let pos = posObject3D()
    let transform = targetObject.querySelector(".object-3D").style.transform;
    if(transform != undefined && transform.trim() != "") {
        if(transform.indexOf(")")) {
            let values = transform.split(")");
            values.forEach(element => {
                if(element.indexOf("(")) {
                    let valueTransform = element.split("(");
                    if(valueTransform[1] != undefined) {
                        let valueAngle = parseInt(valueTransform[1].replaceAll('deg', '').trim());
                        if(!isNaN(valueAngle)) {
                            if(valueTransform[0].trim() == "rotateX") {
                                pos.x = valueAngle;
                            } else if(valueTransform[0].trim() == "rotateY") {
                                pos.y = valueAngle;
                            } else if(valueTransform[0].trim() == "rotateZ") {
                                pos.z = valueAngle;
                            }
                        }
                    }
                }
            });
        }
    }
    return pos;
}

function object_move(e) {
    if(targetObject !== undefined) {
        let pos = recupererAngle();
        let diffPosObject3D = posObject3D();
        diffPosObject3D.x = mouseObject3D.x-mouseStartObject3D.x;
        diffPosObject3D.y = mouseObject3D.y-mouseStartObject3D.y;
        
        pos.y += (diffPosObject3D.x*rotationForceObject3D);
        pos.x -= (diffPosObject3D.y*rotationForceObject3D);

        mouseStartObject3D.x = mouseObject3D.x;
        mouseStartObject3D.y = mouseObject3D.y;
        
        targetObject.querySelector(".object-3D").style.transform = 'rotateX(' + pos.x + 'deg) rotateY(' + pos.y + 'deg)';
        
        recupererAngle(targetObject);
    }
}

let depth3D = 60;
let depth3DHeight = 60;
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
    item.style.transform = "rotateY(-90deg) rotateX(15deg) translateZ("+(depth3DHeight/2)+"px)";
}

function border2Box3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.marginTop = (radius3D-((radius3D/32)*1)+0.5)+"px";
    item.style.marginLeft = (((radius3D/32)*1)-0.5)+"px";
    item.style.width = depth3D+"px";
    item.style.height = ((radius3D/3)+2.5)+"px";
    item.style.transform = "rotateY(-90deg) rotateX(30deg) translateZ("+((depth3DHeight/2))+"px)";
}

function border3Box3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.marginLeft = (radius3D-((radius3D/32)*0)+0.5)+"px";
    item.style.width = (radius3D/3)+"px";
    item.style.height = depth3D+"px";
    item.style.transform = "rotateX(-90deg) rotateY(15deg) translateZ(-"+(depth3DHeight/2)+"px)";
}

function border4Box3D(item, itemMain) {
    let dim2d = dimBox3D(itemMain);
    let width = dim2d.width;
    let height = dim2d.height;
    item.style.marginLeft = (radius3D-((radius3D/32)*1)+0.5)+"px";
    item.style.marginTop = (((radius3D/32)*1)-0.5)+"px";
    item.style.width = ((radius3D/3)+2.5)+"px";
    item.style.height = depth3D+"px";
    item.style.transform = "rotateX(-90deg) rotateY(30deg) translateZ(-"+((depth3DHeight/2))+"px)";
}

function addborder(item) {
    let dim2d = dimBox3D(item);
    let border1 = item.querySelector(".box-3D-border-1");
    let border2 = item.querySelector(".box-3D-border-2");
    let border3 = item.querySelector(".box-3D-border-3");
    let border4 = item.querySelector(".box-3D-border-4");
    let leftTop = item.querySelector(".border-3D-left-top");
    let leftBottom = item.querySelector(".border-3D-left-bottom");
    let rightBottom = item.querySelector(".border-3D-right-bottom");
    let rightTop = item.querySelector(".border-3D-right-top");
    leftBottom.style.width = dim2d.width+"px";
    leftBottom.style.height = dim2d.height+"px";
    rightBottom.style.width = dim2d.width+"px";
    rightBottom.style.height = dim2d.height+"px";
    rightTop.style.width = dim2d.width+"px";
    rightTop.style.height = dim2d.height+"px";
    leftTop.style.marginTop = -dim2d.height+"px";
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

function deleteNode3D(item) {
    let object = item.querySelector(".object-3D");
    object.removeChild(object.querySelector(".object-3D-5F"));
    object.removeChild(object.querySelector(".border-3D-left-top"));
    object.removeChild(object.querySelector(".border-3D-right-top"));
    object.removeChild(object.querySelector(".border-3D-left-bottom"));
    object.removeChild(object.querySelector(".border-3D-right-bottom"));
}

function createNode3D(item) {
    let object_3D_5F = document.createElement("figure");
    object_3D_5F.classList.add("object-3D-5F");
    let border_3D_left_top = document.createElement("figure");
    border_3D_left_top.classList.add("border-3D-left-top");
    let border_3D_right_top = document.createElement("figure");
    border_3D_right_top.classList.add("border-3D-right-top");
    let border_3D_left_bottom = document.createElement("figure");
    border_3D_left_bottom.classList.add("border-3D-left-bottom");
    let border_3D_right_bottom = document.createElement("figure");
    border_3D_right_bottom.classList.add("border-3D-right-bottom");
    /*if(item.querySelector(".box-3D-depth3D") != undefined) {
        depth3D = item.querySelector(".box-3D-depth3D").value;
    } else {
        depth3D = 60;
    }*/
    let fomatMain = item.querySelector(".box-3D-front").cloneNode(true);
    fomatMain.innerHTML = "";
    fomatMain.classList.remove("box-3D-front");
    fomatMain.classList.remove("box-3D-size");
    fomatMain.style.borderRadius = "unset";
    let format1 = fomatMain.cloneNode(true);
    format1.classList.add("box-3D-bottom");
    object_3D_5F.appendChild(format1);
    let format2 = fomatMain.cloneNode(true);
    format2.classList.add("box-3D-back");
    object_3D_5F.appendChild(format2);
    let format3 = fomatMain.cloneNode(true);
    format3.classList.add("box-3D-top");
    object_3D_5F.appendChild(format3);
    let format4 = fomatMain.cloneNode(true);
    format4.classList.add("box-3D-left");
    object_3D_5F.appendChild(format4);
    let format5 = fomatMain.cloneNode(true);
    format5.classList.add("box-3D-right");
    object_3D_5F.appendChild(format5);
    fomatMain.classList.add("box-3D-border");
    let format6 = fomatMain.cloneNode(true);
    format6.classList.add("box-3D-border-1");
    border_3D_left_top.appendChild(format6);
    let format7 = fomatMain.cloneNode(true);
    format7.classList.add("box-3D-border-2");
    border_3D_left_top.appendChild(format7);
    let format8 = fomatMain.cloneNode(true);
    format8.classList.add("box-3D-border-3");
    border_3D_left_top.appendChild(format8);
    fomatMain.classList.add("box-3D-border-4");
    border_3D_left_top.appendChild(fomatMain);
    item.appendChild(object_3D_5F.cloneNode(true));
    item.appendChild(border_3D_left_top.cloneNode(true));
    item.appendChild(border_3D_right_top.cloneNode(true));
    item.appendChild(border_3D_left_bottom.cloneNode(true));
    item.appendChild(border_3D_right_bottom.cloneNode(true));
}

function createFormeBox3D(item) {
    let object_3D = item.querySelector(".object-3D");
    createNode3D(object_3D);
    let dim2d = dimBox3D(item);
    let width = dim2d.width;
    let height = dim2d.height;
    object_3D.style.width = width;
    object_3D.style.height = height;
    item.style.width = dim2d.width+"px";
    item.style.height = dim2d.height+"px";
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

    sizeBoxDefault = element0.querySelector(".box-3D-size").offsetWidth;

    element0.querySelectorAll(".box-3D-main-size").forEach(element => {
        sizeBoxDefault = element.offsetWidth;
    });

    element0.querySelectorAll(".box-3D-maxWidth").forEach(element => {
        sizeBoxDefault = parseInt(element0.querySelector(".box-3D-maxWidth").value);
    });

    createFormeBox3D(element0);

});

document.querySelectorAll(".box-3D-mov").forEach(element0 => {

    element0.addEventListener("pointerdown", obj3DPointerDown);

});


function obj3DPointerDown(event) {
	if (event.isPrimary === false) return;

    mouseStartObject3D.x = event.clientX;
    mouseStartObject3D.y = event.clientY;
    targetObject = findParent(event.target);

	document.addEventListener("pointermove", obj3DPointerMove);
	document.addEventListener("pointerup", obj3DPointerUp);
}

function obj3DPointerMove(event) {
	if (event.isPrimary === false) return;
    mouseObject3D.x = event.clientX;
    mouseObject3D.y = event.clientY;
    object_move(event);
}

function obj3DPointerUp(event) {
	if (event.isPrimary === false) return;

    mouseStartObject3D.x = 0;
    mouseStartObject3D.y = 0;
    targetObject = undefined;

	document.removeEventListener("pointermove", obj3DPointerMove);
	document.removeEventListener("pointerup", obj3DPointerUp);
}

window.addEventListener('resize', function() {
	document.querySelectorAll(".box-3D").forEach(element0 => {

        deleteNode3D(element0);
        createFormeBox3D(element0);
    
    });
});