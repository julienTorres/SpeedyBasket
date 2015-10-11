<?php
include_once 'includes/functions.php';

/**
 * Classe représentant une commande passée par un client.
 *
 * @author julienTorres
 */
class Commande {
    /**
     *
     * @var int     représente l'identifiant de la commande 
     */
    private $idCommande;
    
    /**
     *
     * @var date    représente la date de création de la commande
     */
    private $dateCommande;
    
    /**
     *
     * @var date    représente la date de retrait souhaitée par le client 
     */
    private $dateRetrait;
    
    /**
     *
     * @var int     représente le statut de la commande 
     */
    private $statutCommande;
    
    /**
     *
     * @var int     représente l'identifiant du préparateur chargé de la commande 
     */
    private $preparateurCommande;
    
    private $dm;
    /***************************
     *  CONSTRUCTEUR
     ***************************/
    /** 
     * 
     */
    public function __construct() {
        $this->dm = new DataModel();
    }

    /***************************
     *  ACCESSEURS
     ***************************/    
    /**
     * 
     * @return int
     */
    public function getIdCommande() {
        return $this->idCommande;
    }

    /**
     * 
     * @return date
     */
    public function getDateCommande() {
        return $this->dateCommande;
    }

    /**
     * 
     * @return date
     */
    public function getDateRetrait() {
        return $this->dateRetrait;
    }

    /**
     * 
     * @return int
     */
    public function getStatutCommande() {
        return $this->statutCommande;
    }

    /**
     * 
     * @return int
     */
    public function getPreparateurCommande() {
        return $this->preparateurCommande;
    }

    /**
     * 
     * @param int $idCommande
     */
    public function setIdCommande($idCommande) {
        $this->idCommande = $idCommande;
    }

    /**
     * 
     * @param date $dateCommande
     */
    public function setDateCommande($dateCommande) {
        $this->dateCommande = $dateCommande;
    }

    /**
     * 
     * @param date $dateRetrait
     */
    public function setDateRetrait($dateRetrait) {
        $this->dateRetrait = $dateRetrait;
    }

    /**
     * 
     * @param int $statutCommande
     */
    public function setStatutCommande($statutCommande) {
        $this->statutCommande = $statutCommande;
    }

    /**
     * 
     * @param type $preparateurCommande
     */
    public function setPreparateurCommande($preparateurCommande) {
        $this->preparateurCommande = $preparateurCommande;
    }

    /***************************
     *  METHODES PRIVEES
     ***************************/    
    /** Crée une commande et retourne son identifiant.
     * 
     * @return int identifiant de la commande créée
     */
    public function createCommande() {
        $idCommande = $this->dm->getIdNewCommande();
        $this->createCookie($idCommande);
        $this->dm->createCommande();
        return $idCommande;
    }
    
    /** Crée un cookie pour stocker l'identifiant de la commande pour 48h.
     * 
     */
    public function createCookie($cookie) {
        setcookie('SpeedyMarketCookie', $cookie, time()+3600*48, null, null, false, true);
    }
    
    /** Vérifie l'existence du cookie SpeedyMarketDrive.
     * 
     * @return bool true if cookie exists, false otherwise
     */
    public function checkCookie() {
        return isset($_COOKIE['SpeedyMarketCookie']);
    }

    public function updateCookie() {
        // ça n'a pas de sens de vouloir modifier le cookie
        // pour stocker l'id client, il faut un nouveau cookie
        // changer la valeur du premier cookie reviendrait à modifier la commande
        // liée à ce compte
        // est-ce ce que l'on souhaite ?
    }
    
    public function destroyCookie() {
        setcookie('SpeedyMarketCookie', $this->idCommande, time(), null, null, false, true);
    }


    /** Vérifie l'existence d'une ligne de commande pour un article donné.
     * 
     * @param int   $idArticle
     * @return boolean  true if exists, false otherwise
     */
    public function checkLigneCommande($idArticle) {
        return $this->dm->checkLigneCommande($_COOKIE['SpeedyMarketCookie'], $idArticle);
    }
    
    public function createLigneCommande($idArticle, $quantiteCommandee, $idCommande) {
        if (!is_null($idCommande)) {
            $this->dm->createLigneCommande($idCommande, $idArticle, $quantiteCommandee);
        } else {
            if (!$this->checkLigneCommande($idArticle)) {
                $this->dm->createLigneCommande($_COOKIE['SpeedyMarketCookie'], $idArticle, $quantiteCommandee);
            } else {
               $this->dm->updateQuantiteCommandee($_COOKIE['SpeedyMarketCookie'], $idArticle, $quantiteCommandee);
            }
        }
    }


