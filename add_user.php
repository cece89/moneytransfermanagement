<?php 
  session_start();


//Pour ajouter un utilisateur, il faut être administrateur. Si une session admin existe alors on affiche le formulaire de creation de l'utilisateur

if (isset($_SESSION['admin']))
{
  include('doctype.php');

  include('header.php');?>

  <body>
    <section class="entete">
      <h1> CREATION UTILISATEUR </h1>
    </section>

    <section class="form">

  <form method="post" action="add_user2.php"> 

       <label for="nom">Entrer le nom de l'utilisateur</label>
       <input type="text" name="nom" id="nom" /><br/>

       <label for="prenom">Entrer le prenom de l'utilisateur ?</label>
       <input type="text" name="prenom" id="prenom" /><br/>

       <p>Fonction:
       <select name="fonction">
       <option value="ag_mob_mon">AGENT MOBILE MONEY</option>
       <option value="ag_mon_trans">AGENT TRANSFERT INTER</option>
       </select>
       </p>
       

       <p>Site:

       <select name="site">
       <option value="site1">Site 1</option>
       <option value="site2">Site 2</option>
       <option value="site3">Site 3</option>
       <option value="site4">Site 4</option>
       <option value="site5">Site 5</option>
       </select>
       </p>
 
       <label for="login">Entrer le login de l'utilisateur ?</label>
       <input type="text" name="login" id="login" /><br/>

       <label for="password">Entrer le mot de passe de l'utilisateur ?</label>
       <input type="password" name="password" id="password" /><br/>

       <label for="enregistrer"></label>
       <input type="submit" name="enregistrer" id="enregistrer" /><br/>
</form>

</section>

<section class="resultat_adduser">


 <p>LISTE DES UTILISATEURS</p>
<?php
//On affiche la liste des utilisateurs enregistrés dans la base de donnees
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

    ?> <br/>

    
    <?php
  }?>
</section>




<?php
include('footer.php');
}
//Si on recoit de la part de la page authentication.php des informations de coonnexion, on verifie dans la base si ces informations sont corrects puis on affiche le formulaire de creation d'utilisateur
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

            include('header.php');?>

            <body>
            <section class="entete">
               <h1> CREATION UTILISATEUR </h1>
            </section>

            <section class="form">

            <form method="post" action="add_user2.php"> 

            <label for="nom">Entrer le nom de l'utilisateur</label>
            <input type="text" name="nom" id="nom" /><br/>

           <label for="prenom">Entrer le prenom de l'utilisateur ?</label>
           <input type="text" name="prenom" id="prenom" /><br/>

          <p>Fonction:</p>
           <select name="fonction">
            <option value="ag_mob_mon">AGENT MOBILE MONEY</option>
            <option value="ag_mon_trans">AGENT MONEY TRANSFERT</option>
           </select>
          

          <p>Site:</p>
           <select name="site">
            <option value="site1">Site 1</option>
            <option value="site2">Site 2</option>
            <option value="site3">Site 3</option>
            <option value="site4">Site 4</option>
            <option value="site5">Site 5</option>
           </select>
          
 
           <label for="login">Entrer le login de l'utilisateur ?</label>
           <input type="text" name="login" id="login" /><br/>

           <label for="password">Entrer le mot de passe de l'utilisateur ?</label>
           <input type="password" name="password" id="password" /><br/>
           
           <label for="enregistrer"></label>
            <input type="submit" name="enregistrer" id="enregistrer" /><br/>
            </form>

          </section>

          <section class="result_adduser">
            <p>LISTE DES UTILISATEURS</p>

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
           ?> <br/><?php
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
            include('header.php');?>

            <body>
            <section class="entete">
            <h1> CREATION UTILISATEUR </h1>
            </section><?php

            echo 'authentication failed';
            ?> <br/><a href='authentication.php?service=add_user'><===== Back</a><?php
            include('footer.php');

          }
      }
        
else
        {
          include('doctype.php');
          include('header.php');?>

          <body>
            <section class="entete">
            <h1> CREATION UTILISATEUR </h1>
            </section>

            <?php
          echo 'Veuillez entrer un login et un mot de passe svp';
          ?>
          <br/> <br/>
          <a title="Produits" href="authentication.php?service=add_user" class="center-div"> <====== Back</a>
          <?php
          include('footer.php');
        }
?>
