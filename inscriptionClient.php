<?php
    include_once('includes/header.inc.php');

    if (isset($_SESSION['login'])) {
        echo '<script>location.href=".";</script>';
    }
?>
<!-- Header -->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Inscription Client</h1>
            <p class="lead fw-normal text-white-50 mb-0">Merci de remplir ce formulaire d'inscription</p>
        </div>
    </div>
</header>

<br>

<div class="container">
    <!-- Formulaire d'inscription Client -->
    <form method="post" action="inscriptionClient.php" id="form" enctype="multipart/form-data" autocomplete="on" novalidate>
        <fieldset>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="prenom"><span class="text-danger">*</span> Prénom</label>
                    <input type="text" class="form-control" pattern="[a-zA-ZàâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ-]+" minlength="3" maxlength="45" autocomplete="off" spellcheck="false" name="prenom" id="prenom" placeholder="Votre prénom" required/>
                    <div class="valid-feedback">
                        Prénom Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ prénom est obligatoire et doit faire entre 3 et 45 caractères
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="nom"><span class="text-danger">*</span> Nom</label>
                    <input type="text" class="form-control" pattern="[a-zA-ZàâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ-]+" minlength="3" maxlength="45" autocomplete="off" spellcheck="false" name="nom" id="nom" placeholder="Votre nom" required/>
                    <div class="valid-feedback">
                        Nom Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ nom est obligatoire et doit faire entre 3 et 45 caractères
                    </div>
                </div> 
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="pseudo"><span class="text-danger">*</span> Pseudo</label>
                    <input type="text" class="form-control" pattern="[a-zA-Z .&àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ_-]+" minlength="3" maxlength="45" autocomplete="off" spellcheck="false" name="pseudo" id="pseudo" placeholder="Votre pseudo" required/>
                    <div class="valid-feedback">
                        Pseudo Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ pseudo est obligatoire et doit faire entre 3 et 45 caractères
                    </div>
                </div> 
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="photo">Photo</label>
                    <input class="form-control" type="file" onchange="actuPhoto(this)" id="photoUtilisateur" name="photoUtilisateur" accept="image/jpeg, image/png"/>
                </div> 
            </div>
            <img src="" id="photo" style="width: 20%; border-radius: 50%;" class="img-responsive float-right"/>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="email"><span class="text-danger">*</span> Adresse électronique</label>
                    <input type="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" id="email" name="email" placeholder="nom@exemple.com" required/>
                    <small id="emailHelp" class="form-text text-muted">Nous ne partagerons pas votre email.</small>
                    <div class="invalid-feedback">
                        Vous devez fournir un email valide.
                    </div>
                </div> 
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="motDePasse"><span class="text-danger">*</span> Mot de Passe</label>
                    <input type="password" oninput='motdepasse1.setCustomValidity(motdepasse1.value != motdepasse1.value ?  "Mot de passe non identique" : "")' class="form-control" id="motdepasse1" name="motdepasse1" minlength="5" maxlength="45" required/>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" onclick="Afficher1()">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Afficher le mot de passe</label>
                    </div>
                    <div class="valid-feedback">
                        Mot de Passe Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le mot de passe est obligatoire et doit faire entre 3 et 45 caractères
                    </div>
                    <div  class="invalid-feedback">
                        <p id="erreurMotDePasse"></p>
                    </div>
                </div> 
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="motDePasse2"><span class="text-danger">*</span> Confirmation du mot de passe</label>
                    <input type="password" oninput='motdepasse2.setCustomValidity(motdepasse2.value != motdepasse1.value ?  "Mot de passe non identique" : "")' class="form-control" id="motdepasse2" name="motdepasse2" minlength="5" maxlength="30" required/>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" onclick="Afficher2()">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Afficher le mot de passe</label>
                    </div>
                    <div name="message" class="invalid-feedback">
                        Mot de passe non identique
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="adresse"><span class="text-danger">*</span> Adresse</label>
                    <input type="text" class="form-control" pattern="[a-zA-Z0-9àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ- ]+" minlength="3" maxlength="45" autocomplete="off" spellcheck="false" name="adresse" id="adresse" placeholder="Votre adresse" required/>
                    <div class="valid-feedback">
                        Adresse Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ adresse est obligatoire et doit faire entre 3 et 45 caractères
                    </div>
                </div> 
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="ville"><span class="text-danger">*</span> Ville</label>
                    <input type="text" class="form-control" pattern="[a-zA-ZàâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ-]+" minlength="3" maxlength="45" autocomplete="off" spellcheck="false" name="ville" id="ville" placeholder="Votre ville" required/>
                    <div class="valid-feedback">
                        Ville Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ ville est obligatoire et doit faire entre 3 et 45 caractères
                    </div>
                </div> 
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="codePostal"><span class="text-danger">*</span> Code Postal</label>
                    <input type="text" class="form-control" pattern="[0-9]{5}" minlength="5" maxlength="5" size="5" autocomplete="off" spellcheck="false" name="codepostal" id="codepostal" placeholder="Exemple: 11000" required/>
                    <div class="valid-feedback">
                        Code Postal Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ code postal est obligatoire et doit être de longueur 5
                    </div>
                </div> 
            </div>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="telephone"><span class="text-danger">*</span> Téléphone</label>
                    <input type="tel" class="form-control" pattern="[0]{1}[1-9]{1}[0-9]{8}" minlength="10" maxlength="10" size="10" autocomplete="off" spellcheck="false" name="telephone" id="telephone" placeholder="Exemple: 0612345678" required/>
                    <div class="valid-feedback">
                        Téléphone Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ téléphone est obligatoire et doit être de longueur 10
                    </div>
                </div> 
            </div>
            <p class="user-select-none text-muted"><span class="text-danger">*</span> Obligatoire</p>
            <input type="submit" value="S'inscrire"  class="btn btn-primary" name="submit" id="submit"/>
        </fieldset>
    </form>
    
    <br>

    <?php
        if (isset($_POST['submit'])) {
            // Traitement de la photo
            if($_FILES) {
                switch($_FILES['photoUtilisateur']['type']) {
                    case 'image/jpeg': $extension = 'jpg'; break;
                    case 'image/png':  $extension = 'png'; break;
                    default:           $extension = ''; break;
                }
                if($extension && $_FILES['photoUtilisateur']['size'] < 30*1024*1024) {
                    // Changer le nom de l'image
                    $alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    $nom_alea = '';
                    for($i = 0; $i < 20; $i++) {
                        $nom_alea .= substr($alpha, rand() % (strlen($alpha)), 1);
                    }
                    date_default_timezone_set('Europe/Paris');
                    $nom_fichier = $nom_alea.date('_Y_m_d_H_i_s.').$extension;
                    $fileName = $_FILES['photoUtilisateur']['name'];
                    $tempName = $_FILES['photoUtilisateur']['tmp_name'];
                    if(!isset($fileName)) {
                        if(!$extension) echo $_FILES['photoUtilisateur']['name']."n'est pas accepté comme fichier image";
                        else echo "L'image dépasse les 30 Mo";
                    }
                } else {
                    $nom_fichier = "user.jpg";
                }
                // Traitement des données
                function valid_donnees($donnees) {
                    $donnees = trim($donnees);
                    $donnees = stripslashes($donnees);
                    $donnees = htmlspecialchars($donnees);
                    return $donnees;
                }
                // Vérification d'une donnée
                $ok = true;
                // Vérification mot de passe
                if($_POST['motdepasse1'] != $_POST['motdepasse2']) {
                    $ok = false;
                    throw new Exception("Les mots de passe ne correspondent pas.");
                }
                // Si tout est ok, on enregistre les données dans la base de données
                if ($ok) {
                    $client = new Utilisateur([
                        'nom' => valid_donnees($_POST['nom']),
                        'prenom' => valid_donnees($_POST['prenom']),
                        'pseudo' => $_POST['pseudo'],
                        'siren' => null,
                        'email' => $_POST['email'],
                        'motdepasse' => $_POST['motdepasse2'],
                        'photo' => $nom_fichier,
                        'adresse' => $_POST['adresse'],
                        'ville' => $_POST['ville'],
                        'codePostal' => $_POST['codepostal'],
                        'telephone' => $_POST['telephone']
                    ]);
                    $manager = new UtilisateurManager($db);
                    try {
                        $manager->addClient($client);
                        $location = 'images/utilisateurs/clients/';
                        move_uploaded_file($tempName, $location.$nom_fichier);
                        echo '<script>location.href="inscriptionReussie.php";</script>';
                    } catch (Exception $e) {
                        echo '<br><div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
                    }
                }
            }
        }
    ?>
</div>

<br>

<script src="assets/js/inscription.js"></script>

<?php
    include_once('includes/footer.inc.php');
?>