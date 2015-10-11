<?php
include_once 'includes/functions.php';

$commande = new Commande();
$idCommande = $commande->checkCookie() ? $_COOKIE['SpeedyMarketCookie'] : null;
    
$result = '';
if (!is_null($idCommande)) {
    $result = $commande->createDetailCommande($idCommande);
}

include_once 'includes/header.php';
?>

<div class="col s2">
    <a href="index.php">Retourner dans les rayons</a>
</div>

        <div class="container">
            <div class="col s10 offset-s1">

                <table>
                    <thead>
                        <tr>
                            <th>Désignation</th>
                            <th>Prix HT</th>
                            <th>Quantité commandée</th>
                            <th>TVA</th>
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

            </div>
        </div>

<div class="row validation-commande">
    <div class="col s2 offset-s10">
        <a href="index.php?valider=true" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">done</i></a>
    </div>
</div>

<?php
    include_once 'includes/footer.php';
?>