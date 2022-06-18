<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['marque']) && !isset($_SESSION['pseudo'])){
    $marque=$_SESSION['marque'];
    $reqm=$db->query("SELECT * FROM marques WHERE marque='$marque'");
    $resm=$reqm->fetch();
    $logo=$resm['logo'];
    if (isset($_POST['update-ca'])) {
        $ca=$_POST['ca'];
        if(!empty($ca)){
        $req=$db->query("UPDATE marques set ca='$ca' WHERE marque='$marque'");
        }
    }
    
    if (isset($_POST['update-pass'])) {
        $pass=sha1($_POST['pass']);
        $pass1=sha1($_POST['pass1']);
        $pass2=sha1($_POST['pass2']);
        if($pass==$resp['password']){
        if($pass1==$pass2){
        $req=$db->query("UPDATE influenceurs set password='$pass1' WHERE pseudo='$pseudo'");
        }
        else {
            echo "Les nouveaux mots de passe ne sont pas identiques";
        }
    }
    else {
        echo "Le mot de passe actuel est invalide";
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-edit.css">
    <link rel="stylesheet" href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <title>Profil</title>
</head>

    <?php include "navbar-marque.html"; ?>
<body>
    <div class="main">
        <div class="info">
            <form method="post">
            <a href="#" class="btn-edit"  onclick="showEditMar(1)"><span class="champ">Chiffre d'affaire</span><span class="material-symbols-outlined icone">edit</span></a> <br>
            <div id="ca"> <input type="text" name="ca"  placeholder="Chiffre d'affaire">  <button name="update-ca">Modifier</button></div><br><hr><br>
            <a href="#" class="btn-edit"   onclick="showEditMar(2)"><span class="champ">Adresse</span><span class="material-symbols-outlined icone">edit</span></a> <br>
            <div id="adresse"> <input type="number" name="adresse" placeholder="Adresse">  <button name="update-adresse">Modifier</button></div><br><hr><br>
            <a href="#" class="btn-edit" name="pass" onclick="showEditMar(3)"><span class="champ">Mot de passe</span><span class="material-symbols-outlined icone">edit</span></a> <br>
            <div id="pass"><input type="password" name="pass" placeholder="Mot de passe actuel"><br><br><hr>
            <input type="password" name="pass1" placeholder="Mot de passe"><br><br><hr>
            <input type="password" name="pass2" placeholder="Confrmer mot de passe"><br><br><hr>
            <button name="update-pass">Modifier</button>
            </div> 
            </form>
        </div>
    </div>
</body>
</html>
<script>
function showEditMar(i){
    switch(i){
        case 1 : document.getElementById('ca').style.display="block";
                 document.getElementById('adresse').style.display="none";
                 document.getElementById('pass').style.display="none";
                 break;
        case 2 : document.getElementById('adresse').style.display="block";
                 document.getElementById('ca').style.display="none";
                 document.getElementById('pass').style.display="none";
                 break;
        case 3 : document.getElementById('pass').style.display="block";
                 document.getElementById('adresse').style.display="none";
                 document.getElementById('ca').style.display="none";
                 break;
    }

}
</script>
<?php 
      
} ?>