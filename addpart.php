<?php
include "connect_db.php";
 if (isset($_POST['accept'])) {
    $i=$_POST['ligne'];
    echo $i;
    $id=$_POST['accept'];
    echo $id;
    $marque=$resrequest[$i]['marque'];
    $montant=$resrequest[$i]['montant'];
    $date_debut=$resrequest[$i]['date_debut'];
    $date_fin=$resrequest[$i]['date_fin'];
    $update=$db->query("UPDATE partenariats_avant SET statut='yes' WHERE id=$id");
    $insert=$db->prepare("INSERT INTO partenariats values (?,?,?,?,?,?)");
    $insert->execute(array($id,$pseudo,$marque,$montant,$date_debut,$date_fin));
}
?>