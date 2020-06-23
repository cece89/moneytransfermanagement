<?php 
session_start();

if (isset($_SESSION['admin']))
{

include ('doctype.php');
include ('header.php');?>
<body>
  <section class="entete">
    <h1>RAPPORT MONEY TRANSFER</h1>
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

<h2>UTILISATEURS MONEY TRANSFER ENREGISTRES</h2><?php


$req=$bdd->prepare('select * from utilisateur where (id_societe=:id and fonction=:fonction)');
$req->execute(array(
  'id'=>$_SESSION['id_societe'],
  'fonction'=>'ag_mon_trans'
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


<form method="post" action="report_mt.php">
  
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
$req=$bdd->prepare('select * from ouverture inner join utilisateur on ouverture.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees=$req->fetch();
$solde_ouverture=$donnees['solde_ouverture'];
$espece_ouverture=$donnees['espece_ouverture'];

$req->closecursor();


$req=$bdd->prepare('select * from cloture_mt inner join utilisateur on cloture_mt.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees2=$req->fetch();
$solde_cloture=$donnees2['solde_banque'];
$espece_cloture=$donnees2['espece_cloture'];
$req->closecursor();


?>
<section class="detail_report">
<h2>RAPPORT DETAILLE</h2>
</section>

<section class="detail_western">
<h3>WESTERN UNION</h3>
  <?php
$req=$bdd->prepare('select * from operation inner join utilisateur on operation.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login and service=:service)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login'],
'service'=>'western'
));
?>

<table>
   <caption>DETAIL WESTERN UNION DU <?php echo ''.$_POST['date'];?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>NOM CLIENT</th>
           <th>ENVOI</th>
           <th>RETRAIT</th>
           <th>SOLDE</th>
       </tr>
   </thead>

   <tbody> <!-- Corps du tableau -->
        <?php
        while($donnees3=$req->fetch())
        {
          ?>

       <tr>
           <td><?php echo ''.$donnees3['nom_client'].' '.$donnees3['prenom_client'];?></td>
           <td><?php if ($donnees3['type_operation']=='depot'){
            echo ''.$donnees3['montant'];}?></td>
           <td><?php if ($donnees3['type_operation']=='retrait'){
            echo ''.$donnees3['montant'];}?></td>

       </tr><?php
        }
$req->closecursor();

$req2=$bdd->prepare('select * from rapport inner join utilisateur on rapport.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req2->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees4=$req2->fetch();
?>
        <tr>
           <td></td>
           <td><?php echo ''.$donnees4['envoi_western'];?></td>
           <td><?php echo ''.$donnees4['retrait_western'];?></td>
           <td><?php echo ''.$donnees4['retrait_western']-$donnees4['envoi_western'];?></td>
       </tr>
    </tbody>
</table>
</section>
<?php
$req2->closecursor();
?>  


<section class="detail_ria">
<h3>RIA</h3>
  <?php
$req=$bdd->prepare('select * from operation inner join utilisateur on operation.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login and service=:service)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login'],
'service'=>'ria'
));
?>



<table>
   <caption>DETAIL RIA DU <?php echo ''.$_POST['date'];?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>NOM CLIENT</th>
           <th>ENVOI</th>
           <th>RETRAIT</th>
           <th>SOLDE</th>
       </tr>
   </thead>

   <tbody> <!-- Corps du tableau -->
        <?php
        while($donnees3=$req->fetch())
        {
          ?>

       <tr>
           <td><?php echo ''.$donnees3['nom_client'].' '.$donnees3['prenom_client'];?></td>
           <td><?php if ($donnees3['type_operation']=='depot'){
            echo ''.$donnees3['montant'];}?></td>
           <td><?php if ($donnees3['type_operation']=='retrait'){
            echo ''.$donnees3['montant'];}?></td>

       </tr><?php
        }

$req->closecursor();
$req2=$bdd->prepare('select * from rapport inner join utilisateur on rapport.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req2->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees4=$req2->fetch();
$req2->closecursor();
?>
        <tr>
           <td></td>
           <td><?php echo ''.$donnees4['envoi_ria'];?></td>
           <td><?php echo ''.$donnees4['retrait_ria'];?></td>
           <td><?php echo ''.$donnees4['retrait_ria']-$donnees4['envoi_ria'];?></td>
       </tr>
    </tbody>

    
</table>
</section>


<section class="detail_moneygram">
<h3>MONEY GRAM</h3>
  <?php
$req=$bdd->prepare('select * from operation inner join utilisateur on operation.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login and service=:service)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login'],
'service'=>'money_gram'
));


?>

<table>
   <caption>DETAIL MONEYGRAM DU <?php echo ''.$_POST['date'];?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>NOM CLIENT</th>
           <th>ENVOI</th>
           <th>RETRAIT</th>
           <th>SOLDE</th>
       </tr>
   </thead>

   <tbody> <!-- Corps du tableau -->
        <?php
        while($donnees3=$req->fetch())
        {
          ?>

       <tr>
           <td><?php echo ''.$donnees3['nom_client'].' '.$donnees3['prenom_client'];?></td>
           <td><?php if ($donnees3['type_operation']=='depot'){
            echo ''.$donnees3['montant'];}?></td>
           <td><?php if ($donnees3['type_operation']=='retrait'){
            echo ''.$donnees3['montant'];}?></td>

       </tr><?php
        }

    $req->closecursor();

        $req2=$bdd->prepare('select * from rapport inner join utilisateur on rapport.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req2->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees4=$req2->fetch();
        ?>
        <tr>
           <td></td>
           <td><?php echo ''.$donnees4['envoi_moneygram']?></td>
           <td><?php echo ''.$donnees4['retrait_moneygram'];?></td>
           <td><?php echo ''.$donnees4['retrait_moneygram']-$donnees4['envoi_moneygram'];?></td>
       </tr>
    </tbody><?php
$req2->closecursor();
?> 

</table>
</section>

<section class="global_report">
<table>
   <caption>RAPPORT GLOBAL <?php echo ''.date('Y-m-d H:i:s');?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>SOLDE OUVERTURE</th>
           <th>ESPECES OUVERTURE</th>
           <th>SOLDE CLOTURE</th>
           <th>ESPECE CLOTURE</th>
       </tr>
   </thead>

<tfoot>  
       <tr>
           <th>SOLDE OUVERTURE</th>
           <th>ESPECES OUVERTURE</th>
           <th>SOLDE CLOTURE</th>
           <th>ESPECE CLOTURE</th>
       </tr>
   </tfoot> 

   <tbody> <!-- Corps du tableau -->
       <tr>
           <td><?php echo ''.$solde_ouverture;?></td>
           <td><?php echo ''.$espece_ouverture;?></td>
           <td><?php echo ''.$solde_cloture;?></td>
           <td><?php echo ''.$espece_cloture;?></td>
       </tr>
       
   </tbody>
</table>

</section>

<section class="total_env_ret"> 
<p>
<?php
$total_envoi=$donnees4['envoi_moneygram']+$donnees4['envoi_western']+$donnees4['envoi_ria'];
$total_retrait=$donnees4['retrait_moneygram']+$donnees4['retrait_western']+$donnees4['retrait_ria'];
$total=$total_retrait-$total_envoi;

  echo 'Total envoi: '.$total_envoi;?><br/><?php
  echo 'Total retrait :'.$total_retrait;?><br/><?php
  echo 'Retrait - Envoi :'.$total;
  ?>
</p>
  <br/>
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

          
          include ('doctype.php');
          include ('header.php');?>
          <body>
          <section class="entete">
          <h1>RAPPORT MONEY TRANSFER</h1>
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

<h2>UTILISATEURS MONEY TRANSFER ENREGISTRES</h2><?php


$req=$bdd->prepare('select * from utilisateur where (id_societe=:id and fonction=:fonction)');
$req->execute(array(
  'id'=>$_SESSION['id_societe'],
  'fonction'=>'ag_mon_trans'
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


<form method="post" action="report_mt.php">
  
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
$req=$bdd->prepare('select * from ouverture inner join utilisateur on ouverture.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees=$req->fetch();
$solde_ouverture=$donnees['solde_ouverture'];
$espece_ouverture=$donnees['espece_ouverture'];

$req->closecursor();


$req=$bdd->prepare('select * from cloture_mt inner join utilisateur on cloture_mt.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees2=$req->fetch();
$solde_cloture=$donnees2['solde_banque'];
$espece_cloture=$donnees2['espece_cloture'];
$req->closecursor();

?>
<section class="detail_report">
<h2>RAPPORT DETAILLE</h2>
</section>

<section class="detail_western">
<h3>WESTERN UNION</h3>
  <?php
$req=$bdd->prepare('select * from operation inner join utilisateur on operation.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login and service=:service)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login'],
'service'=>'western'
));
?>


<table>
   <caption>DETAIL WESTERN UNION DU <?php echo ''.$_POST['date'];?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>NOM CLIENT</th>
           <th>ENVOI</th>
           <th>RETRAIT</th>
           <th>SOLDE</th>
       </tr>
   </thead>

   <tbody> <!-- Corps du tableau -->
        <?php
        while($donnees3=$req->fetch())
        {
          ?>

       <tr>
           <td><?php echo ''.$donnees3['nom_client'].' '.$donnees3['prenom_client'];?></td>
           <td><?php if ($donnees3['type_operation']=='depot'){
            echo ''.$donnees3['montant'];}?></td>
           <td><?php if ($donnees3['type_operation']=='retrait'){
            echo ''.$donnees3['montant'];}?></td>

       </tr><?php
        }
$req->closecursor();

$req2=$bdd->prepare('select * from rapport inner join utilisateur on rapport.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req2->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees4=$req2->fetch();

        ?>
        <tr>
           <td></td>
           <td><?php echo ''.$donnees4['envoi_western'];?></td>
           <td><?php echo ''.$donnees4['retrait_western'];?></td>
           <td><?php echo ''.$donnees4['retrait_western']-$donnees4['envoi_western'];?></td>
       </tr>
    </tbody><?php

    $req2->closecursor();
    ?>  
</table>
</section>


<section class="detail_ria">
<h3>RIA</h3>
  <?php
$req=$bdd->prepare('select * from operation inner join utilisateur on operation.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login and service=:service)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login'],
'service'=>'ria'
));
?>


<table>
   <caption>DETAIL RIA DU <?php echo ''.$_POST['date'];?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>NOM CLIENT</th>
           <th>ENVOI</th>
           <th>RETRAIT</th>
           <th>SOLDE</th>
       </tr>
   </thead>

   <tbody> <!-- Corps du tableau -->
        <?php
        while($donnees3=$req->fetch())
        {
          ?>

       <tr>
           <td><?php echo ''.$donnees3['nom_client'].' '.$donnees3['prenom_client'];?></td>
           <td><?php if ($donnees3['type_operation']=='depot'){
            echo ''.$donnees3['montant'];}?></td>
           <td><?php if ($donnees3['type_operation']=='retrait'){
            echo ''.$donnees3['montant'];}?></td>

       </tr><?php
        }

$req->closecursor();
        

$req2=$bdd->prepare('select * from rapport inner join utilisateur on rapport.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req2->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees4=$req2->fetch();
?>
        <tr>
           <td></td>
           <td><?php echo ''.$donnees4['envoi_ria']?></td>
           <td><?php echo ''.$donnees4['retrait_ria'];?></td>
           <td><?php echo ''.$donnees4['retrait_ria']-$donnees4['envoi_ria'];?></td>
       </tr>
    </tbody><?php

    $req2->closecursor();
    ?>  
</table>
</section>



<section class="detail_moneygram">
<h3>MONEY GRAM</h3>
  <?php
$req=$bdd->prepare('select * from operation inner join utilisateur on operation.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login and service=:service)');
$req->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login'],
'service'=>'money_gram'
));
?>


<table>
   <caption>DETAIL MONEYGRAM DU <?php echo ''.$_POST['date'];?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>NOM CLIENT</th>
           <th>ENVOI</th>
           <th>RETRAIT</th>
           <th>SOLDE</th>
       </tr>
   </thead>

   <tbody> <!-- Corps du tableau -->
        <?php
        while($donnees3=$req->fetch())
        {
          ?>

       <tr>
           <td><?php echo ''.$donnees3['nom_client'].' '.$donnees3['prenom_client'];?></td>
           <td><?php if ($donnees3['type_operation']=='depot'){
            echo ''.$donnees3['montant'];}?></td>
           <td><?php if ($donnees3['type_operation']=='retrait'){
            echo ''.$donnees3['montant'];}?></td>

       </tr><?php
        }

    $req->closecursor();

    
$req2=$bdd->prepare('select * from rapport inner join utilisateur on rapport.id_utilisateur=utilisateur.id_utilisateur where (year(:date)=year(date) and month(:date)=month(date) and day(:date)=day(date) and utilisateur.login=:login)');
$req2->execute(array(
'date'=>$_POST['date'],
'login'=>$_POST['login']
));

$donnees4=$req2->fetch();
        ?>
        <tr>
           <td></td>
           <td><?php echo ''.$donnees4['envoi_moneygram']?></td>
           <td><?php echo ''.$donnees4['retrait_moneygram'];?></td>
           <td><?php echo ''.$donnees4['retrait_moneygram']-$donnees4['envoi_moneygram'];?></td>
       </tr>
    </tbody><?php

    $req2->closecursor();
    ?>  
</table>
</section>

?>
<section class="global_report">
<table>
   <caption>RAPPORT GLOBAL <?php echo ''.date('Y-m-d H:i:s');?></caption>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th>SOLDE OUVERTURE</th>
           <th>ESPECES OUVERTURE</th>
           <th>SOLDE CLOTURE</th>
           <th>ESPECE CLOTURE</th>
       </tr>
   </thead>

<tfoot>  
       <tr>
           <th>SOLDE OUVERTURE</th>
           <th>ESPECES OUVERTURE</th>
           <th>SOLDE CLOTURE</th>
           <th>ESPECE CLOTURE</th>
       </tr>
   </tfoot> 

   <tbody> <!-- Corps du tableau -->
       <tr>
           <td><?php echo ''.$solde_ouverture;?></td>
           <td><?php echo ''.$espece_ouverture;?></td>
           <td><?php echo ''.$solde_cloture;?></td>
           <td><?php echo ''.$espece_cloture;?></td>
       </tr>
       
   </tbody>
</table>

</section>

<section class="total_env_ret"> 
<p>
  <?php
$total_envoi=$donnees4['envoi_moneygram']+$donnees4['envoi_western']+$donnees4['envoi_ria'];
$total_retrait=$donnees4['retrait_moneygram']+$donnees4['retrait_western']+$donnees4['retrait_ria'];

  echo 'Total envoi: '.$total_envoi;?><br/><?php
  echo 'Total retrait :'.$total_retrait;?><br/><?php
  echo 'Retrait - Envoi :'.$total_retrait-$total_envoi;
  ?>
</p>
</section>

<?php
}

}
else
{
  include ('doctype.php');
  include ('header.php');?>
  <body>
  <section class="entete">
    <h1>RAPPORT MONEY TRANSFER</h1>
  </section><?php

  echo 'login ou password incorrect!';

  ?><br/>
  <a href="authentication.php?service=report_mt"><======= Back</a><?php
  include ('footer.php');
}

}
else
{
  include ('doctype.php');
  include ('header.php');?>
  <body>
  <section class="entete">
    <h1>RAPPORT MONEY TRANSFER</h1>
  </section><?php
  echo 'Entrer un login ou password svp!';
  ?><br/>
  <a href="authentication.php?service=report_mt"><======= Back</a><br/><?php
  include ('footer.php');
}
?>