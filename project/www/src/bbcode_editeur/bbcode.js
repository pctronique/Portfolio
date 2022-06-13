let tags = 'size|color|center|quote|img|ul|li|strong|u|url|em|h1|h2|h3|h4|h5|h6';
let tags_html = 'font:size|font:color|div:center|blockquote|img|ul|li|strong|span:underline|a|em|h1|h2|h3|h4|h5|h6';
let tags_def_html = 'font|div|blockquote|img|a|ul|li|strong|span|em|h1|h2|h3|h4|h5|h6';

let tags_tab = tags.split("|");
let tags_html_tab = tags_html.split("|");
let tags_def_html_tab = tags_def_html.split("|");

function replace_value_bb_html(element, textBB) {
    let matches;
    switch (element) {
        case 'strong':
        case 'em':
        case 'ul':
        case 'li':
        case 'h1':
        case 'h2':
        case 'h3':
        case 'h4':
        case 'h5':
        case 'h6':
        case 'quote':
            textBB = textBB.replaceAll("["+element+"]", "<"+tags_html_tab[tags_tab.indexOf(element)]+">");
            textBB = textBB.replaceAll("[/"+element+"]", "</"+tags_html_tab[tags_tab.indexOf(element)]+">");
            break;
        case 'center':
            textBB = textBB.replaceAll("["+element+"]", "<div align=\"center\">");
            textBB = textBB.replaceAll("[/"+element+"]", "</div>");
            break;
        case 'u':
            textBB = textBB.replaceAll("["+element+"]", "<span style=\"text-decoration: underline\">");
            textBB = textBB.replaceAll("[/"+element+"]", "</span>");
            break;
        case 'size':
            matches = textBB.match(/\[(size)=?(.*?)\](.*?)\[\/\1\]/g);
            if(matches != undefined) {
                matches.forEach(element1 => {
                    textBB = textBB.replace(element1, element1.replace(/\[(size)=?(.*?)\](.*?)\[\/\1\]/g, '<font style=\"font-size: $2">$3</font>'))
                });
            }
            break;
        case 'color':
            matches = textBB.match(/\[(color)=?(.*?)\](.*?)\[\/\1\]/g);
            if(matches != undefined) {
                matches.forEach(element1 => {
                    textBB = textBB.replace(element1, element1.replace(/\[(color)=?(.*?)\](.*?)\[\/\1\]/g, '<font color="$2">$3</font>'))
                });
            }
            break;
        case 'url':
            matches = textBB.match(/\[(url)=?(.*?)\](.*?)\[\/\1\]/g);
            if(matches != undefined) {
                matches.forEach(element1 => {
                    textBB = textBB.replace(element1, element1.replace(/\[(url)=?(.*?)\](.*?)\[\/\1\]/g, '<a href="$2">$3</a>'))
                });
            }
            break;
        case 'img':
            matches = textBB.match(/\[(img)=?(.*?)\](.*?)\[\/\1\]/g);
            if(matches != undefined) {
                matches.forEach(element1 => {
                    textBB = textBB.replace(element1, element1.replace(/\[(img)=?(.*?)\](.*?)\[\/\1\]/g, '<img src="$2">$3</font>'))
                });
            }
            break;
        default:
            //console.log(`Sorry, we are out of ${element}.`);
      }
      return textBB;
}

