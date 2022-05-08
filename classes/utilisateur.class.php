<?php
    class Utilisateur {
        private $_nom;
        private $_prenom;
        private $_pseudo;
        private $_siren;
        private $_email;
        private $_motDePasse;
        private $_photo;
        private $_adresse;
        private $_ville;
        private $_codePostal;
        private $_telephone;

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
        public function getNom() {
            return $this->_nom;
        }

        public function getPrenom() {
            return $this->_prenom;
        }

        public function getPseudo() {
            return $this->_pseudo;
        }

        public function getSiren() {
            return $this->_siren;
        }

        public function getEmail() {
            return $this->_email;
        }

        public function getMotDePasse() {
            return $this->_motDePasse;
        }

        public function getPhoto() {
            return $this->_photo;
        }

        public function getAdresse() {
            return $this->_adresse;
        }

        public function getVille() {
            return $this->_ville;
        }

        public function getCodePostal() {
            return $this->_codePostal;
        }

        public function getTelephone() {
            return $this->_telephone;
        }

        // Setters

        public function setNom($nom) {
            $this->_nom = $nom;
        }

        public function setPrenom($prenom) {
            $this->_prenom = $prenom;
        }

        public function setPseudo($pseudo) {
            $this->_pseudo = $pseudo;
        }

        public function setSiren($siren) {
            $this->_siren = $siren;
        }

        public function setEmail($email) {
            $this->_email = $email;
        }

        public function setMotDePasse($motDePasse) {
            $this->_motDePasse = $motDePasse;
        }

        public function setPhoto($photo) {
            $this->_photo = $photo;
        }

        public function setAdresse($adresse) {
            $this->_adresse = $adresse;
        }

        public function setVille($ville) {
            $this->_ville = $ville;
        }

        public function setCodePostal($codePostal) {
            $this->_codePostal = $codePostal;
        }

        public function setTelephone($telephone) {
            $this->_telephone = $telephone;
        }
    }
?>