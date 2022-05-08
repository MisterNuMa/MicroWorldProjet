<?php
    include_once('includes/header.inc.php');

    if ($_SESSION['type'] != "admin") { // Si l'utilisateur n'est pas admin
        echo '<script>location.href="connexion.php";</script>'; // On le redirige vers la page de connexion
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Gestion des Tags</h1>
            <p class="lead fw-normal text-white-50 mb-0">Désactiver ou Activer un tag</p>
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
                        <th scope="col">Nom du tag</th>
                        <th scope="col">Active</th>
                        <th scope="col">Nom du créateur</th>
                        <th scope="col">Action</th>
                        <th scope="col">Suppression</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try {
                            $tagManager = new TagManager($db);
                            $result = $tagManager->gestionTag();
                        } catch (Exception $e) {
                            echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                        }
                        if ($result > 0) { // Si il y a des tags
                            foreach ($result as $value) {
                                echo '
                                <tr>
                                    <th scope="row">'.$value['id_tag'].'</th>
                                    <td>'.$value['nom_tag'].'</td>
                                    <td>'.$value['active_tag'].'</td>
                                    <td>'.$value['id_utilisateur'].'</td>
                                    <td><form action="gererTag.php" method="post">';
                                    if ($value['active_tag'] == 1) { // Si le tag est actif
                                        echo '<button class="btn btn-danger" id="desactiver" name="desactiver" value="'.$value['id_tag'].'">Désactiver</button></form></td>'; // Bouton de désactivation
                                    } else { // Si le tag est désactivé
                                        echo '<button class="btn btn-success" id="activer" name="activer" value="'.$value['id_tag'].'">Activer</button></form></td>'; // Bouton d'activation
                                    }
                                    echo '<td><form action="gererTag.php" method="post"><button class="btn btn-danger" id="supprimer" name="supprimer" value="'.$value['id_tag'].'">Supprimer</button></form></td>
                                </tr>';
                            }
                            if (isset($_POST['activer'])) { // Si l'utilisateur clique sur le bouton d'activation
                                try {
                                    $tagManager->activerTag($_POST['activer']); // On active le tag
                                    echo '<script>location.href="gererTag.php";</script>'; // On recharge la page
                                } catch (Exception $e) {
                                    echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                                }
                            } else if (isset($_POST['desactiver'])) { // Si l'utilisateur clique sur le bouton de désactivation
                                try {
                                    $tagManager->desactiverTag($_POST['desactiver']); // On désactive le tag
                                    echo '<script>location.href="gererTag.php";</script>'; // On recharge la page
                                } catch (Exception $e) {
                                    echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                                }
                            } else if (isset($_POST['supprimer'])) { // Si l'utilisateur clique sur le bouton de suppression
                                try {
                                    $tagManager->deleteTag($_POST['supprimer']); // On supprime le tag
                                    echo '<script>location.href="gererTag.php";</script>'; // On recharge la page
                                } catch (Exception $e) {
                                    echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                                }
                            }
                        }
                        else { // Si il n'y a pas de tags
                            echo '<tr><td colspan="7"><center>Pas de Donnée</center></td></tr>';
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