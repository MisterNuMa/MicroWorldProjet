<?php
    include('includes/header.inc.php');

    if(!isset($_SESSION['login'])) {
        echo '<script>location.href=".";</script>';
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Page des utilisateurs de MicroWorld</h1>
            <?php echo '<p class="lead fw-normal text-white-50 mb-0">Bonjour '.$_SESSION['pseudo'].' comment allez vous ?</p>';?>
        </div>
    </div>
</header>

<br>

<?php
    include('includes/footer.inc.php');
?>