    /** Récupère les lignes de commande liées à une commande donnée.
     * 
     * @return array<int>   les identifiants des lignes de commande
     */
    public function getLignesCommande() {
        return $this->dm->getLignesCommandes($this->idCommande);
    }
    
    /** Récupère le nombre d'articles dans une commande donnée.
     * 
     * @return int  le nombre d'articles dans la commande
     */
    public function getNombreArticlesCommande() {
        /*
         * getlignescommandes
         * initialiser compteur d'articles
         * pour chaque ligne, 
         *  récupérer nombre d'article
         *  ajouter au compteur
         * 
         * retourner compteur
         */
        $lignesCommandes = $this->dm->getLignesCommandes($this->idCommande);
                
        $nbArticles = 0;
        foreach ($lignesCommandes as $ligneCommande) {
            $nbArticles += (int)$ligneCommande->getQuantiteCommandee();
        }
        
        return $nbArticles;
    }
    
    public function afficherResumeCommande($idCommande) {
        $lignes = $this->dm->getLignesCommande($idCommande);
        $totalTTC = 0.0;
        $nbItems = 0;
        foreach ((object)$lignes as $ligne) {
            foreach((object)$ligne as $article) {
                $designation = $ligne[0];
                $pht = $ligne[1];
                $quantiteCommandee = $ligne[2];
                $taux = $ligne[3];
                $quantiteEnStock = $ligne[4];
                $urlImage = $ligne[5];
            }

                $nbItems += $quantiteCommandee;

                $prixTTC = ($pht + $pht * $taux / 100) * $quantiteCommandee;
                $totalTTC += $prixTTC;
        }

        return ['nbItems' => $nbItems, 'totalTTC' => $totalTTC];
    }
    
    public function createDetailCommande($idCommande) {
        $lignes = $this->dm->getLignesCommande($idCommande);
        $html = $this->afficherDetailCommande($lignes);
        return $html;
    }
    
    public function afficherDetailCommande($lignes) {
        $resultat = "";
        foreach ((object)$lignes as $ligne) {
            foreach((object)$ligne as $article) {
                $designation = $ligne[0];
                $pht = $ligne[1];
                $quantiteCommandee = $ligne[2];
                $taux = $ligne[3];
                $quantiteEnStock = $ligne[4];
                $urlImage = $ligne[5];
            }

                $resultat .=    '<tr>
                                    <td>'.$designation.'</td>
                                    <td>'.$pht.' €</td>
                                    <td>'.$quantiteCommandee.'</td>
                                    <td>'.number_format((float)$taux, 2, ",", "").' %</td>
                                    <td>'.$quantiteEnStock.'</td>
                                    <td>'.$urlImage.'</td>
                                </tr>';        
        }
        return $resultat;
}


    public function validerCommande($idCommande) {
        /**
         * pour chaque ligneCommande
         *  update stocks
         * 
         * destroy cookie
         * update statut commande
         * 
         * set id_client !!!!!
         */
        $lignesCommandes = $this->dm->getLignesCommande($idCommande);
        foreach ((object)$lignesCommandes as $ligneCommande) {
            $qteStock = $this->dm->getQuantiteStock($ligneCommande['id_article']);
            $qteCommandee = $this->dm->getQuantiteCommandee($ligneCommande['id_commande'], $ligneCommande['id_article']);
            $nouveauStock = (integer)$qteStock[0][0] - (integer)$qteCommandee[0][0];
            $this->dm->setQuantiteStock($nouveauStock, $ligneCommande['id_article']);
        }
        
        $this->destroyCookie();
        $this->updateStatutCommande($idCommande, 2);
        
        header('Location: /SpeedyBasket');
    }
    
    public function supprimerLigneCommande($idArticle) {
        $this->dm->supprimerLigneCommande($this->idCommande, $idArticle);
    }
    
    /** Retourne la quantité en stock de tous les articles de la commande
     * 
     */
    public function checkStocks() {
        /**
         * initialise réserves, associative array
         * pour chaque ligneCommande
         *  si qteStock insuffisante pour honorer la commande
         *  stocker qteEnStock de l'article dans réserves
         * 
         * si réserve pas vide
         * retourner réserves
         * 
         * sinon retourner 0??
         */
        $lignesCommandes = $this->dm->getLignesCommandes($this->idCommande);
        
        foreach ($lignesCommandes as $ligneCommande) {
            if ($ligneCommande->checkStock($ligneCommande->getIdArticle()) != 0) {
                
            }
            
        }        
    }
    
    public function modifierDateRetraitCommande() {
        
    }
    
    public function checkStatutCommande() {
        
    }
    
    public function updateStatutCommande($idCommande, $statutCommande) {
        $this->dm->updateStatutCommande($idCommande, $statutCommande);
    }
    
    public function afficherHistoriqueClient() {
        
    }
    
}
