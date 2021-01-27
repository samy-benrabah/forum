<?php
session_start();
$bdd = new PDO('mysql:dbname=forum;host=localhost', "root", "");
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
<main class="accueil-global">

            <div class="titre-topic">
                <h1>Topics</h1>
            </div>
            <table class="table_topic">
   <?php
$articles = $bdd->query('SELECT id,nom_topic FROM topic ORDER BY id DESC');
if (isset($_GET['search']) and !empty($_GET['search'])) {

    $q = htmlspecialchars($_GET['search']);
    $articles = $bdd->query('SELECT id,nom_topic FROM topic WHERE nom_topic LIKE "%' . $q . '%" ORDER BY id DESC');
    if ($articles->rowCount() == 0) {
        $articles = $bdd->query('SELECT nom_topic FROM topic WHERE CONCAT(nom_topic, contenu) LIKE "%' . $q . '%" ORDER BY id DESC');
    }
}if ($articles != false && $articles->rowCount() > 0) {?>
<tr>
   <?php while ($a = $articles->fetch()) {
    $id_topic = $a['id'];

    echo "<td>" . "<a href='sujet.php?id_topic=$id_topic'>" . $a['nom_topic'] . "</a>" . "</td>";
}?>
</tr>
<?php } else if ($articles == false) {?>
Aucun résultat pour: <?=$q?>...
<?php }?>
</table>

</main>