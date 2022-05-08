<?php
    class Tag {
        private $_nomTag;
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
        public function getNomTag() {
            return $this->_nomTag;
        }

        public function getIdUser() {
            return $this->_idUser;
        }
        
        // Setters
        public function setNomTag($nomTag) {
            $this->_nomTag = $nomTag;
        }

        public function setIdUser($idUser) {
            $this->_idUser = $idUser;
        }
    }
?>