<?php
require_once 'bootstrap.php';

//se non loggato o admin
if(empty($_SESSION["email"]) || 
    $_SESSION["admin"]){
    header("location: login.php");
}

//Base Template
$templateParams["titolo"] = "UniShirts - Carrello";
$templateParams["nome"] = "carrello.php";
//Home Template
$templateParams["maglie"] = $dbh->getProductsInCart($_SESSION["email"]);
if(isset($_GET["msg"])){
    $templateParams["messaggioCarrello"] = $_GET["msg"];
}

if(isset($_POST["acquista"])){
    //eventuali controlli sui valori

    //controllo che ci sia qualcosa nel carrello
    if(count($templateParams["maglie"]) == 0){
        $msg = "il carrello è vuoto, nulla da acquistare!";
    }else{
        //controllo che i prodotti siano ancora disponibili
        $ok = true;
        foreach($templateParams["maglie"] as $maglia){
            $id = $maglia["idMaglia"];
            $result1 = $dbh->stock($id);
            $n = $dbh->numberOfProductInCart($id, $_SESSION["email"]);
            if(count($result1) == 0){
                $msg = "Maglie non trovate nel db";
                break;
            } else {
                $disp = $result1[0]["dispMagazzino"];
                if($disp < $n){
                    $magliaNonDisponibile = $dbh->getProductById($id)[0];
                    $msg = $magliaNonDisponibile["modello"]." ".$magliaNonDisponibile["colore"]." ".$magliaNonDisponibile["genere"]." ".$magliaNonDisponibile["taglia"]." Non è più disponibile in quella quantità!";
                    $ok = false;
                    break;
                }
            }
        }
        if($ok){
            //eseguo l'ordine
            $error = $dbh->executeOrder($_SESSION["email"]);
            if($error){
                $msg = "Errore nel pagamento!";
            }else{
                $msg = "Acquisto completato con successo!";
            }
        }
    }
    $templateParams["messaggio"] = $msg;
}

require 'template/base.php';
?>