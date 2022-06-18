<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['admin']) && !isset($_SESSION['marque']) && !isset($_SESSION['pseudo'])){
    if (isset($_GET['pseudo'])) {
    $pseudo=$_GET['pseudo'];
    $reqp=$db->query("SELECT * FROM influenceurs WHERE pseudo='$pseudo'");
    $resp=$reqp->fetch();
    if($resp){
    $photo=$resp['photo'];
    $reqpart=$db->query("SELECT * FROM partenariats WHERE influenceur='$pseudo'");
    $respart=$reqpart->fetchAll();
    $reqmoney=$db->query("SELECT SUM(montant) as somme FROM partenariats WHERE influenceur='$pseudo'");
    $resmoney=$reqmoney->fetch();
    if (count($respart)==0) {
        $money=0;
    }
    else {
        $money=$resmoney['somme'];
    }
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link rel="stylesheet" type="text/css" href="style-account-mar.css">
    <link rel="stylesheet" href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <title>Compte</title>
</head>
<?php include "navbar-adm.html";?>

<body>
<div class="header">
</div>
<div class="body">
<div class="info-influenceur">
    <center><img class="photo-inf" src="pictures/<?=$pseudo.'_'.$photo?>" width="60" height="60"><p class="nom-inf"><?=$resp['nom'].' '.$resp['prenom']?></p></center><br>
    <li class="properties"><span class="material-symbols-outlined">
mail
</span><?=$resp['email']?></li><hr>
    <a href="<?=$resp['instagram']?>"><li class="properties"><img src="images/insta.png" width="20"><span class="sc-media" ><?=$resp['nom']?> <?=$resp['prenom']?></span> </li></a><hr>
    <a href="<?=$resp['facebook']?>"><li class="properties"><img src="images/fb.png" width="20"><span class="sc-media" ><?=$resp['nom']?> <?=$resp['prenom']?></span> </li></a><hr>
    <li class="properties"><span class="material-symbols-outlined" style="color:#04B45F">monitoring</span>+<?=$money?> MAD</li><hr>
<?php }
else {
    echo "Compte inéxistant ou bien supprimé";
}
} 
}
else {
    header("location:connexion.php");
} ?>