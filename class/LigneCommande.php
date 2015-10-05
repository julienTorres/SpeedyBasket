<?php 

class LigneCommande{

    private $idCommande;
    private $idArticle;
    private $quantiteCommandee;

    public function __construct($idCommande, $idArticle, $quantiteCommandee) {
        $this->idCommande = $idCommande;
        $this->idArticle = $idArticle;
        $this->quantiteCommandee = $quantiteCommandee;
    }

    public function getIdCommande() {
        return $this->idCommande;
    }

    public function getIdArticle() {
        return $this->idArticle;
    }

    public function getQuantiteCommandee() {
        return $this->quantiteCommandee;
    }


    public function setQuantiteCommandee($quantiteCommandee) {
        $this->quantiteCommandee = $quantiteCommandee;
    }

    public function checkStock() {
        $quantiteStock = ConnectionPDO::getInstance()->getQuantiteStock($this->idArticle);

        if ($quantiteStock > $this->quantiteCommandee){
            return 0;
        }
        else {
            return $quantiteStock;
           }
    }

}

 ?>