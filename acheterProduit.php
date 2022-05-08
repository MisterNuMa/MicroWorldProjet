<?php
    include_once('includes/header.inc.php');
?>

<br>

<?php
    try {
        $produitManager = new ProduitManager($db);
        $req = $produitManager->getProduitsById($_GET['idproduit']);
    } catch (Exception $e) {
        echo '<br><div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
    if (!empty($req)){
        foreach ($req as $value) {
            echo '
            <section class="py-5">
                <div class="container px-4 px-lg-5 my-5">
                    <div class="row gx-4 gx-lg-5 align-items-center">
                        <div class="col-md-9"><img class="mb-5 mb-md-2" src="images/produits/'.$value['photo_produit_1'].'" id="imageChange" alt="..." width="400"></div>
                        <div class="col-md-4">
                            <a onmouseover="changeImage(\''.$value['photo_produit_1'].'\')"><img class="mb-5 mb-md-5" src="images/produits/'.$value['photo_produit_1'].'" alt="..." width="100"></a>
                            <a onmouseover="changeImage(\''.$value['photo_produit_2'].'\')"><img class="mb-5 mb-md-5" src="images/produits/'.$value['photo_produit_2'].'" alt="..." width="100"></a>
                            <a onmouseover="changeImage(\''.$value['photo_produit_3'].'\')"><img class="mb-5 mb-md-5" src="images/produits/'.$value['photo_produit_3'].'" alt="..." width="100"></a>
                        </div>
                        <div class="col-md-10">
                            <h1 class="display-5 fw-bolder">'.$value['titre_produit'].'</h1>
                            <div class="fs-4 mb-3">
                                <span>'.$value['prix_produit'].' €
                            </div>
                            <div class="col-md-5"><p class="lead">Vendeur : '.$value['pseudo_utilisateur'].'</p></div>
                            <div class="col-md-5"><p class="lead"><b>'.$value['quantite_produit'].'</b> en stock</p></div>
                            <div class="col-md-12"><h3 class="text-decoration-underline">Descrition du produits</h3><p>'.$value['description_produit'].'</p></div>
                            <div class="col-md-12"><h4 class="text-decoration-underline">Caractèristiques du produits</h4><p>'.$value['caracteristique_produit'].'</p></div>';
                            if ($_SESSION['type'] == "client") {
                                echo '
                                <div class="d-flex">
                                    <form method="post">
                                        <button class="btn btn-outline-warning flex-shrink-0" type="submit" id="acheter" name="acheter" value="acheter">
                                            Achetez maintenant
                                        </button>
                                        <button class="btn btn-outline-dark flex-shrink-0" type="submit" id="ajoutPanier" name="ajoutPanier" value="ajoutPanier">
                                            <i class="bi-cart-fill me-1"></i>
                                            Ajouter au panier
                                        </button>
                                    </form>
                                </div>';
                            } else if ($_SESSION['type'] == "photographe" || $_SESSION['type'] == "employe") {
                                echo '
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">         
                                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </symbol>
                                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                    </symbol>
                                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </symbol>
                                </svg>
                                <div class="alert alert-warning d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                    <div>
                                        Seul un client peut acheter.
                                    </div>
                                </div>';
                            } else {
                                echo '
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">         
                                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </symbol>
                                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                    </symbol>
                                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </symbol>
                                </svg>
                                <div class="alert alert-warning d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                    <div>
                                        Vous devez être <a href="connexion.php" class="alert-link">connecté</a> à un compte client pour pouvoir acheter.
                                    </div>
                                </div>';
                            }
                            if (isset($_POST['acheter'])) {
                                try {
                                    $acheter = new Acheter([
                                        'idUtilisateur' => $_SESSION['id'],
                                        'idProduit' => $_GET['idproduit'],
                                        'quantiteProduit' => 1,
                                        'prixTotal' => round($value['prix_produit'] * 1.1, 2)
                                    ]);
                                    $acheterManager = new AcheterManager($db);
                                    $acheterManager->achatProduit($acheter);
                                    echo '<script>location.href="voirCommande.php";</script>';
                                } catch (Exception $e) {
                                    echo '
                                    <br>
                                    <div class="alert alert-danger" id="bloc" style="display:none role="alert">
                                        '.$e->getMessage().'
                                    </div>
                                    <script>
                                        document.getElementById("bloc").style.display="block";
                                        setTimeout(function(){document.getElementById("bloc").style.display="none";},5000);
                                    </script>';
                                }
                            } else if (isset($_POST['ajoutPanier'])) {
                                try {
                                    $panier = new Panier([
                                        'idProduit' => $_GET['idproduit'],
                                        'idUtilisateur' => $_SESSION['id'],
                                        'quantiteProduitPanier' => 1
                                    ]);
                                    $panierManager = new PanierManager($db);
                                    $panierManager->addProduitPanier($panier);
                                    echo '<script>location.href="panier.php";</script>';
                                } catch (Exception $e) {
                                    echo '
                                    <br>
                                    <div class="alert alert-danger" id="bloc" style="display:none role="alert">
                                        '.$e->getMessage().'
                                    </div>
                                    <script>
                                        document.getElementById("bloc").style.display="block";
                                        setTimeout(function(){document.getElementById("bloc").style.display="none";},5000);
                                    </script>';
                                }
                            }
                        echo '
                        </div>
                    </div>
                </div>
            </section>';
        }
        try {
            $produits = $produitManager->getProduitsByTagAndProduit($value['id_tag'], $_GET['idproduit']);
        } catch (Exception $e) {
                echo '<br><div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
        }
        if (!empty($produits)) {
            echo '
            <section class="py-5 bg-light">
                <div class="container px-4 px-lg-5 mt-5">
                    <h2 class="fw-bolder mb-4">Autres produits de la même catégorie</h2>
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
                    foreach ($produits as $result) {
                        echo '
                        <div class="col mb-5">
                            <div class="card h-100">
                                <img class="card-img-top" src="images/produits/'.$result['photo_produit_1'].'" alt="..." />
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder">'.$result['titre_produit'].'</h5>
                                        '.$result['prix_produit'].' €
                                        <br>
                                        <small class="text-muted">'.$result['nom_tag'].'</small>
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="acheterProduit.php?idproduit='.$result['id_produit'].'">Voir Plus</a></div>
                                </div>
                            </div>
                        </div>';
                    }
                    echo '
                    </div>
                </div>
            </section>';
        }
    } // Fin de la boucle foreach
?>

<br>

<script src="assets/js/acheterProduit.js"></script>

<?php
    include_once('includes/footer.inc.php');
?>