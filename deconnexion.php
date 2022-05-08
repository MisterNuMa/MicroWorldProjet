<?php
    include_once('includes/header.inc.php');
    $utilisateurManager = new utilisateurManager($db);
    $utilisateurManager->deconnectUtilisateur();
?>