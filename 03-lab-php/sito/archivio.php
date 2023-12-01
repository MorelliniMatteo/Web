<?php
require_once("bootstrap.php");

$templateParams["titolo"] = "Blog TW - ConArchivioAtatti";
$templateParams["nome"] = "archivio.php";
$templateParams["articolicasuali"] = $dbh->getRandomPost(2);
$templateParams["categorie"] = $dbh->getCategories();

$templateParams["articoli"] = $dbh->getPosts();

require("template/base.php");

?>