function replace_value_html_bb(element, textHTML) {
    let matches;
    switch (element) {
        case 'strong':
        case 'em':
        case 'ul':
        case 'li':
        case 'h1':
        case 'h2':
        case 'h3':
        case 'h4':
        case 'h5':
        case 'h6':
        case 'blockquote':
            textHTML = textHTML.replaceAll("<"+element+">", "["+tags_tab[tags_html_tab.indexOf(element)]+"]");
            textHTML = textHTML.replaceAll("</"+element+">", "[/"+tags_tab[tags_html_tab.indexOf(element)]+"]");
            break;
        case 'font':
            matches = textHTML.match(/<(font)=?(.*?)>(.*?)<\/\1>/g);
            if(matches != undefined) {
                matches.forEach(element1 => {
                    let elementMain = element1.replaceAll(/<(font)=?(.*?)>(.*?)<\/\1>/g, "$2");
                    if(elementMain == undefined) {
                    } else if(elementMain.trim().split('"')[0] == 'color=') {
                        textHTML = textHTML.replace(element1, element1.replace(/<(font)? color="(.*?)">(.*?)<\/\1>/g, '[color=$2]$3[/color]'))
                    } else if(elementMain.trim().split(':')[0] == 'style="font-size') {
                        textHTML = textHTML.replace(element1, element1.replace(/<(font)? style="font-size: (.*?)">(.*?)<\/\1>/g, '[size=$2]$3[/size]'))
                    }
                });
            }
            break;
        case 'div':
            matches = textHTML.match(/<(div)=?(.*?)>(.*?)<\/\1>/g);
            if(matches != undefined) {
                matches.forEach(element1 => {
                    let elementMain = element1.replaceAll(/<(div)=?(.*?)>(.*?)<\/\1>/g, "$2");
                    if(elementMain == undefined) {
                        textHTML = textHTML.replace(element1, element1.replace(/<(div)=?(.*?)>(.*?)<\/\1>/g, '$3'));
                    } else if(elementMain.trim() == "") {
                        textHTML = textHTML.replace(element1, element1.replace(/<(div)=?(.*?)>(.*?)<\/\1>/g, '$3'));
                    } else if(elementMain.trim() == 'align="center"') {
                        textHTML = textHTML.replace(element1, element1.replace(/<(div)? align="(.*?)">(.*?)<\/\1>/g, '[center]$3[/center]'))
                    }
                    
                });
            }
            break;
        case 'span':
            matches = textHTML.match(/<(span)=?(.*?)>(.*?)<\/\1>/g);
            if(matches != undefined) {
                matches.forEach(element1 => {
                    let elementMain = element1.replaceAll(/<(span)=?(.*?)>(.*?)<\/\1>/g, "$2");
                    if(elementMain == undefined) {
                    } else if(elementMain.trim() == 'style="text-decoration: underline"') {
                        textHTML = textHTML.replace(element1, element1.replace(/<(span)? style="text-decoration: underline">(.*?)<\/\1>/g, '[u]$2[/u]'))
                    }
                });
            }
            break;
        case 'img':
            matches = textHTML.match(/\[(color)=?(.*?)\](.*?)\[\/\1\]/g);
            if(matches != undefined) {
                matches.forEach(element1 => {
                    textHTML = textHTML.replace(element1, element1.replace(/\[(color)=?(.*?)\](.*?)\[\/\1\]/g, '<font color="$2">$3</font>'))
                });
            }
            break;
        case 'a':
            matches = textHTML.match(/\[(url)=?(.*?)\](.*?)\[\/\1\]/g);
            if(matches != undefined) {
                matches.forEach(element1 => {
                    textHTML = textHTML.replace(element1, element1.replace(/\[(url)=?(.*?)\](.*?)\[\/\1\]/g, '<a href="$2">$3</a>'))
                });
            }
            break;
        default:
            //console.log(`Sorry, we are out of ${element}.`);
      }
      return textHTML;
}

