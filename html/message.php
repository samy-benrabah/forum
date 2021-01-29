<?php
session_start();
require_once '../class/messages.php';
require_once '../class/user.php';
$messages = new messages();
$user = new user()
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
        <li><a href="accueil.php">Accueil</a></li>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="logout.php">Se déconnecter</a></li>
    </ul>
    <form method="get" class="header-search-box" action="affichage-message.php">
        <input autocomplete="off" type="search" name="search" class="header-search-input" placeholder="Recherche">
        <i class="fas fa-search"></i>
    </form>
</header>
<main class="message-global">
    <div class="full-message">
<div class="affich_message">
<div class="titre-topic">
        <h1><?php echo $messages->titreConversation($_GET['id_conversation']) ?></h1>
    </div>
    <div class="titre-sujet">
        <h2> Messages</h2>
    </div>
    <div class="table_message">
<table class="table_message_content">
    <?php
if(isset($_SESSION['login'])){
    if ($messages->afficherMessage($_GET['id_conversation']) == true) {
        $messages->setidConversation($_GET['id_conversation']);
        for ($i = 0;isset($messages->allresult_messages[$i]); $i++) {
            $login = $messages->allresult_messages[$i]['login'];
            $id = $messages->allresult_messages[$i]['id_utilisateur'];
            $id_message = $messages->allresult_messages[$i]['id'];
            $user->afficherProfil($id);
            $avatar=$user->user_info[$i]['avatar'];
            echo "<tr class='tr_message'>" . "<td class='td_contenu'>" . "Par: " . "<a href='profil.php?id=$id'>" . $login . "</a>" . "<br>" . "<div class='bloc-avatar-table' alt='avatar'>" . "<img src='$avatar'>" . "</div>" . "</td>";
            echo "<td class='td_contenu'>" . $messages->allresult_messages[$i]['titre'] . "</td>";
            echo "<td class='td_message'>" . $messages->allresult_messages[$i]['message'] . "</td>";
            echo "<td class='td_contenu'>" . "Le: " . $messages->allresult_messages[$i]['date'] . "</td>";
            echo "<td class='td_contenu'>" . "<form method='post'>" . "<button type='submit' name='like=$id_message' id='like=$id_message' ><i class='far fa-thumbs-up'></i></button>" . $messages->afficherlike($id_message) . "<button type='submit' name='like=$id_message' id='like=$id_message' ><i class='far fa-thumbs-down'></i></button>" . $messages->afficherdislike($id_message) . "</td>";
            if (isset($_POST["like=$id_message"])) {
                if ($messages->ajouterlike($id_message, $_SESSION['id']) == true) {
                    echo "like ajoute" . "</form>" . "</td>";
                } else {
                    echo "deja vote" . "</form>" . "</td>";
                }
                if (isset($_POST["dislike=$id_message"])) {
                    if ($messages->ajouterdislike($id_message, $_SESSION['id']) == true) {
                        echo "<br>" . "dislike ajoute" . "</form>" . "</td>";
                    } else {
                        echo "<br>" . "deja vote" . "</form>" . "</td>";
                    }

                }
            }
            if ($_SESSION['status'] == 'admin') {
                echo "<td class='td_contenu'>" . "<form method='post'>" . "<input type='submit' name='supp=$id_message' id='supp=$id_message' value='supp. message'>" . "</form>" . "</td>";
                if (isset($_POST["supp=$id_message"])) {
                    $messages->supprimerMessage($id_message);
                }
            }

        }
    }
} else echo "<tr>" . "<td>" . "Merci de vous connecter pour visualiser les messages" . "</td>" . "</tr>"; 

?>
</table>
</div>
    </div>
        <div class="formulaire_message">
            <form  method="post">
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
if (isset($_POST['submit_message'])) {
    if (!empty(trim($_POST['titre_message'])) || !empty(trim($_POST['text_message']))) {
        $date = date('Y-m-d H:i:s');
        $id_conversation = $messages->getidConversation();
        $messages->ajouterMessage($_POST['titre_message'], $_POST['text_message'], $id_conversation, $_SESSION['id'], $_SESSION['login']);
        header('Refresh:0');
    } else {
        echo "Merci de compléter les champs titre et message";
    }
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
