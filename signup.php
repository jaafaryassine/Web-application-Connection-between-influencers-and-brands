<?php
include "navbarcnx.html";
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .main{
        margin-top:100px;
        display:grid;
        grid-template-columns:15% 42% 42%;
        margin-left:40px;
      }
    a{
        text-decoration:none;
        color:black;
    }
    a:hover{
        transform:scale(1.05);
    }
    img{
      width: 288px;
    }
    .title{
      margin-top:30px;
      color:#008037;
    }
    .text{
      padding: 20px;
    }
    .carte{
      box-shadow: #1d2924 0px 6px 12px -2px, #1a1f1d 0px 3px 7px -3px ;
    }
    p{
      margin-top:-10px
    }
    @media (max-width:900px){
      .main{
        display:block;
      }
    }
    </style>
<body>

    <div class="main">
      <div class="lddl"></div>
        <a href="sign-in.php">
<div class="carte" style="width: 18rem;">
  <img src="images/influ.jpg" height="170">
  <div class="carte-body">
      <div class="title" style="font-weight:bold;"><center>Vous etes influenceur ?</center></div>
    <p class="text">Macolab va vous aider à trouver les collaborations avec des marques nationale,internationale et dans le domaine qui vous convient .</p>
  </div>
</div>
</a>

<a href="sign-mar.php">
<div class="carte carte2" style="width: 18rem;">
  <img src="images/marque.jpg" class="card-img-top" alt="..." height="170">
  <div >
      <div class="title" style="font-weight:bold;"><center>Vous etes une marque ?</center></div>
    <p class="text">Macolab est la meilleure stratégie pour promouvoir votre marque, chercher votre influenceur préferé et gagner de nouveaux clients . </p>
  </div>
</div>
</div>
</body>
</html>