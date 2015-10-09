<?php

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
    

    /***************************
     *  CONSTRUCTEUR
     ***************************/
    /** 
     * 
     */
    public function __construct() {}

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
        $i = ConnexionPDO::getInstance();
        $i->createCommande();
        return $i->getIdNewCommande();
    }
    
    /** Crée un cookie pour stocker l'identifiant de la commande pour 48h.
     * 
     */
    public function createCookie() {
        setcookie('SpeedyMarketCookie', $this->idCommande, time()+3600*48, null, null, false, true);
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
    
    /** Vérifie l'existence d'une ligne de commande pour un article donné.
     * 
     * @param int   $idArticle
     * @return boolean  true if exists, false otherwise
     */
    public function checkLigneComande($idArticle) {
        $i = ConnexionPDO::getInstance();
        return $i->checkLigneCommande($this->idCommande, $idArticle);
    }
    
    /** Récupère les lignes de commande liées à une commande donnée.
     * 
     * @return array<int>   les identifiants des lignes de commande
     */
    public function getLignesCommande() {
        $i = ConnexionPDO::getInstance();
        return $i->getLignesCommandes($this->idCommande);
    }
    
    /** Récupère le nombre d'articles dans une commande donnée.
     * 
     * @return int  le nombre d'articles dans la commande
     */
    public function getNombreArticlesCommande() {
        /*
         * getlignescommandes
         * getLigneCommande ... ?
         */
        
        return;
    }
    
    public function afficherResumeCommande() {
        
    }
    
}
