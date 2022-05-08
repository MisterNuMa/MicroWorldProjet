<?php
    class ProduitManager {
        private $_db;

        public function __construct($db) {
            $this->setDB($db);
        }

        // Ajout produit dans la base de données
        public function addProduit(Produit $produit) {
            // Vérification des doublons de nom de produit
            $req = $this->_db->prepare("SELECT titre_produit FROM produit WHERE titre_produit = :titreProduit");
            $req->bindValue(':titreProduit', $produit->getTitreProduit());
            $req->execute();
            $result = $req->rowCount();
            if ($result > 0) {
                throw new Exception("Ce produit est déjà en ligne. Veuiller en mettre un autre.");
            }

            // Vérification des données
            $ok = true;

            // Vérification du titre
            if (empty($produit->getTitreProduit())
                ||
                strlen($produit->getTitreProduit()) < 3
                ||
                strlen($produit->getTitreProduit()) > 45
                ||
                !preg_match("/^[a-zA-Z0-9 .&%àâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ_-]{3,45}$/", $produit->getTitreProduit())) {
            $ok = false;
            throw new Exception("Veuillez entrer un titre valide.");
            }

            // Vérification de la description
            if (empty($produit->getDescriptionProduit())
                ||
                strlen($produit->getDescriptionProduit()) < 500
                ||
                strlen($produit->getDescriptionProduit()) > 2000) {
            $ok = false;
            throw new Exception("Veuillez entrer une description valide.");
            }

            // Vérification des caractèristiques
            if (empty($produit->getCaracteristiqueProduit())
                ||
                strlen($produit->getCaracteristiqueProduit()) < 500
                ||
                strlen($produit->getCaracteristiqueProduit()) > 2000) {
            $ok = false;
            throw new Exception("Veuillez entrer des caractéristiques valide.");
            }

            // Vérification du prix
            if (empty($produit->getPrixProduit())
                ||
                $produit->getPrixProduit() < 0.00) {
            $ok = false;
            throw new Exception("Veuillez entrer un prix valide.");
            }

            // Vérification de la quantité
            if (empty($produit->getQuantiteProduit())
                ||
                $produit->getQuantiteProduit() < 0) {
            $ok = false;
            throw new Exception("Veuillez entrer une quantité valide.");
            }

            // Vérification de la photo 1
            if (empty($produit->getPhotoProduit1())) {
                $ok = false;
                throw new Exception("Veuillez entrer une photo valide.");
            }

            // Vérification de la photo 2
            if (empty($produit->getPhotoProduit2())) {
                $ok = false;
                throw new Exception("Veuillez entrer une photo valide.");
            }

            // Vérification de la photo 3
            if (empty($produit->getPhotoProduit3())) {
                $ok = false;
                throw new Exception("Veuillez entrer une photo valide.");
            }

            // Vérification du tag
            if (empty($produit->getIdTag())) {
                $ok = false;
                throw new Exception("Veuillez entrer un tag valide.");
            }
            if ($ok) {
                $req = $this->_db->prepare('INSERT INTO produit (titre_produit, description_produit, caracteristique_produit, prix_produit, quantite_produit, photo_produit_1, photo_produit_2, photo_produit_3, id_tag, id_utilisateur) VALUES (:titreProduit, :descriptionProduit, :caracteritiqueProduit, :prixProduit, :quantiteProduit, :photoProduit1, :photoProduit2, :photoProduit3, :idTag, :idUser)');
                $req->bindValue(':titreProduit', $produit->getTitreProduit(), PDO::PARAM_STR);
                $req->bindValue(':descriptionProduit', $produit->getDescriptionProduit(), PDO::PARAM_STR);
                $req->bindValue(':caracteritiqueProduit', $produit->getCaracteristiqueProduit(), PDO::PARAM_STR);
                $req->bindValue(':prixProduit', $produit->getPrixProduit(), PDO::PARAM_STR);
                $req->bindValue(':quantiteProduit', $produit->getQuantiteProduit(), PDO::PARAM_INT);
                $req->bindValue(':photoProduit1', $produit->getPhotoProduit1(), PDO::PARAM_STR);
                $req->bindValue(':photoProduit2', $produit->getPhotoProduit2(), PDO::PARAM_STR);
                $req->bindValue(':photoProduit3', $produit->getPhotoProduit3(), PDO::PARAM_STR);
                $req->bindValue(':idTag', $produit->getIdTag(), PDO::PARAM_STR);
                $req->bindValue(':idUser', $produit->getIdUser(), PDO::PARAM_INT);
                $req->execute();
            }
        }

        // Afficher les produits
        public function getProduits() {
            $req = $this->_db->query('SELECT * FROM produit, utilisateur, tag WHERE produit.id_utilisateur = utilisateur.id_utilisateur AND produit.id_tag = tag.id_tag AND tag.active_tag = 1 AND active_produit = 1 ORDER BY id_produit DESC');
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        // Afficher les produits par tag
        public function getProduitsByTag($idTag) {
            $req = $this->_db->prepare('SELECT * FROM produit, utilisateur, tag WHERE produit.id_utilisateur = utilisateur.id_utilisateur AND produit.id_tag = tag.id_tag AND tag.active_tag = 1 AND active_produit = 1 AND tag.id_tag = :idTag ORDER BY id_produit DESC');
            $req->bindValue(':idTag', $idTag, PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        // Afficher les produits par tag
        public function getProduitsByTagAndProduit($idTag, $idProduit) {
            $req = $this->_db->prepare('SELECT * FROM produit, utilisateur, tag WHERE produit.id_utilisateur = utilisateur.id_utilisateur AND produit.id_tag = tag.id_tag AND tag.active_tag = 1 AND active_produit = 1 AND tag.id_tag = :idTag AND id_produit != :idProduit ORDER BY id_produit DESC');
            $req->bindValue(':idTag', $idTag, PDO::PARAM_INT);
            $req->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        // Afficher les produits par id
        public function getProduitsById($idProduit) {
            $req = $this->_db->prepare('SELECT * FROM produit, utilisateur WHERE produit.id_utilisateur = utilisateur.id_utilisateur AND active_produit = 1 AND id_produit = :idProduit ORDER BY id_produit DESC');
            $req->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        // Gestion des produits
        public function gestionProduit() {
            $req = $this->_db->query('SELECT id_produit, titre_produit, photo_produit_1, photo_produit_2, photo_produit_3, active_produit, email_utilisateur, nom_tag, quantite_produit FROM produit, utilisateur, tag WHERE produit.id_utilisateur = utilisateur.id_utilisateur AND produit.id_tag = tag.id_tag ORDER BY id_produit DESC');
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        // Activation des produits
        public function activerProduit($idProduit) {
            $req = $this->_db->prepare('UPDATE produit SET active_produit = 1 WHERE id_produit = :idProduit');
            $req->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $req->execute();
        }

        // Désactivation des produits
        public function desactiverProduit($idProduit) {
            $req = $this->_db->prepare('UPDATE produit SET active_produit = 0 WHERE id_produit = :idProduit');
            $req->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $req->execute();
        }

        // Suppression des produits
        public function deleteProduit($idProduit) {
            $req = $this->_db->prepare('DELETE FROM produit WHERE id_produit = :idProduit');
            $req->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $req->execute();
        }

        // Modification quantité produit
        public function updateQuantiteProduit($idProduit, $quantite) {
            $req = $this->_db->prepare('UPDATE produit SET quantite_produit = quantite_produit - :quantite WHERE id_produit = :idProduit');
            $req->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $req->bindValue(':quantite', $quantite, PDO::PARAM_INT);
            $req->execute();
        }

        // Recherche d'un produit
        public function searchProduit($search) {
            $req = $this->_db->prepare('SELECT * FROM produit, utilisateur, tag WHERE produit.id_utilisateur = utilisateur.id_utilisateur AND produit.id_tag = tag.id_tag AND tag.active_tag = 1 AND active_produit = 1 AND (titre_produit LIKE :search OR description_produit LIKE :search OR caracteristique_produit LIKE :search OR pseudo_utilisateur LIKE :search OR nom_tag LIKE :search) ORDER BY id_produit DESC');
            $req->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        public function setDB(PDO $db) {
            $this->_db = $db;
        }
    }
?>