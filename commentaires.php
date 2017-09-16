<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Un article en particulier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">

  </head>
  <body class=" bg-primary">
    <h1 class="text-white bg-warning">Mon BLOG de fifou</h1>
    <main>
      <a href="index.php" class="btn btn-warning">Retour aux articles</a>

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
      $page = intval(htmlspecialchars($_GET['page']));

      if($page == 0) {
        header('Location: commentaires.php?ID='. $_GET['ID']);
      }

    } else {
      $page = 1;
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
      <article class="card">

        <h2 class="card-header text-primary"><?= $article['titre'] ?> <br>
          <span class="date text-warning">Le <?= $article['ladate'] ?> </span>
        </h2>
        <p class="card-body"><?= $article['contenu'] ?><br>
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

        <p class="un_commentaire bg-warning text-white">
          <span style="font-style : italic;"> Le <?=$comm['ladate']?> </span> <br>
          <span style="font-weight : bolder;">
            <?=$comm['auteur']?> a écrit : <br>
          </span>
          <span style="font-size : 0.9em;">
            <?=$comm['commentaire']?>
          </span>
        </p>


        <?php
      } //ferme la boucle

      // OK fermer cette requete
      $mescomms->closeCursor();
       ?>
       <nav aria-label="...">

         <ul class="pagination">
           <li class="page-item disabled">
             <span class="page-link">PAGE </span>
           </li>
           <!-- mettre le html et la boucle pour choisir le a et la page voulu -->
           <?php
           //pour calculer le nombre de pages que je vais faire
           $nbrTotalComm = $bdd->prepare('SELECT COUNT(*) AS nb_comm FROM commentaires WHERE ID_billet = :laref');
           $nbrTotalComm->execute(array('laref'=> $idRef));

           $nbrComm = $nbrTotalComm->fetch();
           $nbrComm1 = floatval($nbrComm['nb_comm']);
           $nbrPage = ceil($nbrComm1 / 5);

           if (isset($_GET['page']) AND $_GET['page'] > $nbrPage) { // DEMANDER AUX COACHS D'EXPLIQUER CE COMPORTEMENT. reussi à debugger mais aucune idée du pourquoi du comment (rapport au ISSET)...
           header('Location: commentaires.php?ID='. $idRef);
           }

           for ($i=1; $i <= $nbrPage; $i++) {
          ?>
          <li class="page-item"><a class="page-link" href="commentaires.php?ID=<?=$idRef?>&page=<?=$i?>"><?=$i?></a></li>
          <?php
          } //close for loop
          $nbrTotalComm->closeCursor();

          ?>
          </ul>
        </nav>
      </div>

      <!-- Formulaire pour soumettre un commentaire  -->
      <form class="" action="comment_post.php" method="post">

        <h3 class="text-white">Rédiger un commentaire</h3>
        <input type="hidden" name="ID_billet" value="<?=$idRef?>"/>
        <label for="auteur" class="text-white">Votre pseudo :
          <br>
          <input type="text" name="auteur" value="">
        </label>
        <br>
        <label for="commentaire" class="text-white">Votre Message :
          <br>
          <textarea name="commentaire"></textarea>
        </label>
        <br>
        <input type="submit" name="" value="Soumettre" class="btn btn-primary bg-warning">
      </form>

    </main>

        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>
