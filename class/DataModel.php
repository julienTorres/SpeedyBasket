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
                SELECT a_designation, qte_cmde , a_quantite_stock, a_pht, t_taux, url_image, t_libelle  
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
        $total = "";
        $tvapayee = "";
        $nbart = 0;
        $totalprix = 0;
        $totalttc = 0;
        $tvanormale = 0;
        $tvaintermediaire = 0;
        $tvareduite = 0;
        $tvasuperreduite = 0;
        
        while ($ligne = $req->fetch()) {
            $designation = $ligne[0];
            $quantiteCommandee = $ligne[1];
            $quantiteEnStock = $ligne[2];
            $pht = $ligne[3];
            $taux = $ligne[4];
            $urlImage = $ligne[5];
            $tva = $ligne[6];
            $prix = $pht*$quantiteCommandee;
            $pttc = ($taux/100*$pht+$pht)*$quantiteCommandee;
            $nbart += $quantiteCommandee;
            $totalprix += $prix;
            $totalttc += $pttc;            
            
            if ($tva==="normal"){
                $tvanormale += $pttc-$prix;
            }
            elseif ($tva==="intermediaire") {
                $tvaintermediaire += $pttc-$prix;
            }
            elseif ($tva==="reduit") {
                $tvareduite += $pttc-$prix;
            }
            else {
                $tvasuperreduite += $pttc-$prix;
            }
            
            $resultat .=    '<tr>
                                <td>'.$designation.'</td>
                                <td>'.$quantiteCommandee.'</td>
                                <td>'.$pht.'</td>
                                <td>'.$prix.'</td>
                                <td>'.$taux.'</td>
                                <td>'.$pttc.'</td>
                                <td>'.$urlImage.'</td>
                            </tr>'; 
            
        }       

        $total .= '<tr> 
                    <th>'."Total".'</td>
                    <th>'.$nbart.'</td>
                    <th>'.'</td>
                    <th>'.$totalprix.'</td>
                    <th>'.'</td>
                    <th>'.$totalttc.'</td>
                    <th>'.'</td>
                 </tr>';
        $totaltva = $tvanormale+$tvaintermediaire+$tvareduite+$tvasuperreduite;
        $tvapayee .= '<tr> 
                    <th>'."T.V.A Payée".'</td>
                    <th>'."T.V.A normale payée: ".$tvanormale.'</td>
                    <th>'."T.V.A intermediaire payée: ".$tvaintermediaire.'</td>
                    <th>'."T.V.A réduite payée: ".$tvareduite.'</td>
                    <th>'."T.V.A super réduite payée: ".$tvasuperreduite.'</td>
                    <th>'."Total T.V.A payée: ".$totaltva.'</td>
                    <th><button type="button"> VALIDER PANIER </button></td>
                 </tr>';
                
                
        return $resultat.$total.$tvapayee; 
        
    }
    
}
