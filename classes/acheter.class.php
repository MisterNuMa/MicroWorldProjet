<?php
    class Acheter {
        private $_idUtilisateur;
        private $_idProduit;
        private $_quantiteProduit;
        private $_prixTotal;

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
        public function idUtilisateur() {
            return $this->_idUtilisateur;
        }

        public function idProduit() {
            return $this->_idProduit;
        }

        public function quantiteProduit() {
            return $this->_quantiteProduit;
        }

        public function prixTotal() {
            return $this->_prixTotal;
        }

        // Setters
        public function setIdUtilisateur($idUtilisateur) {
            $this->_idUtilisateur = $idUtilisateur;
        }

        public function setIdProduit($idProduit) {
            $this->_idProduit = $idProduit;
        }

        public function setQuantiteProduit($quantiteProduit) {
            $this->_quantiteProduit = $quantiteProduit;
        }

        public function setPrixTotal($prixTotal) {
            $this->_prixTotal = $prixTotal;
        }
    }
?>