<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mon mini mini mini Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">

  </head>
  <body class="bg-primary">

    <h1 class="text-white">Mon BLOG de fifou</h1>
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
      <article class="card">

        <h2 class="card-header text-primary"><?= $article['titre'] ?> <br>
          <span>Le <?= $article['ladate'] ?> </span>
        </h2>
        <p class="card-body"><?= $article['contenu'] ?><br>
          <!-- OK dans cette boucle y mettre le bouton commentaires pour rediriger vers page commentaires avec info de l'id de l'article dans url -->
          <a href="commentaires.php?ID=<?=$article['ID']?>" class="btn btn-primary">Lire les commentaires ! </a>
        </p>

      </article>

    <?php
    } // fin de ma boucle while

    //OK fermer cette requete
    $mesarticles->closeCursor();


    ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>
