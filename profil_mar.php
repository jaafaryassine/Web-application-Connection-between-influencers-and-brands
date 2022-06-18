<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['pseudo']) && !isset($_SESSION['marque'])){
    if (isset($_GET['marque'])) {
    $pseudo=$_SESSION['pseudo'];
    $marque=$_GET['marque'];
    $reqm=$db->query("SELECT * FROM marques WHERE marque='$marque'");
    $resm=$reqm->fetch();
    if($resm){
    $logo=$resm['logo'];
    $reqp=$db->query("SELECT * FROM influenceurs WHERE pseudo='$pseudo'");
    $resp=$reqp->fetch();
    $photo=$resp['photo'];
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
    if (isset($_POST['send'])) {
        $date_debut=$_POST['date_debut'];
        $date_fin=$_POST['date_fin'];
        $montant=$_POST['montant'];
        if(!empty($date_fin) && !empty($montant)){
           $insert=$db->prepare("INSERT INTO partenariats_avant (influenceur,marque,montant,date_debut,date_fin,statut,sender) VALUES (?,?,?,?,?,?,?)");
           $insert->execute(array($pseudo,$marque,$montant,$date_debut,$date_fin,'no','inf'));
           header("location:account_inf.php");
        }
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

<body>
<div class="header">
<?php include "navbar2.html";?>
</div>
<div class="body">
<div class="info-marque">
    <center><img class="photo-inf" src="pictures/<?=$marque.'_'.$logo?>" width="60"><br><span class="nom-inf"><?=$resm['marque']?></span><br></center><br>
    
<li class="properties"><a href="marque.php?marque=<?=$marque?>#bas"><span class="material-symbols-outlined icone">
message
</span> Envoyer message</a></li><hr>
<li class="properties"><span class="material-symbols-outlined icone">
mail
</span> <?=$resm['email']?></li><hr>
    <li class="properties"><span class="material-symbols-outlined icone">
monetization_on
</span> <?=$resm['ca']?> MAD</li><hr>
    <li class="properties"><span class="material-symbols-outlined" style="color:red">monitoring</span><?=$money?> MAD</li><hr>
    <center>
    <button class="collaboration" onclick="showCollaboration()">Demander partenariat</button>
</center>

<div id="detail_col">
    <form method="post">
        <label for="date_debut">Debut du contrat</label><input type="date" name="date_debut"><br>
        <label for="date_fin">Fin du contrat</label> <input type="date" name="date_fin"><br>
        <label for="montant">Montant en MAD</label><input type="number" name="montant">
        <center>
        <button class="send" name="send">Envoyer</button>
</center>
    </form>
</div>
</div>
</div>
</body>
<script>
    function showCollaboration(){
        document.getElementById('detail_col').style.display='block';
    }
    </script>
    <?php
 
}
else {
    echo "Compte inéxistant ou bien supprimé";
}
} 
}
else {
    header("location:connexion.php");
}
?>