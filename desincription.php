<?php
    include_once('includes/header.inc.php');

    if ($_SESSION['type'] != "client") {
        echo '<script>location.href=".";</script>';
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Désincription</h1>
            <p class="lead fw-normal text-white-50 mb-0">Vous aller nous manquer :_(</p>
        </div>
    </div>
</header>

<br>

<form action="desincription.php" method="post">
    <div class="container px-4 px-lg-5 my-5">
        <div class="form-group">
            <p class="lead fw-normal text-black-50 mb-0">Toutes vos données seront supprimées. Êtes-vous sûr ?</p>
        </div>
        <br>
        <button type="submit" name="desinscription" class="btn btn-danger">Désincription</button>
    </div>
</form>
<?php
    if (isset($_POST['desinscription'])) {
        $manager = new utilisateurManager($db);
        try {
            $manager->deleteUtilisateur($_SESSION['id']);
            echo '<script>location.href="deconnexion.php";</script>';
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'");</script>';
        }
    }
?>

<br>

<?php
    include_once('includes/footer.inc.php');
?>