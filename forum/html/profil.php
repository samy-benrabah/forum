<?php
session_start();
require_once '../class/user.php';
require_once '../class/admin.php';

$user = new user();
$admin = new admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/218e7c5bb4.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<header>
    <div class="header-first">
        <img src="../image/logo.black.svg">
        <h1>Dev<span class="header-span-title">.Help</span></h1>
    </div>
    <ul>
        <li><a href="../index.php">Accueil</a></li>
        <li><a href="inscription.php">Inscription</a></li>
        <li><a href="connexion.php">Connexion</a></li>
        <li><a href="profil.php">Profil</a></li>
    </ul>
</header>
<main class="profil">
    <h2><u>Infos profil:</u></h2>
    <?php
if (isset($_GET['id']) || isset($_SESSION['id'])) {
    if (isset($_GET['id'])) {
        if ($user->afficherProfil($_GET['id']) == true) {
            echo "<div>" . "<p>" . "Login: " . $user->user_info[0]['login'] . "</p>" . "<br>";
            echo "<p>" . "Email : " . $user->user_info[0]['email'] . "</p>" . "<br>";
            echo "<p>" . "Statut : " . $user->user_info[0]['status'] . "</p>" . "<br>";
            echo "<p>" . "Date d'inscription : " . $user->user_info[0]['date_inscription'] . "</p>" . "<br>";
            echo "<p>" . "Nombre de messages envoyes : " . $user->nbmessages($_SESSION['id']) . "</p>" . "<br>" . "</div>";
        }
    } else {
        $user->afficherProfil($_SESSION['id']);
        echo "<div>" . "<p>" . "Login: " . $user->user_info[0]['login'] . "</p>" . "<br>";
        echo "<p>" . "Email : " . $user->user_info[0]['email'] . "</p>" . "<br>";
        echo "<p>" . "Statut : " . $user->user_info[0]['status'] . "</p>" . "<br>";
        echo "<p>" . "Date d'inscription : " . $user->user_info[0]['date_inscription'] . "</p>" . "<br>";
        echo "<p>" . "Nombre de messages envoyes : " . $user->nbmessages($_SESSION['id']) . "</p>" . "<br>" . "</div>";
    }

    if ($_SESSION['status'] == 'admin') {
        ?>
    <h2><u>Espace admin :</u></h2>
    <form method="post" name="modif_profil" id="modif_profil">
    <label class="profil" for="modif_status">Modifier le statut du membre :</label>
        <select name="modif_status" id="modif_status">
            <option></option>
            <option>Membre</option>
            <option value="mod">Modérateur</option>
            <option value="admin">Administrateur</option>
        </select><br>
        <input type="submit" value="Valider" name="submit_change_status" id="submit_change_status">
    </form>
    <?php
if (isset($_POST['submit_change_status'])) {
            $admin->changeStatus($_POST['modif_status'], $_GET['id']);
            echo "Le statut à bien été modifié";
        }
        ?>
    <form class="delete_profil" method="post">
        <input type="checkbox" name="delete_profile" id="delete_profile"> Supprimer le profil </input>
        <input type="submit" value="Valider" name="submit_delete_user" id="submit_delete_user">

    <?php
if (isset($_POST['submit_delete_user'])) {
            echo "Etes-vous sûr de vouloir supprimer le profil? (le profil ne pourra pas être récuperé ulterierement)" . "<br>";
            echo "<input type='checkbox' value='check_delete' name='check_delete' id='check_delete'> Oui, je confirme <input type='submit' value='valider' name='confirm_delete' id='confirm_delete'>";
            var_dump($_GET['id']);
        }
        if (isset($_POST['confirm_delete'])) {
            if (isset($_POST['check_delete'])) {
                var_dump($_POST['check_delete']);
                var_dump($_POST['confirm_delete']);
                $admin->deleteUser($_GET['id']);
                echo "le profil a été supprimé";
            }
        }
    }
    ?>
        </form>
    <div class="bloc-avatar">
        <img src="<?=$_SESSION['avatar']?>" alt="picture">
        <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="picture" >
        <input type="submit" name ="upload" value="Upload">
    </div>
<?php
} else {
    echo "Merci de vous connecter avant de consulter le profil";
}

?>
</main>
<footer>
    <section>
        <p>Copyright &copy All right reserved</p>
        <div class="footer-link-1">
            <a href="">Facebook</a>
            <a href="">GitHub</a>
            <a href="">Twitter</a>
        </div>
        <div class="footer-link-2">
            <a href="">Connexion</a>
            <a href="">Inscription</a>
        </div>
    </section>
</footer>
</body>
</html>

