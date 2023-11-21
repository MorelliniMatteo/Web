<?php
require_once 'bootstrap.php';

if(empty($_SESSION["email"]) || 
    !$_SESSION["admin"] || 
    !isset($_POST["action"])){
    header("location: login.php");
}

if($_POST["action"]==1){
    //Inserisco
    $taglia = htmlspecialchars($_POST["taglia"]);

    list($result1, $msg1) = uploadImage(UPLOAD_DIR, $_FILES["immagineFronte"]);
    list($result2, $msg2) = uploadImage(UPLOAD_DIR, $_FILES["immagineRetro"]);
    if($result1 != 0 &&
        $result2 != 0){
        $imgFronte = $msg1;
        $imgRetro = $msg2;
        $id = $dbh->insertProduct($_POST["modello"], $_POST["colore"], $taglia,
            $_POST["genere"], $_POST["dispMagazzino"], $_POST["prezzo"],
            $imgFronte, $imgRetro);
        if($id!=false){
            $msg = "Inserimento completato correttamente!";
        }
        else{
            $msg = "Errore durante l'inserimento nel db!";
        }
            
    } else {
        $msg = "Errore nel caricamento delle immagini!";
    }
    header("location: login.php?formmsg=".$msg);
}

if($_POST["action"]==2){
    //modifico
    $taglia = htmlspecialchars($_POST["taglia"]);

    if(isset($_FILES["immagineFronte"]) && strlen($_FILES["immagineFronte"]["name"])>0){
        list($result, $msg) = uploadImage(UPLOAD_DIR, $_FILES["immagineFronte"]);
        if($result == 0){
            header("location: login.php?formmsg=".$msg);
        }
        $immagineFronte = $msg;
    }
    else{
        $immagineFronte = $_POST["oldImmagineFronte"];
    }

    if(isset($_FILES["immagineRetro"]) && strlen($_FILES["immagineRetro"]["name"])>0){
        list($result, $msg) = uploadImage(UPLOAD_DIR, $_FILES["immagineRetro"]);
        if($result == 0){
            header("location: login.php?formmsg=".$msg);
        }
        $immagineRetro = $msg;
    }
    else{
        $immagineRetro = $_POST["oldImmagineRetro"];
    }

    $result = $dbh->updateProduct($_POST["idMaglia"], $_POST["prezzo"], $taglia, $immagineFronte, $immagineRetro, $_POST["dispMagazzino"]);
    if($result == 1){
        $msg = "Modifica completata correttamente!";
    } else {
        $msg = "Non c'è stata alcuna modifica! potrebbe esserci stato un errore...";
    }
    header("location: login.php?formmsg=".$msg);
}

if($_POST["action"]==3){
    //cancello
    $result = $dbh->removeProduct($_POST["idMaglia"]);
    if($result == 1){
        $msg = "Cancellazione completata correttamente!";
    } else {
        $msg = "Errore nella cancellazione!";
    }
    header("location: login.php?formmsg=".$msg);
}

?>