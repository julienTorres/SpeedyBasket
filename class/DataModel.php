/<?php

/**
 * Classe regroupant les appels à la base de données.
 *
 * @author iota
 */
class DataModel {
    
     /**
      * Permet de trouver toutes les lignes de commande  d'une commande grace a son id
      * @param int $idCommande
      * @return array [a_designation, a_pht, qte_cmde ,t_taux, a_quantite_stock, url_image ]
      */   
    public function getLignesCommande($idCommande) {
        $sql =  "
                $sql= "SELECT a_designation, qte_cmde , a_quantite_stock, a_pht, t_taux, url_image, t_libelle  
               FROM tb_article, tb_ligne_commande, tb_commande,tb_tva 
               WHERE tb_article.id_article = tb_ligne_commande.id_article
               AND tb_ligne_commande.id_commande = tb_commande.id_commande
               AND tb_tva.id_tva = tb_article.id_tva
               AND tb_ligne_commande.id_commande = ".$idCommande
               ;
                
        
        $i = ConnexionPDO::getInstance();
        $req = $i->prepare($sql);
        $req->execute();
        
        $resultat = "";
        while ($ligne = $req->fetch()) {
            $designation = $ligne[0];
            $pht = $ligne[1];
            $quantiteCommandee = $ligne[2];
            $taux = $ligne[3];
            $quantiteEnStock = $ligne[4];
            $urlImage = $ligne[5];
        
            $resultat .=    '<tr>
                                <td>'.$designation.'</td>
                                <td>'.$pht.'</td>
                                <td>'.$quantiteCommandee.'</td>
                                <td>'.$taux.'</td>
                                <td>'.$quantiteEnStock.'</td>
                                <td>'.$urlImage.'</td>
                            </tr>';        
        }
        return $resultat;
    }
    
    public function getAllArticles() {
        $sql =  "
                SELECT id_article, a_designation, a_pht, a_description, a_quantite_stock, tb_categorie.c_libelle, tb_article.url_image, t_taux
                FROM tb_article, tb_tva, tb_categorie
                WHERE tb_article.id_tva = tb_tva.id_tva
                AND tb_article.id_categorie = tb_categorie.id_categorie
                AND a_visible = 1
                AND a_quantite_stock > 0 "
                ;

        $i = ConnexionPDO::getInstance();
        $req = $i->prepare($sql);
        $req->execute();        
        
        $resultat = "";
        while ($ligne = $req->fetch()) {
            $idArticle = $ligne[0];
            $designation = $ligne[1];
            $pht = $ligne[2];
            $description = $ligne[3];
            $quantiteEnStock = $ligne[4];
            $categorie = $ligne[5];
            $urlImage = $ligne[6];
            $tva = $ligne[7];

            $resultat .=    '<div class="row">
                                <form method="post" action="">
                                    <div class="col s1">'.$urlImage.'</div>
                                    <div class="col s2">'.$designation.'</div>
                                    <div class="col s1">'.$categorie.'</div>
                                    <div class="col s3">'.$description.'</div>
                                    <div class="col s1">'.$pht.'</div>
                                    <div class="col s1">'.$tva.'</div>
                                    <div class="col s1">'.$quantiteEnStock.'</div>
                                    <input type="number" name="qteCommandee" min="1" max="'.$quantiteEnStock.'" class="col s1" />
                                    <input type="hidden" name="article" value="'.$idArticle.'" />
                                    <button class="btn waves-effect waves-light col s1" type="submit" name="action">Ajouter</button>
                                </form>
                            </div>';        
        }
        return $resultat;
    }
    
    public function gatArticlesByCategorie() {
        
    }

    /**
     * Permet de trouver un ou des articles par mot clé
     * @param String $motCle
     * @return array[a_designation]
     */
    public function getArticleByMotCle($motCle){
       $sql= "SELECT a_designation
              FROM tb_article
              WHERE a_designation LIKE '%$motCle%'";

       $pdo = ConnexionPDO::getInstance();
       $result = $pdo->query($sql);

       return  $result->fetchAll();
    } 
    
    public function getCategorieMere($idcategorie){
        
    }    
    
    public function getSousCategories($idcategorie) {
        
    }
    
