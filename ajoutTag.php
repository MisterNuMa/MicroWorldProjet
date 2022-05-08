<?php
    include_once('includes/header.inc.php');

    if($_SESSION['type'] != "admin" && $_SESSION['type'] != "employe") {
        echo '<script>location.href=".";</script>';
    }
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Formulaire ajout d'un Tag</h1>
            <p class="lead fw-normal text-white-50 mb-0">Votre tag sera bientôt disponible</p>
        </div>
    </div>
</header>

<br>

<div class="container">
    <div class="jumbotron">
        <form  method="post" action=""  id="form"  enctype="multipart/form-data" novalidate>
            <fieldset>
            <div class="form-group row">
                <div class="col-md-4 mb-3">
                    <label for="prenom">Nom du Tag</label>
                    <input type="text" class="form-control" pattern="[a-zA-Z .&àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ-]+" minlength="3" maxlength="45" name="tag" id="tag" required/>
                    <div class="valid-feedback">
                        Tag Ok !
                    </div>
                    <div class="invalid-feedback">
                        Le champ tag est obligatoire et doit faire entre 3 et 45 caractères
                    </div>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Confirmer" id="submit" name="submit"/>
                </div>
            </div>
            </fieldset>
        </form>
        <?php
            if(isset($_POST['submit'])) {
                try {
                    $tag = new Tag([
                        'nomTag' => $_POST['tag'],
                        'idUser' => $_SESSION['id']
                    ]);
                    $tagManager = new TagManager($db);
                    $tagManager->addTag($tag);
                    echo '<div class="alert alert-success" role="alert">Le tag a été ajouté avec succès !</div>';
                } catch (Exception $e) {
                    echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
                }
            }
        ?>
    </div>
</div>

<br>

<script src="assets/js/ajoutTag.js"></script>

<?php
    include_once('includes/footer.inc.php');
?>