<?php 
include "connect_db.php";
session_start();
if(isset($_SESSION['pseudo']) && !isset($_SESSION['marque'])){
    $pseudo=$_SESSION['pseudo'];
    $delete=$db->query("DELETE FROM partenariats_avant WHERE influenceur='$pseudo' AND statut='no'");
    header("location:account_inf.php");
}
if(isset($_SESSION['marque']) && !isset($_SESSION['pseudo'])){
    $marque=$_SESSION['marque'];
    $delete=$db->query("DELETE FROM partenariats_avant WHERE marque='$marque' AND statut='no'");
    header("location:account_mar.php");
}