let idform = "";
let namePageExec = "";
let namePageDeletExec = "";
let namePageModifExec = "";
let namePageDisplExec = "";
let namePageFindExec = "";
let nameLienModifExec = "";

function valiadtionForm(e) {
   // pour ne pas prendre l'adresse de l'action du formulaire.
   e.preventDefault();
   let lien = "./src/exec/"+namePageExec+".php";
   /* envoyer les informations du message sur la page php a partir d'un formulaire */
   fetch_form(lien, idform).then(function (
      response
   ) {
        /* si c'est bon, on recupere le tableau des valeurs de la liste des messages */
        if (response == "true") {
           //location.reload();
           window.location.href = nameLienModifExec;
        } else {
            alert(response);
        }
   });
}

function deletObject(e) {
   // pour ne pas prendre l'adresse de l'action du formulaire.
   e.preventDefault();
   let values = {
      id: e.target.id.split("_")[1]
  };
   let name = e.target.parentNode.parentNode.parentNode.querySelector(".name").innerText;
   let lien = "./src/exec/"+namePageDeletExec+".php";
   /* message de confirmation */
   let isExecuted = confirm("Attention vous allez supprimer '"+name+"'. 'Ok' pour continuer.");
   /* si on confirme la suppression */
   if(isExecuted) {
      /* envoyer les informations du message sur la page php a partir d'un formulaire */
      fetch_post(lien, values).then(function (
         response
      ) {
         /* si c'est bon, on recupere le tableau des valeurs de la liste des messages */
         if (response == "true") {
            //location.reload();
            window.location.href = nameLienModifExec;
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

function td_find(e) {
   // pour ne pas prendre l'adresse de l'action du formulaire.
   e.preventDefault();
   if(document.getElementById("recherche") != undefined && document.getElementById("recherche").value != "") {
      console.log(nameLienModifExec);
      window.location.href = nameLienModifExec+"&find="+document.getElementById("recherche").value+"#tab_find";
   } else {
      window.location.href = nameLienModifExec+"#tab_find";
   }
}

document.querySelectorAll("#validation").forEach((element) => {
   element.addEventListener("click", valiadtionForm);
});

function display_change(e) {
   // pour ne pas prendre l'adresse de l'action du formulaire.
   e.preventDefault();
   let values = {
      "id": e.target.id.split("_")[1],
      "display": (e.target.checked?1:0)
   };
   let lien = "./src/exec/"+namePageDisplExec+".php";
   let get_id = function_GET('id');
   /*envoyer les informations du message sur la page php a partir d'un formulaire */
   fetch_post(lien, values).then(function (
      response
   ) {
      /* si c'est bon, on recupere le tableau des valeurs de la liste des messages */
      if (response != "true") {
         e.target.checked = !e.target.checked;
         alert(response);
      } else {
         if(get_id != undefined && get_id==values.id) {
            document.getElementById("checkDisplay").checked = e.target.checked;
         }
      }
   });
}

/**
 * activer les boutons de la page
 */
 function activeClick() {
   document.querySelectorAll("#bt_find").forEach((element) => {
      element.addEventListener("click", td_find)
   });
   document.querySelectorAll("#tab_find").forEach((element0) => {
    /* activer le changement de format des cellules */
    element0
     .querySelectorAll(".delete_row")
     .forEach((element) => {
        element.addEventListener("click", deletObject);
     });
  
     /* activer le bouton de suppression */
     element0
     .querySelectorAll(".modif_row")
     .forEach((element) => {
        element.addEventListener("click", modifObject);
     });

     /* activer le bouton de suppression */
     element0
     .querySelectorAll(".display_row")
     .forEach((element) => {
        element.addEventListener("change", display_change);
     });
   });
}
  
/* activer les cellules de la table, pour changer la valeur quand on clique dessus */
activeClick();