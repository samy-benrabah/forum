<?php
session_start();
require_once '../class/user.php';
require_once '../class/admin.php';

$user = new user();
$admin = new admin();

var_dump($_GET['id']);
var_dump($_SESSION['status']);
var_dump($_SESSION['login']);

if($user->afficherProfil($_GET['id'])==true)
{
    echo "<div>" . "Login: " . $user->user_info[0]['login'] . "<br>";
    echo "Email: " . $user->user_info[0]['email'] . "<br>";
    echo "Statut :" . $user->user_info[0]['status'] . "<br>";
    echo "Date d'inscritpion :" . $user->user_info[0]['date_inscription'] . "<br>" . "</div>";
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

