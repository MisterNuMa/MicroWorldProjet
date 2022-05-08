<?php
    class UtilisateurManager {
        private $_db;

        public function __construct($db) {
            $this->setDB($db);
        }

        // Ajoute un client dans la base de données
        public function addClient(Utilisateur $client) {
            // Vérification des doublons d'adresse mail
            $req = $this->_db->prepare("SELECT email_utilisateur FROM utilisateur WHERE email_utilisateur = :email");
            $req->bindValue(':email', $client->getEmail());
            $req->execute();
            $result = $req->rowCount();
            if ($result > 0) {
                throw new Exception("Cette adresse mail est déjà utilisée par un autre compte. Veuiller en utiliser une autre.");
            }
    
            // Vérification des doublons de pseudo
            $req = $this->_db->prepare("SELECT pseudo_utilisateur FROM utilisateur WHERE pseudo_utilisateur = :pseudo");
            $req->bindValue(':pseudo', $client->getPseudo());
            $req->execute();
            $result = $req->rowCount();
            if ($result > 0) {
                throw new Exception("Ce pseudo est déjà utilisé par un autre compte. Veuiller en choisir un autre.");
            }

            //Vérification des données
            $ok = true;
            
            // Vérification du nom
            if (empty($client->getNom())
                ||
                strlen($client->getNom()) < 3
                ||
                strlen($client->getNom()) > 45
                ||
                !preg_match("/^[a-zA-Z àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ-]{3,45}$/", $client->getNom())) {
            $ok = false;
            throw new Exception("Veuillez entrer un nom valide.");
            }

            // Vérification du prénom
            if (empty($client->getPrenom())
                ||
                strlen($client->getPrenom()) < 3
                ||
                strlen($client->getPrenom()) > 45
                ||
                !preg_match("/^[a-zA-Z àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ-]{3,45}$/", $client->getPrenom())) {
            $ok = false;
            throw new Exception("Veuillez entrer un prénom valide.");
            }

            // Vérification du pseudo
            if (empty($client->getPseudo())
                ||
                strlen($client->getPseudo()) < 3
                ||
                strlen($client->getPseudo()) > 45
                ||
                !preg_match("/^[a-zA-Z0-9 .&àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ_-]{3,45}$/", $client->getPseudo())) {
            $ok = false;
            throw new Exception("Veuillez entrer un pseudo valide.");
            }

            // Vérification de l'adresse mail
            if (empty($client->getEmail())
                ||
                strlen($client->getEmail()) < 3
                ||
                strlen($client->getEmail()) > 45
                ||
                !filter_var($client->getEmail(), FILTER_VALIDATE_EMAIL)
                ||
                !preg_match("/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/", $client->getEmail())) {
            $ok = false;
            throw new Exception("Veuillez entrer une adresse mail valide.");
            }

            // Vérification de l'adresse
            if (empty($client->getAdresse())
                ||
                strlen($client->getAdresse()) < 3
                ||
                strlen($client->getAdresse()) > 45
                ||
                !preg_match("/^[0-9a-zA-Z àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ-]{3,45}$/", $client->getAdresse())) {
            $ok = false;
            throw new Exception("Veuillez entrer une adresse valide.");
            }

            // Vérification de la ville
            if (empty($client->getVille())
                ||
                strlen($client->getVille()) < 3
                ||
                strlen($client->getVille()) > 45
                ||
                !preg_match("/^[a-zA-Z àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ-]{3,45}$/", $client->getVille())) {
            $ok = false;
            throw new Exception("Veuillez entrer une ville valide.");
            }

            // Vérification du code postal
            if (empty($client->getCodePostal())
                ||
                strlen($client->getCodePostal()) != 5
                ||
                !preg_match("/^[0-9]{5}$/", $client->getCodePostal())) {
            $ok = false;
            throw new Exception("Veuillez entrer un code postal valide.");
            }

            // Vérification du téléphone
            if (empty($client->getTelephone())
                ||
                strlen($client->getTelephone()) != 10
                ||
                !preg_match("/^[0]{1}[1-9]{1}[0-9]{8}$/", $client->getTelephone())) {
            $ok = false;
            throw new Exception("Veuillez entrer un numéro de téléphone valide.");
            }

            // Insertion dans la base de données
            if ($ok) { // Si tout est ok
                $req = $this->_db->prepare('INSERT INTO utilisateur (type_utilisateur, active_utilisateur, nom_utilisateur, prenom_utilisateur, pseudo_utilisateur, email_utilisateur, mot_de_passe_utilisateur, photo_utilisateur, adresse_utilisateur, ville_utilisateur, code_postal_utilisateur, telephone_utilisateur) VALUES ("client", 1, InitCap(:nom), InitCap(:prenom), :pseudo, :email, :motDePasse, :photo, :adresse, InitCap(:ville), :codePostal, :telephone)');
                $req->bindValue(':nom', $client->getNom(), PDO::PARAM_STR);
                $req->bindValue(':prenom', $client->getPrenom(), PDO::PARAM_STR);
                $req->bindValue(':pseudo', $client->getPseudo(), PDO::PARAM_STR);
                $req->bindValue(':email', $client->getEmail(), PDO::PARAM_STR);
                $req->bindValue(':motDePasse', hash('sha512', $client->getMotDePasse()), PDO::PARAM_STR);
                $req->bindValue(':photo', $client->getPhoto(), PDO::PARAM_STR);
                $req->bindValue(':adresse', $client->getAdresse(), PDO::PARAM_STR);
                $req->bindValue(':ville', $client->getVille(), PDO::PARAM_STR);
                $req->bindValue(':codePostal', $client->getCodePostal(), PDO::PARAM_STR);
                $req->bindValue(':telephone', $client->getTelephone(), PDO::PARAM_STR);
                $req->execute();
            }
        }

        // Ajoute un employe dans la base de données
        public function addEmploye(Utilisateur $employe) {
            // Vérification des doublons d'adresse mail
            $req = $this->_db->prepare("SELECT email_utilisateur FROM utilisateur WHERE email_utilisateur = :email");
            $req->bindValue(':email', $employe->getEmail());
            $req->execute();
            $result = $req->rowCount();
            if ($result > 0) {
                throw new Exception("Cette adresse mail est déjà utilisée par un autre compte. Veuiller en utiliser une autre.");
            }
    
            // Vérification des doublons de pseudo
            $req = $this->_db->prepare("SELECT pseudo_utilisateur FROM utilisateur WHERE pseudo_utilisateur = :pseudo");
            $req->bindValue(':pseudo', $employe->getPseudo());
            $req->execute();
            $result = $req->rowCount();
            if ($result > 0) {
                throw new Exception("Ce pseudo est déjà utilisé par un autre compte. Veuiller en choisir un autre.");
            }

            //Vérification des données
            $ok = true;
            
            // Vérification du nom
            if (empty($employe->getNom())
                ||
                strlen($employe->getNom()) < 3
                ||
                strlen($employe->getNom()) > 45
                ||
                !preg_match("/^[a-zA-Z àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ-]{3,45}$/", $employe->getNom())) {
            $ok = false;
            throw new Exception("Veuillez entrer un nom valide.");
            }

            // Vérification du prénom
            if (empty($employe->getPrenom())
                ||
                strlen($employe->getPrenom()) < 3
                ||
                strlen($employe->getPrenom()) > 45
                ||
                !preg_match("/^[a-zA-Z àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ-]{3,45}$/", $employe->getPrenom())) {
            $ok = false;
            throw new Exception("Veuillez entrer un prénom valide.");
            }

            // Vérification du pseudo
            if (empty($employe->getPseudo())
                ||
                strlen($employe->getPseudo()) < 3
                ||
                strlen($employe->getPseudo()) > 45
                ||
                !preg_match("/^[a-zA-Z0-9 .&àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ_-]{3,45}$/", $employe->getPseudo())) {
            $ok = false;
            throw new Exception("Veuillez entrer un pseudo valide.");
            }

            // Vérification du siren
            if (empty($employe->getSiren())
                ||
                strlen($employe->getSiren()) != 9
                ||
                !preg_match("/^[0-9]{9}$/", $employe->getSiren())) {
            $ok = false;
            throw new Exception("Veuillez entrer un numéro de siren valide.");
            }

            // Vérification de l'adresse mail
            if (empty($employe->getEmail())
                ||
                strlen($employe->getEmail()) < 3
                ||
                strlen($employe->getEmail()) > 45
                ||
                !filter_var($employe->getEmail(), FILTER_VALIDATE_EMAIL)
                ||
                !preg_match("/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/", $employe->getEmail())) {
            $ok = false;
            throw new Exception("Veuillez entrer une adresse mail valide.");
            }

            // Insertion dans la base de données
            if ($ok) { // Si tout est ok
                $req = $this->_db->prepare('INSERT INTO utilisateur (type_utilisateur, active_utilisateur, nom_utilisateur, prenom_utilisateur, pseudo_utilisateur, siren_utilisateur, email_utilisateur, mot_de_passe_utilisateur, photo_utilisateur) VALUES ("employe", 0, InitCap(:nom), InitCap(:prenom), :pseudo, :siren, :email, :motDePasse, :photo)');
                $req->bindValue(':nom', $employe->getNom(), PDO::PARAM_STR);
                $req->bindValue(':prenom', $employe->getPrenom(), PDO::PARAM_STR);
                $req->bindValue(':pseudo', $employe->getPseudo(), PDO::PARAM_STR);
                $req->bindValue(':siren', $employe->getSiren(), PDO::PARAM_STR);
                $req->bindValue(':email', $employe->getEmail(), PDO::PARAM_STR);
                $req->bindValue(':motDePasse', hash('sha512', $employe->getMotDePasse()), PDO::PARAM_STR);
                $req->bindValue(':photo', $employe->getPhoto(), PDO::PARAM_STR);
                $req->execute();
            }
        }
        
        // Connecte un utilisateur
        public function connectUtilisateur($email, $motDePasse) {
            $req = $this->_db->prepare('SELECT * FROM utilisateur WHERE email_utilisateur = :email AND mot_de_passe_utilisateur = :motDePasse');
            $req->bindValue(':email', $email, PDO::PARAM_STR);
            $req->bindValue(':motDePasse', hash('sha512', $motDePasse), PDO::PARAM_STR);
            $req->execute();
            $result = $req->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                if ($result['active_utilisateur'] == 1) {
                    // On récupère le prénom pour le message d'accueil
                    $_SESSION['login'] = true;
                    $_SESSION['id'] = htmlentities($result['id_utilisateur']);
                    $_SESSION['type'] = htmlentities($result['type_utilisateur']);
                    $_SESSION['prenom'] = htmlentities($result['prenom_utilisateur']);
                    $_SESSION['nom'] = htmlentities($result['nom_utilisateur']);
                    $_SESSION['pseudo'] = htmlentities($result['pseudo_utilisateur']);
                    $_SESSION['siren'] = htmlentities($result['siren_utilisateur']);
                    $_SESSION['email'] = htmlentities($result['email_utilisateur']);
                    $_SESSION['photo_profil'] = htmlentities($result['photo_utilisateur']);
                    $_SESSION['adresse'] = htmlentities($result['adresse_utilisateur']);
                    $_SESSION['ville'] = htmlentities($result['ville_utilisateur']);
                    $_SESSION['code_postal'] = htmlentities($result['code_postal_utilisateur']);
                    $_SESSION['telephone'] = htmlentities($result['telephone_utilisateur']);
                    unset($result);
                } else {
                    throw new Exception("Votre compte n'est pas activé. Veuiller demander à un administrateur pour plus de renseignement.");
                }
            } else {
                throw new Exception("Votre email ou votre mot de passe est incorrect.");
            }
        }

        // Déconnecte un utilisateur
        public function deconnectUtilisateur() {
            session_destroy();
            echo '<script>location.href=".";</script>';
            exit;
        }

        // Supprime un utilisateur
        public function deleteUtilisateur($id) {
            $req = $this->_db->prepare('DELETE FROM utilisateur WHERE id_utilisateur = :id');
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();
        }

        // Gérer les utilisateurs
        public function gestionUtilisateur() {
            $req = $this->_db->query('SELECT id_utilisateur, type_utilisateur, active_utilisateur, email_utilisateur FROM utilisateur WHERE type_utilisateur != "admin" ORDER BY id_utilisateur DESC');
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        // Active un utilisateur
        public function activerUtilisateur($id) {
            $this->_db->exec('UPDATE utilisateur SET active_utilisateur = 1 WHERE id_utilisateur = '.$id);
        }

        // Désactive un utilisateur
        public function desactiverUtilisateur($id) {
            $this->_db->exec('UPDATE utilisateur SET active_utilisateur = 0 WHERE id_utilisateur = '.$id.' AND type_utilisateur != "admin"');
        }

        // Compter nombre de produits mis par un employe
        public function countProduits($id) {
            $req = $this->_db->prepare('SELECT nombre_produit(:id) AS nombre_produit');
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();
            return $req->fetch(PDO::FETCH_ASSOC);
        }

        public function setDB(PDO $db) {
            $this->_db = $db;
        }
    }
?>