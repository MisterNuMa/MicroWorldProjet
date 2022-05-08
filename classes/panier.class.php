<?php
    class Panier {
        private $_idProduit;
        private $_idUtilisateur;
        private $_quantiteProduitPanier;

        // Constructeur
        public function __construct(array $donnees) {
            $this->hydrate($donnees);
        }

        // Hydratation
        public function hydrate(array $donnees) {
            foreach ($donnees as $key => $value) {
                $method = 'set'.ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                } else {
                    trigger_error('Je trouve pas la méthode !'.$key, E_USER_WARNING);
                }
            }
        }

        // Getters
        public function idProduit() {
            return $this->_idProduit;
        }

        public function idUtilisateur() {
            return $this->_idUtilisateur;
        }

        public function quantiteProduitPanier() {
            return $this->_quantiteProduitPanier;
        }

        // Setters
        public function setIdProduit($idProduit) {
            $this->_idProduit = $idProduit;
        }

        public function setIdUtilisateur($idUtilisateur) {
            $this->_idUtilisateur = $idUtilisateur;
        }

        public function setQuantiteProduitPanier($quantiteProduitPanier) {
            $this->_quantiteProduitPanier = $quantiteProduitPanier;
        }
    }
?>