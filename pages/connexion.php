<?php

require_once '../class/user.php';
session_start();
$user = new user();

if (isset($_COOKIE['mail']))
{
    echo "Vous êtes déjà connecté" . "<br>";
    echo "<button><a href='logout.php'>Se déconnecter</a></button>";
}
else
{
?>
    <p>Connexion</p>
    <form method="post">
    <div class="form-group">
        <label>Login</label>
        <input type="text" class="form-control" name="login" id="login">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    </div>
    <button type="submit" name="submit_connect" class="btn btn-primary">Valider</button>
    <input type="checkbox" name="souvenir">Se souvenir de moi</input>
    </form>

    <?php
    if (isset($_POST['submit_connect']))
    {
        if ($user -> connect($_POST['login'], $_POST['password'])==true) {
            $_SESSION['login'] = $user->getLogin();
            $_SESSION['id'] = $user->getId();
            $_SESSION['status'] = $user->getStatus();
            var_dump($_SESSION['status']);
            echo "Bonjour" . " " . $user->getLogin() . " " . "vous êtes connecté" . "<br>";
            echo "Vous allez être automatiquement redirigé vers l'accueil, sinon cliquez " . "<a href='../index.php'>ici</a>";
            //header('Refresh: 3; url=../index.php');
            if (isset($_POST['souvenir'])) {
                setcookie('mail', $user->getEmail(), time() + 3600, '/');
            }
        } else
        {
        foreach ($user->errors as $values){
            echo $values . "<br>";
        }
        }
}
}
?>


