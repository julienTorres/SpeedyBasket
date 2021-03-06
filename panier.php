<?php
include_once 'includes/functions.php';

$idCommande = 1;
$dm = new DataModel();
$result = $dm->getLignesCommande($idCommande);

?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta charset="utf-8" />

    </head>
    <body>

        <div class="container">
            <div class="col s10 offset-s1">

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

            </div>
        </div>

        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
    </body>
</html>