<?php
require_once("bootstrap.php");

$templateParams["titolo"] = "Blog TW - ConArchivioAtatti";
$templateParams["nome"] = "archivio.php";
$templateParams["articolicasuali"] = $dbh->getRandomPost(2);
$templateParams["categorie"] = $dbh->getCategories();
$idarticolo = -1;
if(isset($_GET ["id"])){
    $idarticolo = $_GET ["id"]
}

$templateParams["articoli"] = $dbh->getPostsById($idarticolo);

require("template/base.php");

?>