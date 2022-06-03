/**
 * On valide le formulaire.
 * 
 * @param {event} e evenement du javascript 
 */
function connected(e) {
    // les regex de validation
    let regexTextValide = /^.{3,}$/;
    let login = document.getElementById("name-user").value;
    let password_user = document.getElementById("pass-user").value;
    // verifier la validite des valeurs
    if(regexTextValide.test(login) && regexTextValide.test(password_user)) {
        // tableau de donnees post a envoyer
        let dataArray = {
            "login" : login,
            "password_user" : password_user
        };
        /* envoyer les informations du formulaire dans la page php. */
        fetch_post('./src/exec/connexion_exec.php', dataArray).then(function(response) {
            /* si tout c'est bien passe */
            if(response == "true") {
                /* retourne a l'index et ferme la fenetre */
                window.location.href = "./pctr_admin/";
                window.close();
            } else {
                // afficher le message dans un modal.
                alert(response);
            }
        });
    } else {
        // afficher le message dans un modal.
        alert("Les informations sont vides, vous ne pouvez pas vous connecter.");
    }
}

/**
 * On ferme la fenetre.
 * 
 * @param {event} e evenement du javascript 
 */
function annuler(e) {
    window.close();
}

/**
 * Action si on touche le bouton entrer du clavier.
 */
document.body.addEventListener("keydown", (event) => {
  if (event.key == "Enter") {
    connected(event);
  }
});

/* action sur le bouton valider ou annuler */
document.querySelectorAll("#connected").forEach(element => {
    element.addEventListener("click", connected);
});