function create_buttons_bbcode(itemTxt) {
    // recupere l'editeur texte du bbcode dans la noeud.
    let edit = recupe_editor_bb(itemTxt);
    // creation d'une div pour l'editer en format html
    let button_b = document.createElement("button");
    let button_i = document.createElement("button");
    let button_u = document.createElement("button");

    button_b.classList.add("bbcode_b");
    button_b.classList.add("bbcode_btn");
    button_i.classList.add("bbcode_i");
    button_i.classList.add("bbcode_btn");
    button_u.classList.add("bbcode_u");
    button_u.classList.add("bbcode_btn");

    button_b.innerHTML = "<strong>B</strong>";
    button_i.innerHTML = "<em>i</em>";
    button_u.innerHTML = "<span style=\"text-decoration: underline\">U</span>";

    edit.parentNode.querySelector(".bbcode-btns").appendChild(button_b);
    edit.parentNode.querySelector(".bbcode-btns").appendChild(button_i);
    edit.parentNode.querySelector(".bbcode-btns").appendChild(button_u);
}



function replace_bb_html(textBB) {
    // verifier qu'on a du texte
    if(textBB != undefined) {
        let matchesMain = textBB.match(/\[(.*)=?(.*?)\](.*?)\[\/\1\]/g);
        while(matchesMain != undefined) {
            matchesMain.forEach(element => {
                let elementMain = element.replaceAll(/\[(.*)=?(.*?)\](.*?)\[\/\1\]/g, "$1");
                textBB = replace_value_bb_html(elementMain, textBB);
            });
            matchesMain = textBB.match(/\[(.*)=?(.*?)\](.*?)\[\/\1\]/g);
        }
        let text_out = "";
        textBB.split("\n").forEach(element => {
            if(element.trim() != "") {
                text_out += "<div>"+element+"</div>";
            } else {
                text_out += "<div><br/></div>";
            }
        });
        // retourne le texte html
        return text_out;
    }
    return "";
}

function replace_html_bb(textHTML) {
    // verifier qu'on a du texte
    if(textHTML != undefined) {
        let matchesMain = textHTML.match(/<(.*)=?(.*?)>(.*?)<\/\1>/g);
        while(matchesMain != undefined) {
            matchesMain.forEach(element => {
                let elementMain = element.replaceAll(/<(.*)=?(.*?)>(.*?)<\/\1>/g, "$1");
                textHTML = replace_value_html_bb(elementMain, textHTML);
            });
            //textHTML = replace_html_bb0(textHTML);
            matchesMain = textHTML.match(/<(.*)=?(.*?)>(.*?)<\/\1>/g);
        }
        // retourne le texte html
        return textHTML.replaceAll("<br>", "\n\n");
    }
    return "";
}

/**
 * Le tableau de valeur du bbcode et sa conversion
 * 
 * @returns tableau du bbcode et sa conversion.
 */
function tab_values() {
    return [
        tags.split("|"),
        tags_html.split("|")
    ]; 
}

/**
 * Recuperer le noeud du texte avec bbcode
 * 
 * @param {*} itemTxt le noeud de depart (pour aller au noeud parent)
 * @returns le noeud du texte avec bbcode
 */
function recupe_editor_bb(itemTxt) {
    let edit = undefined;
    itemTxt.parentNode.querySelectorAll('.editor_bbcode').forEach(function(item) {
        edit = item;
    });
    return edit;
}

/**
 * Recuperer le noeud du texte avec html
 * 
 * @param {*} itemTxt le noeud depart (pour aller au noeud parent)
 * @returns le noeud du texte avec html
 */
function recupe_editor_html(itemTxt) {
    let edit = undefined;
    itemTxt.parentNode.querySelectorAll('.editor_html_bbcode').forEach(function(item) {
        edit = item;
    });
    return edit;
}

/**
 * Recuperer le noeud qui contient l'affichage (bbcode ou html)
 * 
 * @param {*} itemTxt le noeud depart (pour aller au noeud parent)
 * @returns le noeud qui contient l'affichage (bbcode ou html)
 */
function recupe_editor_type(itemTxt) {
    let edit = undefined;
    itemTxt.parentNode.querySelectorAll('.bbcode_type').forEach(function(item) {
        edit = item;
    });
    return edit;
}

/**
 * Modifier le texte de bbcode en html ou inversement.
 * 
 * @param {*} chaine le texte a modifier
 * @param {*} edit_type type d'affichage
 * @returns retourne le texte modifie
 */
