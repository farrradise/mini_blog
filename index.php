<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mon mini mini mini Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">

  </head>
  <body class="bg-primary">
    <aside class="bg-warning">
      <button class="login" type="button" name="button" data-toggle="modal" data-target="#exampleModal">
        <i class="fa fa-sign-in text-white" aria-hidden="true"></i>
      </button>

    </aside>

    <h1 class="text-white bg-warning">Mon BLOG de fifou</h1>
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
          <span class="date text-warning">Le <?= $article['ladate'] ?> </span>
        </h2>
        <p class="card-body presentation-paragraphe"><?= $article['contenu'] ?><br>
          <!-- OK dans cette boucle y mettre le bouton commentaires pour rediriger vers page commentaires avec info de l'id de l'article dans url -->
        </p>
        <a href="commentaires.php?ID=<?=$article['ID']?>" class="btn btn-warning">Lire la suite ! </a>

      </article>

    <?php
    } // fin de ma boucle while

    //OK fermer cette requete
    $mesarticles->closeCursor();


    ?>

    </main>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Se connecter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="" action="index.html" method="post">
              <label for="admin"> Administrateur  <input type="text" name="admin" value=""></label>
              <label for="mot_de_passe">Password <input type="password" name="mot_de_passe" value=""></label>
              <button type="button" class="btn btn-primary">Valider</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>
