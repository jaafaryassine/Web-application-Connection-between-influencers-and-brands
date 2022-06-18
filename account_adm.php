<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['admin']) && !isset($_SESSION['marque']) && !isset($_SESSION['pseudo'])){
$reqinf=$db->query("SELECT * FROM influenceurs");
$resinf=$reqinf->fetchAll();
$reqmar=$db->query("SELECT * FROM marques");
$resmar=$reqmar->fetchAll();
$reqpart=$db->query("SELECT * FROM partenariats");
$respart=$reqpart->fetchAll();
$reqnopart=$db->query("SELECT * FROM partenariats_avant WHERE statut='no'");
$resnopart=$reqnopart->fetchAll();
$reqstatinf=$db->query("SELECT DISTINCT pseudo FROM influenceurs,partenariats WHERE pseudo IN (SELECT influenceur FROM partenariats WHERE partenariats.influenceur=influenceurs.pseudo)");
$statinf=$reqstatinf->fetchALL();
$reqstatmar=$db->query("SELECT DISTINCT marques.marque FROM marques,partenariats WHERE marques.marque IN (SELECT marque FROM partenariats WHERE partenariats.marque=marques.marque)");
$statmar=$reqstatmar->fetchALL();
$reqsupp=$db->query("SELECT suppression.pseudo,photo FROM suppression,influenceurs WHERE influenceurs.pseudo=suppression.pseudo");
$ressupp=$reqsupp->fetchAll();
$reqsuppmar=$db->query("SELECT suppression.pseudo,logo FROM suppression,marques WHERE marques.marque=suppression.pseudo");
$ressuppmar=$reqsuppmar->fetchAll();

if (isset($_POST['supp'])) {
    $pseudo=$_POST['supp'];
    $delete1=$db->query("DELETE FROM suppression WHERE pseudo='$pseudo'");
    $delete2=$db->query("DELETE FROM influenceurs WHERE pseudo='$pseudo'");
    header("location:account_adm.php");
}
if (isset($_POST['suppmar'])) {
    $marque=$_POST['suppmar'];
    $delete1=$db->query("DELETE FROM suppression WHERE pseudo='$marque'");
    $delete2=$db->query("DELETE FROM marques WHERE marque='$marque'");
    header("location:account_adm.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" type="text/css" href="style-adm.css">
    <title>Administrateur</title>
</head>
<?php include "navbar-adm.html";?>

<style>
    a{
        text-decoration:none;
        color:black;
    }
    </style>
    <div class="main">
      <div class="vertical">
    <ul>
        <a href="#" onclick="showInf()"><li><span class="material-symbols-outlined icone">person</span>Influenceurs</li></a> <br>
        <a href="#" onclick="showMar()"><li><span class="material-symbols-outlined icone">group</span>Marques</li></a> <br>
        <a href="#" onclick="showPart()"><li> <span class="material-symbols-outlined icone">handshake</span>Partenariats</li></a><br>
        <a href="#" onclick="showStats()"><li><span class="material-symbols-outlined icone">query_stats</span>Statistiques</li></a><br>
        <a href="#" onclick="showRequests()"><li><span class="material-symbols-outlined icone">block</span>Demandes</li></a><br>


        

    </ul>
</div>
<body>
    <div id="influenceurs" class="scroll">
    <div class="chercher">
<input type="text" name="search" id="search" placeholder="Tapez pour chercher influenceur ..."></div>      
  <div id="suggestions"></div>
        <div id="lesinfluenceurs">
        <?php for ($i=0; $i <count($resinf) ; $i++) { ?>
            <a href="profil_inf_adm.php?pseudo=<?=$resinf[$i]['pseudo']?>#bas"> 
          <div class="lamarque">
          <img class="logo" src="pictures/<?=$resinf[$i]['pseudo'].'_'.$resinf[$i]['photo']?>">
          <span class="nom-marque"><?=$resinf[$i]['pseudo']?></span>
          <button class="contact" href="#">Voir profil</button>
          </div>
          </a>
          <hr>
       <?php } ?>    

    </div>
    
    </div>
        
    <div id="marques" class="scroll">
    <div class="chercher">
<input type="text" name="search" id="searchmar" placeholder="Tapez pour chercher marque ..."></div>        <div id="suggestionsmar"></div>
        <div id="lesmarques">
    <?php 
    for ($i=0; $i <count($resmar) ; $i++) { ?>
          <a href="profil_mar_adm.php?marque=<?=$resmar[$i]['marque']?>#bas"> 
          <div class="lamarque">
          <img class="logo" src="pictures/<?=$resmar[$i]['marque'].'_'.$resmar[$i]['logo']?>">
          <span class="nom-marque"><?=$resmar[$i]['marque']?></span>
          <button class="contact" href="#">Voir profil</button>
          </div>
          </a>
          <hr>
   <?php }
?>
    </div>
    </div>

    <div id="partenariats">
        <div class="grid-partenariats">
        <div class="part scroll">
            <center>
            <h5 style="color:#04B45F">Partenariats finalisé</h5></center>
    <table>
                <tr>
                <td class="colonnes">Influenceur</td>
                <td class="colonnes">Marque</td>
                <td class="colonnes">Fin</td>
             </tr>
            <?php for ($i=0; $i <count($respart) ; $i++) { ?>
                <tr>
                <td><?=$respart[$i]['influenceur']?></td>
                <td><?=$respart[$i]['marque']?></td>
                <td><?=$respart[$i]['date_fin']?>   <button class="details" onclick="showDetails(<?=$i?>)"><span class="material-symbols-outlined">info</span></button></td>
                </tr>
                <tr>
            </tr>
           <?php } ?>
            </table>
    
            </div> 
            <div class="nopart scroll">
                <center>
            <h5 style="color:#04B45F">Demandes non accéptées</h5> </center>
    <table>
                <tr>
                <td class="colonnes">Influenceur</td>
                <td class="colonnes">Marque</td>
                <td class="colonnes">Fin</td>
             </tr>
            <?php for ($i=0; $i <count($resnopart) ; $i++) { ?>
                <tr>
                <td><?=$resnopart[$i]['influenceur']?></td>
                <td><?=$resnopart[$i]['marque']?></td>
                <td><?=$resnopart[$i]['date_fin']?>   <button class="details" onclick="showDetails2(<?=$i?>)"><span class="material-symbols-outlined">info</span></button></td>
                </tr>
    
    <?php } ?>
            </table>
            </div>
            </div>
    </div>
    <div id="stats">
        <center><h4>Statistiques</h4></center>
                <div class="stat-info"><p style="color:#04B45F;"><?=number_format(count($statinf)/count($resinf) * 100 , 2, ',', ' ') .'% des influenceurs ont déjà finalisé au moins un partenariat'?></p></div>
                <div class="stat-info"><p style="color:#04B45F;"><?=number_format(count($statmar)/count($resmar) * 100 , 2, ',', ' ') .'% des marques ont déjà finalisé au moins un partenariat'?></p></div>
                <div class="stat-info"><p style="color:red;"><?=number_format(count($resnopart)/(count($respart)+count($resnopart))* 100 , 2, ',', ' ') .'% des demandes de partenariat n\'ont pas été accepté'?></p></div>    
    </div>
    <div id="demandes">
    <div class="lesdemandes">
    <div class="demandes scroll">
        <center><h4>Demandes d'influenceurs</h4></center>
        <?php for ($i=0; $i <count($ressupp) ; $i++) { ?>
            <a href="profil_inf_adm.php?pseudo=<?=$ressupp[$i]['pseudo']?>#bas"> 
          <div class="lamarque">
          <img class="logo" src="pictures/<?=$ressupp[$i]['pseudo'].'_'.$ressupp[$i]['photo']?>">
          <span class="nom-marque"><?=$ressupp[$i]['pseudo']?></span>
          </a>
          <form method="post">
          <button class="supp" name="supp" value="<?=$ressupp[$i]['pseudo']?>">Supprimer</button>
        </form>
          </div>
          <hr>
    <?php  } ?>
    </div>
    <div class="demandes scroll" >
    <center><h4>Demandes des marques</h4></center>
        <?php for ($i=0; $i <count($ressuppmar) ; $i++) { ?>
            <a href="profil_mar_adm.php?marque=<?=$ressuppmar[$i]['pseudo']?>#bas"> 
          <div class="lamarque">
          <img class="logo" src="pictures/<?=$ressuppmar[$i]['pseudo'].'_'.$ressuppmar[$i]['logo']?>">
          <span class="nom-marque"><?=$ressuppmar[$i]['pseudo']?></span>
          </a>
          <form method="post">
          <button class="supp" name="suppmar" value="<?=$ressuppmar[$i]['pseudo']?>">Supprimer</button>
        </form>
          </div>
          <hr>
    <?php  } ?>
    </div>
    </div>
    </div>
</body>
</html>
<script>
    function showDetails(i){
        var res= <?php echo json_encode($respart); ?>;
        swal("Details du contrat",'Influenceur : ' + res[i]['influenceur'] + '\n' + 'Marque : ' + res[i]['marque'] + '\n' + 'Montant : ' + res[i]['montant'] +  'MAD' + '\n'  + 'Début de contrat : ' + res[i]['date_debut'] + '\n' + 'Fin du contrat : ' + res[i]['date_fin'], "info");
    }
    function showDetails2(i){
        var res= <?php echo json_encode($resnopart); ?>;
        swal("Contrat non encore finalisé",'Influenceur : ' + res[i]['influenceur'] + '\n' + 'Marque : ' + res[i]['marque'] + '\n' + 'Montant : ' + res[i]['montant'] +  'MAD' + '\n'  + 'Début de contrat : ' + res[i]['date_debut'] + '\n' + 'Fin du contrat : ' + res[i]['date_fin'], "error");
    }

    function showInf(){
    document.getElementById('marques').style.display='none';
    document.getElementById('partenariats').style.display='none';
    document.getElementById('stats').style.display='none';
    document.getElementById('demandes').style.display='none';
    document.getElementById('influenceurs').style.display='block';
    }
    function showMar(){
    document.getElementById('influenceurs').style.display='none';
    document.getElementById('partenariats').style.display='none';
    document.getElementById('stats').style.display='none';
    document.getElementById('demandes').style.display='none';
    document.getElementById('marques').style.display='block';
    }
    function showPart(){
    document.getElementById('marques').style.display='none';
    document.getElementById('influenceurs').style.display='none';
    document.getElementById('stats').style.display='none';
    document.getElementById('demandes').style.display='none';
    document.getElementById('partenariats').style.display='block';
    }
    function showStats(){
    document.getElementById('marques').style.display='none';
    document.getElementById('partenariats').style.display='none';
    document.getElementById('influenceurs').style.display='none';
    document.getElementById('demandes').style.display='none';
    document.getElementById('stats').style.display='block';
    }
    function showRequests(){
    document.getElementById('marques').style.display='none';
    document.getElementById('partenariats').style.display='none';
    document.getElementById('influenceurs').style.display='none';
    document.getElementById('stats').style.display='none';
    document.getElementById('demandes').style.display='block';
    }
</script>
<!-- javascript suggestions -->
<script>
    const searchinput=document.getElementById('search');
    searchinput.addEventListener('keyup',function(){
    const input=searchinput.value;
    var res= <?php echo json_encode($resinf); ?>;
    const result=res.filter(item=>item.pseudo.toLocaleLowerCase().includes(input.toLocaleLowerCase()));
    let suggestions='';
    if(input!=''){
      result.forEach(resultItem=>
      suggestions+='<a href="profil_inf_adm.php?marque='+resultItem.pseudo+'"><div class="lamarque"><img class="logo" src="pictures/'+resultItem.pseudo+'_'+resultItem.photo+'"><span class="nom-marque">'+resultItem.pseudo+'</span><button class="contact" href="#">Contacter</button></div></a><hr>'
      )
      let influenceurs=document.getElementById('lesinfluenceurs');
      influenceurs.style.display='none';

    }
    document.getElementById('suggestions').innerHTML= suggestions;
    if(input==''){
      let influenceurs=document.getElementById('lesinfluenceurs');
      influenceurs.style.display='block';
    }
    })
 
</script>
<script>
    const searchinputmar=document.getElementById('searchmar');
    searchinputmar.addEventListener('keyup',function(){
    const inputmar=searchinputmar.value;
    var resmar= <?php echo json_encode($resmar); ?>;
    const resultmar=resmar.filter(item=>item.marque.toLocaleLowerCase().includes(inputmar.toLocaleLowerCase()));
    let suggestions='';
    if(inputmar!=''){
      resultmar.forEach(resultItem=>
      suggestions+='<a href="profil_inf_adm.php?marque='+resultItem.marque+'"><div class="lamarque"><img class="logo" src="pictures/'+resultItem.marque+'_'+resultItem.logo+'"><span class="nom-marque">'+resultItem.marque+'</span><button class="contact" href="#">Contacter</button></div></a><hr>'
      )
      let marques=document.getElementById('lesmarques');
      marques.style.display='none';

    }
    document.getElementById('suggestionsmar').innerHTML= suggestions;
    if(inputmar==''){
      let marques=document.getElementById('lesmarques');
      marques.style.display='block';
    }
    })
 
</script>
<?php
}
?>