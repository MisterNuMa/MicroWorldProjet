<?php
    include_once('includes/header.inc.php');
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">MicroWorld</h1>
            <p class="lead fw-normal text-white-50 mb-0">Des produits pour vous satisfaire</p>
        </div>
    </div>
</header>

<br>

<div class="container text-center">
    <main>
        <!-- Carrousel-->
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
        <div class="carousel-item active" data-interval="4000">
            <img class="d-block w-100" src="images/carousel/1.jpg" alt="...">
        <div class="container">
        </div>
        </div>
        <div class="carousel-item" data-interval="2000">
            <img class="d-block w-100" src="images/carousel/2.jpg" alt="...">
        <div class="container">
        </div>
        </div>
        <div class="carousel-item" data-interval="1000">
            <img class="d-block w-100" src="images/carousel/3.jpg" alt="...">
        <div class="container">
        </div>
        </div>
        </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </main>
    <div class="h-100 p-3 text-white bg-dark rounded-3">
        <img class="rounded mx-auto d-block" src="assets/logo.png" alt="..." width="250">
        <h3>Moins de temps à chercher. Plus de résultats.</h3>
        <h6>Découvrez les produits qui vous aideront dans votre quotidien.</h6>
    </div>
</div>

<br>

<div class="album py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4 text-center">Produits les plus vendus</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
                try {
                    $produitManager = new ProduitManager($db);
                    $produits = $produitManager->getProduitsPlusVendu();
                } catch (Exception $e) {
                    echo '<script>alert('.$e->getMessage().');</script>';
                }

                foreach ($produits as $values) {
                    foreach ($values as $value) {
                        echo '<div class="col mb-5">
                            <div class="card h-100">
                                <img class="card-img-top" src="images/produits/'.htmlentities($value['photo_produit_1']).'" alt="...">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder">'.$value['titre_produit'].'</h5>
                                        '.$value['prix_produit'].' €
                                        <br>
                                        <small class="text-muted">'.$value['nom_tag'].'</small>
                                    </div>
                                </div>';
                                if ($value['quantite_produit'] > 0) {
                                    echo '
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="acheterProduit.php?idproduit='.$value['id_produit'].'">Voir Plus</a></div>
                                    </div>';
                                } else {
                                    echo '
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><p class="user-select-none text-muted">Plus de produits disponible</p></div>
                                    </div>';
                                }
                            echo '
                            </div>
                        </div>';
                    }
                }
            ?>
        </div>
    </div>
</div>

<br>

<?php
    include_once('includes/footer.inc.php');
?>