function conversion_bbcode(chaine, edit_type) {
    // recupere la table avec les clee et valeur html du bbcode
    let allTab = tab_values();
    // recupere les tableau pour faire la modification de html a texte
    let tabFrom = allTab[1];
    let tabTo = allTab[0];
    // si on est sur l'editeur texte
    if(edit_type.value == "txt") {
        // recupere les tableau pour faire la modification de texte a html
        chaine = replace_bb_html(chaine);
        /*tabFrom = allTab[0];
        tabTo = allTab[1];*/
    }
    // on remplace les valeurs de bbcode dans le texte
    /*for(let i=0; i < tabFrom.length; i++) {
        chaine = chaine.replaceAll(tabFrom[i], tabTo[i]);
    }*/
    // on retourne le texte modifie
    return chaine;
}

/**
 * Mettre en place le texte dans l'autre editeur (texte ou html)
 * 
 * @param {*} edit l'editeur de texte ou html
 */
function display_text(edit) {
    // recupere le type de format
    let edit_type = recupe_editor_type(edit);
    // recupere l'editeur de texte pour modificer son texte
    let editModif = recupe_editor_bb(edit);
    // si on est sur l'affichage texte
    if(edit_type.value == "txt") {
        // recupere l'editeur html pour modificer son texte
        editModif = recupe_editor_html(edit);
        // modifier son contenu a partir de celui de l'editeur de texte
        editModif.innerHTML = conversion_bbcode(edit.value, edit_type);
    } else {
        // modifier son contenu a partir de celui de l'editeur html
        editModif.value = conversion_bbcode(edit.innerHTML.replaceAll('&nbsp;', ' ').replaceAll('<div>', '').replaceAll('</div>', ''), edit_type);
    }
}

/**
 * Modifier le contenu du texte html en ajoutant du bbcode au format html
 * 
 * @param {*} edithtml l'editeur html
 * @param {*} type le type de bbcode (exemple "b" ou "title");
 */
function remplaceSelectHtml(edithtml, type) {
    // recuperation du texte selectionne dans l'editeur html
    let sel;
    if (document.getSelection) {    // all browsers, except IE before version 9
        sel = document.getSelection();
    } 
    else {
        sel = document.selection;   // Internet Explorer before version 9
    }
    // recupere les balise a placer dans le texte
    let allTab = addBalise(0, type);
    // recupere le range de selection
    // => https://fr.javascript.info/selection-range
    let range = sel.getRangeAt(0);
    // recupere le noeud de fin de selection
    let endContainer = range.endContainer;
    // new noeud non defit par defaut
    let newNode = undefined;
    // choissir le bbcode a ajouter
    if(allTab[0] == "[b]") {
        // creation du noeud pour le gras
        newNode = document.createElement("STRONG");
    } else if(allTab[0] == "[title]") {
        // creation du noeud pour le titre
        newNode = document.createElement("SPAN");
        newNode.classList.add("bb_title");
    }
    // si on a un noeud bbcode a ajouter
    if(newNode != undefined) {
        try {
            // place la selection dans le noeud du bbcode qu'on vient d'ajouter
            range.surroundContents(newNode);
        } catch(e) { alert("Action impossible.") }
    }
    // creer un range vide (emplacement sur le html)
    range = document.createRange();
    // retire la selection du html
    sel.removeAllRanges();
    // se place sur le noeud de fin de selection
    range.selectNodeContents(endContainer);
    // place le cursor a la fin de la selection
    range.collapse(false);
    sel.addRange(range);
    // se place et active l'editeur du html
    edithtml.focus();
}

/**
 * Ajouter le bbcode au texte avec ou sans selection de morceau de texte
 * 
 * @param {string} text le texte
 * @param {array} allTab tableau avec le bbcode
 * @param {interger} posStart possition de debut de selection
 * @param {interger} posEnd possition de fin de selection
 * @returns retourne le texte avec le bbcode
 */
