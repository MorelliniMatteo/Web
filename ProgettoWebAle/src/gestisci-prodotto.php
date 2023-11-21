<?php
require_once 'bootstrap.php';

if(empty($_SESSION["email"]) || 
    !$_SESSION["admin"] ||
    !isset($_GET["action"]) || 
    ($_GET["action"]!=1 && $_GET["action"]!=2 && $_GET["action"]!=3) || 
    ($_GET["action"]!=1 && !isset($_GET["id"]))){
    header("location: login.php");
}

if($_GET["action"]!=1){
    $risultato = $dbh->getProductById($_GET["id"]);
    if(count($risultato)==0){
        $templateParams["maglia"] = -1;
    }
    else{
        $templateParams["maglia"] = $risultato[0];
    }
}


$templateParams["titolo"] = "UniShirts - Gestisci prodotto";
$templateParams["nome"] = "gestione-maglia.php";

$templateParams["azione"] = $_GET["action"];

require 'template/base.php';
?>