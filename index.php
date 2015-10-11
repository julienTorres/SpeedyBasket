<?php
include_once 'includes/functions.php';
$dm = new DataModel();
$commande = new Commande();

$commandeValidee = '';
if (isset($_GET['valider'])) {
    $commandeValidee = 'Votre commande est validée ! <br />A bientôt au magasin.';
    $commande->validerCommande($_COOKIE['SpeedyMarketCookie']);
}

if (isset($_POST['article'])) {
    $idCommande = null;
    if (!($commande->checkCookie())) {
        $idCommande = $commande->createCommande();
    }
    $commande->createLigneCommande($_POST['article'], $_POST['qteCommandee'], $idCommande); 
}

$idCommande = $commande->checkCookie() ? $_COOKIE['SpeedyMarketCookie'] : null;
if(!empty($commandeValidee)){
    $idCommande = null;
}
if (!is_null($idCommande) || isset($_POST['article'])) {
    $synthesePanier = $commande->afficherResumeCommande($idCommande);
    $nbItems = $synthesePanier['nbItems'];
    $totalTTC = $synthesePanier['totalTTC'];
}

$result = $dm->getAllArticles();

include_once 'includes/header.php';
?>

        <div class="row">
            <div class="commandeValidee col s4 offset-s2">
                <?php echo $commandeValidee; ?>
            </div>
            <div class="synthese-panier col s2 offset-s4">
                <h4>Panier</h4>
                <div>
                    Nombre d'articles : <?php echo is_null($idCommande)? '' : $nbItems; ?>
                    <br />
                    Total ttc : <?php echo is_null($idCommande)? '' : number_format((float)$totalTTC, 2, ',', ''); ?> €
                </div>
                <a href="panier.php">Accéder au panier</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th>Prix HT</th>
                    <th>Quantité commandée</th>
                    <th>Taux TVA</th>
                    <th>Quantité en stock</th>
                    <th>URL Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo $result;
                ?>
            </tbody>
        </table>

<?php
    include_once 'includes/footer.php';
?>