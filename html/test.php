<meta charset="utf-8" />
<?php

$bdd = new PDO('mysql:dbname=forum;host=localhost', "root", "");

$articles = $bdd->query('SELECT nom_topic FROM topic ORDER BY id DESC');
if (isset($_GET['q']) and !empty($_GET['q'])) {
    $q = htmlspecialchars($_GET['q']);
    $articles = $bdd->query('SELECT nom_topic FROM topic WHERE nom_topic LIKE "%' . $q . '%" ORDER BY id DESC');
    if ($articles->rowCount() == 0) {
        $articles = $bdd->query('SELECT nom_topic FROM topic WHERE CONCAT(nom_topic, contenu) LIKE "%' . $q . '%" ORDER BY id DESC');
    }
}
?>
<form method="GET">
   <input type="search" name="q" placeholder="Recherche..." />
   <button type="submit" value="Valider" /></button>
</form>
<?php if ($articles->rowCount() > 0) {?>
   <ul>
   <?php while ($a = $articles->fetch()) {?>
      <li><?=$a['nom_topic']?></li>
   <?php }?>
   </ul>
<?php } else {?>
Aucun résultat pour: <?=$q?>...
<?php }?>