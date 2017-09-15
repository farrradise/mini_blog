<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Un article en particulier</title>
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

      .commentaires {
        display: flex;
        flex-flow: column-reverse;
      }
    </style>

  </head>
  <body>
    <h1>Mon BLOG de fifou</h1>
    <main>
      <a href="index.php">Retour aux articles</a>

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

    // OK identifier le ID pour savoir quel article afficher
    $idRef = $_GET['ID'];
    $monarticle = $bdd->prepare('SELECT ID, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %H:%i\') AS ladate FROM billets WHERE ID = :id') or die(print_r($bdd->errorInfo()));
    $monarticle->execute(array('id' => $_GET['ID']));
    while ($article = $monarticle->fetch())
    {
    ?>

    <!-- OK afficher l'article de l'id identifié précédemment -->
      <article class="news">

        <h2><?= $article['titre'] ?> <br>
          <span>Le <?= $article['ladate'] ?> </span>
        </h2>
        <p><?= $article['contenu'] ?><br>
        </p>

      </article>
      <?php
      }

      //OK fermer la requete d'affichage de l'article
      $monarticle->closeCursor();
       ?>

      <div class="commentaires">

      <?php

      // OK faire requete pour lier la BDD commentaire a cette page
      $mescomms = $bdd->prepare('SELECT ID_billet, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %H:%i\') AS ladate FROM commentaires WHERE ID_billet = :id') or die(print_r($bdd->errorInfo()));
      // OK identifier le ID pour savoir quels commentaires afficher
      $mescomms->execute(array('id' => htmlspecialchars($_GET['ID'])));

      // OK créer une boucle qui selectionne et affiche tous les commentaires qui possède l'id envoyé par l'url
      while ($comm = $mescomms->fetch())
      {

        ?>

        <p class="un_commentaire">
          <span><?=$comm['auteur']?> : </span> le <?=$comm['ladate']?> <br>
          <?=$comm['commentaire']?>
        </p>




        <?php
        } //ferme la boucle

        // ICI on rajoute une condition pour que si $comm est vide elle renvoie une erreur
        if (empty($comm)) {
          ?>

          <h2> Ce billet n'existe pas ou plus </h2>

          <?php
        }
      // OK fermer cette requete
      $mescomms->closeCursor();
        ?>
      </div>

      <!-- Formulaire pour soumettre un commentaire  -->
      <form class="" action="comment_post.php" method="post">

        <h3>Rédiger un commentaire</h3>
        <input type="hidden" name="ID_billet" value="<?=$idRef?>"/>
        <label for="auteur"><input type="text" name="auteur" value=""></label><br>
        <label for="commentaire"><textarea name="commentaire" rows="8" cols="80"></textarea></label><br>
        <input type="submit" name="" value="Soumettre">
      </form>

    </main>

  </body>
</html>
