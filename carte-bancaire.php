<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['pseudo']) && !isset($_SESSION['marque'])){
    $pseudo=$_SESSION['pseudo']; 
    $req=$db->query("SELECT * FROM cartes WHERE pseudo='$pseudo' LIMIT 1");
    $res=$req->fetch();
    if ($res) {
        $oldname=$res['nom'];
        $olddate=$res['date_exp'];
        $oldcrypt=$res['crypt'];
    }
    else {
        $oldname='';
        $olddate='';
        $oldcrypt='';
    }
    if (isset($_POST['add'])) {
        $nom=$_POST['nom'];
        $num=sha1($_POST['num']);
        $date_exp=$_POST['date_exp'];
        $crypt=$_POST['crypt'];
        if ($res) {
            $update=$db->query("UPDATE cartes SET nom='$nom',num='$num',date_exp='$date_exp',crypt='$crypt' WHERE pseudo='$pseudo'");
        }
        else{
            $insert=$db->query("INSERT INTO cartes (pseudo,nom,num,date_exp,crypt) VALUES ('$pseudo','$nom','$num','$date_exp','$crypt')");
        }
        header("location:account_inf.php");
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php include "navbar2.html";?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Orelega+One&family=Poppins:ital,wght@0,200;0,300;0,500;1,100;1,600&display=swap');
*{
    font-family: poppins;
}
    body{
        background-color: #f5f5f5;
    }
    form{
        margin-top:40px !important;
        margin-bottom:30px !important;
        background-color: white;
        width: 450px;
        height: 380px;
        border-radius: 16px;
        padding: 20px;
        margin: auto;
        padding-top: 30px;
        box-shadow: #04B45F 0px 3px 8px;

    }
 
    input{
        width: 90%;
        border: none;
        padding: 10px;
        border-radius: 16px;
        outline: 0;
    }
    button{
        margin: auto;
        border: none;
        color: #04B45F;
        background-color: #212226;
        padding: 10px;
        border-radius: 16px;
    }
   
</style>
<body>
    <form method="post" onsubmit="showAlert()">
        <center><img src="images/carte-bancaire.png" width="60"></center><br>
        <input type="text" class="tout" name="nom" placeholder="Nom complet du porteur de la carte" pattern="[A-Za-z][A-Za-z\s]*" required="" value="<?=$oldname?>"><hr>
        <input type="text" class="tout" name="num" placeholder="XXXX XXXX XXXX XXXX" pattern="[0-9]{16}" title="Ce champ doit avoir 16 chiffres" required=""><hr>
        <input type="text"  name="date_exp" placeholder="Date d'expiration ex : 07/29" pattern="[01][0-9]{1}/[0-9]{2}" title="La date doit etre sous le format mois/année" required="" value="<?=$olddate?>"><hr>
        <input type="text"  name="crypt" placeholder="Cryptogramme ex : 022" pattern="[0-9]{3}" title="Ce champ doit avoir trois chiffres" required="" value="<?=$oldcrypt?>"><hr><br>
        <center><button type="submit" name="add">Enregistrer carte</button></center>
    </form>
</body>
</html>
<script>
function showAlert(){
    swal("La carte a été bien ajouté", "success");
}
</script>
<?php
}
else {
    header("location:connexion.php");
}
?>