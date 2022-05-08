<?php
    class PanierManager {
        private $_db;

        public function __construct($db) {
            $this->setDB($db);
        }

        // Ajout d'un produit dans le panier
        public function addProduitPanier(Panier $produit) {
            $req = $this->_db->prepare('SELECT panier.id_produit FROM panier, produit WHERE panier.id_produit = produit.id_produit AND quantite_produit_panier <= quantite_produit AND panier.id_produit = :idProduit');
            $req->bindValue(':idProduit', $produit->idProduit(), PDO::PARAM_INT);
            $req->execute();

            $req1 = $this->_db->prepare('SELECT quantite_produit FROM produit WHERE id_produit = :idProduit');
            $req1->bindValue(':idProduit', $produit->idProduit(), PDO::PARAM_INT);
            $req1->execute();
            $req1 = $req1->fetch(PDO::FETCH_ASSOC);

            $req2 = $this->_db->prepare('SELECT quantite_produit_panier FROM panier WHERE id_produit = :idProduit');
            $req2->bindValue(':idProduit', $produit->idProduit(), PDO::PARAM_INT);
            $req2->execute();
            $req2 = $req2->fetch(PDO::FETCH_ASSOC);

            if ($req->rowCount() == 0 && $req1 > $req2) {
                $req = $this->_db->prepare('INSERT INTO panier (id_produit, id_utilisateur, quantite_produit_panier) VALUES(:idProduit, :idUser,:quantiteProduitPanier)');
                $req->bindValue(':idProduit', $produit->idProduit(), PDO::PARAM_INT);
                $req->bindValue(':idUser', $produit->idUtilisateur(), PDO::PARAM_STR);
                $req->bindValue(':quantiteProduitPanier', $produit->quantiteProduitPanier(), PDO::PARAM_INT);
                $req->execute();
            } else if ($req->rowCount() > 0 && $req1['quantite_produit'] > $req2['quantite_produit_panier']) {
                $req = $this->_db->prepare('UPDATE panier SET quantite_produit_panier = quantite_produit_panier + 1 WHERE id_produit = :idProduit AND id_utilisateur = :idUser');
                $req->bindValue(':idProduit', $produit->idProduit(), PDO::PARAM_INT);
                $req->bindValue(':idUser', $produit->idUtilisateur(), PDO::PARAM_STR);
                $req->execute();
            } else {
                throw new Exception("Plus de stock disponible");
            }
        }

        public function countProduitPanier($idUtilisateur) {
            $req = $this->_db->prepare('SELECT SUM(quantite_produit_panier) AS quantite_produit_panier FROM panier WHERE id_utilisateur = :idUser');
            $req->bindValue(':idUser', $idUtilisateur, PDO::PARAM_INT);
            $req->execute();
            $req = $req->fetch(PDO::FETCH_ASSOC);
            if (empty($req['quantite_produit_panier'])) {
                return '0';
            } else {
                return $req['quantite_produit_panier'];
            }
        }

        public function getProduitPanier($idUtilisateur) {
            $req = $this->_db->prepare('SELECT * FROM panier, produit WHERE panier.id_produit = produit.id_produit AND panier.id_utilisateur = :idUser');
            $req->bindValue(':idUser', $idUtilisateur, PDO::PARAM_INT);
            $req->execute();
            $req = $req->fetchAll(PDO::FETCH_ASSOC);
            return $req;
        }

        public function updateQuantitePanier($quantite, $idProduit, $idUtilisateur) {
            $req = $this->_db->prepare('UPDATE panier SET quantite_produit_panier = :quantite WHERE id_produit = :idProduit AND id_utilisateur = :idUser');
            $req->bindValue(':quantite', $quantite, PDO::PARAM_INT);
            $req->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $req->bindValue(':idUser', $idUtilisateur, PDO::PARAM_STR);
            $req->execute();
        }

        public function deleteProduitPanier($idUser, $idProduit) {
            $req = $this->_db->prepare('DELETE FROM panier WHERE id_utilisateur = :idUser AND id_produit = :idProduit');
            $req->bindValue(':idUser', $idUser, PDO::PARAM_INT);
            $req->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $req->execute();
        }

        public function deletePanier($idUser) {
            $req = $this->_db->prepare('DELETE FROM panier WHERE id_utilisateur = :idUser');
            $req->bindValue(':idUser', $idUser, PDO::PARAM_INT);
            $req->execute();
        }

        public function getTotalPanier($idUser) {
            $req = $this->_db->prepare('SELECT SUM(produit.prix_produit * panier.quantite_produit_panier) AS total_panier, round((SUM(produit.prix_produit * panier.quantite_produit_panier) * 0.1), 2) AS livraison FROM panier, produit WHERE panier.id_produit = produit.id_produit AND panier.id_utilisateur = :idUser');
            $req->bindValue(':idUser', $idUser, PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getTotalProduit($idProduit, $idUser) {
            $req = $this->_db->prepare('SELECT SUM(produit.prix_produit * panier.quantite_produit_panier) AS total_panier, round((SUM(produit.prix_produit * panier.quantite_produit_panier) * 0.1), 2) AS livraison FROM panier, produit WHERE panier.id_produit = produit.id_produit AND panier.id_produit = :idProduit AND panier.id_utilisateur = :idUser');
            $req->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $req->bindValue(':idUser', $idUser, PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        public function setDB(PDO $db) {
            $this->_db = $db;
        }
    }
?>