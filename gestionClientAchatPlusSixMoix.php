<?php
    include_once('includes/header.inc.php');

    if ($_SESSION['type'] != "admin") { // Si l'utilisateur n'est pas admin
        //echo '<script>location.href="connexion.php";</script>'; // On le redirige vers la page de connexion
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
                                    <td><form action="gestionClientAchatPlusSixMoix.php" method="post"><button class="btn btn-primary" id="info" name="info" value="'.$value['id_utilisateur'].'">Envoyer Mail Réduction 15 %</button></form></td>
                                </tr>';
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