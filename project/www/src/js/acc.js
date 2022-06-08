function dimCarrouselBox3D(itemMain) {
    let maxWidth = itemMain.querySelector(".box-3D-maxWidth").value;
    let maxHeight = itemMain.querySelector(".box-3D-maxHeight").value;
    let heightMod = maxHeight/(maxWidth/itemMain.querySelector(".box-3D-size").offsetWidth);
    itemMain.querySelector(".box-3D-size").offsetHeight = heightMod;
    itemMain.querySelector(".box-3D-size").style.height = heightMod;
    console.log("Width : "+itemMain.querySelector(".box-3D-size").offsetWidth);
    console.log("Height : "+itemMain.querySelector(".box-3D-size").offsetHeight);
    console.log("heightMod : "+heightMod);
}

window.addEventListener('resize', function() {
	document.querySelectorAll(".box-3D").forEach(element0 => {
        dimCarrouselBox3D(element0);
        deleteNode3D(element0);
        createFormeBox3D(element0);
    
    });
});