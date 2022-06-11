idform = "form-user";
namePageExec = "modif_user";
namePageDeletExec = "";
namePageModifExec = "";
namePageDisplExec = "";
namePageFindExec = "";
nameLienModifExec = ".?ind=user";

function valiadtionModifPass(e) {
    // pour ne pas prendre l'adresse de l'action du formulaire.
    e.preventDefault();
    let lien = "./src/exec/modif_mdp.php";
    /* envoyer les informations du message sur la page php a partir d'un formulaire */
    fetch_form(lien, "form-pass").then(function (
       response
     ) {
         /* si c'est bon, on recupere le tableau des valeurs de la liste des messages */
         if (response == "true") {
            //location.reload();
            window.location.href = nameLienModifExec;
         } else {
            console.log(response);
             alert(response);
         }
     });
}

// Replace the textarea #example with SCEditor
var textarea = document.getElementById('formDescription');
sceditor.create(textarea, {
    format: 'bbcode',
    icons: 'monocons',
    style: './src/bbcode_editeur/minified/themes/defaultdark.min.css'
});

document.getElementById("validation_pass").addEventListener("click", valiadtionModifPass);