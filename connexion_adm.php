<?php 
include "connect_db.php";
include "navbarcnx.html";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="connexionadmin.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

</head>
<body>
<center>
<div class="connexion">
<div id="Admin">
    <form method="post">
       <h4 class="connect_titre">Connectez-vous comme Admin !</h4>
       <input type="text" name="pseudo" placeholder="Nom d'utilisateur" required="">
       <hr>
       <input type="password" name="pass" placeholder="Mot de passe">
       <hr>
       <br><br>
       <button class="connecter" name="connecter"  style="width:200px">Connexion</button>
   </form>
  
</div>
</div>
</center>
</body>
</html>
<?php 
    if (isset($_POST['connecter'])) {
        $pseudo=$_POST['pseudo'];
        $pass=sha1($_POST['pass']);
        $req=$db->query("SELECT * FROM admins WHERE pseudo='$pseudo'");
        $res=$req->fetch();
        if($res){
            if($pass==$res['password']){
                session_start();
                $_SESSION=array();
                session_destroy();
                session_start();
                $_SESSION['admin']=$pseudo;
                header("location:account_adm.php");
            }
            else {
                $erreur="Mot de passe incorect";
            }
        }
        else {
            $erreur="Nom d'utilisateur inéxistant";
        }

        if ($erreur) {
            echo $erreur;
        }
    }