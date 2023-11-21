<?php
require_once 'bootstrap.php';

if(isset($_POST["logout"])){
    session_unset();
    session_destroy();
    session_start();
}

//login
if(isset($_POST["invioLogin"])){
    if(isset($_POST["email"]) && isset($_POST["password"])){
        $login_result = $dbh->checkLogin($_POST["email"], $_POST["password"]);
        if(count($login_result)==0){
            //Login fallito
            $templateParams["messaggio"] = "Errore! Controllare email e password!";
        }
        else{
            //Login con successo
            $_SESSION["email"] = $login_result[0]["email"];
            $_SESSION["password"] = $login_result[0]["password"];
            $_SESSION["admin"] = $login_result[0]["admin"];
            //Nel caso ci siano valori nel carrello da salvare
            if(isset($_SESSION["cart"]) && !$_SESSION["admin"]){
                foreach($_SESSION["cart"] as $riga){
                    $dbh->addToCart($riga["idMaglia"],
                        $_SESSION["email"],
                        $riga["quantità"],
                        $riga["nome"],
                        $riga["numero"],
                        $riga["costo"]);
                }
            }
        }
    } else {
        $templateParams["messaggio"] = "Email o password non inserite!";
    }
}

//se già loggato
if(!empty($_SESSION["email"])){
    if($_SESSION["admin"]){
        //pagina Admin
        $templateParams["titolo"] = "UniShirts - Gestione";
        $templateParams["nome"] = "amministratore.php";
        //amministratore template
        $templateParams["ordini"] = $dbh->getLatestOrders(5);
        $templateParams["prodotti"] = $dbh->getProducts();
        if(isset($_GET["formmsg"])){
            $templateParams["messaggio1"] = $_GET["formmsg"];
        }
        if(isset($_POST["aggiungi"])){
            $result = $dbh->addToProduct($_POST["idMaglia"], $_POST["quantità"]);
            if($result != 1){
                $templateParams["messaggio2"] = "c'è stato un errore nell'aggiunta!";
            } else {
                $templateParams["messaggio2"] = "aggiunta eseguita con successo!";
            }
        }
    } else {
        //pagina utente
        $templateParams["titolo"] = "UniShirts - Utente";
        $templateParams["nome"] = "utente.php";
        //utente template
        $templateParams["ordini"] = $dbh->getOrdersOfUser($_SESSION["email"]);
    }
}
else{
    $templateParams["titolo"] = "UniShirts - Login";
    $templateParams["nome"] = "login.php";
}

//eventuale cambio password
if(isset($_POST["cambia"])){
    $pass_change_result = $dbh->changePassword($_SESSION["email"], 
        $_POST["vecchiaPassword"], 
        $_POST["nuovaPassword"]);
    if($pass_change_result==0){
        $templateParams["messaggio"] = "Errore! password non modificata!";
    } else {
        $templateParams["messaggio"] = "Password modificata con successo!";
    }
}

require 'template/base.php';
?>