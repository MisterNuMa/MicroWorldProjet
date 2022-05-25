<?php
    include_once('includes/header.inc.php');

    if($_SESSION['type'] != "employe") { // Si l'utilisateur n'est pas employe
        echo '<script>location.href="connexion.php";</script>'; // redirection vers la page de connexion
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Formulaire ajout produit</h1>
            <p class="lead fw-normal text-white-50 mb-0">Votre article sera bientôt en vente sur nôtre site</p>
        </div>
    </div>
</header>

<br>

<div class="container">
    <form class="need-validate" method="post" action="" id="form" enctype="multipart/form-data" novalidate >
        <fieldset>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="titre" class="form-label"><span class="text-danger">*</span> Titre du produit</label>
                    <input type="text" class="form-control" id="libelle" name="libelle" placeholder="Titre" pattern="[a-zA-Z0-9 .%&àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ_-]+" minlength="3" maxlength="45" required/>  
                    <div class="valid-feedback">
                        Titre Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ titre est obligatoire et doit faire entre 3 et 45 caractères
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="description"><span class="text-danger">*</span> Description du produit</label>
                    <textarea class="form-control" id="description" name="description" rows="7" placeholder="Description" minlength="500" maxlength="2000" required></textarea>
                    <div class="valid-feedback">
                        Description Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ description est obligatoire et doit faire au moins 500 caractères et peut aller jusqu'à 2000 caractères
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="caracteristiques"><span class="text-danger">*</span> Caractéristiques du produit</label>
                    <textarea class="form-control" id="caracteristiques" name="caracteristiques" rows="13" placeholder="Caractéristiques" minlength="500" maxlength="2000" required></textarea>
                    <div class="valid-feedback">
                        Caractéristiques Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ caracteristiques est obligatoire et doit faire au moins 500 caractères et peut aller jusqu'à 2000 caractères
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="prix" class="form-label"><span class="text-danger">*</span> Prix du produit</label>
                    <input type="number" class="form-control" id="prix" name="prix" placeholder="15,00" min="0.01" step="0.01" required/>
                    <div class="valid-feedback">
                        Prix Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ prix est obligatoire et doit être un nombre entier de type int(eger)
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="quantite" class="form-label"><span class="text-danger">*</span> Quantité du produit</label>
                    <input type="number" class="form-control" id="quantite" name="quantite" placeholder="1" min="1" step="1" required/>
                    <div class="valid-feedback">
                        Quantité Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ quantité est obligatoire et doit être un nombre entier de type int(eger)
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="quantiteProduitAlerte" class="form-label">Quantité du produit minimum</label>
                    <input type="number" class="form-control" id="quantiteProduitAlerte" name="quantiteProduitAlerte" placeholder="0" min="1" step="1"/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="photo"><span class="text-danger">*</span> Photo du produit 1</label>
                    <input class="form-control" type="file" onchange="actuPhoto(this)" id="nomImage" name="nomImage" accept="image/jpeg, image/png" required/>
                    <div class="valid-feedback">
                        Photo Ok !
                    </div>
                    <div class="invalid-feedback">
                        Vous devez mettre une photo est obligatoire
                    </div>
                </div>
            </div>
            <img class="img-responsive float-right" src="" id="affiche" width="300"/>

            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="photo1"><span class="text-danger">*</span> Photo du produit 2</label>
                    <input class="form-control" type="file" onchange="actuPhoto1(this)" id="nomImage1" name="nomImage1" accept="image/jpeg, image/png" required/>
                    <div class="valid-feedback">
                        Photo Ok !
                    </div>
                    <div class="invalid-feedback">
                        Vous devez mettre une photo est obligatoire
                    </div>
                </div>
            </div>
            <img class="img-responsive float-right" src="" id="affiche1" width="300"/>

            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="photo2"><span class="text-danger">*</span> Photo du produit 3</label>
                    <input class="form-control" type="file" onchange="actuPhoto2(this)" id="nomImage2" name="nomImage2" accept="image/jpeg, image/png" required/>
                    <div class="valid-feedback">
                        Photo Ok !
                    </div>
                    <div class="invalid-feedback">
                        Vous devez mettre une photo est obligatoire
                    </div>
                </div>
            </div>
            <img class="img-responsive float-right" src="" id="affiche2" width="300"/>

            <div class="col-auto my-1">
                <label class="mr-sm-2" for="inlineFormCustomSelect"><span class="text-danger">*</span> Choisir tag du produit</label>
                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="tags">
                    <option selected></option>
                    <?php
                        $tagManager = new TagManager($db);
                        $tags = $tagManager->getTags();
                        foreach ($tags as $value) {
                            echo "<option value=".$value["id_tag"].">".$value["nom_tag"]."</option>";
                        };
                    ?>
                </select>
            </div>

            <br>

            <p class="user-select-none text-muted"><span class="text-danger">*</span> Obligatoire</p>
            <button type="submit" class="btn btn-primary" name="submit">Confirmer</button>
        </fieldset>
    </form>
    <?php
        if (isset($_POST["submit"])) {
            function random_string($length) {
                $alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $nom_alea = '';
                for($i = 0; $i < $length; $i++) {
                    $nom_alea .= substr($alpha, rand() % (strlen($alpha)), 1);
                }
                return $nom_alea;
            }
            if(!empty($_FILES['nomImage']['name']) && !empty($_FILES['nomImage1']['name']) && !empty($_FILES['nomImage2']['name'])) {
                // Image 1
                switch($_FILES['nomImage']['type']) {
                    case 'image/jpeg': $extension = 'jpg'; break;
                    case 'image/png':  $extension = 'png'; break;
                    default:           $extension = ''; break;
                }
                if($extension && $_FILES['nomImage']['size'] < 30*1024*1024) {
                    // Changer le nom de l'image
                    $nom_alea = random_string(20);
                    date_default_timezone_set('Europe/Paris');
                    $nom_fichier = $nom_alea.date('_Y_m_d_H_i_s.').$extension;
                    $fileName = $_FILES['nomImage']['name'];
                    $tempName = $_FILES['nomImage']['tmp_name'];
                    if(!isset($fileName)) {
                        if(!$extension) echo $_FILES['nomImage']['name']."n'est pas accepté comme fichier image";
                        else echo "L'image dépasse les 30 Mo";
                    }
                } else {
                    echo "L'image dépasse les 30 Mo";
                }
                // Image 2
                switch($_FILES['nomImage1']['type']) {
                    case 'image/jpeg': $extension_1 = 'jpg'; break;
                    case 'image/png':  $extension_1 = 'png'; break;
                    default:           $extension_1 = ''; break;
                }
                if($extension_1 && $_FILES['nomImage1']['size'] < 30*1024*1024) {
                    // Changer le nom de l'image
                    $nom_alea_1 = random_string(20);
                    date_default_timezone_set('Europe/Paris');
                    $nom_fichier_1 = $nom_alea_1.date('_Y_m_d_H_i_s.').$extension_1;
                    $fileName_1 = $_FILES['nomImage1']['name'];
                    $tempName_1 = $_FILES['nomImage1']['tmp_name'];
                    if(!isset($fileName_1)) {
                        if(!$extension_1) echo $_FILES['nomImage1']['name']."n'est pas accepté comme fichier image";
                        else echo "L'image dépasse les 30 Mo";
                    }
                } else {
                    echo "L'image dépasse les 30 Mo";
                }
                // Image 3
                switch($_FILES['nomImage2']['type']) {
                    case 'image/jpeg': $extension_2 = 'jpg'; break;
                    case 'image/png':  $extension_2 = 'png'; break;
                    default:           $extension_2 = ''; break;
                }
                if($extension_2 && $_FILES['nomImage2']['size'] < 30*1024*1024) {
                    // Changer le nom de l'image
                    $nom_alea_2 = random_string(20);
                    date_default_timezone_set('Europe/Paris');
                    $nom_fichier_2 = $nom_alea_2.date('_Y_m_d_H_i_s.').$extension_2;
                    $fileName_2 = $_FILES['nomImage2']['name'];
                    $tempName_2 = $_FILES['nomImage2']['tmp_name'];
                    if(!isset($fileName_2)) {
                        if(!$extension_2) echo $_FILES['nomImage2']['name']."n'est pas accepté comme fichier image";
                        else echo "L'image dépasse les 30 Mo";
                    }
                } else {
                    echo "L'image dépasse les 30 Mo";
                }
                try {
                    // Traitement des données
                    function valid_donnees($donnees) {
                        $donnees = stripslashes($donnees);
                        $donnees = htmlspecialchars($donnees);
                        return $donnees;
                    }
                    $produit = new Produit([
                        "titreProduit" => valid_donnees($_POST["libelle"]),
                        "descriptionProduit" => valid_donnees($_POST["description"]),
                        "caracteristiqueProduit" => valid_donnees($_POST["caracteristiques"]),
                        "prixProduit" => $_POST["prix"],
                        "quantiteProduit" => $_POST["quantite"],
                        "quantiteProduitAlerte" => $_POST["quantiteProduitAlerte"],
                        "photoProduit1" => $nom_fichier,
                        "photoProduit2" => $nom_fichier_1,
                        "photoProduit3" => $nom_fichier_2,
                        "idTag" => $_POST["tags"],
                        "idUser" => $_SESSION["id"]
                    ]);
                    $produitManager = new ProduitManager($db);
                    $produitManager->addProduit($produit);
                    $location = 'images/produits/';
                    move_uploaded_file($tempName, $location.$nom_fichier);
                    move_uploaded_file($tempName_1, $location.$nom_fichier_1);
                    move_uploaded_file($tempName_2, $location.$nom_fichier_2);
                    echo '<script>location.href="ajoutProduitReussi.php";</script>';
                } catch (Exception $e) {
                    echo '<br><div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
                }
            } else {
                echo '<br><div class="alert alert-danger" role="alert">Veuillez mettre 3 photos</div>';
            }
        }
    ?>
</div>

<br>

<script src="assets/js/ajoutProduit.js"></script>

<?php
    include_once('includes/footer.inc.php');
?>