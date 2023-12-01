<?php
require_once("bootstrap.php");

$templateParams["titolo"] = "Blog TW - Contatti";
$templateParams["nome"] = "contatti.php";
$templateParams["articolicasuali"] = $dbh->getRandomPost(2);
$templateParams["categorie"] = $dbh->getCategories();

$templateParams["autori"] = $dbh->getPosts(2);

require("template/base.php");

?>