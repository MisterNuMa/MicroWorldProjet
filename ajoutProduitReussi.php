<?php
    include_once('includes/header.inc.php');

    if($_SESSION['type'] != "employe") {
        echo '<script>location.href=".";</script>';
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Vôtre produit sera bientôt en ligne</h1>
            <p class="lead fw-normal text-white-50 mb-0">Vôtre produit doit être contrôler par l'administrateur puis il sera mis en ligne</p>
        </div>
    </div>
</header>
        
<br>

<?php
    include_once('includes/footer.inc.php');
?>