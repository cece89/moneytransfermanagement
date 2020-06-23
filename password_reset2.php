<?php 
  session_start();

if (isset($_POST['login']) and isset($_POST['password']))
{
  try
  {
  $bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
  }
  catch (Exception $e)
  {
  die('Erreur : ' . $e->getMessage());
  }

  $response=$bdd->prepare('select login from utilisateur where id_societe=:id_societe');
  $response->execute(array(
         'id_societe'=> $_SESSION['id_societe']
       ));

  $login_exist=False;
  while($donnees=$response->fetch())
  {
    if ($_POST['login'] == $donnees['login'])
    {     
      $login_exist=True;
      break;
    }
  }  

  $response->closecursor();
 

  if($login_exist)
  {
  $req=$bdd->prepare('update utilisateur set password=:password where login=:login');
  $req->execute(array(
  'login'=> $_POST['login'],
  'password'=> $_POST['password']
  ));
  $req->closecursor();

  include ('doctype.php');
  include ('header.php');

    ?>

  <body>
        <section class="entete">
          <h1>REINITIALISATION MOT DE PASSE</h1>
        </section><?php
  echo 'Le mot de passe de l\'Utilisateur a été modifié avec succès!';
  ?>
  <br/>
  <a href="password_reset.php"><======== Back</a><?php
  include ('footer.php');
  }

  else
  {

  include ('doctype.php');
  include ('header.php');
  ?>

  <body>
        <section class="entete">
          <h1>REINITIALISATION MOT DE PASSE</h1>
        </section><?php
  echo 'Utilisateur introuvable';  ?>
  <br/>
  <a href="password_reset.php"><======== Back</a><?php
  include ('footer.php');
  }
}

else
{
  include ('doctype.php');
  include ('header.php');
  ?>

  <body>
        <section class="entete">
          <h1>REINITIALISATION MOT DE PASSE</h1>
        </section><?php
  echo 'Veuillez enter un login correct svp';
  include('footer.php');
}
?>
  
