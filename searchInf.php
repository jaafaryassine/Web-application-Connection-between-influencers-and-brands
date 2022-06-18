<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['marque']) && !isset($_SESSION['pseudo']) ){
    $marque=$_SESSION['marque'];
    $reqpart=$db->query("SELECT DISTINCT influenceurs.pseudo,photo FROM partenariats,influenceurs WHERE partenariats.marque='$marque' AND partenariats.influenceur=influenceurs.pseudo");
    $respart=$reqpart->fetchAll();
    $reqnopart=$db->query("SELECT DISTINCT influenceurs.pseudo,photo  FROM influenceurs,partenariats WHERE influenceurs.pseudo NOT IN (SELECT partenariats.influenceur FROM partenariats WHERE partenariats.marque='$marque') ");
    $resnopart=$reqnopart->fetchAll();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="style-searchMarque.css">
            <link rel="stylesheet" type="text/css" href="style2.css">
            <link rel="stylesheet" type="text/css" href="style-account.css">
            <title>Chercher marque</title>
        </head>
        <?php include "navbar-marque.html";?>
        <body>
            <div class="marques">
            <div class="marques-nopart">
                <h4 style="text-align:center;">Jamais de partenariat</h4>
                <div class="lesmarques">
            <?php  
            for ($i=0; $i <count($resnopart) ; $i++) { ?>
                <a href="profil_inf.php?pseudo=<?=$resnopart[$i]['pseudo']?>"> 
                <div class="lamarque">
                <img class="logo" src="pictures/<?=$resnopart[$i]['pseudo'].'_'.$resnopart[$i]['photo']?>">
                <span class="nom-marque"><?=$resnopart[$i]['pseudo']?></span>
                <button class="contact" href="#">Contacter</button>
                </div>
                </a>
                <hr>
                    <?php }                
                ?>
            </div>
            </div>

            <div class="marques-part">
            <h4 style="text-align:center;">influenceurs amis</h4>
            <div class="lesmarques">
                <?php 
            for ($i=0; $i <count($respart) ; $i++) { ?>
                <a href="profil_inf.php?pseudo=<?=$respart[$i]['pseudo']?>"> 
                <div class="lamarque">
                <img class="logo" src="pictures/<?=$respart[$i]['pseudo'].'_'.$respart[$i]['photo']?>">
                <span class="nom-marque"><?=$respart[$i]['pseudo']?></span>
                <button class="contact" href="#">Contacter</button>
                </div>
                </a>
                <hr>
                    <?php }             
                ?>
            </div>
            </div>
            </div>
        </body>
        </html>

        <?php } ?>