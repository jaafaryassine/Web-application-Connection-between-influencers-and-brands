<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['pseudo']) && !isset($_SESSION['marque'])){
    $pseudo=$_SESSION['pseudo'];
    $reqp=$db->query("SELECT * FROM influenceurs WHERE pseudo='$pseudo'");
    $resp=$reqp->fetch();
    $photo=$resp['photo'];
    $reqm=$db->query("SELECT * FROM marques");
    $resm=$reqm->fetchAll();
    $reqpart=$db->query("SELECT * FROM partenariats WHERE influenceur='$pseudo'");
    $respart=$reqpart->fetchAll();
    $reqrequest=$db->query("SELECT * FROM partenariats_avant WHERE influenceur='$pseudo' AND statut='no' AND sender='mar'");
    $resrequest=$reqrequest->fetchAll();
    $reqmsg=$db->query("SELECT marques.marque,message,date,logo,vu FROM marques,messages WHERE marques.marque=messages.env AND messages.rec='$pseudo' ORDER BY date DESC");
    $resmsg=$reqmsg->fetchAll();
    $reqmoney=$db->query("SELECT SUM(montant) as somme FROM partenariats WHERE influenceur='$pseudo'");
    $resmoney=$reqmoney->fetch();
    $reqsupp=$db->query("SELECT * FROM suppression WHERE pseudo='$pseudo' LIMIT 1");
    $ressupp=$reqsupp->fetch();
    if ($ressupp) {
        $requestdelete=1;
    }
    else {
        $requestdelete=0;
    }
    $j=0;
    $existNonvu=0;
    
    // Recupérons le dernier message avec chaque marque
    function tester($ch,$last_msg,$nb){
        $x=0;
        for ($i=0; $i <$nb ; $i++) { 
            if ($last_msg[$i][0]==$ch) {
                $x=1;
                break;
            }
        }
        return $x;
    }

    
    $last_msg=array(array());
    $last_msg[0][0]='-';
    $last_msg[0][1]='-';
    $last_msg[0][2]='-';


    for ($i=0; $i <count($resmsg) ; $i++) { 
        $tmp=$resmsg[$i]['marque'];
        if (tester($tmp,$last_msg,$j)==0) {
        $last_msg[$j][0]=$tmp;
        $last_msg[$j][1]=$resmsg[$i]['message'];
        $last_msg[$j][2]=$resmsg[$i]['date'];
        $last_msg[$j][3]=$resmsg[$i]['logo'];
        $last_msg[$j][4]=$resmsg[$i]['vu'];
        if ($last_msg[$j][4]=='no') {
            $existNonvu=1;
        }
        $j++;
        continue;
        } 
    }
    // Fin récupération

    if (isset($_POST['accept'])) {
        $i=$_POST['ligne'];
        $id=$_POST['accept'];
        $marque=$resrequest[$i]['marque'];
        $montant=$resrequest[$i]['montant'];
        $date_debut=$resrequest[$i]['date_debut'];
        $date_fin=$resrequest[$i]['date_fin'];
        $update=$db->query("UPDATE partenariats_avant SET statut='yes' WHERE id=$id");
        $insert=$db->prepare("INSERT INTO partenariats values (?,?,?,?,?,?)");
        $insert->execute(array($id,$pseudo,$marque,$montant,$date_debut,$date_fin));
        header("location:account_inf.php");
    }

    if (isset($_POST['change'])) {
      $extension_valides=array('jpg','jpeg','png','gif');
      $newphoto=$_FILES['photo']['name'];
      $extension=strtolower(substr(strrchr($newphoto,'.'),1));
      if (in_array($extension,$extension_valides)) {
      $upload="pictures/".$pseudo."_".$newphoto;
      move_uploaded_file($_FILES['photo']['tmp_name'],$upload);
      $ajout=$db->query("UPDATE influenceurs SET photo='$newphoto' WHERE pseudo='$pseudo'");
      header("location:account_inf.php");
    }
      else {
        echo "Le fichier doit etre en format jpg, jpeg, png ou gif";
      }
    } 

    if (isset($_POST['supp'])) {
        $req=$db->query("INSERT INTO suppression (pseudo) VALUES ('$pseudo')");
        header("location:account_inf.php");
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link rel="stylesheet" type="text/css" href="style-account.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <title>Compte</title>
</head>

<?php include "navbar2.html";?>

<body>
    <div class="main">
    <div class="vertical">
    <ul>
        <a href="#" onclick="profil()"><li><span class="material-symbols-outlined icone">person</span>Profil</li></a> <br>
        <a href="#" onclick="messages()"><li><span class="material-symbols-outlined icone">message</span>Messages 
        <?php if ($existNonvu==1) { ?><span class="material-symbols-outlined" style="float:right; color:red;">mark_email_unread</span><?php } ?></li></a><br>
        <a href="#" onclick="partenariats()"><li> <span class="material-symbols-outlined icone">handshake</span>Mes partenariats</li></a><br>
        <a href="#" onclick="marques()"><li><span class="material-symbols-outlined icone">group</span>Marques</li></a><br>
        <a href="#" onclick="settings()"><li><span class="material-symbols-outlined icone">settings</span>Paramètres</li></a>

    </ul>
</div>

<?php 
    if (count($respart)==0) {
        $money=0;
    }
    else {
        $money=$resmoney['somme'];
    }
?>

<div id="profil">
    <div class="grid-profil">
    <div class="info-profil bordure-rond">
        <center>
        <img class="img-inf" width="70" height="70" src="pictures/<?=$pseudo.'_'.$photo?>">
        
        </center>
    <p class="nom-inf"><?=$resp['nom']?> <?=$resp['prenom']?></p>
    <li class="properties"><span class="material-symbols-outlined icone">
toggle_on
</span>Actif</li><hr>
    <a href="<?=$resp['instagram']?>"><li class="properties"><img src="images/insta.png" width="15"><span class="sc-media" ><?=$resp['nom']?> <?=$resp['prenom']?></span> </li></a><hr>
    <a href="<?=$resp['facebook']?>"><li class="properties"><img src="images/fb.png" width="15"><span class="sc-media" ><?=$resp['nom']?> <?=$resp['prenom']?></span> </li></a><hr>
    <li class="properties"><span class="material-symbols-outlined" style="color:#04B45F">monitoring</span>+<?=$money?> MAD</li><hr>
    <li class="properties"></li>
    <button class="edit_photo" name="change" onclick="showChange()">
        <span class="material-symbols-outlined">edit </span>
        Changer photo de profil
</button>
</form>

    </div>
    <div>
        <a href="#" class="link-info" onclick="partenariats()">
        <div class="info bordure-rond">
        <center>
        <img src="images/partner.png" width="70">
        <h4>Vous avez fait <?=count($respart)?> partenariats</h4> 
        </center>
        </div>
        </a>
        <a href="profil_edit_inf.php" class="link-info">
        <div class="info edit bordure-rond">
        <center>
        <img src="images/profil.png" width="55">
        <h4>Editer votre profil</h4> 
        </center>
        </div>
        </a>
        <div id="change" class="edit bordure-rond">
        <center>
        <img src="images/cam.png" width="30">
        <form method="post" enctype="multipart/form-data">
        <input type="file" name="photo">
        <button name="change">Valider</button>
        </form>
        </center>
        </div>
        

    </div>

    </div>
</div>



<div id="marques" class="bordure-rond">
<div class="grid_marques">
<div id="lesmarques">
    <div class="chercher">
<input type="text" name="search" id="search" placeholder="Tapez pour chercher marque ..."></div>
    <div id="suggestions"></div>
    <div id="marque_info">
<?php 
    for ($i=0; $i <count($resm) ; $i++) { ?>
          <a href="profil_mar.php?marque=<?=$resm[$i]['marque']?>"> 
          <div class="lamarque">
          <img class="logo" src="pictures/<?=$resm[$i]['marque'].'_'.$resm[$i]['logo']?>">
          <span class="nom-marque"><?=$resm[$i]['marque']?></span>
          <button class="contact" href="#">Contacter</button>
          </div>
          </a>
          <hr>
   <?php }
?>
    </div>
    </div>
    </div>
    </div>
    <div id="partenariats">
    <div class="nb-partenariats bordure-rond">
        <p>Vous avez <?=count($respart)?> partenariat(s) </p>
    </div>
        <div class="marque-partenaires">
            <table>
                <tr>
                <td class="colonnes">Marque</td>
                <td class="colonnes">Montant</td>
                <td class="colonnes">Début</td>
                <td class="colonnes">Fin du contrat</td>
             </tr>
            <?php for ($i=0; $i <count($respart) ; $i++) { ?>
                <tr>
                <td><?=$respart[$i]['marque']?></td>
                <td><?=$respart[$i]['montant']?> MAD</td>
                <td><?=$respart[$i]['date_debut'];?></td>
                <td><?=$respart[$i]['date_fin']?></td>
            </tr>
               
           <?php } ?>
            </table>
        </div>
        <center>Demandes de partenariats</center>
        <div class="request-part bordure-rond">
           
                <table>
                <tr>
                <td class="colonnes">Marque</td>
                <td class="colonnes">Montant</td>
                <td class="colonnes">Début</td>
                <td class="colonnes">Fin du contrat</td>
                <td class="colonnes">Décision</td>
             </tr>
            <?php for ($i=0; $i <count($resrequest) ; $i++) { ?>
                <form method="post" >
                <select name="ligne" style="display:none"><option  value="<?=$i?>"></select>
                <tr>
                <td><?=$resrequest[$i]['marque']?></td>
                <td><?=$resrequest[$i]['montant']?> MAD</td>
                <td><?=$resrequest[$i]['date_debut'];?></td>
                <td><?=$resrequest[$i]['date_fin']?></td>
                <td><button name="accept" type="submit" value="<?=$resrequest[$i]['id']?>">Accepter</button></td>
            </tr>
            </form>
           <?php } ?>
            </table>
    </div>
    </div>
    <div id="messages">
        <div class="msg-box bordure-rond scroll">
            <center><h3>Boite de réception</h3></center>
    <?php for ($i=0; $i <$j ; $i++) {  
        if ($i%2!=0) {
            $color='#f7f7f7';
        }
        else{
            $color='white';
        }
        ?>
        <a href="marque.php?marque=<?=$last_msg[$i][0]?>#bas">
        <div class="msg" style="background-color:<?=$color?>;">
            <img class="logo" src="pictures/<?=$last_msg[$i][0].'_'.$last_msg[$i][3]?>"> <span class="name-marque"><?=$last_msg[$i][0]?></span> <span> <?=substr($last_msg[$i][1],0,180)?><small style="float:right;"><?=substr($last_msg[$i][2],10,-3)?></small> <?php if(strlen($last_msg[$i][1])>180){echo '...';}?></span><?php if($last_msg[$i][4]=='no') { ?> <span class="material-symbols-outlined" style="float:right; color:red;">mark_chat_unread</span><?php } ?>
        </div> </a>

      <?php } ?>
      </div>
    </div>
    <div id="settings">
            <div class="grid-settings">
                <a href="carte-bancaire.php"><div class="carte success"><center><img src="images/carte-bancaire.png" width="55"><br><br>Ajouter carte bancaire</center></div></a>
                <div class="carte success" onclick="showConfid()"><center><img src="images/confidentialite.png" width="55"><br>Confidentialité</center></div>
                <a href="delete_part.php"><div class="carte danger"><center><img src="images/poubelle.png" width="45"><br>
                    Supprimer toute les demandes de partenariats
                </center>
                </div></a>
                <?php if ($requestdelete==0) { ?>
                <form method="post">
                <button name="supp" style="background-color:transparent; border:none;">
                <div class="carte danger"><center><img src="images/supp.png" width="65"><br>
                Demander suppression du profil</center></div></button></form>
            <?php }
            else{ ?>
            <div class="carte danger" onclick="showAlert()"><center><img src="images/loading.png" width="45"><br>
                Votre Demande de suppression est en cours</center></div>
            <?php } ?>
            </div>
        </div>
    </div>
        
</body>
</html>
<script src="afficher.js"></script>
<!-- javascript suggestions -->
<script>
    const searchinput=document.getElementById('search');
    searchinput.addEventListener('keyup',function(){
    const input=searchinput.value;
    var res= <?php echo json_encode($resm); ?>;
    const result=res.filter(item=>item.marque.toLocaleLowerCase().includes(input.toLocaleLowerCase()));
    let suggestions='';
    if(input!=''){
      result.forEach(resultItem=>
      suggestions+='<a href="profil_mar.php?marque='+resultItem.marque+'"><div class="lamarque"><img class="logo" src="pictures/'+resultItem.marque+'_'+resultItem.logo+'"><span class="nom-marque">'+resultItem.marque+'</span><button class="contact" href="#">Contacter</button></div></a><hr>'
      )
      let marques=document.getElementById('marque_info');
      marques.style.display='none';

    }
    document.getElementById('suggestions').innerHTML= suggestions;
    if(input==''){
      let marques=document.getElementById('marque_info');
      marques.style.display='block';
    }
    })
 

function showAlert(){
    swal("Bien reçu", "Votre demande sera traité par l'administrateur", "info");
}
function showConfid(){
    swal({title : " Termes de confidentialité ",text : "Vous ne pouvez ni usurper l’identité d’autrui ni fournir des informations erronées. Vous ne pouvez rien faire qui soit illégal, trempeur ou frauduleux, ni agir dans un but illicite ou interdit. La suppression du compte peut prendre jusqu’a 15 jours. Apres la suppression de votre compte toutes vos informations vont disparaitre", icon : "info"});
}

</script>

<?php 


}
else {
    header("location:connexion.php");
}

?>

