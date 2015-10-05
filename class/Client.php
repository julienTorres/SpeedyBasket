<?php
include_once 'connexionPDO.php';


class Client{
    private $idClient;
    private $nomClient;
    private $prenomClient;
    private $rueClient;
    private $villeClient;
    private $codePostalClient;
    private $telephoneClient;
    private $emailClient;
    private $mdpClient;
    
    function __construct($idClient, $nomClient, $prenomClient, $villeClient, $codePostalClient, $emailClient, $mdpClient, $rueClient=[],$telephoneClient=[]) {
        $this->idClient = $idClient;
        $this->nomClient = $nomClient;
        $this->prenomClient = $prenomClient;
        $this->rueClient = $rueClient;
        $this->villeClient = $villeClient;
        $this->codePostalClient = $codePostalClient;
        $this->telephoneClient = $telephoneClient;
        $this->emailClient = $emailClient;
        $this->mdpClient = $mdpClient;
    }
    
    function getIdClient() {
        return $this->idClient;
    }

    function getNomClient() {
        return $this->nomClient;
    }

    function getPrenomClient() {
        return $this->prenomClient;
    }

    function getRueClient() {
        return $this->rueClient;
    }

    function getVilleClient() {
        return $this->villeClient;
    }

    function getCodePostalClient() {
        return $this->codePostalClient;
    }

    function getTelephoneClient() {
        return $this->telephoneClient;
    }

    function getEmailClient() {
        return $this->emailClient;
    }

    function getMdpClient() {
        return $this->mdpClient;
    }

    function setIdClient($idClient) {
        $this->idClient = $idClient;
    }

    function setNomClient($nomClient) {
        $this->nomClient = $nomClient;
    }

    function setPrenomClient($prenomClient) {
        $this->prenomClient = $prenomClient;
    }

    function setRueClient($rueClient) {
        $this->rueClient = $rueClient;
    }

    function setVilleClient($villeClient) {
        $this->villeClient = $villeClient;
    }

    function setCodePostalClient($codePostalClient) {
        $this->codePostalClient = $codePostalClient;
    }

    function setTelephoneClient($telephoneClient) {
        $this->telephoneClient = $telephoneClient;
    }

    function setEmailClient($emailClient) {
        $this->emailClient = $emailClient;
    }

    function setMdpClient($mdpClient) {
        $this->mdpClient = $mdpClient;
    }

    public function getFullName() {
        ConnexionPDO::getInstance()->getFullNames($mail);
        return [$this->nomClient, $this->prenomClient];
    }
    public function authentifierClient($password,$mail){
        
        $userPassword = ConnexionPDO::getInstance()->getUserPassword($mail);
        
        if ($userPassword === $password) {
            
            if((new Commande)->checkCookie()==true){
                
                
                $id = ConnexionPDO::getInstance()->getIdPersonne($mail);
                // reccupere la valeur du cookie et lui ajoute l'id dans l'array 'id = $id'
            }  else {
               (new Commande)->createCookie();
            }
        }else{
            echo 'Erreur d\'identification, veuillez recommencer';
        }
    }


}

