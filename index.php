<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mon mini mini mini Blog</title>
    <style media="screen">
      h1, h2
      {
        text-align:center;
      }

      h2
      {
        background-color:black;
        color:white;
        font-size:0.9em;
        position: relative;
        margin-bottom:0px;
        height: 40px;
      }

      h2 span {
        position: absolute;
        right: 0;
        color: white!important;
      }

      .news p
      {
        background-color:#CCCCCC;
        margin-top:0px;
      }
      .news
      {
        width:70%;
        margin:auto;
      }

      a
      {
        text-decoration: none;
        color: blue;
      }

      main {
        display: flex;
        flex-flow: column-reverse;
      }
    </style>
  </head>
  <body>

<h1>Mon BLOG de fifou</h1>
<main>

<?php
// OK faire requete pour lier la BDD a cette page
try
{
  $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
  die('Erreur : '.$e->getMessage());
}

//OK faire une requete pour afficher tous les articles (5 derniers orderby desc + limit)
$mesarticles = $bdd->query('SELECT ID, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %H:%i\') AS ladate FROM billets ORDER BY ID DESC LIMIT 0, 5') or die(print_r($bdd->errorInfo()));

//OK faire une boucle pour afficher la requete
while ($article = $mesarticles->fetch())
{
?>

  <!-- OK mettre html -->
  <article class="news">

    <h2><?= $article['titre'] ?> <br>
      <span>Le <?= $article['ladate'] ?> </span>
    </h2>
    <p><?= $article['contenu'] ?><br>
      <!-- OK dans cette boucle y mettre le bouton commentaires pour rediriger vers page commentaires avec info de l'id de l'article dans url -->
      <a href="commentaires.php?ID=<?=$article['ID']?>">Lire les commentaires ! </a>
    </p>

  </article>

<?php
} // fin de ma boucle while

//OK fermer cette requete
$mesarticles->closeCursor();


?>
</main>

  </body>
</html>
