<?php
    include_once('includes/header.inc.php');

    if ($_SESSION['type'] != "client") {
        echo '<script>location.href="connexion.php";</script>';
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Votre Panier</h1>
        </div>
    </div>
</header>

<br>

<div class="container">
    <div class="jumbotron">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <table class="table">
                <thead class="thead-dark" style="width:100%">
                    <tr>
                        <th scope="col">Nom du produit</th>
                        <th scope="col">Photo du produit</th>
                        <th scope="col">Prix unitaire</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Suppression</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try {
                            $panierManager = new PanierManager($db);
                            $result = $panierManager->getProduitPanier($_SESSION['id']);
                        } catch (Exception $e) {
                            echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                        }
                        if (!empty($result)) { // Si il y a des produits
                            foreach ($result as $value) {
                                echo '
                                <tr>
                                    <td>'.$value['titre_produit'].'</td>
                                    <td><img class="img-responsive" src="images/produits/'.$value['photo_produit_1'].'" alt="..."  width="200"></td>
                                    <td>'.$value['prix_produit'].' €</td>
                                    <td><form action="panier.php" method="post"><input type="number" id="quantite" name="quantite" value="'.$value['quantite_produit_panier'].'" min="1" max="'.$value['quantite_produit'].'" step="1" /> <button class="btn btn-primary" id="valid" name="valid" type="submit" value="'.$value['id_produit'].'"><i class="bi bi-check2-circle"></i></button></form></td>
                                    <td><form action="panier.php" method="post"><button class="btn btn-danger" id="supprimer" name="supprimer" value="'.$value['id_produit'].'"><i class="bi bi-x-lg"></i></button></form></td>
                                </tr>';
                            }
                            if (isset($_POST['valid'])) {
                                try {
                                    $panierManager->updateQuantitePanier($_POST['quantite'], $_POST['valid'],$_SESSION['id']);
                                    echo '<script>location.href="panier.php";</script>';
                                } catch (Exception $e) {
                                    echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                                }
                            } else if (isset($_POST['supprimer'])) {
                                try {
                                    $panierManager->deleteProduitPanier($_SESSION['id'], $_POST['supprimer']);
                                    echo '<script>location.href="panier.php";</script>';
                                } catch (Exception $e) {
                                    echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                                }
                            }
                        }
                        else { // Si il n'y a pas de produits
                            echo '<tr><td colspan="7"><center>Pas de produit dans votre panier</center></td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <h1 class="text-decoration-underline">Total :</h1>
        <p class="lead">
            • Prix du panier :
            <?php
                try {
                    $result = $panierManager->getTotalPanier($_SESSION['id']);
                } catch (Exception $e) {
                    echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                }
                if (!empty($result[0]['total_panier'])) {
                    echo $result[0]['total_panier'];
                } else {
                    echo '0';
                }
            ?> 
            €
            <br>
            • Frais de livraison (10 %) :
            <?php
                echo $result[0]['livraison'];
            ?>
            €
            <br>
            <b>Prix Total :</b>
            <?php
                echo $result[0]['total_panier'] + $result[0]['livraison'];
            ?>
            €
        </p>
        <?php
            if (!empty($result[0]['total_panier'])) {
                echo '
                <form action="panier.php" method="post">
                    <button class="btn btn-success" id="payer" name="payer">Payer</button>
                </form>
                ';
            }
            if (isset($_POST['payer'])) {
                try {
                    $req = $panierManager->getProduitPanier($_SESSION['id']);
                    foreach ($req as $value) {
                        $result = $panierManager->getTotalProduit($value['id_produit'], $_SESSION['id']);
                        $acheter = new Acheter([
                            'idUtilisateur' => $_SESSION['id'],
                            'idProduit' => $value['id_produit'],
                            'quantiteProduit' => $value['quantite_produit_panier'],
                            'prixTotal' => $result[0]['total_panier'] + $result[0]['livraison']
                        ]);
                        $acheterManager = new AcheterManager($db);
                        $acheterManager->addAcheterProduitPanier($acheter);
                        $produitManager = new ProduitManager($db);
                        $produitManager->updateQuantiteProduit($value['id_produit'], $value['quantite_produit_panier']);
                    }
                    $panierManager->deletePanier($_SESSION['id']);
                    echo '<script>location.href="voirCommande.php";</script>';
                } catch (Exception $e) {
                    echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                }
            }
        ?>
    </div>
</div>

<br>

<?php
    include_once('includes/footer.inc.php');
?>