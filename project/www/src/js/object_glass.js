document.querySelectorAll(".rectangular_glass").forEach(element => {
    document.querySelectorAll(".rectangular_glass:before").forEach(element1 => {
        console.log("test");
        element1.style.width = element.offsetWidth;
        element1.style.height = element.offsetHeight;
    });
});
