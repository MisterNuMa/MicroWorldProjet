<?php
    include('config.php');

    try {
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Erreur BDD : ".$e->getMessage();
        die();
    }

    spl_autoload_register(function($class) {
        require_once("classes/$class.class.php");
    });
?>