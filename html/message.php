<?php
session_start();
require_once '../class/messages.php';
$messages = new messages();
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
    <div class="full-topic">
<div class="topic">
<div class="titre-topic">
        <h1><?php echo $messages->titreConversation($_GET['id_conversation'])?></h1>
    </div>
    <div class="titre-sujet">
        <h2> Messages</h2>
    </div>
    <div class="table">
<table>
    <?php
    if($messages->afficherMessage($_GET['id_conversation'])==true)
    {
        $messages->setidConversation($_GET['id_conversation']);
        for ($i=0; isset($messages->allresult_messages[$i]); $i++){
            $login = $messages->allresult_messages[$i]['login'];
            $id = $messages->allresult_messages[$i]['id_utilisateur'];
            $id_message=$messages->allresult_messages[$i]['id'];
            echo "<tr>" . "<td>" . "auteur du message: " . "<a href='profil.php?id=$id'>" . $login . "</a>" . "<br>";
            echo $messages->allresult_messages[$i]['titre'] . "<br>";
            echo $messages->allresult_messages[$i]['message'] . "<br>";
            echo "<form method='post'>" . "<input type='submit' name='like=$id_message' id='like=$id_message' value='aime'>" . $messages->afficherlike($id_message) . "<input type='submit' name='dislike=$id_message' id='dislike=$id_message' value='aime pas'>" . $messages->afficherdislike($id_message) . "</form>" ;
            echo "<form method='post'>" . "<input type='submit' name='supp=$id_message' id='like=$id_message' value='supp'>";
            if (isset($_POST["like=$id_message"]))
            {
                if ($messages->ajouterlike($id_message, $_SESSION['id'])==true)
                {
                    echo "like ajouté";
                }
                else echo "déjà voté";
            }
            if (isset($_POST["dislike=$id_message"]))
            {
                if ($messages->ajouterdislike($id_message, $_SESSION['id'])==true)
                {
                    echo "dislike ajouté";
                }
                else echo "déjà voté";
            }
        } echo "</td>" . "</tr>";
    }
    ?>
</table>
</div>

<form action="" method="get">
<div class="button-sujet">
    <input class="button-sujet" type="button" value="Ajouter">
    </div>
    </form>
    </div>
    <div class="formulaire">
    <div class="titre-topic">
        <h1>Sujets</h1>
    </div>

    <div class="login">
   <label for="login">Titre : </label>
    <input type="text" name="login">
   </div>

<div class="message">
    <label for="texte">Texte:</label>
    <input type="text" name="message">
</div>
<form action="" method="get">
<div class="button-topic">
    <input class="button-topic" type="button" value="Ajouter">
    </div>
    </form>
    </div>
    </div>
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
