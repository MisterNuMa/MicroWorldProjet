<?php
    session_start();

    if(!isset($_SESSION['type'])) {    
        $_SESSION['type'] = 'visiteur';
    }

    require_once('autoload.php');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MicroWorld</title>
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap link -->
        <link rel="stylesheet" href="assets/css/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    </head>
    <body>
        <?php
            // On regarde le niveau d'habilitation
            switch ($_SESSION['type']) {
                case "client":      $niveauHab = "%C%"; break;
                case "employe":     $niveauHab = "%E%"; break;
                case "visiteur":    $niveauHab = "%V%"; break;
                case "admin":       $niveauHab = "%A%"; break;
            }

            // On récupère l'ensemble des itérations dans Menu
            $requete = "SELECT id_menu, nom_menu, url_menu FROM menu WHERE habilitation_menu LIKE '".$niveauHab."'";
            $instruction = $db->prepare($requete);
            $instruction->execute();
            $num = $instruction->fetchAll(); // Tout se trouve maintenant dans le tableau $num
        ?>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href=".">MicroWorld</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <?php
                            // On va récupérer les menus de niveau 1 dont l'id est compris entre 1 et 9
                            foreach ($num as $value) {
                                // Menu de niveau 1
                                if (strlen($value['id_menu']) == 1) {
                                    $niv = substr($value['id_menu'], 0, 1); // On mémorise le niveau
                                    echo '<li class="nav-item dropdown">'.PHP_EOL;
                                    echo '<a class="nav-link dropdown-toggle" id="navbarDropdown" href="'.$value['url_menu'].'" role="button" data-bs-toggle="dropdown" aria-expanded="false">'.$value['nom_menu'].'</a>'.PHP_EOL;
                                    echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">'.PHP_EOL;
                                    foreach($num as $value) {
                                        // Sous menu
                                        if (strlen($value['id_menu']) == 2 AND substr($value['id_menu'], 0, 1) == $niv ) {
                                            echo '<li><a class="dropdown-item" href="'.$value['url_menu'].'">'.$value['nom_menu'].'</a></li>'.PHP_EOL;
                                        }
                                    }
                                    echo "</ul>";
                                    echo "</li>";
                                }
                            }
                        ?>
                    </ul>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <form class="d-flex" method="post">
                            <input class="form-control me-2" type="search" name="recherche" id="recherche" placeholder="Recherche" aria-label="Search"/>
                            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
                        </form>
                        <?php
                            // Nettoyage de la recherche de l'utilisateur
                            function valid_donnees_search($donnees) {
                                $donnees = trim($donnees);
                                $donnees = stripslashes($donnees);
                                $donnees = htmlspecialchars($donnees);
                                return $donnees;
                            }
                            // On regarde si l'utilisateur a entré quelque chose
                            if (isset($_POST['recherche']) && !empty($_POST['recherche'])) {
                                $recherche = valid_donnees_search($_POST['recherche']); // On récupère la recherche de l'utilisateur et on la nettoie
                                echo '<script>location.href="voirProduit.php?recherche='.$recherche.'";</script>'; // On redirige vers la page de recherche
                            }
                        ?>
                        <?php
                            if (!isset($_SESSION['login'])) {
                                echo '
                                <!-- Button trigger modal -->
                                <form class="d-flex">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalConnexionInscription">
                                    S\'inscrire | Se connecter
                                    </button>
                                </form>
                                <!-- Modal -->
                                <div class="modal fade" tabindex="-1" role="dialog" id="modalConnexionInscription">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content rounded-5 shadow">
                                            <div class="modal-header p-5 pb-4 border-bottom-0">
                                                <h2 class="fw-bold mb-0">Connectez-vous</h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-5 pt-0">
                                                <!-- Bouton Connexion -->
                                                <a class="w-100 py-2 mb-2 btn btn-outline-primary rounded-4" href="connexion.php" role="button">Connexion</a>
                                                <hr class="my-4">
                                                <h2 class="fs-5 fw-bold mb-3">Ou Inscrivez-vous</h2>
                                                <!-- Bouton Inscription pour les Clients -->
                                                <a class="w-100 py-2 mb-2 btn btn-outline-dark rounded-4" href="InscriptionClient.php" role="button">Inscription Client</a>
                                                <!-- Bouton Inscription pour les Employé -->
                                                <a class="w-100 py-2 mb-2 btn btn-outline-dark rounded-4" href="InscriptionEmploye.php" role="button">Inscription Employé</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            } else {
                                echo '
                                <form class="d-flex">
                                    <a class="btn btn-outline-primary" href="deconnexion.php" role="button">Deconnexion</a>
                                </form>';
                            }
                            if ($_SESSION['type'] == "client") {
                                echo '
                                <form class="d-flex">
                                    <a class="btn btn-outline-dark" href="panier.php" role="button">
                                        <i class="bi-cart-fill me-1"></i>
                                        Panier
                                        <span class="badge bg-dark text-white ms-1 rounded-pill">';
                                        try {
                                            $panierManager = new PanierManager($db);
                                            $panier = $panierManager->countProduitPanier($_SESSION['id']);
                                            if (isset($_SESSION['login']) && $panier > 0) {
                                                echo $panier;
                                            } else {
                                                echo '0';
                                            }
                                        } catch (Exception $e) {
                                            echo '<p class="text-muted">'.$e->getMessage().'<p>';
                                        }
                                        echo '</span>
                                    </a>
                                </form>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </nav>