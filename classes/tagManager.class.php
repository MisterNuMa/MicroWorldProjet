<?php
    class TagManager {
        private $_db;

        public function __construct($db) {
            $this->setDB($db);
        }

        // Ajoute un tag dans la base de données
        public function addTag(Tag $tag) {
            // Vérification des doublons de tag
            $req = $this->_db->prepare("SELECT nom_tag FROM tag WHERE nom_tag = InitCap(:nomTag)");
            $req->bindValue(':nomTag', $tag->getNomTag());
            $req->execute();
            $result = $req->rowCount();
            if ($result > 0) {
                throw new Exception("Ce tag est déjà sur nôtre site. Veuiller en définir un autre.");
            }

            // Vérification de la donnée
            $ok = true;

            // Vérification du libelle du tag
            if(empty($tag->getNomTag())
                ||
                strlen($tag->getNomTag()) < 3
                ||
                strlen($tag->getNomTag()) > 45) {
            $ok = false;
            throw new Exception("Veuillez entrer un tag valide.");
            }

            if ($ok) {
                $req = $this->_db->prepare('INSERT INTO tag (nom_tag, id_utilisateur) VALUES (InitCap(:nomTag), :idUser)');
                $req->bindValue(':nomTag', $tag->getNomTag(), PDO::PARAM_STR);
                $req->bindValue(':idUser', $tag->getIdUser(), PDO::PARAM_INT);
                $req->execute();
            }
        }

        // Retourne tous les tags de la base de données
        public function getTags() {
            $req = $this->_db->query('SELECT * FROM tag WHERE active_tag = 1 ORDER BY id_tag DESC');
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        // Retourne tous les tags sauf celui de l'id de la base de données
        public function getTagsExcept($idTag) {
            $req = $this->_db->prepare('SELECT * FROM tag WHERE active_tag = 1 AND id_tag != :idTag ORDER BY id_tag DESC');
            $req->bindValue(':idTag', $idTag, PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        // Retourne un tag
        public function gestionTag() {
            $req = $this->_db->query('SELECT id_tag, nom_tag, active_tag, utilisateur.id_utilisateur FROM tag, utilisateur WHERE tag.id_utilisateur = utilisateur.id_utilisateur ORDER BY id_tag DESC');
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        // Supprime un tag
        public function deleteTag($id) {
            $this->_db->exec('DELETE FROM tag WHERE id_tag = '.$id);
        }

        // Active un tag
        public function activerTag($id) {
            $this->_db->exec('UPDATE tag SET active_tag = 1 WHERE id_tag = '.$id);
        }

        // Désactive un tag
        public function desactiverTag($id) {
            $this->_db->exec('UPDATE tag SET active_tag = 0 WHERE id_tag = '.$id);
        }

        public function setDB(PDO $db) {
            $this->_db = $db;
        }
    }
?>