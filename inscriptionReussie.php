<?php
    include_once('includes/header.inc.php');

    if(isset($_SESSION['login'])) {
        echo '<script>location.href=".";</script>';
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Inscription Réussie</h1>
            <p class="lead fw-normal text-white-50 mb-0">Tu es maintenant inscrit ! <a href="connexion.php">Connecte toi</a> maintenant !</p>
        </div>
    </div>
</header>

<br>

<?php
    include_once('includes/footer.inc.php');
?>