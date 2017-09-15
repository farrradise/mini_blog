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
    $monarticle = $bdd->prepare('SELECT ID, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y %Hh%imin%ss\') AS ladate FROM billets WHERE ID = :id') or die(print_r($bdd->errorInfo()));
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
          <!-- OK dans cette boucle y mettre le bouton commentaires pour rediriger vers page commentaires avec info de l'id de l'article dans url -->
        </p>

      </article>
      <?php
      }
      //OK fermer la requete d'affichage de l'article
      $monarticle->closeCursor();

       ?>
      <div class="commentaires">

        <!--

        // faire requete pour lier la BDD commentaire a cette page
        // identifier le ID pour savoir quels commentaires afficher
        // créer une boucle qui selectionne et affiche tous les commentaires qui possède l'id envoyé par l'url
        // fermer cette requete
      -->

      </div>
    </main>

  </body>
</html>
