<?php
require_once '../class/user.php';
session_start();
$user = new user();
?>



    <p>Inscription</p>
    <form method="post">
        <div class="form-group">
            <label>Login</label>
            <input type="text" class="form-control" name="login" id="login">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email">
        </div>

        <button type="submit" name="submit_register" class="btn btn-primary">Valider</button>
    </form>

<?php

if (isset($_POST['submit_register'])) {

    if ($user -> register($_POST['login'], $_POST['password'], $_POST['email'])==true){
        echo "Bonjour, votre profil à bien été crée" . "<br>";
        echo "Votre login :" . " " . $user->getLogin() . "<br>";
        echo "Votre email :" . " " . $user->getEmail() . "<br>";
        echo "Vous allez être redirigé vers la page de connexion";
        //header("Refresh: 3;url=connexion.php");
    }
    else
    {
        foreach ($user->errors as $values){
            echo $values . "<br>";
        }
    }

}
?>