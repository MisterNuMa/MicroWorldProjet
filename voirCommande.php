<?php
    include_once('includes/header.inc.php');

    if ($_SESSION['type'] != "client") {
        echo '<script>location.href="connexion.php"</script>';
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Vos Commandes</h1>
            <p class="lead fw-normal text-white-50 mb-0">Visualiser toutes les commandes que vous avez faites</p>
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
                        <th scope="col">Quantité acheté</th>
                        <th scope="col">Date de l'achat</th>
                        <th scope="col">Prix total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try {
                            $acheterManager = new acheterManager($db);
                            $acheter = $acheterManager->getProduitAcheter($_SESSION['id']);
                        } catch (Exception $e) {
                            echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                        }
                        if (!empty($acheter)) { // Si il y a des produits achetés
                            foreach ($acheter as $value) {
                                echo '
                                <tr>
                                    <td>'.$value['titre_produit'].'</td>
                                    <td><img src="images/produits/'.$value['photo_produit_1'].'" alt="..." width="200"</td>
                                    <td>'.$value['quantite_acheter_produit'].'</td>
                                    <td>'.$value['date_achat'].'</td>
                                    <td>'.$value['prix_total'].' €</td>
                                </tr>';
                            }
                        }
                        else { // Si il n'y a pas de produits achetés
                            echo '<tr><td colspan="7"><center>Vous n\'avez pas encore acheté de produit(s)</center></td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
    include_once('includes/footer.inc.php');
?>