<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['pseudo']) && !isset($_SESSION['marque'])){
    $pseudo=$_SESSION['pseudo'];
    $reqp=$db->query("SELECT * FROM influenceurs WHERE pseudo='$pseudo'");
    $resp=$reqp->fetch();
    $photo=$resp['photo'];
    if (isset($_POST['update-nom'])) {
        $nom=$_POST['nom'];
        if(!empty($nom)){
        $req=$db->query("UPDATE influenceurs set nom='$nom' WHERE pseudo='$pseudo'");
        $resp['nom']=$nom;
        }
    }
    if (isset($_POST['update-prenom'])) {
        $prenom=$_POST['prenom'];
        if(!empty($prenom)){
        $req=$db->query("UPDATE influenceurs set prenom='$prenom' WHERE pseudo='$pseudo'");
        $resp['prenom']=$prenom;
    }
    }
    if (isset($_POST['update-age'])) {
        $age=$_POST['age'];
        if(!empty($age)){
        $req=$db->query("UPDATE influenceurs set age='$age' WHERE pseudo='$pseudo'");
        $resp['age']=$age;
    }
    }
    if (isset($_POST['update-insta'])) {
        $insta=$_POST['insta'];
        if(!empty($insta)){
        $req=$db->query("UPDATE influenceurs set instagram='$insta' WHERE pseudo='$pseudo'");
        $resp['instagram']=$insta;
    }
    }
    if (isset($_POST['update-face'])) {
        $face=$_POST['face'];
        if(!empty($face)){
        $req=$db->query("UPDATE influenceurs set facebook='$face' WHERE pseudo='$pseudo'");
        $resp['facebook']=$face;
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

    <?php include "navbar2.html"; ?>
<body>
    <div class="main">
        <div class="info">
            <form method="post">
            <a href="#" class="btn-edit" name="nom" onclick="showEdit(1)"><span class="champ">Nom</span><span class="material-symbols-outlined icone">edit</span></a> 
            <div id="nom"><input type="text" name="nom"  placeholder="Nom" value="<?=$resp['nom']?>"> <button type="submit" name="update-nom">Modifier</button></div><hr><br>
            <a href="#" class="btn-edit" name="prenom"  onclick="showEdit(2)"><span class="champ">Prenom</span><span class="material-symbols-outlined icone">edit</span></a> <br>
            <div id="prenom"> <input type="text" name="prenom"  placeholder="Prenom" value="<?=$resp['prenom']?>">  <button name="update-prenom">Modifier</button></div><hr><br>
            <a href="#" class="btn-edit" name="age"  onclick="showEdit(3)"><span class="champ">Age</span><span class="material-symbols-outlined icone">edit</span></a> <br>
            <div id="age"> <input type="number" name="age" placeholder="Age" value="<?=$resp['age']?>">  <button name="update-age">Modifier</button></div><hr><br>
            <a href="#" class="btn-edit" name="insta"  onclick="showEdit(4)"><span class="champ">instagram</span><span class="material-symbols-outlined icone">edit</span></a> <br>
            <div id="insta" > <input type="text" name="insta" placeholder="instagram" value="<?=$resp['instagram']?>"> <button name="update-insta">Modifier</button></div><hr><br>
            <a href="#" class="btn-edit" name="face"  onclick="showEdit(5)"><span class="champ">Facebook</span><span class="material-symbols-outlined icone">edit</span></a><br>
            <div id="face"><input type="text" name="face"  placeholder="Facebook" value="<?=$resp['facebook']?>"> <button name="update-face">Modifier</button></div> <hr><br>
            <a href="#" class="btn-edit" name="pass" onclick="showEdit(6)"><span class="champ">Mot de passe</span><span class="material-symbols-outlined icone">edit</span></a> <br>
            <div id="pass"><input type="password" name="pass" placeholder="Mot de passe actuel"><hr>
            <input type="password" name="pass1" placeholder="Mot de passe"><hr>
            <input type="password" name="pass2" placeholder="Confrmer mot de passe"><hr>
            <button name="update-pass">Modifier</button>
            </div>
            
            </form>
        </div>
    </div>
</body>
</html>

<script src="afficher.js"></script>
<?php 
      
} ?>