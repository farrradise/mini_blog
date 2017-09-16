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
        /*display: flex;*/
        /*flex-flow: colum;*/
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

    //securise get
    // verif get pas vide
    if (empty($_GET['ID'])) {
      header('Location: index.php');
    }

    if (isset($_GET['page'])) {
      $page = htmlspecialchars($_GET['page']);
    } else {
      $page = "";
    }

    $idRef = htmlspecialchars($_GET['ID']);



    $monarticle = $bdd->prepare('SELECT ID, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %H:%i\') AS ladate FROM billets WHERE ID = :id') or die(print_r($bdd->errorInfo()));
    $monarticle->execute(array('id' => $idRef));

    $article = $monarticle->fetch();

        //condition qui vérifie si article vaut faux ou vrai, si faux cela signifie que l'article n'est pas dans la base de données et qu'on essaie d'ajouter une information via URL
        if (!$article) {
        ?>

        <h2> Ce billet n'existe pas ou plus </h2>

        <?php
        } // ferme la condition qui vérifie que l'article n'existe pas
        else {
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
      $mescomms = $bdd->prepare('SELECT ID_billet, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %H:%i\') AS ladate FROM commentaires WHERE ID_billet = :id ORDER BY ladate DESC LIMIT :debut, :nombre') or die(print_r($bdd->errorInfo()));
      // OK identifier le ID pour savoir quels commentaires afficher

      // pour savoir quelle page des commentaires afficher
       $premier_comm = 0;
       $nombre_comm = 5;
       $mescomms->bindParam(':id', $idRef, PDO::PARAM_INT);
       $mescomms->bindParam(':nombre', $nombre_comm, PDO::PARAM_INT);

      if ($page == '1' OR empty($page)) {

      $premier_comm = 0;
      $mescomms->bindParam(':debut', $premier_comm, PDO::PARAM_INT);
      $mescomms->execute();

      }  else {
        // OK faire une boucle for qui verifiera la condition si $j nest pas egal à $page on ajoute +5 à $premier_comm
        for ($j=2 ; $j<= $page; $j++) {
          $premier_comm+= 5;
          if ($j == $page) {
            $mescomms->bindParam(':debut', $premier_comm, PDO::PARAM_INT);
            $mescomms->execute();
          }
        }
      }

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

      // OK fermer cette requete
      $mescomms->closeCursor();
       ?>
       <p>Page :
         <!-- mettre le html et la boucle pour choisir le a et la page voulu -->
         <?php
         //pour calculer le nombre de pages que je vais faire
         $nbrTotalComm = $bdd->prepare('SELECT COUNT(*) AS nb_comm FROM commentaires WHERE ID_billet = :laref');
         $nbrTotalComm->execute(array('laref'=> $idRef));

         $nbrComm = $nbrTotalComm->fetch();
         $nbrComm1 = floatval($nbrComm['nb_comm']);
         $nbrPage = ceil($nbrComm1 / 5);
         for ($i=1; $i <= $nbrPage; $i++) {
        ?>
        <a href="commentaires.php?ID=<?=$idRef?>&page=<?=$i?>"><?=$i?></a>
        <?php
        } //close for loop
        $nbrTotalComm->closeCursor();

        ?>
       </p>
      </div>

      <!-- Formulaire pour soumettre un commentaire  -->
      <form class="" action="comment_post.php" method="post">

        <h3>Rédiger un commentaire</h3>
        <input type="hidden" name="ID_billet" value="<?=$idRef?>"/>
        <label for="auteur"><input type="text" name="auteur" value=""></label> <br>
        <label for="commentaire"><textarea name="commentaire" rows="8" cols="80"></textarea></label><br>
        <input type="submit" name="" value="Soumettre">
      </form>

    </main>

  </body>
</html>
