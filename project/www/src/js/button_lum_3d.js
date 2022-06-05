/* https://codepen.io/alexkorzin/pen/bOpxPM */

let rotationForce = 0.01;

let mouse = {
    x: 0,
    y: 0
}

let rotation = {
    x: 0,
    y: 0
}

window.addEventListener('mousemove', function (event) {
    mouse.x = event.clientX;
    mouse.y = event.clientY;

    document.querySelectorAll('.container-bt-3D').forEach(element => {

        let button = element.querySelector('.button');
        let buttonGlow = element.querySelector('.button_glow');

        let buttonPos = {
            x: element.offsetLeft + button.offsetWidth / 2,
            y: element.offsetTop + button.offsetHeight / 2
        }

        rotation.x = (mouse.y - buttonPos.y) / (window.innerHeight * rotationForce);
        rotation.y = (mouse.x - buttonPos.x) / (window.innerWidth * rotationForce);

        button.style.transform = 'rotateX(' + rotation.x + 'deg)' + 'rotateY(' + rotation.y + 'deg)';
        buttonGlow.style.transform = 'rotateX(' + -1 * rotation.x + 'deg)' + 'rotateY(' + -1 * rotation.y + 'deg)';
        
    });
})