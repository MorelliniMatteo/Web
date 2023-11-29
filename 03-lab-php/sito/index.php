<?php
require_once("bootstrap.php");

$templateParams["titolo"] = "Blog TW - Home";
$templateParams["nome"] = "lista-articoli.php";
$templateParams["articolicasuali"] = $dbh->getRandomPost(2);
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["articoli"] = $dbh->getPosts(2);

require("template/base.php");

?>