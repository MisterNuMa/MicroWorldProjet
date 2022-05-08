<?php
    class acheterManager {
        private $_db;

        public function __construct($db) {
            $this->setDB($db);
        }

        // Ajout d'un produit dans le panier
        public function addAcheterProduitPanier(acheter $produit) {
            // Vérification du nombre de produits dans le panier et dans la table produit
            $req = $this->_db->prepare('SELECT quantite_produit FROM produit WHERE id_produit = :idProduit');
            $req->bindValue(':idProduit', $produit->idProduit());
            $req->execute();
            $quantiteProduit = $req->fetch(PDO::FETCH_ASSOC);

            // Si le nombre de produits dans le panier est inférieur au nombre de produits dans la table produit
            if ($produit->quantiteProduit() <= $quantiteProduit['quantite_produit']) {
                // Ajout du produit dans la table acheter
                $req = $this->_db->prepare('INSERT INTO acheter (id_utilisateur, id_produit, quantite_acheter_produit, date_achat, prix_total) VALUES(:idUser, :idProduit,:quantiteProduitPanier, NOW(), :prixTotal)');
                $req->bindValue(':idUser', $produit->idUtilisateur(), PDO::PARAM_INT);
                $req->bindValue(':idProduit', $produit->idProduit(), PDO::PARAM_INT);
                $req->bindValue(':quantiteProduitPanier', $produit->quantiteProduit(), PDO::PARAM_INT);
                $req->bindValue(':prixTotal', $produit->prixTotal(), PDO::PARAM_INT);
                $req->execute();
            } else { // Si le nombre de produits dans le panier est supérieur au nombre de produits dans la table produit
                throw new Exception('Désolé, il n\'y a plus de produit(s) en stock');
            }
        }

        // Achat d'un produit
        public function achatProduit(acheter $acheter) {
            // Vérification du nombre de produits dans la table produit
            $req = $this->_db->prepare('SELECT quantite_produit FROM produit WHERE id_produit = :idProduit');
            $req->bindValue(':idProduit', $acheter->idProduit());
            $req->execute();
            $quantiteProduit = $req->fetch(PDO::FETCH_ASSOC);
            // Si le nombre de produits dans la table produit est inférieur au nombre de produits dans le panier
            if ($quantiteProduit['quantite_produit'] >= $acheter->quantiteProduit()) {
                // Ajout du produit dans la table acheter
                $req = $this->_db->prepare('INSERT INTO acheter (id_utilisateur, id_produit, quantite_acheter_produit, date_achat, prix_total) VALUES (:idUser, :idProduit, :quantiteProduit, NOW(), :prixTotal)');
                $req->bindValue(':idUser', $acheter->idUtilisateur(), PDO::PARAM_INT);
                $req->bindValue(':idProduit', $acheter->idProduit(), PDO::PARAM_INT);
                $req->bindValue(':quantiteProduit', $acheter->quantiteProduit(), PDO::PARAM_INT);
                $req->bindValue(':prixTotal', $acheter->prixTotal(), PDO::PARAM_STR);
                $req->execute();
                // Mise à jour de la quantité de produit dans la table produit
                $req = $this->_db->prepare('UPDATE produit SET quantite_produit = quantite_produit - :quantiteProduit WHERE id_produit = :idProduit');
                $req->bindValue(':quantiteProduit', $acheter->quantiteProduit(), PDO::PARAM_INT);
                $req->bindValue(':idProduit', $acheter->idProduit(), PDO::PARAM_INT);
                $req->execute();
            } else { // Si le nombre de produits dans la table produit est supérieur au nombre de produits dans le panier
                throw new Exception('Désolé, il n\'y a plus de produit(s) en stock');
            }
        }

        // Récupération de tous les produits achetés par un utilisateur
        public function getProduitAcheter($idUser) {
            $req = $this->_db->prepare('SELECT titre_produit, photo_produit_1, quantite_acheter_produit, date_achat, prix_total FROM acheter, produit WHERE acheter.id_produit = produit.id_produit AND acheter.id_utilisateur = :idUser');
            $req->bindValue(':idUser', $idUser, PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        public function setDB(PDO $db) {
            $this->_db = $db;
        }
    }
?>