let check_nav_left = document.getElementById("check-nav-left");
let check_nav_right = document.getElementById("check-nav-right");

check_nav_left.addEventListener("click", function() {
    if(check_nav_right.checked) {
        check_nav_right.click();
    }
});

check_nav_right.addEventListener("click", function() {
    if(check_nav_left.checked) {
        check_nav_left.click();
    }
    if(check_nav_right.checked) {
        document.getElementById("img-nav-right").src="./src/img/cadenas-deverrouille.svg";
    } else {
        document.getElementById("img-nav-right").src="./src/img/cadenas-ferme.svg";
    }
})

document.getElementById("nav-left").querySelectorAll(".lien").forEach(element => {
    if(element.classList.contains("lien")) {
        element.addEventListener("click", function() {
            element.querySelectorAll("a").forEach(element_a => {
                window.location.href=element_a.href;
            });
        })
    }
});