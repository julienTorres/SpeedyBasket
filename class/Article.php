<?php

/**
 * Classe représentant un article.
 *
 * @author julienTorres
 */
class Article
{
    /**
     * @var int l'identifiant de l'article
     */
    private $idArticle;

    /**
     * @var string le nom de l'article
     */
    private $designation;

    /**
     * @var float le prix hors taxe
     */
    private $prixHT;

    /**
     * @var string la description détaillée de l'article
     */
    private $description;

    /**
     * @var int la quantité d'articles disponible en stock
     */
    private $quantiteStock;

    /**
     * @var bool 1 si le produit est commercialisé, 0 sinon
     */
    private $visible;

    /**
     * @var int l'identifiant de la catégorie d'appartenance du produit
     */
    private $categorie;

    /**
     * @var string l'URL de l'image du produit
     */
    private $urlImage;

    /**
     * @var int l'identifiant de la TVA applicable au produit
     */
    private $TVA;


    /***************************
     *  CONSTRUCTEURS
     ***************************/
    /**
     * Article constructor.
     * @param int $idArticle
     * @param string $designation
     * @param float $prixHT
     * @param string $description
     * @param int $quantiteStock
     * @param bool $visible
     * @param int $categorie
     * @param string $urlImage
     * @param int $TVA
     */
    public function __construct($idArticle, $designation, $prixHT, $description, $quantiteStock, $visible, $categorie, $urlImage, $TVA)
    {
        $this->idArticle = $idArticle;
        $this->designation = $designation;
        $this->prixHT = $prixHT;
        $this->description = $description;
        $this->quantiteStock = $quantiteStock;
        $this->visible = $visible;
        $this->categorie = $categorie;
        $this->urlImage = $urlImage;
        $this->TVA = $TVA;
    }


    /***************************
     *  ACCESSEURS
     ***************************/
    /**
     * @return int
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * @param int $idArticle
     */
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;
    }

    /**
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param string $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    /**
     * @return float
     */
    public function getPrixHT()
    {
        return $this->prixHT;
    }

    /**
     * @param float $prixHT
     */
    public function setPrixHT($prixHT)
    {
        $this->prixHT = $prixHT;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getQuantiteStock()
    {
        return $this->quantiteStock;
    }

    /**
     * @param int $quantiteStock
     */
    public function setQuantiteStock($quantiteStock)
    {
        $this->quantiteStock = $quantiteStock;
    }

    /**
     * @return boolean
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @param boolean $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return int
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param int $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return string
     */
    public function getUrlImage()
    {
        return $this->urlImage;
    }

    /**
     * @param string $urlImage
     */
    public function setUrlImage($urlImage)
    {
        $this->urlImage = $urlImage;
    }

    /**
     * @return int
     */
    public function getTVA()
    {
        return $this->TVA;
    }

    /**
     * @param int $TVA
     */
    public function setTVA($TVA)
    {
        $this->TVA = $TVA;
    }


}