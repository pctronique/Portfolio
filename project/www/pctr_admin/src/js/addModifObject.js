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

function add_td_find(name_id, id, name, display = false, check_display = false) {
   let td = "<tr id=\""+name_id+"_"+id+"\">";
   td += "<td>";
   td += "<a href=\"#\"><img class=\"delete_row\" id=\"delete_"+id+"\" src=\"./src/img/icons8-supprimer-pour-toujours-90_white.svg\" /></a>";
   td += "</td>";
   td += "<td>";
   td += "<a href=\"#\"><img class=\"modif_row\" id=\"modif_"+id+"\" src=\"./src/img/icons8-modifier_white.svg\" /></a>";
   td += "</td>";
   if(check_display) {
       td += "<td>";
       td += "<div class=\"form-check form-switch\">";
       td += "<input class=\"form-check-input display_row\" type=\"checkbox\" name=\"display\" value=\"true\" id=\"checkDisplay_"+id+"\" "+(display?"checked":"")+">";
       td += "</div>";
       td += "</td>";
   }
   td += "<td class=\"name\">";
   td += name;
   td += "</td>";
   td += "</tr>";
   return td;
}

document.querySelectorAll("#validation").forEach((element) => {
   element.addEventListener("click", valiadtionForm);
});

function display_change(e) {
   // pour ne pas prendre l'adresse de l'action du formulaire.
   e.preventDefault();
   let values = {
      "id": e.target.id.split("_")[1],
      "display": e.target.checked
   };
   let lien = "./src/exec/"+namePageDisplExec+".php";
   let get_id = function_GET('id');
   console.log(e.target.checked);
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
            document.getElementById("checkDisplay").checked = values.display;
         }
      }
   });
}

/**
 * activer les boutons de la page
 */
 function activeClick() {
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