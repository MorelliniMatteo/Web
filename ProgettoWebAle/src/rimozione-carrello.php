<?php
require_once 'bootstrap.php';

//se arrivato a questa pagina per errore
if(empty($_SESSION["email"]) || 
    $_SESSION["admin"] ||
    !isset($_GET["idRiga"])){
    header("location: index.php");
}

$result = $dbh->removeFromCart($_GET["idRiga"]);
if($result==1){
    $msg = "Prodotto rimosso dal carrello correttamente";
} else {
    $msg = "Errore nella rimozione dal db!";
}

header("location: carrello.php?msg=".$msg);
?>