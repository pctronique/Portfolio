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
 * On valide le formulaire.
 * 
 * @param {event} e evenement du javascript 
 */
 function validerPassPerdu(e) {
    // regex pour verifier la validite de l'email */
    let regexTextValide = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    // recuperer l'adresse email.
    let email = document.getElementById("email-pass-perdu").value;
    // verifier que l'adresse email et valide.
    if(regexTextValide.test(email)) {
        // tableau de donnees post a envoyer
        let dataArray = {
            "email" : email
        };
        // envoyer le post a la page d'email perdu.
        fetch_post('./src/exec/mdp_perdu_email_exec.php', dataArray).then(function(response) {
            // si la page retourne "true", tout c'est bien passe.
            if(response == "true") {
                // afficher le message dans un modal.
                // quand on ferme le modal, on revient a l'index
                console.log("Vous avez reçu un email, pour modifier le mot de passe.");
                location.reload();
            } else {
                // afficher le message dans un modal.
                console.log(response);
            }
        });
    } else {
        // afficher le message dans un modal.
        console.log("Les informations sont vides, vous ne pouvez pas vous connecter.");
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
    document.getElementById('recep-mod-pass').addEventListener("click", validerPassPerdu);
});
