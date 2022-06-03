let idform = "";
let namePageExec = "";
let namePageDeletExec = "";
let namePageModifExec = "";
let nameLienModifExec = "";

function valiadtionForm(e) {
   // pour ne pas prendre l'adresse de l'action du formulaire.
   e.preventDefault();
   let lien = "./src/exec/"+namePageExec+".php";
   console.log(lien);
   console.log(idform);
   console.log(document.getElementById(idform));
   /* envoyer les informations du message sur la page php a partir d'un formulaire */
   fetch_form(lien, idform).then(function (
      response
    ) {
        /* si c'est bon, on recupere le tableau des valeurs de la liste des messages */
        if (response == "true") {
           location.reload();
        } else {
         console.log(response);
            alert(response);
        }
    });
}

function deletObject(e) {
   // pour ne pas prendre l'adresse de l'action du formulaire.
   e.preventDefault();
   let name = e.parentNode.querySelector(".name").innerText;
   let lien = "./src/exec/"+namePageDeletExec+".php";
   /* message de confirmation */
   let isExecuted = confirm("Attention vous allez supprimer l'utilisateur. 'Ok' pour continuer.");
   /* si on confirme la suppression */
   if(isExecuted) {
      /* envoyer les informations du message sur la page php a partir d'un formulaire */
      fetch_form(lien, idform).then(function (
         response
      ) {
         /* si c'est bon, on recupere le tableau des valeurs de la liste des messages */
         if ("true") {
               location.reload();
         } else {
               alert(response);
         }
      });
   }
}

function modifObject(e) {
   // pour ne pas prendre l'adresse de l'action du formulaire.
   e.preventDefault();
   let id = e.target.id.split("_")[1];
   window.location.href = nameLienModifExec+"&id="+id;
}

document.querySelectorAll("#validation").forEach((element) => {
   element.addEventListener("click", valiadtionForm);
});

/**
 * activer les boutons de la page
 */
 function activeClick() {
    /* activer le changement de format des cellules */
     document
     .getElementById("tab_find")
     .querySelectorAll(".delete_row")
     .forEach((element) => {
        element.addEventListener("click", deletObject);
     });
  
     /* activer le bouton de suppression */
     document
     .getElementById("tab_find")
     .querySelectorAll(".modif_row")
     .forEach((element) => {
        element.addEventListener("click", modifObject);
     });
  }
  
  /* activer les cellules de la table, pour changer la valeur quand on clique dessus */
  activeClick();