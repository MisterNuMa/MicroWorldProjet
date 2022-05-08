<?php
    include_once('includes/header.inc.php');

    if (isset($_SESSION['login'])) {
        echo '<script>location.href=".";</script>';
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Connexion</h1>
            <p class="lead fw-normal text-white-50 mb-0">Merci de vous identifier</p>
        </div>
    </div>
</header>

<br>

<div class="container">
    <!-- Formulaire de connexion-->
    <form method="post" id="formId" novalidate>
        <fieldset>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="email">Adresse électronique :</label>
                    <input type="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2, 4}$" name="email" id="email" required/>
                    <div class="invalid-feedback">
                        Vous devez fournir une adresse électronique.
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="mdp">Mot de Passe :</label>
                    <input type="password" class="form-control" minlength="5" maxlength="45" name="mdp" id="mdp" required/>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" onclick="Afficher()">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Afficher le mot de passe</label>
                    </div>
                    <div class="invalid-feedback">
                        Vous devez fournir un mot de passe.
                    </div>
                </div>
            </div>

            <input type="submit" value="Confirmer" class="btn btn-primary" name="submit" id="submit"/>
        </fieldset>
    </form>
    <?php
        if (isset($_POST['submit'])) {
            function valid_donnees($donnees) {
                $donnees = stripslashes($donnees);
                $donnees = htmlspecialchars($donnees);
                return $donnees;
            }
            $email = valid_donnees($_POST['email']);
            $mdp = valid_donnees($_POST['mdp']);
            $manager = new utilisateurManager($db);
            try{
                $manager->connectUtilisateur($email, $mdp);
                echo '<script>location.href="connexionReussie.php";</script>';
            } catch (Exception $e) {
                echo '<br><div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
            }
        }
    ?>
</div>

<br>

<script src="assets/js/connexion.js"></script>

<?php
    include_once('includes/footer.inc.php');
?>