<?php

/**
 * Classe regroupant les appels à la base de données.
 *jklhklggjkgjgkjhgkh
 * @author iota
 */
class DataModel {
    
    public function getArticleByMotCle($motCle){
        $sql=   "SELECT a_designation
                FROM tb_article
                WHERE a_designation LIKE'".$motCle."'";

        $i = ConnexionPDO::getInstance();
        return  $i->query($sql); 

    }
    
    public function getLignesCommande($idCommande) {
        $sql =  "
                SELECT a_designation, a_pht, qte_cmde ,t_taux, a_quantite_stock, url_image  
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

    public function createCommande() {

    }

}