function remplaceTxt(text, allTab, posStart, posEnd) {
    // valeur du bbcode a ajouter
    let add_start = allTab[0];
    let add_end = allTab[1];
    // valeur par defaut
    pretext = "";
    selectedtext = "";
    posttext = "";
    // si on n'a pas de selection
    if(posStart == posEnd) {
        // ajouter le bbcode
        pretext = text.substring(0,posStart);
        posttext = text.substring(posEnd,text.length);
    } else {
        // placer la selection entre les balise du bbcode
        pretext = text.substring(0,posStart);
        selectedtext = text.substring(posStart,posEnd);
        posttext = text.substring(posEnd,text.length);
    }
    // retourne le texte avec le bbcode.
    return pretext+add_start+selectedtext+add_end+posttext;
}

/**
 * On remplace le code dans une selection en conservent le contenu de la selection
 * dans un editeur de texte bbcode.
 * 
 * @param {*} edit l'editeur de texte bbcode.
 * @param {*} type le type de bbcode (exemple "b" ou "title");
 * @returns retourne le texte modifier de celui-ci
 */
function remplaceSelectText(edit, type) {
    return remplaceTxt(edit.value, addBalise(0, type), edit.selectionStart, edit.selectionEnd);
}

/**
 * Recupere un tableau avec le bbcode a placer (ou html).
 * Deux choix possibles 'b' ou 'title'.
 * 
 * @param {*} intType le numero 0 pour texte et 1 pour html;
 * @param {*} type le type de bbcode (exemple "b" ou "title");
 * @returns un tableau contenent le bbcode a ajouter ["[b]", "[/b]"]
 */
function addBalise(intType, type) {
    // recupere le tableau des valeur bbcode et html
    let allTab = tab_values();
    // le choix entre bbcode ou html
    let tab = allTab[intType];
    // si c'est b
    if(type == "b") {
        add_start = tab[2];
        add_end = tab[3];
    // si c'est le titre
    } else if(type == "t") {
        add_start = tab[4];
        add_end = tab[5];
    }
    // retourne le tableau
    return [add_start, add_end];
}

/**
 * Il integre le bbcode dans le texte bbcode et dans le html.
 * Fait tout le travail.
 * 
 * @param {*} e evenement du javascript 
 * @param {*} type le type de bbcode (exemple "b" ou "title");
 */
function bbcode_add_txt(e, type) {
    // recupere le type d'affichage du bbcode
    let edit_type = recupe_editor_type(e.target);
    // recupere l'editeur html
    let edit = recupe_editor_html(e.target);
    // si c'est l'editeur de texte
    if(edit_type.value == "txt") {
        // recupere l'editeur de texte
        edit = recupe_editor_bb(e.target);
    }
    // si on a choissi d'ajouter un contenu bbcode
    if(type !== undefined) {
        // format texte
        if(edit_type.value == "txt") {
            // on remplace son texte
            edit.value = remplaceSelectText(edit, type);
        } else {
            // on remplace son texte
            remplaceSelectHtml(edit, type);
        }
    }
    // on fait l'affichage sur les deux editeurs.
    display_text(edit);
}

/**
 * Remplace du texte bbcode en html
 * 
 * @param {*} textBB le texte bbcode
 * @returns le texte sous format html
 */
/*function replace_bb_html(textBB) {
    // verifier qu'on a du texte
    if(textBB != undefined) {
        // recupere le tableau des valeurs bbcode et html
        let tab = tab_values();
        // remplace les valeurs bbcode par celui en html
        for(i = 0; i < tab[0].length; i++) {
            textBB = textBB.replaceAll(tab[0][i], tab[1][i]);
        }
        // retourne le texte html
        return textBB;
    }
    return "";
}*/

