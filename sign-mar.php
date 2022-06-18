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
    <link rel="stylesheet" type="text/css" href="signmar.css">

    <title>Créez compte</title>
</head>
<body>

  <center>
  <div class="formulaire">
       <form method="post" enctype="multipart/form-data">
      
            <h4 class="titre">Inscrivez-vous !</h4>
                <input type="text" name="email" placeholder="Email" required="">
                <hr>
                <input type="text" name="marque" placeholder="Nom de la marque" required="">
                <hr>
                <input type="password" name="pass1" placeholder="Mot de passe" required="">
                <hr>
                <input type="password" name="pass2" placeholder="Confrmer mot de passe" required="">
                <hr>
                <input type="number" name="ca" placeholder="Chiffre d'affaire" required="">
                <hr>
                <input type="file" name="logo" placeholder="Chiffre d'affaire"  required="" ><br>
                <br><br>
                <button type="submit" class="btn_success" name="create">Créez compte !</button> <br><br>
                <center><a href="connexion.php" style="color:grey">J'ai déja un compte !</a></center>
                </div> 
       </form>
   <center>
</body>



    <?php 
    if (isset($_POST['create'])) {
        if(!empty($_POST['marque']) && !empty($_POST['email']) && !empty($_POST['pass1']) && !empty($_POST['pass2'])){
			$email=$_POST['email'];
            $marque=$_POST['marque'];
			$pass1=sha1($_POST['pass1']);
			$pass2=sha1($_POST['pass2']);
            $ca=$_POST['ca'];
            $reqe=$db->query("SELECT * FROM marques where email='$email'");
            $rese=$reqe->fetch();
            if ($pass1==$pass2) {
            
                if($rese){
                    $erreur="Email déja existant";
                }
                else {
                    $reqp=$db->query("SELECT * FROM marques where marque='$marque'");
                    $resp=$reqp->fetch();
                    $reqe2=$db->query("SELECT * FROM influenceurs where pseudo='$marque'");
                    $rese2=$reqe2->fetch();
                    if($resp || $rese2){
                        $erreur="Le nom de la marque déja existant";
                    }
                    else {
                        $extension_valides=array('jpg','jpeg','png','gif');
                        $photo=$_FILES['logo']['name'];
                        $extension=strtolower(substr(strrchr($photo,'.'),1));
                        if (in_array($extension,$extension_valides)) {
                            $taillemax=4000000;
                            if($_FILES['logo']['size']<=$taillemax){
                            $upload="pictures/".$marque."_".$photo;
                            move_uploaded_file($_FILES['logo']['tmp_name'],$upload);
                            $insert=$db->query("INSERT INTO marques (email,marque,password,logo,ca) VALUE ('$email','$marque','$pass1','$photo','$ca')");
                            session_start();
                            $_SESSION=array();
                            session_destroy();
                            session_start();
                            $_SESSION['email']=$email;
                            $_SESSION['marque']=$marque;
                            header("location:account_mar.php");
                            }
                    }
                    else {
                        $erreur="Le format du logo doit etre png,jpg,jpeg ou gif";
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