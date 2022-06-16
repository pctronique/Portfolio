<?php
/**
 * Pour ajouter ou modifier un parcours.
 */

/* demarrer la session */
session_start();

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST)) {

    /* inclure des fonctionnalites à la page */
    include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';
    include_once dirname(__FILE__) . '/../../../src/class/Error_Log.php';
    
    /* creation de la variable pour connaitre le type de parcours */
    $type = "exp";
    
    /* creation d'un tableau avec les valeurs de recuperation du post */
    $values = array(
                ":title_parcours" => "",
                ":nom_parcours" => "",
                ":date_debut_parcours" => 0,
                ":in_progress_parcours" => 0,
                ":date_fin_parcours" => 0,
                ":lieu_parcours" => "",
                ":description_parcours" => "",
                ":entreprise_parcours" => "",
                ":display" => 0
            );

    
    /* un id a 0 par defaut, pour signaler un nouveau logo */
    $id = 0;
    /* si on a un id, modifier un logo */
    if(array_key_exists("id", $_POST) && !empty($_POST['id'])) {
        /* on recupere l'id du logo */
        $id = $_POST['id'];
        $values[":id_parcours"] = $id;
    } else {
        /* sinon on recupere l'id de l'utilisateur */
        $values[":id_user"] = $_SESSION['id_user'];
    }

    /* debut : de la recuperation des post */
    if(array_key_exists("type", $_POST) && !empty($_POST['type'])) {
        $type = $_POST['type'];
    }
    if(array_key_exists("name", $_POST) && !empty($_POST['name'])) {
        $values[":nom_parcours"] = htmlspecialchars(stripslashes(trim($_POST['name'])));
    }
    if(array_key_exists("title", $_POST) && !empty($_POST['title'])) {
        $values[":title_parcours"] = htmlspecialchars(stripslashes(trim($_POST['title'])));
    }
    if(array_key_exists("date-start", $_POST) && !empty($_POST['date-start'])) {
        $values[":date_debut_parcours"] = $_POST['date-start'];
    }
    if(array_key_exists("display", $_POST) && !empty($_POST['display'])) {
        $values[":display"] = 1;
    }
    if(array_key_exists("progress", $_POST) && !empty($_POST['progress'])) {
        $values[":in_progress_parcours"] = 1;
    }
    if(array_key_exists("date-end", $_POST) && !empty($_POST['date-end'])) {
        $values[":date_fin_parcours"] = $_POST['date-end'];
    }
    if(array_key_exists("lieu", $_POST) && !empty($_POST['lieu'])) {
        $values[":lieu_parcours"] = htmlspecialchars(stripslashes(trim($_POST['lieu'])));
    }
    if(array_key_exists("description", $_POST) && !empty($_POST['description'])) {
        $values[":description_parcours"] = htmlspecialchars(stripslashes(trim($_POST['description'])));
    }
    if(array_key_exists("entreprise", $_POST) && !empty($_POST['entreprise'])) {
        $values[":entreprise_parcours"] = htmlspecialchars(stripslashes(trim($_POST['entreprise'])));
    }
    /* fin : de la recuperation des post */

    /*Connexion*/
    $sgbd = connexion_sgbd();

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $sgbd->beginTransaction();
            /* pour verifier la validiter des informations (eviter les doublons) */
            $valide = true;
            /* verifier qu'on a bien entree un nom */
            if(empty($values[":nom_parcours"])) {
                echo "Merci d'entrer un nom.";
                $valide = false;
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* on verifit que le nom n'a pas deja ete utilise */
                $res = $sgbd->prepare("SELECT * FROM parcours WHERE nom_parcours=:nom_parcours && id_parcours!=:id_parcours");
                $res->execute([
                    ":nom_parcours" => $values[":nom_parcours"],
                    ":id_parcours" => $id
                ]);
                /* s'il est deja utilise */
                if($res->rowCount() > 0) {
                    echo "le nom est déja utilisé, merci d'en prendre un autre.";
                    $valide = false;
                }
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* si l'id n'est pas a  0 */
                if(!empty($id)) {
                    /* modifier le contenu dans la base de donnee */
                    $res1 = $sgbd->prepare("UPDATE parcours SET nom_parcours=:nom_parcours, title_parcours=:title_parcours, date_debut_parcours=:date_debut_parcours,  date_fin_parcours=:date_fin_parcours,lieu_parcours=:lieu_parcours, description_parcours=:description_parcours, in_progress_parcours=:in_progress_parcours, entreprise_parcours=:entreprise_parcours, display_parcours=:display WHERE id_parcours=:id_parcours");
                    foreach ($values as $key => $value) {
                        if(is_numeric($value)) {
                            $res1->bindValue($key, $value, PDO::PARAM_INT);
                        } else {
                            $res1->bindValue($key, $value, PDO::PARAM_STR);
                        }
                    }
                    $res1->execute();
                } else {
                    /* sinon on insert le contenu a la base de donnee */
                    $res1 = $sgbd->prepare("INSERT INTO parcours (nom_parcours, title_parcours, date_debut_parcours, date_fin_parcours, lieu_parcours, description_parcours, in_progress_parcours, entreprise_parcours, display_parcours, id_user) VALUES (:nom_parcours, :title_parcours, :date_debut_parcours, :date_fin_parcours, :lieu_parcours, :description_parcours, :in_progress_parcours, :entreprise_parcours, :display, :id_user)");
                    foreach ($values as $key => $value) {
                        if(is_numeric($value)) {
                            $res1->bindValue($key, $value, PDO::PARAM_INT);
                        } else {
                            $res1->bindValue($key, $value, PDO::PARAM_STR);
                        }
                    }
                    $res1->execute();
                    /* recupere son id */
                    $id = $sgbd->lastInsertId();
                }
                /* si on a l'id du parcours */
                if(!empty($id)) {
                    /* supprimer le parcours dans les deux bases */
                    $res = $sgbd->prepare("DELETE FROM experiences WHERE id_parcours=:id_parcours");
                    $res->execute([":id_parcours" => $id]);
                    $res = $sgbd->prepare("DELETE FROM formations WHERE id_parcours=:id_parcours");
                    $res->execute([":id_parcours" => $id]);
                    /* introduire le parcours dans la bonne base */
                    if($type == "exp") {
                        $res = $sgbd->prepare("INSERT INTO experiences (id_parcours) VALUES (:id_parcours)");
                        $res->execute([":id_parcours" => $id]);
                    } else if($type == "forma") {
                        $res = $sgbd->prepare("INSERT INTO formations (id_parcours) VALUES (:id_parcours)");
                        $res->execute([":id_parcours" => $id]);
                    }
                }
                echo "true";
            }
            /* on transmets les commits sous format securise */
            $sgbd->commit();
        } catch (Exception $e) {
            /* sauvegarde le message d'erreur dans le fichier "errors.log" */
            $error_log = new Error_Log();
            $error_log->addError($e);
            echo "Désolé, une erreur c'est produite lors du téléchargement de la page.";
        }
    }

} else {
    header("Status: 403");
}