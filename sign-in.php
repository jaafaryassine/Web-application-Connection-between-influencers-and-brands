<?php 
include "connect_db.php";
include "navbarcnx.html";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styleform.css">

    <title>Créez un compte</title>
</head>
<body>

   <center> <form method="post" enctype="multipart/form-data">
   <div class="formulaire">
        <h4 class="title">Inscrivez-vous !</h4>
        <input type="text" name="email" placeholder="Email" required="">
        <hr>
        <input type="text" name="nom" placeholder="Nom" required=""> 
        <hr>
        <input type="text" name="prenom" placeholder="Prenom" required=""> 
        <hr>
        <input type="number" name="age" placeholder="Age" required=""> 
        <hr>
        <input type="text" name="pseudo" placeholder="Pseudo" required=""> 
        <hr>
        <input type="text" name="insta" placeholder="instagram" required="">
        <hr>
        <input type="text" name="face" placeholder="Facebook" required=""> 
        <hr>
        <input type="password" name="pass1" placeholder="Mot de passe" required="">
        <hr>
        <input type="password" name="pass2" placeholder="Confrmer mot de passe" required=""><hr>
        <div class="sexe">
        <label for="homme"><strong>Homme</strong></label><input type="radio" name="sexe" value="homme" checked>
		<label for="femme"><strong>Femme</strong></label><input type="radio" name="sexe" value="femme" >
        </div>
         <br><br>
        <input type="file" name="photo" required=""><br><br><br>
        <button type="submit" class="btn_success" name="create">Créez compte !</button><br> <br>
        <center><a href="connexion.php" style="color:grey">J'ai déja un compte !</a></center>

        </div>
    </form>
</center>

    <?php 
    if (isset($_POST['create'])) {
        if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['age']) && !empty($_POST['insta']) && !empty($_POST['face'])){
			$email=$_POST['email'];
            $nom=$_POST['nom'];
            $prenom=$_POST['prenom'];
            $age=$_POST['age'];
			$pseudo=$_POST['pseudo'] ;
            $insta=$_POST['insta'];
            $face=$_POST['face'];
			$pass1=sha1($_POST['pass1']);
			$pass2=sha1($_POST['pass2']);
			$sexe=$_POST['sexe'];
			$pseudolength=strlen($pseudo);
            $reqe=$db->query("SELECT * FROM influenceurs where email='$email'");
            $rese=$reqe->fetch();
            if($pass1==$pass2){
                if($rese){
                    $erreur="Email déja existant";
                }
                else {
                    $reqp=$db->query("SELECT * FROM influenceurs where pseudo='$pseudo'");
                    $resp=$reqp->fetch();
                    $reqp2=$db->query("SELECT * FROM marques where marque='$pseudo'");
                    $resp2=$reqp2->fetch();
                    if($resp || $resp2){
                        $erreur="Pseudo déja existant";
                    }
                    else {
                        $reqr=$db->query("SELECT * FROM influenceurs where instagram='$insta' or facebook='$face'");
                        $resr=$reqr->fetch();
                        if($resr){
                            $erreur="L'un des réseaux sociaux est déjà utilisé dans un autre compte";
                        }
                        else {
                            $extension_valides=array('jpg','jpeg','png','gif');
                            $photo=$_FILES['photo']['name'];
                            $extension=strtolower(substr(strrchr($photo,'.'),1));
                            if (in_array($extension,$extension_valides)) {
                            $taillemax=4000000;
                            if($_FILES['photo']['size']<=$taillemax){
                            $upload="pictures/".$pseudo."_".$photo;
                            move_uploaded_file($_FILES['photo']['tmp_name'],$upload);
                            $insert=$db->query("INSERT INTO influenceurs (email,nom,prenom,age,pseudo,instagram,facebook,password,sexe,photo) VALUE ('$email','$nom','$prenom',$age,'$pseudo','$insta','$face','$pass1','$sexe','$photo')");
                            session_start();
                            $_SESSION=array();
                            session_destroy();
                            session_start();
                            $_SESSION['email']=$email;
                            $_SESSION['pseudo']=$pseudo;
                            header("location:account_inf.php");
                        }
                    }
                }
                    }
                }
            }
            else {
                $erreur="Les mots de passe ne sont pas identiques";
            }
        }
        if ($erreur) { ?>
            <script>swal("Erreur !","<?=$erreur?>","error")</script>
        <?php }
    }
    ?>
</body>
</html>