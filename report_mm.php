<?php 
session_start();

if (isset($_SESSION['admin']))
{

include ('doctype.php');
include ('header.php');?>
<body>
	<section class="entete">
		<h1>RAPPORT MOBILE MONEY</h1>
	</section><?php

try
{
$bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
}
catch (Exception $e)
{
  die('Erreur : ' . $e->getMessage());
}

?>
<section class="dayly">

<h2>UTILISATEURS MOBILE MONEY ENREGISTRES</h2><?php


$req=$bdd->prepare('select * from utilisateur where (id_societe=:id and fonction=:fonction)');
$req->execute(array(
  'id'=>$_SESSION['id_societe'],
  'fonction'=>'ag_mob_mon'
));

while($donnees=$req->fetch())
{
  echo ''.$donnees['id_utilisateur'].'->'.$donnees['login'].'->'.$donnees['nom_utilisateur'].'->'.$donnees['prenom_utilisateur'].'->'.$donnees['fonction'];?> <br/> <?php
}



$req->closecursor();

?>
</section>

<section class="dayly_form">

<h2>FORMULAIRE</h2>


<form method="post" action="report_mm.php">
  
       <label for="date">Entrer la date:</label>
       <input type="text" name="date" id="date" /><br/>

       <label for="id">Entrer le login de l'utilisateur:</label>
       <input type="text" name="login" id="login" /><br/>

       <input type="submit" name="valider" id="valider" /><br/>
       
</form>
</section>


<?php

if (isset($_POST['date']) and isset($_POST['login']))
{

?>

<section class="echo">
<h3><?php echo '['.$_POST['login'].']';?>SITUATION JOURNALIERE DU <?php echo ''.date('Y-m-d H:i:s');?><h3>
</section>

<?php
$req=$bdd->prepare('select * from ouverture_mm inner join utilisateur on ouverture_mm.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees=$req->fetch();
$total=$donnees['solde_orange']+$donnees['solde_mtn']+$donnees['solde_moov'];

$req->closecursor();


$req=$bdd->prepare('select * from cloture_mm inner join utilisateur on cloture_mm.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees2=$req->fetch();
$total2=$donnees2['solde_orange']+$donnees2['solde_mtn']+$donnees2['solde_moov'];

$req->closecursor();

?>
<section class="report">
<table>
   <caption>OUVERTURE AU <?php echo ''.date('Y-m-d H:i:s');?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>LIBELLE</th>
           <th>OPERATEUR</th>
           <th>CREDIT</th>
       </tr>
   </thead>

<!--    <tfoot>  
       <tr>
           <th>LIBELLE</th>
           <th>OPERATEUR</th>
           <th>CREDIT</th>
       </tr>
   </tfoot> -->

   <tbody> <!-- Corps du tableau -->
       <tr>
           <td>DOTATION CREDIT</td>
           <td>ORANGE</td>
           <td><?php echo ''.$donnees['solde_orange'];?></td>
       </tr>
       <tr>
           <td></td>
           <td>MTN</td>
           <td><?php echo ''.$donnees['solde_mtn'];?></td>
       </tr>
       <tr>
           <td></td>
           <td>MOOV</td>
           <td><?php echo ''.$donnees['solde_moov'];?></td>
       </tr>
       <tr>
           <td>TOTAL DOTATION CREDIT</td>
           <td></td>
           <td><?php echo ''.$total;?></td>
       </tr>
       <tr>
           <td>TOTAL ESPECES DISPONIBLES</td>
           <td></td>
           <td><?php echo ''.$donnees['espece_ouverture'];?></td>
       </tr>
       
   </tbody>
</table>

</section>

<section class="report_cloture">
<table>
   <caption>CLOTURE AU <?php echo ''.date('Y-m-d H:i:s');?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>LIBELLE</th>
           <th>OPERATEUR</th>
           <th>CREDIT</th>
       </tr>
   </thead>

<!--    <tfoot>  
       <tr>
           <th>LIBELLE</th>
           <th>OPERATEUR</th>
           <th>CREDIT</th>
       </tr>
   </tfoot> -->

   <tbody> <!-- Corps du tableau -->
       <tr>
           <td>DOTATION CREDIT</td>
           <td>ORANGE</td>
           <td><?php echo ''.$donnees2['solde_orange'];?></td>
       </tr>
       <tr>
           <td></td>
           <td>MTN</td>
           <td><?php echo ''.$donnees2['solde_mtn'];?></td>
       </tr>
       <tr>
           <td></td>
           <td>MOOV</td>
           <td><?php echo ''.$donnees2['solde_moov'];?></td>
       </tr>
       <tr>
           <td>TOTAL DOTATION CREDIT</td>
           <td></td>
           <td><?php echo ''.$total2;?></td>
       </tr>
       <tr>
           <td>TOTAL ESPECES DISPONIBLES</td>
           <td></td>
           <td><?php echo ''.$donnees2['espece_cloture'];?></td>
       </tr>
       
   </tbody>
</table>

</section>



<?php
}
include ('footer.php');

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

      
         $response=$bdd->prepare('select * from admin inner join societe on admin.id_admin = societe.id_admin where login=:login');
         $response->execute(array(
         'login'=> $_POST['login']));

         $donnees = $response->fetch();
         $response->closecursor();
  
         if ($donnees!=null and ($donnees['login']==$_POST['login']) and ($donnees['password']==$_POST['password']))
          {
            $_SESSION['admin']=$_POST['login'];
            $_SESSION['id_societe']=$donnees['id_societe'];

          include('doctype.php');
          include('header.php');?>

           <body>
	<section class="entete">
		<h1>RAPPORT JOURNALIER</h1>
	</section><?php

try
{
$bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
}
catch (Exception $e)
{
  die('Erreur : ' . $e->getMessage());
}

?>
<section class="dayly">

<h2>UTILISATEURS MOBILE MONEY ENREGISTRES</h2><?php


$req=$bdd->prepare('select * from utilisateur where (id_societe=:id and fonction=:fonction)');
$req->execute(array(
  'id'=>$_SESSION['id_societe'],
  'fonction'=>'ag_mob_mon'
));

while($donnees=$req->fetch())
{
  echo ''.$donnees['id_utilisateur'].'->'.$donnees['login'].'->'.$donnees['nom_utilisateur'].'->'.$donnees['prenom_utilisateur'].'->'.$donnees['fonction'];?> <br/> <?php
}



$req->closecursor();

?>
</section>

<section class="dayly_form">

<h2>FORMULAIRE</h2>


<form method="post" action="report_mm.php">
  
       <label for="date">Entrer la date:</label>
       <input type="text" name="date" id="date" /><br/>

       <label for="id">Entrer le login de l'utilisateur:</label>
       <input type="text" name="login" id="login" /><br/>

       <input type="submit" name="valider" id="valider" /><br/>
       
</form>
</section>


<?php

if (isset($_POST['date']) and isset($_POST['login']))
{

?>

<section class="echo">
<h3>SITUATION JOURNALIERE DU <?php echo ''.date('Y-m-d H:i:s');?><h3>
</section>

<?php
$req=$bdd->prepare('select * from ouverture_mm inner join utilisateur on ouverture_mm.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees=$req->fetch();
$total=$donnees['solde_orange']+$donnees['solde_mtn']+$donnees['solde_moov'];

$req->closecursor();


$req=$bdd->prepare('select * from cloture_mm inner join utilisateur on cloture_mm.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees2=$req->fetch();
$total2=$donnees2['solde_orange']+$donnees2['solde_mtn']+$donnees2['solde_moov'];

$req->closecursor();

?>
<section class="report">
<table>
   <caption>OUVERTURE AU <?php echo ''.date('Y-m-d H:i:s');?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>LIBELLE</th>
           <th>OPERATEUR</th>
           <th>CREDIT</th>
       </tr>
   </thead>

<!--    <tfoot>  
       <tr>
           <th>LIBELLE</th>
           <th>OPERATEUR</th>
           <th>CREDIT</th>
       </tr>
   </tfoot> -->

   <tbody> <!-- Corps du tableau -->
       <tr>
           <td>DOTATION CREDIT</td>
           <td>ORANGE</td>
           <td><?php echo ''.$donnees['solde_orange'];?></td>
       </tr>
       <tr>
           <td></td>
           <td>MTN</td>
           <td><?php echo ''.$donnees['solde_mtn'];?></td>
       </tr>
       <tr>
           <td></td>
           <td>MOOV</td>
           <td><?php echo ''.$donnees['solde_moov'];?></td>
       </tr>
       <tr>
           <td>TOTAL DOTATION CREDIT</td>
           <td></td>
           <td><?php echo ''.$total;?></td>
       </tr>
       <tr>
           <td>TOTAL ESPECES DISPONIBLES</td>
           <td></td>
           <td><?php echo ''.$donnees['espece_ouverture'];?></td>
       </tr>
       
   </tbody>
</table>

</section>

<section class="report_cloture">
<table>
   <caption>CLOTURE AU <?php echo ''.date('Y-m-d H:i:s');?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>LIBELLE</th>
           <th>OPERATEUR</th>
           <th>CREDIT</th>
       </tr>
   </thead>

<!--    <tfoot>  
       <tr>
           <th>LIBELLE</th>
           <th>OPERATEUR</th>
           <th>CREDIT</th>
       </tr>
   </tfoot> -->

   <tbody> <!-- Corps du tableau -->
       <tr>
           <td>DOTATION CREDIT</td>
           <td>ORANGE</td>
           <td><?php echo ''.$donnees2['solde_orange'];?></td>
       </tr>
       <tr>
           <td></td>
           <td>MTN</td>
           <td><?php echo ''.$donnees2['solde_mtn'];?></td>
       </tr>
       <tr>
           <td></td>
           <td>MOOV</td>
           <td><?php echo ''.$donnees2['solde_moov'];?></td>
       </tr>
       <tr>
           <td>TOTAL DOTATION CREDIT</td>
           <td></td>
           <td><?php echo ''.$total2;?></td>
       </tr>
       <tr>
           <td>TOTAL ESPECES DISPONIBLES</td>
           <td></td>
           <td><?php echo ''.$donnees2['espece_cloture'];?></td>
       </tr>
       
   </tbody>
</table>

</section>

<?php
}}

else
{
	include('doctype.php');
	include('header.php');?>
	
	<body>
		<section class="entete">
			<h1>RAPPORT JOURNALIER</h1>
		</section><?php
	echo 'Login ou mot de passe incorrect';?><br/>
	<a href="authentication.php?service=report_mm"><====== Back</a><?php
}
include ('footer.php');
}
?>