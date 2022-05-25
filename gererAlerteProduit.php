<?php
    include_once('includes/header.inc.php');

    if ($_SESSION['type'] != "admin" && $_SESSION['type'] != "employe") { // Si l'utilisateur n'est pas admin ou employe, il n'a pas accès à cette page
        echo '<script>location.href="connexion.php";</script>'; // On le redirige vers la page de connexion
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Gestion des produits avec alerte</h1>
            <p class="lead fw-normal text-white-50 mb-0">Ajouter des produits</p>
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
                        <th scope="col">Id</th>
                        <th scope="col">Nom du produit</th>
                        <th scope="col">Photo du produit</th>
                        <th scope="col">Vendeur du produit</th>
                        <th scope="col">Nom du tag du produit</th>
                        <th scope="col">Quantité</th>
                        <?php
                            if ($_SESSION['type'] == "employe") {
                                echo '<th scope="col">Ajout</th>';
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try {
                            $produitManager = new ProduitManager($db);
                            $result = $produitManager->gestionProduitAlerte();
                        } catch (Exception $e) {
                            echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                        }
                        if ($result > 0) { // Si il y a des produits
                            foreach ($result as $value) {
                                echo '
                                <tr>
                                    <th scope="row">'.$value['id_produit'].'</th>
                                    <td>'.$value['titre_produit'].'</td>
                                    <td>
                                        <img class="img-responsive" src="images/produits/'.$value['photo_produit_1'].'" alt="..."  width="100">
                                        <img class="img-responsive" src="images/produits/'.$value['photo_produit_2'].'" alt="..."  width="100">
                                        <img class="img-responsive" src="images/produits/'.$value['photo_produit_3'].'" alt="..."  width="100">
                                    </td>
                                    <td>'.$value['email_utilisateur'].'</td>
                                    <td>'.$value['nom_tag'].'</td>
                                    <td>'.$value['quantite_produit'].'</td>';
                                    if ($_SESSION['type'] == "employe") {
                                        echo '<td><form action="gererAlerteProduit.php" method="post"><input type="number" class="form-control" id="quantite" name="quantite" placeholder="1" min="1" step="1" required/><br><button type="submit" class="btn btn-primary" name="submit" value="'.$value['id_produit'].'">Ajouter</button></form></td>';
                                    }
                                echo '</tr>';
                            }
                        }
                        else { // Si il n'y a pas de produits
                            echo '<tr><td colspan="7"><center>Pas de Donnée</center></td></tr>';
                        }
                        
                        if (isset($_POST['submit'])) { // Si on a cliqué sur le bouton Ajouter
                            try {
                                $produitManager->ajoutQuantiteProduit($_POST['submit'], $_POST['quantite']);
                                echo '<script>location.href="gererAlerteProduit.php"</script>';
                            } catch (Exception $e) {
                                echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
    include_once('includes/footer.inc.php')
?>