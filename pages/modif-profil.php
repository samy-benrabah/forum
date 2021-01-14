
<?php
session_start();
require_once '../class/user.php';
$user = new user();

$user->setId($_SESSION['id']);
$user->setLogin($_SESSION['login']);

if (isset($_POST['submit_login'])){
   if($user->login($_POST['login'],$_POST['password'])==true){
      echo "</p>" . "Le login à bien été modifié" . "<br>" . "Nouveau login:" . " " . $user->getLogin() . "</p>" . "</div>";
      $_SESSION['login']=$_POST['login'];
   }
   else
       {
       foreach ($user->errors as $values){
           echo $values . "<br>";
       }
   }
}
?>
    <form action="" method="post">
            <p><b>Votre login actuel:</b> <?php echo $user->getLogin()?></p>
            <label for="Login">Nouveau Login</label>
            <input type="text" class="form-control" name="login" id="login">
            <label for="Password">Password</label>
            <input type="password" name="password" id="password">
           <button type="submit" name="submit_login" id="submit_login" value="valider">Valider</button>
    </form>

<?php
if(isset($_POST['submit_pass'])) {
    if ($user->password($_POST['password'], $_POST['cpassword1'], $_POST['cpassword2']) == true) {
        echo "</p>" . "Le mot de passe a bien été modifié" . "</p>";
    } else {
        foreach ($user->errors as $values) {
            echo $values . "<br>";
        }
    }
}
?>
    <form action="" method="post" id="form">
        <label for="password">Entrez votre mot de passe</label>
        <input type="text" class="form-control" name="password" id="password">
        <label for="Password">Nouveau mot de passe</label>
        <input type="password" class="form-control" name="cpassword1" id="cpassword1">
        <label for="Password">Confirmez le nouveau mot de passe</label>
        <input type="password" class="form-control" name="cpassword2" id="cpassword2">
        <button type="submit" name="submit_pass" id="submit_pass" value="valider" class="btn btn-outline-primary">Valider</button>
    </form>
