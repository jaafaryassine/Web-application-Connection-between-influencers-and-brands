<?php 
include "connect_db.php";
include "navbarcnx.html";
?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 
    if (isset($_POST['connecter_inf'])) {
        $email=$_POST['email'];
        $pass=sha1($_POST['pass']);
        $req=$db->query("SELECT * FROM influenceurs WHERE email='$email'");
        $res=$req->fetch();
        if($res){
            if($res['password']==$pass){
                session_start();
                $_SESSION=array();
                session_destroy();
                session_start();
                $_SESSION['email']=$email;
                $_SESSION['pseudo']=$res['pseudo'];
                header("location:account_inf.php");
            }
            else {
                $erreur="Le mot de passe est incorrect";
            }
        }
        else {
            $erreur="Ce compte est inéxistant";
        }
        if($erreur){?>
            <script>swal("Erreur !","<?=$erreur?>","error")</script>
      <?php }
    }
    if (isset($_POST['connecter_mar'])) {
        $email=$_POST['email'];
        $pass=sha1($_POST['pass']);
        $req=$db->query("SELECT * FROM marques WHERE email='$email'");
        $res=$req->fetch();
        if($res){
            if($res['password']==$pass){
                session_start();
                $_SESSION=array();
                session_destroy();
                session_start();
                $_SESSION['email']=$email;
                $_SESSION['marque']=$res['marque'];
                header("location:account_mar.php");
            }
            else {
                $erreur="Le mot de passe est incorrect";
            }
        }
        else {
            $erreur="Ce compte est inéxistant";
        }
        if($erreur){?>
             <script>swal("Erreur !","<?=$erreur?>","error")</script>
       <?php }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-cnx.css">
    <title>Connexion</title>
</head>
<style>
   
</style>
<body>
    <center>
    <div class="connexion">
      <div class="choix">
                <button id="inf"   onclick="change_inf()">Influenceur</button>
                <button id="mar"  onclick="change_mar()">Marque</button> 
      </div>
  
      
      <div id="influenceur">
         <form method="post">
            <h4 class="connect_titre">Connectez-vous comme influenceur !</h4>
            <input type="email" name="email" placeholder="Email de l'influenceur" required="">
            <hr>
            <input type="password" name="pass" placeholder="Mot de passe">
            <hr>
            <br><br>
            <button class="connecter" name="connecter_inf"  style="width:200px">Connexion</button><br><br>
            <center><a href="sign-in.php" style="color:grey">Je n'ai pas encore un compte !</a> </center>
        </form>
    </div>
    <div id="marque">
        <form method="post">
            <h4 class="connect_titre">Connectez-vous comme une marque !</h4>
            <input type="email" name="email" placeholder="Email de la marque" required="">
            <hr>
            <input type="password" name="pass" placeholder="Mot de passe">
            <hr>
            <br><br>
            <button class="connecter" name="connecter_mar"  style="width:200px">Connexion</button><br><br>
            <center><a href="sign-mar.php" style="color:grey">Je n'ai pas encore un compte !</a></center>
        </form>
    </div>
</div>
</center>
</body>
</html>
<script>
    function change_mar(){
        document.getElementById('influenceur').style.display="none";
        document.getElementById('marque').style.display="block";
        document.getElementById('mar').style.backgroundColor="#017143";
        document.getElementById('inf').style.backgroundColor="white";
        document.getElementById('inf').style.color="white";
        document.getElementById('inf').style.color="black";
        document.getElementById('mar').style.color="white";


    }
    function change_inf(){
        document.getElementById('marque').style.display="none";
        document.getElementById('influenceur').style.display="block";
        document.getElementById('inf').style.backgroundColor="#017143";
        document.getElementById('mar').style.backgroundColor="white";
        document.getElementById('inf').style.color="white";
        document.getElementById('mar').style.color="black";



    }
</script>
