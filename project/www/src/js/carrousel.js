let liste_defilement = document.getElementsByClassName("carrousel");
let listBouton = [];
let click_first_button = false; /* pour verifier si on a cliquer au moins une fois sur le bouton */

function create_carrousel_main() {
    let decalag = 0;

    /* pour ne pas corrompre l'annimation lors du changement de taille */
    /* pour eviter d'ajout en continu de bouton sur le carrousel */
    if(liste_defilement.length != listBouton.length) {
        let listProgress = [];
        let num_carrousel = -1; /* pour retrouver le bon carrousel */
        let num;
        let animationDuration = 6;
        let background_color_progressBar_def = "lightgrey";
        let color_progressBar_def = "green";
        let background_color_progressBar_paused = "lightgrey";
        let color_progressBar_paused = "orange";
        let activated_progressBar = true;
        let activated_paused = true;
        let activated_paused_button = true;
        let activated_paused_click = true;

        /* creation de la div d'affichage */
        let new_flex = document.createElement("div");
        new_flex.id = "carrousel_animation_principale";
        new_flex.style.display = "flex";
        new_flex.style.justifyContent = "center";
        new_flex.style.padding = "5px 10%";
        new_flex.style.flexWrap = "wrap";
        let depot = document.getElementById("img_factice");
        depot.insertAdjacentElement("afterend", new_flex);


        /* mettre en pause l'annimation */
        function paused() {
            if(liste_defilement[num_carrousel].style.animationPlayState == "paused") {
                //function_timed_out(temps_restent);
                liste_defilement[num_carrousel].style.animationPlayState = "running";
                if(activated_progressBar) {
                    listProgress[num_carrousel].style.animationPlayState = "running";
                }
                listBouton[num_carrousel].style.backgroundColor = background_color_progressBar_def;
                listProgress[num_carrousel].style.backgroundColor = color_progressBar_def;
            } else {
                liste_defilement[num_carrousel].style.animationPlayState = "paused";
                if(activated_progressBar) {
                    listProgress[num_carrousel].style.animationPlayState = "paused";
                }
                listBouton[num_carrousel].style.backgroundColor = background_color_progressBar_paused;
                listProgress[num_carrousel].style.backgroundColor = color_progressBar_paused;
            }
        }

        /* Creation des boutons et de l'affichage de l'animation */
        for (let i = liste_defilement.length - 1; i >= 0; i--) {
            /* creation des boutons */
            let new_button = document.createElement("div");
            let progress = document.createElement("div");
            progress.id = "carrousel_progress_"+i; /* id primordiale pour les boutons */
            if(activated_progressBar) {
                progress.style.width = "0%";
            } else {
                progress.style.width = "100%";
            }
            progress.style.height = "100%";
            progress.style.backgroundImage = "none";
            progress.style.backgroundColor = color_progressBar_def;
            new_button.appendChild(progress);
            new_button.classList.add("bouton");
            new_button.id = "carrousel_button_"+i; /* id primordiale pour les boutons */
            new_button.style.width = "25px";
            new_button.style.height = "10px";
            new_button.style.border = "1px solid black";
            //new_button.style.borderRadius = "50%";
            new_button.style.backgroundColor = background_color_progressBar_def;
            new_button.style.margin = "5px";
            new_button.style.boxSizing = "border-box";
            new_button.style.overflow = "hidden";

            /* l'action a effectuer lors du click d'un bouton */
            new_button.addEventListener('click', function (e) {
                /* il faut recuperer l'emplacement du bouton sur l'id, pas avec "i" */
                num = Number.parseInt(e.target.id.split("_")[2]);
                /* si on a cliquer sur le meme bouton plus d'une fois pour la meme animation,
                on active ou desactive la pausse de celle-ci. */
                if(num == num_carrousel && click_first_button) {
                    if(activated_paused && activated_paused_button) {
                        paused();
                    }
                } else {
                    //stop_function_timed_out();
                    /* Si c'est la premiere fois, on desactiver les annimations, pour activer la bonne. */
                    click_first_button = true;
                    num = num < 0 ? 0 : num;
                    num_carrousel = num;
                    /* desactiver les animations */
                    for (j = 0; j < listBouton.length; j++) { 
                        liste_defilement[j].style.animationName = null;
                        liste_defilement[j].style.opacity = 0;
                        listProgress[j].style.animationName = null;
                        if(activated_progressBar) {
                            listProgress[j].style.width = "0%";
                        }
                        listProgress[j].style.backgroundColor = background_color_progressBar_def;
                        listBouton[j].style.backgroundColor = background_color_progressBar_def;
                    }
                    /* activer la bonne animation */
                    listProgress[num].style.backgroundColor = color_progressBar_def;
                    if(activated_progressBar) {
                        listProgress[num].style.animationDuration = animationDuration+"s";
                        listProgress[num].style.animationPlayState = "running";
                        listProgress[num].style.animationName = "linear";
                        listProgress[num].style.animationName = "progressBar";
                    }
                    liste_defilement[num].style.animationDuration = animationDuration+"s";
                    liste_defilement[num].style.animationPlayState = "running";
                    liste_defilement[num].style.animationName = "defilement";
                    liste_defilement[num].style.opacity = 1;
                }
            });

            
            
            /* Action a effectuer a la fin de l'animation */
            liste_defilement[i].addEventListener('animationend', function (e) {
                console.log(liste_defilement[i]);
                click_first_button = false;
                liste_defilement[num_carrousel].style.animationPlayState = "paused";
                listBouton[num_carrousel].style.backgroundColor = background_color_progressBar_def;
                num_carrousel++;
                /* verifier qu'on ne depasse pas le nombre d'image du carrousel */
                if(num_carrousel >= liste_defilement.length) {
                    num_carrousel = 0;
                }
                /* on clik sur le bouton suivant, pour la prochaine animation */
                document.getElementById("carrousel_button_"+num_carrousel).click();
            });

            /* pour mettre en place une pausse sur l'image */
            liste_defilement[i].addEventListener('click', function (e) {
                if(activated_paused && activated_paused_click) {
                    paused();
                }
            });

            /* on ajoute le bouton dans une liste */
            listBouton.unshift(new_button);
            listProgress.unshift(progress);
            /* on ajoute le bouton a la page html */
            new_flex.insertAdjacentElement("afterbegin", new_button);

        }
    }

    /* verifiont qu'on a bien des images a faire annimer */
    if(liste_defilement.length > 0) {
        /* on click sur la première animation pour faire partir l'annimation */
        document.getElementById("carrousel_button_0").click();
    }
}

let start_load_carrousel = false;
create_carrousel_main();
start_load_carrousel = true;

console.log(liste_defilement);

/*
if (screen.width < 1024 || window.innerWidth < 1024) {
    create_carrousel_main();
    start_load_carrousel = true;
}

window.addEventListener('resize', function (e) {
    if (screen.width < 1024 || window.innerWidth < 1024) {
        if(!start_load_carrousel) {
            create_carrousel_main();
            start_load_carrousel = true;
        }
    } else {
        click_first_button = false;
        start_load_carrousel = false;
        for (let i = liste_defilement.length - 1; i >= 0; i--) {
            liste_defilement[i].style.opacity = 1;
            liste_defilement[i].style.animationName = null;
        }
    }
});*/