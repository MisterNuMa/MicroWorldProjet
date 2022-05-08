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
            <h1 class="display-4 fw-bolder">Gestion Utilisateurs</h1>
            <p class="lead fw-normal text-white-50 mb-0">Désactiver ou Activer un compte utilisateur</p>
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
                        <th scope="col">Type</th>
                        <th scope="col">Active</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                        <th scope="col">Suppression</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try {
                            $utilisateurManager = new UtilisateurManager($db);
                            $result = $utilisateurManager->gestionUtilisateur();
                        } catch (Exception $e) {
                            echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                        }
                        if ($result > 0) { // Si il y a des utilisateurs
                            foreach ($result as $value) {
                                echo '
                                <tr>
                                    <th scope="row">'.$value['id_utilisateur'].'</th>
                                    <td>'.$value['type_utilisateur'].'</td>
                                    <td>'.$value['active_utilisateur'].'</td>
                                    <td>'.$value['email_utilisateur'].'</td>
                                    <td><form action="gererUtilisateur.php" method="post">';
                                    if ($value['active_utilisateur'] == 1) { // Si l'utilisateur est actif
                                        echo '<button class="btn btn-danger" id="desactiver" name="desactiver" value="'.$value['id_utilisateur'].'">Désactiver</button></form></td>'; // Bouton de désactivation
                                    } else { // Si l'utilisateur est désactivé
                                        echo '<button class="btn btn-success" id="activer" name="activer" value="'.$value['id_utilisateur'].'">Activer</button></form></td>'; // Bouton d'activation
                                    }
                                    echo '<td><form action="gererUtilisateur.php" method="post"><button class="btn btn-danger" id="supprimer" name="supprimer" value="'.$value['id_utilisateur'].'">Supprimer</button></form></td>
                                </tr>';
                            }
                            if (isset($_POST['activer'])) { // Si l'utilisateur clique sur le bouton d'activation
                                try {
                                    $utilisateurManager->activerUtilisateur($_POST['activer']); // On active l'utilisateur
                                    echo '<script>location.href="gererUtilisateur.php";</script>'; // On recharge la page
                                } catch (Exception $e) {
                                    echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                                }
                            } else if (isset($_POST['desactiver'])) { // Si l'utilisateur clique sur le bouton de désactivation
                                try {
                                    $utilisateurManager->desactiverUtilisateur($_POST['desactiver']); // On désactive l'utilisateur
                                    echo '<script>location.href="gererUtilisateur.php";</script>'; // On recharge la page
                                } catch (Exception $e) {
                                    echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                                }
                            } else if (isset($_POST['supprimer'])) { // Si l'utilisateur clique sur le bouton de suppression
                                try {
                                    $utilisateurManager->deleteUtilisateur($_POST['supprimer']); // On supprime l'utilisateur
                                    echo '<script>location.href="gererUtilisateur.php";</script>'; // On recharge la page
                                } catch (Exception $e) {
                                    echo '<script>alert("'.$e->getMessage().'");</script>'; // On affiche un message d'erreur
                                }
                            }
                        }
                        else { // Si il n'y a pas d'utilisateur
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