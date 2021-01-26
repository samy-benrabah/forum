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
<main class="message-global">
    <div class="full-message">
<div class="affich_message">
<div class="titre-topic">
        <h1><?php echo $messages->titreConversation($_GET['id_conversation'])?></h1>
    </div>
    <div class="titre-sujet">
        <h2> Messages</h2>
    </div>
    <div class="table_message">
<table>
    <?php
    if($messages->afficherMessage($_GET['id_conversation'])==true)
    {
        $messages->setidConversation($_GET['id_conversation']);
        for ($i=0; isset($messages->allresult_messages[$i]); $i++){
            $login = $messages->allresult_messages[$i]['login'];
            $id = $messages->allresult_messages[$i]['id_utilisateur'];
            $id_message=$messages->allresult_messages[$i]['id'];
            echo "<tr class='tr_message'>" . "<td class='td_contenu'>" . "Par: " . "<a href='profil.php?id=$id'>" . $login . "</a>" . "</td>";
            echo "<td class='td_contenu'>" . $messages->allresult_messages[$i]['titre'] . "</td>";
            echo "<td class='td_message'>" . $messages->allresult_messages[$i]['message'] . "</td>";
            echo "<td class='td_contenu'>" . "Le: " . $messages->allresult_messages[$i]['date'] . "</td>";
            echo "<td class='td_contenu'>" . "<form method='post'>" . "<input type='submit' name='like=$id_message' id='like=$id_message' value='J`aime'>" . $messages->afficherlike($id_message) . "<input type='submit' name='dislike=$id_message' id='dislike=$id_message' value='Je n`aime pas'>" . $messages->afficherdislike($id_message) . "</form>" . "</td>";
            if (isset($_POST["like=$id_message"]))
            {
                if ($messages->ajouterlike($id_message, $_SESSION['id'])==true)
                {
                    echo "like ajoute";
                }
                else echo "deja vote";
            }
            if (isset($_POST["dislike=$id_message"]))
            {
                if ($messages->ajouterdislike($id_message, $_SESSION['id'])==true)
                {
                    echo "dislike ajoute";
                }
                else echo "deja vote";
            }
            if ($_SESSION['status']=='admin') {
                echo "<td class='td_contenu'>" . "<form method='post'>" . "<input type='submit' name='supp=$id_message' id='supp=$id_message' value='supp. message'>" . "</form>" . "</td>";
                if (isset($_POST["supp=$id_message"])){
                    $messages->supprimerMessage($id_message);
                }
            }
        } echo "</tr>";
    }?>
</table>
</div>
    </div>
        <div class="formulaire_message">
<form action="" method="post">

        <div class="titre-topic">
            <h1>Ajouter message</h1>
        </div>
        <div class="ajout-message">
            <label for="ajout-message">Titre : </label>
            <input type="text" name="titre_message">
       </div>

        <div class="ajout-message">
            <label for="ajout-message">Texte:</label>
            <input type="text" name="text_message">
        </div>
    <?php
    if (isset($_POST['submit_message']))
    {
        if (!empty(trim($_POST['titre_message'])) || !empty(trim($_POST['text_message'])))
            {
                $date = date('Y-m-d H:i:s');
                $id_conversation = $messages->getidConversation();
                $messages->ajouterMessage($_POST['titre_message'], $_POST['text_message'], $id_conversation, $_SESSION['id'], $_SESSION['login']);
            } else echo "Merci de compléter les champs titre et message";
    }?>
    <div class="button-topic">
        <input class="button-topic" name="submit_message" type="submit" value="Ajouter">
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