    /**
     * Permet de créer une nouvelle commande
     * @return boolean
     */
    public function createCommande() {
        $sql= "INSERT INTO `tb_commande`(`id_commande`) "
             ."VALUES (NULL)";
        $pdo = ConnexionPDO::getInstance();
        $pdo->exec($sql);

        return  true;
    }
    
    /**
     * Permet de trouver l'id de la dernière commande créée
     * @return array [id_commande ]
     */
    public function getIdNewCommande() {
        $sql= "SELECT MAX(id_commande) as id_commande "
             ."FROM tb_commande";
                
        $pdo = ConnexionPDO::getInstance();
        $result = $pdo->query($sql);

        return  $result->fetch();
    }
    
    /**
     * Permet de créer une nouvelle ligne de commande
     * @param int $idcommande
     * @param int $idarticle
     * @param int $quantiteCommandee
     * @return boolean
     */
    public function createLigneCommande($idcommande,$idarticle, $quantiteCommandee) {
        $sql= "INSERT INTO `tb_ligne_commande`"
            . "(`id_article`, `id_commande`, `qte_cmde`) "
            . "VALUES ('$idcommande','$idarticle','$quantiteCommandee')";
        $pdo = ConnexionPDO::getInstance();
        $pdo->exec($sql);

        return  true; // !always true !!
    }
    
