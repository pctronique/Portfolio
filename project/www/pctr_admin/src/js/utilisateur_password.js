// si on clique sur l'oeuil pour afficher ou masquer le mot de passe
document.querySelectorAll(".togglePassword").forEach(element => {
    element.addEventListener('click', (e) => {

        if(e.target.classList.contains("bi")) {
            // recupere l'input du premier mot de passe
            let password = element.parentNode.querySelector(".formPass");

            // connaitre le type d'affichage et le modifier
            let type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
        
            // choissir l'image selon le type d'affichage
            let img_renove = (type === 'text') ? "bi-eye-slash" : "bi-eye";
            let img_eye = (type === 'text') ? "bi-eye" : "bi-eye-slash";
        
            // changer l'image (en modifient le nom de la classe)
            e.target.classList.remove(img_renove);
            e.target.classList.add(img_eye);
        }
    });
});
