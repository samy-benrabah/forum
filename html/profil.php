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
    <form method="get" class="header-search-box">
        <input autocomplete="off" type="search" name="search" class="header-search-input" placeholder="Recherche">
        <i class="fas fa-search"></i>
    </form>
</header>
<main>

<?php
    if($user->afficherProfil($_GET['id'])==true)
    {
        echo "<div>" . "Login: " . $user->user_info[0]['login'] . "<br>";
        echo "Email : " . $user->user_info[0]['email'] . "<br>";
        echo "Statut : " . $user->user_info[0]['status'] . "<br>";
        echo "Date d'inscription : " . $user->user_info[0]['date_inscription'] . "<br>" . "</div>";
        echo "Nombre de messages envoyés : " . $user->nbmessages($_SESSION['id']) . "<br>";
    };

    if ($_SESSION['status']=='admin')
    {
?>
    <label for="modif_status">Modifier le statut du membre</label>
    <form method="post" name="modif_profil" id="modif_profil">
        <select name="modif_status" id="modif_status">
            <option></option>
            <option>Membre</option>
            <option value="mod">Modérateur</option>
            <option value="admin">Administrateur</option>
        </select><br>
        <input type="submit" value="Valider" name="submit_change_status" id="submit_change_status">
    </form>
<?php
if (isset($_POST['submit_change_status']))
{
    $admin->changeStatus($_POST['modif_status'], $_GET['id']);
    echo "Le statut à bien été modifié";
}
?>
    <form method="post">
        <input type="checkbox" name="delete_profile" id="delete_profile"> Supprimer le profil </input>
        <input type="submit" value="Valider" name="submit_delete_user" id="submit_delete_user">

<?php
if (isset($_POST['submit_delete_user']))
{
    echo "Etes-vous sûr de vouloir supprimer le profil? (le profil ne pourra pas être récuperé ulterierement)" . "<br>";
    echo "<input type='checkbox' value='check_delete' name='check_delete' id='check_delete'> Oui, je confirme <input type='submit' value='valider' name='confirm_delete' id='confirm_delete'>";
    var_dump($_GET['id']);
}
if (isset($_POST['confirm_delete']))
{
    if (isset($_POST['check_delete'])) {
        var_dump($_POST['check_delete']);
        var_dump($_POST['confirm_delete']);
        //$admin->deleteUser($_GET['id']);
        echo "le profil a été supprimé";
    }
}
}?>
    </form>
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

