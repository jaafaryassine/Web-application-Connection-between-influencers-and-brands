<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['pseudo']) && !isset($_SESSION['marque']) ){
if(isset($_GET['marque']) && !empty($_GET['marque'])){
$pseudo=$_SESSION['pseudo'];
$reqp=$db->query("SELECT * FROM influenceurs WHERE pseudo='$pseudo'");
$resp=$reqp->fetch();
$photo=$resp['photo'];
$marque=$_GET['marque'];
$reqm=$db->query("SELECT * FROM marques WHERE marque='$marque'");
$resm=$reqm->fetch();
if ($resm) {
$logo=$resm['logo'];
$reqmsg=$db->query("SELECT * FROM messages WHERE (env='$pseudo' AND rec='$marque') OR (env='$marque' AND rec='$pseudo')");
$msg=$reqmsg->fetchAll();
$updateVu=$db->query("UPDATE messages SET vu='yes' WHERE env='$marque' AND rec='$pseudo'");
if (isset($_POST['send'])) {
    $msg=htmlspecialchars($_POST['msg']);
    if(!empty($msg)){
    $insert=$db->prepare("INSERT INTO messages (env,rec,message,vu) VALUE (?,?,?,?)");
    $insert->execute(array($pseudo,$marque,$msg,'no'));
    }
        header("location:marque.php?marque=$marque#bas");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style-chat.css">
    <link rel="stylesheet" type="text/css" href="style-navbar.css">
    <link rel="stylesheet" href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Contacter marque</title>
</head>
<style>
    header{
        margin-top:-20px !important;
       
    }
    </style>
<?php include "navbar2.html";?>

<body>
    <div class="chat">
        <div class="marque">
            <img class="logo" src="pictures/<?=$resm['marque'].'_'.$resm['logo']?>"><center><div class="nom_marque"><?=$marque?></div><center>
        </div>
        <div class="messages">
        <?php if (count($msg)>4) {?>
                <a href="#bas" class="down"><span class="material-symbols-outlined">expand_more</span></a> <br>
            <?php } ?>
            <br>
        <?php for ($i=0; $i <count($msg) ; $i++) {
             $date=$msg[$i]['date'];
             $newDate=substr($date,10,-3);
            if($msg[$i]['env']==$pseudo){
                $style='right';
                $bg='#E8F9FD';
                $img=$pseudo.'_'.$photo;
                $hour_position='left';
            }
            else {
                $style='left';
                $bg='#EFEFEF';
                $img=$marque.'_'.$logo;
                $hour_position='right';
            }
           ?>
        <div class="bg-msg" style="padding:2px; background-color:<?=$bg?>">
        <img src="pictures/<?=$img?>" width="25" height="25" style="border-radius:50%; margin-top:5px; float:<?=$style?>;"> <p  class="msg" style="margin-top:10px;"><?=$msg[$i]['message']?> <br><span class="date" style="float:<?=$hour_position?>; margin-top:10px;"><?=$newDate?></span></p> 
    </div>
     <?php
            } 
        ?>
            <div id="bas"></div>
        
        </div>
        <form method="post">
        <div class="envoie">
        <div ><input class="input" type="text" name="msg" placeholder="Envoyer message"></div><div ><button name="send" class="send" ><span class="material-symbols-outlined">
send</span></button></div></div>
</span>
    </div>
     </form>
</body>
</html>
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

