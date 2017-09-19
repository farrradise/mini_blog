<?php

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$pseudo = htmlspecialchars($_POST['auteur']);
$message = htmlspecialchars($_POST['commentaire']);
$id = htmlspecialchars($_POST['ID_billet']);


if (isset($_POST['commentaire']) AND isset($_POST['auteur']) AND $pseudo != "" AND $message != "") {

$enregistrerComm = $bdd->prepare('INSERT INTO commentaires (auteur, ID_billet, commentaire, date_commentaire) VALUES (?, ?, ?, NOW())');
$enregistrerComm->execute(array($pseudo, $id, $message));
$enregistrerComm->closeCursor();

} else {
  echo "<h1> ERREUR 404 PAGE NOT FOUND </h1>";
}

// Puis rediriger vers minichat.php comme ceci :
header('Location: commentaires.php?ID='.$id);


?>