function create_main_div_bbcode(itemTxt) {
    // recupere l'editeur texte du bbcode dans la noeud.
    let edit = itemTxt;
    // creation d'une div pour l'editer en format html
    let main = document.createElement("figure");
    main.classList.add("bbcode");
    edit.parentNode.insertBefore(main, edit);
    // creation d'une div pour l'editer en format html
    let mainBt = document.createElement("figure");
    mainBt.classList.add("bbcode-btns");
    main.appendChild(mainBt);
    main.appendChild(edit);
    create_buttons_bbcode(itemTxt);
    editor_bbcode(itemTxt);
}

/**
 * Creation des editeurs visibles dans la page a partir du html.
 * 
 * @param {*} itemTxt le noeud de du bbcode page.
 * @returns retourne le noeud de l'editeur html
 */
function editor_bbcode(itemTxt) {
    // recupere l'editeur texte du bbcode dans la noeud.
    let edit = recupe_editor_bb(itemTxt);
    // creation d'une div pour l'editer en format html
    var input = document.createElement("div");
    input.classList.add("editor_html_bbcode");
    input.style.width = edit.style.offsetWidth;
    input.style.height = edit.style.offsetHeight;
    input.contentEditable = true;
    // si l'editeur texte bbcode contient du texte, le placer dans le html
    input.innerHTML = replace_bb_html(edit.value);
    // l'ajouter a la page
    edit.parentNode.appendChild(input);
    // creation du input pour conserver le mode d'affichage (ne s'affiche pas a l'ecran)
    var inputType = document.createElement("input");
    inputType.setAttribute("type", "hidden");
    inputType.classList.add("editor_type_bbcode");
    // par defaut on le met en mode html
    inputType.value = "html";
    // on l'ajoute au noeud
    edit.parentNode.appendChild(inputType);
    // on retire l'editeur texte bbcode.
    edit.readOnly = true;
    edit.style.display = "none";
    // on recupere l'editeur html
    return recupe_editor_html(edit);
}

/**
 * On insert du gras dans le texte.
 * QU'il soit visible sur les deux editeurs (texte bbcode et html).
 * 
 * @param {*} e evenement du javascript
 */
function bbcode_bold(e) {
    // pour ne pas prendre l'adresse de l'action du formulaire.
    e.preventDefault();
    bbcode_add_txt(e, "b");
}

/**
 * On insert un titre dans le texte.
 * QU'il soit visible sur les deux editeurs (texte bbcode et html).
 * 
 * @param {*} e evenement du javascript
 */
function bbcode_title(e) {
    // pour ne pas prendre l'adresse de l'action du formulaire.
    e.preventDefault();
    bbcode_add_txt(e, "t");
}

/**
 * Si on place un texte par defaut, ou changement de contenu.
 * QU'il soit visible sur les deux editeurs (texte bbcode et html).
 * 
 * @param {*} e evenement du javascript
 */
function bbcode_change(e) {
    // pour ne pas prendre l'adresse de l'action du formulaire.
    e.preventDefault();
    bbcode_add_txt(e, undefined);
}

/**
 * On recupere la touche du clavier dans l'editeur texte bbcode.
 * 
 * @param {*} event evenement du javascript
 * @returns null
 */
function bbcode_key(event) {
    // recupere le type d'editeur d'affichage
    let edit_type = recupe_editor_type(event.target);
    // si c'est un editeur de texte bbcode
    if(edit_type.value == "txt") {
        // recupere la nom de la touche
        const nomTouche = event.key;
        // si c'est la touche 'control', on ne fait rien.
        if (nomTouche === 'Control') {
            return;
        }
        // on modifit le contenu de l'editeur
        bbcode_change(event);
    }
}

/**
 * On recupere la touche du clavier dans l'editeur html.
 * 
 * @param {*} event evenement du javascript
 * @returns null
 */
