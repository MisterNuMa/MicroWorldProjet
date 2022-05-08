<?php
    include_once('includes/header.inc.php');
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Pages des produits</h1>
            <p class="lead fw-normal text-white-50 mb-0">Retrouver tous nos produits en ventes ici</p>
        </div>
    </div>
</header>

<br>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php
            if (!empty($_GET['recherche'])) {
                try {
                    $produitManager = new ProduitManager($db);
                    $produits = $produitManager->searchProduit($_GET['recherche']);
                } catch (Exception $e) {
                    echo '<script>alert('.$e->getMessage().');</script>';
                }
            }
            else if (isset($_GET['idtag'])) {
                try {
                    $produitManager = new ProduitManager($db);
                    $produits = $produitManager->getProduitsByTag($_GET['idtag']);
                } catch (Exception $e) {
                    echo '<br><div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
                }
            } else {
                try {
                    $produitManager = new ProduitManager($db);
                    $produits = $produitManager->getProduits();
                } catch (Exception $e) {
                    echo '<br><div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
                }
            }
            foreach ($produits as $value) {
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
        ?>
        </div>
    </div>
</section>

<div class="album py-5 bg-light">
    <div class="container">
        <h2 class="fw-bolder mb-4 text-center">Catégories</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
                if (isset($_GET['idtag'])) {
                    try {
                        $tagManager = new TagManager($db);
                        $tags = $tagManager->getTagsExcept($_GET['idtag']);
                    } catch (Exception $e) {
                        echo '<br><div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
                    }
                } else {
                    try {
                        $tagManager = new TagManager($db);
                        $tags = $tagManager->getTags();
                    } catch (Exception $e) {
                        echo '<br><div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
                    }
                }
                foreach ($tags as $value) {
                    echo"
                    <a style='color: #000000; text-decoration: none; text-align: center;' href='voirProduit.php?idtag=".$value['id_tag']."'>
                    <div class='col'>
                        <div class='card shadow-sm'>
                            <div class='card-body'>
                                <h5 class='card-title'>".$value["nom_tag"]."</h5>
                            </div>
                        </div>
                    </div>
                    </a>";
                }
            ?>
        </div>
    </div>
</div>

<br>

<?php
    include_once('includes/footer.inc.php');
?>