<?php
$coordonnees = array (
    'admin' => 'MonsieurX',
    'mdp' => 'motdepasse',
);

// pseudo bon
if (isset($_POST['admin']) AND htmlspecialchars($_POST['admin']) == $coordonnees['admin']) {
  //mot de passe bon
  if (isset($_POST['mot_de_passe']) AND htmlspecialchars($_POST['mot_de_passe']) == $coordonnees['mdp'])
  {

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Espace Administrateur</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
  </head>
  <body class="bg-primary">

    <div class="add bg-warning">
      <form class="" action="manager.php" method="post">
        <h3 class="text-white">Ajouter un article</h3>
        <label for="titre">Titre de l'article : <br><input type="text" name="titre" value=""></label>
        <label for="message">Contenu de l'article : <br> <textarea name="message"></textarea></label>
        <input type="submit" name="" value="Ajouter">
      </form>
    </div>

    <div class="delete bg-warning">
      <form class="" action="manager.php" method="post">
        <h3 class="text-white">Supprimer un article</h3>
        <label for="choixarticle"> Titre de l'article :
          <br>
          <select class="" name="choixarticle">

            <!-- mettre autant d'option que de titre -->
            <!-- relier la table article de la base de données  -->
            <!-- je fais un boucle pour qu'on mette une option avec en value le tour de boucle et en vraie valeur le titre trouvé  -->
            
          </select>

        </label>
        <input type="submit" name="" value="Supprimer">
      </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>

<?php


  } else {
    // le mot de passe est mauvais
    header('Location: index.php');
  }
}

// Le pseudo est mauvais
else
{
  header('Location: index.php');
}

?>
