<?php 
  session_start();

if ($_POST['nom']!=null and $_POST['prenom']!=null  and $_POST['fonction']!=null  and $_POST['login']!=null  and $_POST['password']!=null  and $_POST['site']!=null)
{

  try
  {
  $bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
  }
  catch (Exception $e)
  {
  die('Erreur : ' . $e->getMessage());
  }

  $req=$bdd->prepare('insert into utilisateur (nom_utilisateur, prenom_utilisateur, fonction, login, password, site, id_societe) values (:nom,:prenom,:fonction,:login,:password,:site,:id_societe)');
  $req->execute(array(
         'id_societe'=> $_SESSION['id_societe'],
         'nom' => $_POST['nom'],
         'prenom' => $_POST['prenom'],
         'login' => $_POST['login'],
         'password' => $_POST['password'],
         'fonction' => $_POST['fonction'],
         'site' => $_POST['site']
       ));

  $req->closecursor();


  include ('doctype.php');
  include ('header.php');?>

          <body>
            <section class="entete">
            <h1> CREATION UTILISATEUR </h1>
            </section><?php
  echo 'l\'Utilisateur a été ajouté avec succès!';?><br/><br/><?php

  echo 'nom: '.$_POST['nom']; ?><br/><?php
  echo 'prenom: '.$_POST['prenom']; ?><br/><?php
  echo 'login: '. $_POST['login'];?><br/><?php
  echo 'password: '. $_POST['password'];?><br/><?php
  echo 'fonction: '. $_POST['fonction'];?><br/><?php
  echo 'site: '. $_POST['site'];?><br/>


  <a href="add_user.php"><======== Back</a><?php
  include ('footer.php');

}

else
{
  include ('doctype.php');
  include ('header.php');?>
  <body>
            <section class="entete">
            <h1> CREATION UTILISATEUR </h1>
            </section><?php
  
  echo 'Veuillez renseigner tous les champs svp';?><br/>
  <a href="add_user.php"><======== Back</a><?php

  include('footer.php');
}

  
