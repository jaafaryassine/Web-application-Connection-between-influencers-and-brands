<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['admin']) && !isset($_SESSION['marque']) && !isset($_SESSION['pseudo'])){
    if (isset($_GET['marque'])) {
    $marque=$_GET['marque'];
    $reqm=$db->query("SELECT * FROM marques WHERE marque='$marque'");
    $resm=$reqm->fetch();
    if ($resm){
    $logo=$resm['logo'];
    $reqpart=$db->query("SELECT * FROM partenariats WHERE  marque='$marque'");
    $respart=$reqpart->fetchAll();
    $reqmoney=$db->query("SELECT SUM(montant) as somme FROM partenariats WHERE marque='$marque'");
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
            <link rel="icon" type="image/png" sizes="16x16" href="images/M.png">

    <title>Compte</title>
</head>
<body>
<?php include "navbar-adm.html";?>
<div class="body">
<div class="info-influenceur">
    <center><img class="photo-inf" src="pictures/<?=$marque.'_'.$logo?>" width="60"><p class="nom-inf"><?=$marque?></p></center>
    <li class="properties"><span class="material-symbols-outlined">
mail
</span><?=$resm['email']?></li><hr>
<li class="properties"><span class="material-symbols-outlined icone">
toggle_on
</span>Actif</li><hr>
    <li class="properties">Chiifre d'affaire : <?=$resm['ca']?></li><hr>
    <li class="properties"><span class="material-symbols-outlined" style="color:red">monitoring</span><?=$money?> MAD</li><hr>
<?php } 
else {
    echo "Compte inéxistant ou bien supprimé";
}
} 
}
else {
    header("location:connexion.php");
}
?>