<?php
function getIDFFromName($name) {
    return preg_replace("/[^a-z]/", '', strtolower($name));
}

function isUserLoggedIn(){
    return !empty($_SESSION["idautore"]);
}

?>