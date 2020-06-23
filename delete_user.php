<?php 
  session_start();

if (isset($_SESSION['admin']))
{
  include('doctype.php');

  include('header.php');

  ?>
  <section class="entete">
    <h1>SUPPRIMER UTILISATEUR</h1>
  </section>

  <section class="del_form">
  <form method="post" action="delete_user2.php"> 
       <label for="login">Entrer le login de l'utilisateur à supprimer:</label>
       <input type="text" name="login" id="login" /><br/>

       <label for="Supprimer"></label>
       <input type="submit" name="Supprimer" id="supprimer" /><br/>
</form>

  </section>

<?php

echo 'LISTE DES UTILISATEURS:';
?> <br/><br/><?php

try
{
  $bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}

$response=$bdd->prepare('select nom_utilisateur, prenom_utilisateur, fonction, login, password, fonction, site from utilisateur where id_societe=:id_societe');
  $response->execute(array(
         'id_societe'=> $_SESSION['id_societe']));

      $i=1;
  while($donnees=$response->fetch())
  {
    echo $i.'- nom:'.$donnees['nom_utilisateur'].',';
    echo 'prenom:'.$donnees['prenom_utilisateur'].',';
    echo 'login:'.$donnees['login'].',';
    echo 'password:'.$donnees['password'].',';
    echo 'fonction:'.$donnees['fonction'].',';
    echo 'site:'.$donnees['site'].',';
    $i++;
    ?> <br/><?php
  }
  $response->closecursor();
include('footer.php');
}

elseif (isset($_POST['login']) and isset($_POST['password']))
        {
          try
          {
            $bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
          }
          catch (Exception $e)
          {
            die('Erreur : ' . $e->getMessage());
          }

      
         $response=$bdd->prepare('select admin.login, admin.password, societe.id_societe from admin inner join societe on admin.id_admin = societe.id_admin where login=:login');
         $response->execute(array(
         'login'=> $_POST['login']));

         $donnees = $response->fetch();
  
         if ($donnees!=null and ($donnees['login']==$_POST['login']) and ($donnees['password']==$_POST['password']))
          {
            $_SESSION['admin']=$_POST['login'];
            $_SESSION['id_societe']=$donnees['id_societe'];

            $response->closecursor();

            include('doctype.php');

            include('header.php');

            ?>

            <section class="entete">
            <h1>SUPPRIMER UTILISATEUR</h1>
            </section>

            <section class="del_form">

            <form method="post" action="delete_user2.php"> 
            <label for="login">Entrer le login de l'utilisateur à supprimer ?</label>
            <input type="text" name="login" id="login" /><br/>

            <label for="Supprimer"></label>
            <input type="submit" name="Supprimer" id="Supprimer" /><br/>
            </form>

          </section>

            <section class="liste_users">
            <h2>LISTE DES UTILISATEURS</h2>
            <?php


          $response2=$bdd->prepare('select nom_utilisateur, prenom_utilisateur, fonction, login, password, site from utilisateur where id_societe=:id_societe');
           $response2->execute(array(
         'id_societe'=> $_SESSION['id_societe']));

          $i=1;
          while($donnees=$response2->fetch())
          {
           echo $i.'- nom:'.$donnees['nom_utilisateur'].',';
           echo 'prenom:'.$donnees['prenom_utilisateur'].',';
           echo 'login:'.$donnees['login'].',';
           echo 'password:'.$donnees['password'].',';
           echo 'fonction:'.$donnees['fonction'].',';
           echo 'site:'.$donnees['site'].',';
           $i++;
           ?> 
           <br/><?php
          }
          ?>
          </section>

          <?php
          $response2->closecursor();
          include('footer.php');
          }

          else
          {
            include('doctype.php');
            include('header.php');
            echo 'authentication failed';
            ?> <br/><a href='authentication.php?service=delete_user'><===== Back</a><?php
            include('footer.php');

          }
      }
        
else
        {
          include('doctype.php');
          include('header.php');

          echo 'Veuillez entrer un login et un mot de passe svp';
          ?>
          <br/> <br/>
          <a title="Produits" href="authentication.php?service=delete_user" class="center-div"> <====== Back</a>
          <?php
          include('footer.php');
        }
?>
