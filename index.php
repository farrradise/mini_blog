<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mon mini mini mini Blog</title>
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
$mesarticles = $bdd->query('SELECT * FROM billets ORDER BY ID DESC LIMIT 0, 5') or die(print_r($bdd->errorInfo()));

//OK faire une boucle pour afficher la requete
while ($article = $mesarticles->fetch())
{
?>

<!-- mettre html -->
<article>

<h2>Y mettre mon titre d'article</h2>
<h3>Ecrit le y mettre la date  et l'heure </h3>
<p>Y mettre larticle</p>

</article>

<?php
} // fin de ma boucle while
// {
// 	echo '<li>' . $donnees['nom'] . ' (' . $donnees['prix'] . ' EUR)</li>';
// }

//OK fermer cette requete
$mesarticles->closeCursor();

// dans cette boucle y mettre le bouton commentaires pour rediriger vers page commentaires avec info de l'id de l'article dans url

?>
</main>

  </body>
</html>
