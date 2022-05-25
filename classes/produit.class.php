<?php
    class Produit {
        private $_titreProduit;
        private $_descriptionProduit;
        private $_caracteristiqueProduit;
        private $_prixProduit;
        private $_quantiteProduit;
        private $_quantiteProduitAlerte;
        private $_photoProduit1;
        private $_photoProduit2;
        private $_photoProduit3;
        private $_idTag;
        private $_idUser;

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
        public function getTitreProduit() {
            return $this->_titreProduit;
        }

        public function getDescriptionProduit() {
            return $this->_descriptionProduit;
        }

        public function getCaracteristiqueProduit() {
            return $this->_caracteristiqueProduit;
        }

        public function getPrixProduit() {
            return $this->_prixProduit;
        }

        public function getQuantiteProduit() {
            return $this->_quantiteProduit;
        }

        public function getQuantiteProduitAlerte() {
            return $this->_quantiteProduitAlerte;
        }

        public function getPhotoProduit1() {
            return $this->_photoProduit1;
        }

        public function getPhotoProduit2() {
            return $this->_photoProduit2;
        }

        public function getPhotoProduit3() {
            return $this->_photoProduit3;
        }

        public function getIdTag() {
            return $this->_idTag;
        }

        public function getIdUser() {
            return $this->_idUser;
        }

        // Setters
        public function setTitreProduit($titreProduit) {
            $this->_titreProduit = $titreProduit;
        }

        public function setDescriptionProduit($descriptionProduit) {
            $this->_descriptionProduit = $descriptionProduit;
        }

        public function setCaracteristiqueProduit($caracteristiqueProduit) {
            $this->_caracteristiqueProduit = $caracteristiqueProduit;
        }

        public function setPrixProduit($prixProduit) {
            $this->_prixProduit = $prixProduit;
        }

        public function setQuantiteProduit($quantiteProduit) {
            $this->_quantiteProduit = $quantiteProduit;
        }

        public function setQuantiteProduitAlerte($quantiteProduitAlerte) {
            $this->_quantiteProduitAlerte = $quantiteProduitAlerte;
        }

        public function setPhotoProduit1($photoProduit) {
            $this->_photoProduit1 = $photoProduit;
        }

        public function setPhotoProduit2($photoProduit) {
            $this->_photoProduit2 = $photoProduit;
        }

        public function setPhotoProduit3($photoProduit) {
            $this->_photoProduit3 = $photoProduit;
        }

        public function setIdTag($idTag) {
            $this->_idTag = $idTag;
        }

        public function setIdUser($idUser) {
            $this->_idUser = $idUser;
        }
    }
?>