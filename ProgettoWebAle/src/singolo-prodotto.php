<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "UniShirts - Singolo Prodotto";
$templateParams["nome"] = "prodotto.php";
//Home Template

$templateParams["taglie"] = $dbh->getSizes();
$templateParams["js"] = array("js/jquery-1.11.3.min.js","js/singolo-prodotto.js");

$id = 1;
if(isset($_GET["idMaglia"])){
    $id = $_GET["idMaglia"];
}
$templateParams["maglia"] = $dbh->getProductById($id)[0];

if(isset($_POST["cambioTaglia"])){

    $taglia = $_POST["taglia"];
    $maglia = $templateParams["maglia"];
    
    $idMaglia = $dbh->getProductBySize($maglia["idGenere"], $maglia["idColore"], $maglia["idModello"], $taglia)[0];
    $templateParams["maglia"] = $dbh->getProductById($idMaglia["idMaglia"])[0];
    header("location: singolo-prodotto.php?idMaglia=".$idMaglia["idMaglia"]);
}

$templateParams["colori"] = $dbh->getColorsByModel($templateParams["maglia"]["idModello"], $templateParams["maglia"]["idGenere"], $templateParams["maglia"]["taglia"]);

if(isset($_POST["cambioColore"])){

    $colore = $_POST["colore"];
    $maglia = $templateParams["maglia"];

    $idMaglia = $dbh->getProductBySize($maglia["idGenere"], $colore, $maglia["idModello"], $maglia["taglia"])[0];
    $templateParams["maglia"] = $dbh->getProductById($idMaglia["idMaglia"])[0];
    header("location: singolo-prodotto.php?idMaglia=".$idMaglia["idMaglia"]);
}

if(isset($_POST["aggiungi"])){
    if(isset($_GET["idMaglia"])){
        $idMaglia = $_GET["idMaglia"];

        if(isset($_POST["quantità"])){
            $quantità = $_POST["quantità"];
            $aggiunte = 0;

            if(isset($_POST["nomePersonalizzato"]) && !empty($_POST["nomePersonalizzato"])){
                $nome = $_POST["nomePersonalizzato"];
                $aggiunte = $aggiunte + 5;
            } else {
                $nome = NULL;
            }

            if(isset($_POST["numeroPersonalizzato"]) && !empty($_POST["numeroPersonalizzato"])){
                $numero = $_POST["numeroPersonalizzato"];
                $aggiunte = $aggiunte + 5;
            } else {
                $numero = NULL;
            }

            $costoUnitario = $dbh->getProductById($idMaglia)[0]["prezzo"];
            $costo = $quantità * ($costoUnitario + $aggiunte);
            
            if(isset($_SESSION["email"])){
                $dbh->addToCart($idMaglia, $_SESSION["email"], $quantità, $nome, $numero, $costo);
            } else {
                //se non è loggato ci salviamo i valori in una variabile di session
                $nuovaRiga = array("idMaglia"=>$idMaglia,
                    "quantità"=>$quantità,
                    "nome"=>$nome,
                    "numero"=>$numero,
                    "costo"=>$costo);
                if(isset($_SESSION["cart"])){
                    array_push($_SESSION["cart"], $nuovaRiga);
                } else {
                    $_SESSION["cart"] = array($nuovaRiga);
                }
                header("location: login.php");
            }
        }
    }
}

require 'template/base.php';
?>