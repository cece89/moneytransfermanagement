<?php 

if (isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['email'])
     and isset($_POST['contact']) and isset($_POST['company_name']) and isset($_POST['branch'])
     and isset($_POST['login']) and isset($_POST['password']))
{
  try
    {
        $bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
    }
  catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

        
    $req=$bdd->prepare('insert into admin (nom, prenom, email, contact, login, password) 
      values (:nom,:prenom,:email,:contact,:login,:password)');
    $req->execute(array(
     'nom'=> $_POST['nom'], 
     'prenom'=> $_POST['prenom'], 
     'email'=> $_POST['email'], 
     'contact'=> $_POST['contact'], 
     'login'=> $_POST['login'], 
     'password'=> $_POST['password']));
    $req->closecursor();

    $response=$bdd->prepare('select id_admin from admin where login=:login');
    $response->execute(array(
    'login'=>$_POST['login']));
    $donnees=$response->fetch();
    $response->closecursor();

    $req2=$bdd->prepare('insert into societe (nom, branch, id_admin)
      values (:nom,:branch,:id_admin)');
    $req2->execute(array(
     'nom'=> $_POST['company_name'], 
     'branch'=> (int)$_POST['branch'],
     'id_admin'=> (int)$donnees['id_admin']));

    $req2->closecursor();

    include('doctype.php');
    include('header.php');?>
    <body>

    <section class="entete">
      <h1>NOUVELLE COMPAGNIE</h1>
    </section><?php
    echo 'Votre compte a été créé!';?>
          <p>Vous pouvez maintenant ajouter des utilisateurs en cliquant le lien ci dessous:</p>
          <a href="authentication.php?service=add_user">Ajouter un utilisateur</a>

      <section class="recapitulatif"><?php
      echo 'nom: '.$_POST['nom'] ?><br/><?php
      echo 'prenom: '. $_POST['prenom']?><br/><?php
      echo 'email: '. $_POST['email']?><br/><?php 
      echo 'contact: '. $_POST['contact']?><br/><?php  
      echo 'login: '.$_POST['login']?><br/><?php 
      echo 'password: '. $_POST['password']?><br/><?php
      echo 'nom: '. $_POST['company_name']?><br/>

      </section>
    <?php
          
    include('footer.php');
}

else
{
include('doctype.php');
include('header.php');
echo 'Veuillez renseigner tous les chams svp';
?>
          <br/> <br/>
          <a title="Produits" href="new_company.php"> <====== Back</a>
          <?php
include('footer.php');  
}
?>


