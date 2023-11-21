<?php
require_once 'bootstrap.php';

//registrazione
if(isset($_POST["invioRegistrazione"])){
    $result = $dbh->register($_POST["emailRegistrazione"], 
        $_POST["nomeRegistrazione"], 
        $_POST["cognomeRegistrazione"], 
        $_POST["passwordRegistrazione"],
        $_POST["telefonoRegistrazione"]);
    if($result == 1){
        //registrato con successo
        //login automatico
        $_SESSION["email"] = $_POST["emailRegistrazione"];
        $_SESSION["password"] = $_POST["passwordRegistrazione"];
        $_SESSION["admin"] = 0;
    }else{
        //errore nell'inserimento nel db
        $templateParams["messaggio"] = "Si è verificato un errore nell'inserimento nel database";
    }
}

//se già loggato
if(!empty($_SESSION["email"])){
    header("location: index.php");
} else {
    $templateParams["titolo"] = "UniShirts - Registrazione";
    $templateParams["nome"] = "registrazione.php";
}

require 'template/base.php';
?>