function bbcode_key_html(event) {
    // recupere l'editeur html
    let edit_type = recupe_editor_type(event.target);
    // si ce n'est pas un editeurde texte bbcode
    if(edit_type.value != "txt") {
        // recupere la nom de la touche
        const nomTouche = event.key;
        // si c'est la touche 'control', on ne fait rien.
        if (nomTouche === 'Control') {
            return;
        }
        // on modifit le contenu de l'editeur
        bbcode_change(event);
    }
}

/**
 * Si on modifit la taille de l'editeur bbcode (on modifit aussi celui du html).
 * 
 * @param {event} e evenement du javascript 
 */
function resize_bb_text(e) {
    let edit_text = e.target;
    // recupere l'editeur html
    let edit_html = recupe_editor_html(edit_text);
    edit_html.style.width = edit_text.style.offsetWidth;
    edit_html.style.height = edit_text.style.offsetHeight;
}

/**
 * Si on modifit la taille de l'editeur html (on modifit aussi celui du bbcode).
 * 
 * @param {event} e evenement du javascript 
 */
function resize_bb_html(e) {
    let edit_html = e.target;
    // recupere l'editeur bbcode
    let edit_text = recupe_editor_bb(edit_html);
    edit_text.style.width = edit_html.style.offsetWidth;
    edit_text.style.height = edit_html.style.offsetHeight;
}

/**
 * Ecouteur sur la partie bbcode (texte bbcode ou html) a partir du texte bbcode.
 */
document.querySelectorAll('.editor_bbcode').forEach(function(item) {
    // Creation de l'editeur html du bbcode et activation de celui-ci.
    itemHtml = create_main_div_bbcode(item);
    // en cas de changement dans la fenetre de l'editeur
    /*item.addEventListener('change', bbcode_change);
    itemHtml.addEventListener('change', bbcode_change);
    // si on appuis sur une touche du clavier.
    item.addEventListener('keyup', bbcode_key);
    itemHtml.addEventListener('keyup', bbcode_key_html);
    // si on change la taille de l'editeur.
    item.addEventListener('resize', resize_bb_text);
    itemHtml.addEventListener('resize', resize_bb_html);*/
});

/**
 * Le changement d'affichage
 * 
 * @param {event} e evenement du javascript 
 */
function bbcode_type(e) {
    // pour ne pas prendre l'adresse de l'action du formulaire.
    e.preventDefault();
    /* recupere les editeurs de la partir bbcode et le type d'affichage */
    let edit_html = recupe_editor_html(e.target);
    let edit_text = recupe_editor_bb(e.target);
    let edit_type = recupe_editor_type(e.target);
    /* si c'est un affichage bbcode */
    if(edit_type.value == "txt") {
        /* 
        Se placer en affichage html.
        Afficher la div du html editable et masquer le texte bbcode.
         */
        edit_html.readOnly = false;
        edit_text.readOnly = true;
        edit_html.style.display = "block";
        edit_text.style.display = "none";
        edit_type.value = "html";
    } else {
        /* 
        Se placer en affichage bbcode.
        Afficher l'editeur bbcode et masquer la div html.
         */
        edit_html.readOnly = true;
        edit_text.readOnly = false;
        edit_html.style.display = "none";
        edit_text.style.display = "block";
        edit_type.value = "txt";
    }
}

/* les boutons du bbcode */
/* pour mettre en gras */
document.querySelectorAll('.bbcode_bold').forEach(function(item) {
    item.addEventListener('click', bbcode_bold);
});

/* pour mettre un titre */
document.querySelectorAll('.bbcode_title').forEach(function(item) {
    item.addEventListener('click', bbcode_title);
});

/* pour changer l'affichage bbcode/html */
document.querySelectorAll('.bbcode_type').forEach(function(item) {
    item.addEventListener('click', bbcode_type);
});

//document.getElementById("test021").innerHTML = replace_html_bb(document.querySelector(".editor_html_bbcode").innerHTML).replaceAll("\n", "<br />");