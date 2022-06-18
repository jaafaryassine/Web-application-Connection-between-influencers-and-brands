<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['pseudo']) && !isset($_SESSION['marque'])){
    $pseudo=$_SESSION['pseudo'];
    $reqp=$db->query("SELECT * FROM influenceurs WHERE pseudo='$pseudo'");
    $resp=$reqp->fetch();
    $photo=$resp['photo'];
    $reqm=$db->query("SELECT * FROM marques");
    $resm=$reqm->fetchAll();
    $reqpart=$db->query("SELECT DISTINCT marques.marque,logo,ca FROM partenariats,marques WHERE partenariats.influenceur='$pseudo' AND partenariats.marque=marques.marque");
    $respart=$reqpart->fetchAll();
    $reqrequest=$db->query("SELECT * FROM partenariats_avant WHERE influenceur='$pseudo' AND statut='no'");
    $resrequest=$reqrequest->fetchAll(); 
    $reqnopart=$db->query("SELECT DISTINCT marques.marque,logo,ca FROM marques,partenariats WHERE marques.marque NOT IN (SELECT partenariats.marque FROM partenariats WHERE partenariats.influenceur='$pseudo') ");
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
        <?php include "navbar2.html";?>
        <body>
            <div class="marques">
            <div class="marques-nopart">
                <div class="titre">
                <h4 style="text-align:center;">Jamais de partenariat</h4>
                </div>
                <div class="lesmarques">
            <?php  
            for ($i=0; $i <count($resnopart) ; $i++) { ?>
                <a href="profil_mar.php?marque=<?=$resnopart[$i]['marque']?>"> 
                <div class="lamarque">
                <img class="logo" src="pictures/<?=$resnopart[$i]['marque'].'_'.$resnopart[$i]['logo']?>">
                <span class="nom-marque"><?=$resnopart[$i]['marque']?></span>
                <button class="contact" href="#">Contacter</button>
                </div>
                </a>
                <hr>
                    <?php }                
                ?>
            </div>
            </div>

            <div class="marques-part">
            <div class="titre">
            <h4 style="text-align:center;">Marques amis</h4>
            </div>
            <div class="lesmarques">
                <?php 
            for ($i=0; $i <count($respart) ; $i++) { ?>
                <a href="profil_mar.php?marque=<?=$respart[$i]['marque']?>"> 
                <div class="lamarque">
                <img class="logo" src="pictures/<?=$respart[$i]['marque'].'_'.$respart[$i]['logo']?>">
                <span class="nom-marque"><?=$respart[$i]['marque']?></span>
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