    /**
     * Permet de trouver le mot de passe d'une personne via son mail
     * @param String $email
     * @return array[p_mdp]
     */ 
    public function getUserPassword($email) {
         $sql= "SELECT p_mdp "
             ."FROM tb_personne"
             ."WHERE p_mail = '$email'";   
        $pdo = ConnexionPDO::getInstance();
        $result = $pdo->query($sql);

        return  $result->fetch();
    }
    /**
     * Permet de créer un nouveau client insert dans la table personne et la table client
     * @param String $nom
     * @param String $prenom
     * @param String $ville
     * @param int $cp
     * @param String $mail
     * @param String $mdp
     * @param String $rue
     * @param int $tel
     * @return boolean
     */
    public function createUser($nom, $prenom, $ville, $cp, $mail, $mdp, $rue="", $tel="") {
        $sql= "INSERT INTO `tb_personne`(`id_personne`, `p_nom`, `p_prenom`,"
                . " `p_arue`, `p_aville`, `p_acp`, `p_tel`, `p_mail`, `p_mdp`)" 
            ."VALUES (NULL,'$nom','$prenom','$rue',"
                . "'$ville','$cp','$tel','$mail','$mdp')";
        $pdo = ConnexionPDO::getInstance();
        $pdo->exec($sql);
        
        $id ->getIdPersonne($email);
        $sql = "INSERT INTO `tb_client`(`id_personne`) VALUES ('$id')";
        $pdo = ConnexionPDO::getInstance();
        $pdo->exec($sql);        

        return  TRUE;// !always true !!
    }
    /**
     * Donne l'id d'une personne via son mail
     * @param string $email
     * @return array[id_personne]
     */
    public function getIdPersonne($email) {
         $sql= "SELECT id_personne "
             ."FROM tb_personne"
             ."WHERE p_mail = '$email'";   
        $pdo = ConnexionPDO::getInstance();
        $result = $pdo->query($sql);

        return  $result->fetch();
    }
    /**
     * Permet d'avoir le Nom et Prenom d'une personne
     * @param String $email
     * @return array[p_nom, p_prenom]
     */
    public function getFullName($email) {
         $sql= "SELECT p_nom, p_prenom "
             ."FROM tb_personne"
             ."WHERE p_mail = $email";   
        $pdo = ConnexionPDO::getInstance();
        $result = $pdo->query($sql);

        return  $result->fetch();
    }
    /**
     * Permet de valider une commande en ajoutant une date de retrait, un id client 
     * et en passant le statut de la commande à validée
     * @param int $idcommande
     * @param date $dateRetrait
     * @param int $idPersonne
     * @return boolean
     */
    public function validerCommande($idcommande,$dateRetrait,$idPersonne) {
        $sql= "UPDATE `tb_commande` SET `c_dateretrait`='$dateRetrait',`id_statut`='2',`client_id_pers`='$idPersonne'"
                . " WHERE id_commande = '$idcommande'";
        $pdo = ConnexionPDO::getInstance();
        $pdo->exec($sql);

        return true ;// !always true !!
    }
    /**
     * Met a jour la quantité en stock d'un produit en fonction de la quantité commandée
     * @param int $idcommande
     * @param int $idarticle
     * @param int $quantiteCommandee
     * @return boolean
     */
    public function setQuantiteStock($idcommande, $idarticle,$quantiteCommandee) {
        $soussql = "SELECT (a_quantite_stock - '$quantiteCommandee') FROM `tb_article` WHERE `id_article` = '$idarticle'";
        $sql= "UPDATE `tb_article` SET a_quantite_stock`='$soussql'"
            . " WHERE `id_article` = '$idarticle'";
        $pdo = ConnexionPDO::getInstance();
        $pdo->exec($sql);

        return  true;// !always true !!
    }
    /**
     * Regarde si la ligne de commande existe en vue de la créer ou de changer la quantité d'article
     * @param int $idcommande
     * @param int $idarticle
     * @return boolean true si la ligne existe false si elle est a créer
     */
    public function checkLigneCommande($idcommande, $idarticle) {
        $sql="SELECT * FROM `tb_ligne_commande` "
            . "WHERE `id_article` = '$idarticle' "
            . "AND id_commande = '$idcommande'";
        $pdo = ConnexionPDO::getInstance();
        $result = $pdo->query($sql);
        if ($result != 0){
            return true;
        }else{
            return  false;
        }
    }
    /**
     * Supprime une ligne de commande
     * @param int $idcommande
     * @param int $idarticle
     * @return boolean
     */
    public function supprimerLigneCommande($idcommande, $idarticle) {
        $sql= "DELETE FROM `tb_ligne_commande`" 
            . "WHERE id_commande = '$idcommande'"
            . "AND id_article = '$idarticle' "; 
         $pdo = ConnexionPDO::getInstance();
         $pdo->exec($sql);
         return  true;// !always true !!
    }
    /**
     * Affiche la date de retrait d'une commande
     * @param int $idcommande
     * @return array[c_dateretrait]
     */
    public function getDateRetraitCommande($idcommande) {
         $sql= "SELECT c_dateretrait "
             ."FROM tb_commande"
             ."WHERE id_commande = '$idcommande'";   
        $pdo = ConnexionPDO::getInstance();
        $result = $pdo->query($sql);

        return  $result->fetch();
    }
    /**
     * Change la date de retrait d'une commande
     * @param int $idcommande
     * @param date $dateRetrait
     * @return boolean
     */
    public function updateDateRetraitCommande($idcommande, $dateRetrait) {
         $sql= "UPDATE tb_commande"
             ."SET c_dateretrait = '$dateRetrait'"
             ."WHERE id_commande = '$idcommande'";   
        $pdo = ConnexionPDO::getInstance();
        $pdo->exec($sql);
        return true ;// !always true !!
    }
    /**
     * Obtention de la quantit�e en stock pour un article donn�
     * @param int $idArticle
     * @return int a_quantite_stock
     */
        public function getQuantiteStock($idArticle){
            $sql="SELECT a_quantite_stock ".
                 "FROM tb_article".
                 "WHERE id_article = $idArticle";
            $pdo = ConnexionPDO::getInstance();
            $result = $pdo->query($sql);

        return  $result->fetch();
        }
        
        /**
         * Suppression d'un compte client
         * @param int $idClient
         * @return boolean
         */
        public function deleteCompteClient($idClient){
            $sql="DELETE FROM tb_client".
                 "WHERE id_personne = $idClient";
            $pdo = ConnexionPDO::getInstance();
        $pdo->exec($sql);
        return  true;// !always true !!
        }
        
        /**
         * Obtention de l'historique des commandes pour un client donn�
         * @param int $idClient
         * @return int id_commande
         */
        public function getHistoriqueClient($idClient){
            $sql="SELECT id_commande "
                . "FROM `tb_commande` "
                . "WHERE client_id_pers = '$idClient' ";
            $pdo = ConnexionPDO::getInstance();
            $result = $pdo->query($sql);

        return  $result->fetch();
        }
    
}
