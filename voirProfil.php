<?php
    include_once('includes/header.inc.php');

    if (!isset($_SESSION['login'])) {
        echo '<script>location.href="connexion.php"</script>';
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Votre Profil</h1>
            <p class="lead fw-normal text-white-50 mb-0">Bienvenue sur votre profil</p>
        </div>
    </div>
</header>

<br>
            
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <?php echo '<img class="rounded-circle mt-5" width="150px" src="images/utilisateurs/'.$_SESSION['type'].'/'.$_SESSION['photo_profil'].'">
                    <span class="font-weight-bold">'.$_SESSION['prenom'].' '.$_SESSION['nom'].'</span>
                    <span class="text-black-50">'.$_SESSION['email'].'</span>';
                ?>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <?php echo "<h4 class='text-right'>Profil de"."\t".$_SESSION['prenom']."\t".$_SESSION['nom']."</h4>"?>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6"><label class="labels">Prenom</label><?php echo"<span class='form-control font-weight-bold'>"."\t".$_SESSION['prenom']."</span>";?></div>
                    <div class="col-md-6"><label class="labels">Nom</label><?php echo"<span class='form-control font-weight-bold'>"."\t".$_SESSION['nom']."</span>";?></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6"><label class="labels">Statut</label><?php echo"<span class='form-control font-weight-bold'>"."\t".$_SESSION['type']."</span>";?></div>
                    <?php
                        if ($_SESSION['type'] == "employe") {
                            echo '
                            <div class="col-md-6"><label class="labels">SIREN</label><span class="form-control font-weight-bold">'.$_SESSION['siren'].'</span></div>';
                        }
                    ?>
                </div>
                <div class="row mt-3">
                <div class="col-md-6"><label class="labels">Pseudo</label><?php echo"<span class='form-control font-weight-bold'>"."\t".$_SESSION['pseudo']."</span>";?></div>
                    <?php
                        if ($_SESSION['type'] == "employe") {
                            try {
                                $utilisateurManager = new UtilisateurManager($db);
                                $nbrProduit = $utilisateurManager->countProduits($_SESSION['id']);
                            } catch (Exception $e) {
                                echo '<script>alert('.$e->getMessage().')</script>';
                            }
                            echo '
                            <div class="col-md-6"><label class="label">Nombre de produits en ventes</label><span class="form-control font-weight-bold">'.$nbrProduit['nombre_produit'].'</span></div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<br>

<?php
    include_once('includes/footer.inc.php');
?>