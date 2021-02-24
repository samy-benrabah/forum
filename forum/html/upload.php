<?php
session_start();
try
{

    $connexion = new PDO("mysql:host=localhost;dbname=forum", 'root', '');
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//----------------------------------------------------/
    /* UPLOAD picture
    ------------------------------------------------------ */

    // Vérifie si le fichier a été uploadé sans erreur.
    if (!empty($_FILES["picture"]) && $_FILES["picture"]["error"] == 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["picture"]["name"];
        $filetype = $_FILES["picture"]["type"];
        $filesize = $_FILES["picture"]["size"];
        $id_user = $_SESSION['id'];

        // Vérifie l'extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            die("Erreur : Veuillez sélectionner un format de fichier valide.");
        }

        // Vérifie la taille du fichier - 5Mo maximum
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            die("Error: La taille du fichier est supérieure à la limite autorisée.");
        }

        // Vérifie le type MIME du fichier
        if (in_array($filetype, $allowed)) {
            // Vérifie si le fichier existe avant de le télécharger.
            if (file_exists("../upload/" . $_FILES["picture"]["name"])) {
                echo $_FILES["picture"]["name"] . " existe déjà.";

            } else {
                //  Déplace un fichier téléchargé
                move_uploaded_file($_FILES["picture"]["tmp_name"], "../upload/" . $_FILES["picture"]["name"]);
                //var_dump($_FILES);
                echo "Votre fichier a été téléchargé avec succès.";

                $file_path_picture = "../upload/" . $_FILES["picture"]["name"];

                // "UPDATE utilisateurs SET picture='$file_path'"; //ajouter id utilisateur
                $update_cov = "UPDATE utilisateurs SET avatar=:avatar WHERE id= $id_user ";
                $update_picture = $connexion->prepare($update_cov);
                $update_picture->bindParam('avatar', $file_path_picture, PDO::PARAM_STR);
                //$update_pic->bindParam(':id',$id_user, PDO::PARAM_INT);
                $update_picture->execute();
                $_SESSION['avatar'] = $file_path_picture;
                header('location:profil.php');
            }
        } else {
            echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
        }
    } else {
        echo "Error: " . $_FILES["picture"]["error"];
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
