<?php
session_start();

if (isset($_POST['solde_cloture']))
{
include('doctype.php');
include('header.php');


	try
    	  {
     	   $bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
    		}
  			catch (Exception $e)
   			 {
    	    die('Erreur : ' . $e->getMessage());
    }

	$especes=(int)$_POST['10000']*10000+(int)$_POST['5000']*5000+ (int)$_POST['2000']*2000+ (int)$_POST['1000']*1000+ (int)$_POST['500']*500+ (int)$_POST['200']*200+ (int)$_POST['100']*100+ (int)$_POST['50']*50+ (int)$_POST['25']*25;


	$response = $bdd->prepare('select montant from operation where (year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()) and id_utilisateur=:id and service=:service and type_operation=:operation)');
	$response->execute(array(
		'id'=>$_SESSION['id'],
		'service'=>'money_gram',
		'operation'=>'depot'
	));

	$total_moneygram_envoi=0;
	while($donnees=$response->fetch())
	{
		$total_moneygram_envoi+=$donnees['montant'];
	}
	
	$response->closecursor();
	


	$response = $bdd->prepare('select montant from operation where (year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()) and id_utilisateur=:id and service=:service and type_operation=:operation)');
	$response->execute(array(
		'id'=>$_SESSION['id'],
		'service'=>'money_gram',
		'operation'=>'retrait'
	));


	$total_moneygram_retrait=0;
	while($donnees=$response->fetch())
	{
		$total_moneygram_retrait+=$donnees['montant'];
	}
	$response->closecursor();


	$response = $bdd->prepare('select montant from operation where (year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()) and id_utilisateur=:id and service=:service and type_operation=:operation)');
	$response->execute(array(
		'id'=>$_SESSION['id'],
		'service'=>'ria',
		'operation'=>'depot'
	));

	$total_ria_envoi=0;
	while($donnees=$response->fetch())
	{
		$total_ria_envoi+=$donnees['montant'];
	}
	$response->closecursor();


	$response = $bdd->prepare('select montant from operation where (year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()) and id_utilisateur=:id and service=:service and type_operation=:operation)');
	$response->execute(array(
		'id'=>$_SESSION['id'],
		'service'=>'ria',
		'operation'=>'retrait'
	));


	$total_ria_retrait=0;
	while($donnees=$response->fetch())
	{
		$total_ria_retrait+=$donnees['montant'];
	}
	$response->closecursor();


	$response = $bdd->prepare('select montant from operation where (year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()) and id_utilisateur=:id and service=:service and type_operation=:operation)');
	$response->execute(array(
		'id'=>$_SESSION['id'],
		'service'=>'western',
		'operation'=>'depot'
	));


	$total_western_envoi=0;
	while($donnees=$response->fetch())
	{
		$total_western_envoi+=$donnees['montant'];
	}
	$response->closecursor();



	$response = $bdd->prepare('select montant from operation where (year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()) and id_utilisateur=:id and service=:service and type_operation=:operation)');
	$response->execute(array(
		'id'=>$_SESSION['id'],
		'service'=>'western',
		'operation'=>'retrait'
	));


	$total_western_retrait=0;
	while($donnees=$response->fetch())
	{
		$total_western_retrait+=$donnees['montant'];
	}
	$response->closecursor();

	?>

	<body>
	<section class="entete">
		<h1> <?php echo 'POINT DE LA JOURNEE DU '.date('Y-m-d H:i:s');?> </h1>
	</section>

	<section class="envoi_retrait">
	
	<h1>ENVOI/RETRAIT</h1>
	<h2>WESTERN UNION</h2/><?php
	echo 'Total envoi:'.$total_western_envoi;?> <br/><?php
	echo 'Total retrait:'.$total_western_retrait;?> <br/>

	<h2>RIA</h2><?php
	echo 'Total envoi:'.$total_ria_envoi;?> <br/><?php
	echo 'Total retrait:'.$total_ria_retrait;?> <br/>

	<h2>MONEY GRAM</h2/><?php
	echo 'Total envoi:'.$total_moneygram_envoi;?> <br/><?php
	echo 'Total retrait:'.$total_moneygram_retrait;?> <br/><?php

	$total_envoi=$total_moneygram_envoi+$total_ria_envoi+$total_western_envoi;
	$total_retrait=$total_moneygram_retrait+$total_ria_retrait+$total_western_retrait;

	$credit=0;
	$response=$bdd->prepare('select * from credit where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
	$response->execute(array(
		'id'=>$_SESSION['id']
	));
	while($donnees=$response->fetch())
	{
		$credit+=$donnees['montant'];
	}
	$response->closecursor();

	$response=$bdd->prepare('select * from ouverture where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
   	$response->execute(array(
   		'id'=>$_SESSION['id']));
   	$donnees=$response->fetch();

   	$esp_o=$donnees['espece_ouverture'];
   	$response->closecursor();?>

   	</section>
   	<section class=resultat>

	<?php
   	echo 'Especes ouverture:'.$esp_o;?> <br/><?php
   	echo 'solde ouverture:'.$_SESSION['solde_ouverture'];?> <br/><?php
	echo 'Total envoi:'.$total_envoi;?> <br/><?php
	echo 'Total retrait:'.$total_retrait;?> <br/><?php
	echo 'Total impayés:'.$credit;?> <br/> <br/>

	</section>
	
	<section class="recapitulatif">
	<h1>RECAPITULATIF</h1>
	<?php

	$esp=$esp_o+$total_envoi-$total_retrait-$credit;
	$banque=$_SESSION['solde_ouverture']-$total_envoi+$total_retrait;
	echo 'BANQUE ESCOMPTE: '.$banque;?> <br/><?php
	echo 'BANQUE DECLARE: '.$_POST['solde_cloture'];?> <br/><?php
	echo 'ESPECE ESCOMPTE: '.$esp;?> <br/><?php
	echo 'ESPECE DECLARE: '.$especes;?> <br/><?php


	if($banque==$_POST['solde_cloture'] and $esp==$especes)
	{
		echo 'solde OK!';

		// Avant d'enregistrer une entrée dans la table ouverture, on supprime la donnée correspondante à la date du jour pour eviter les doublons. La table ne recevant une entree par jour par utilisateur
    $req=$bdd->prepare('delete from ouverture_mm where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
    $req->execute(array(
      'id'=>$_SESSION['id']));
    $req->closecursor();

    $req=$bdd->prepare('insert into cloture_mt(date,solde_banque,espece_cloture,id_utilisateur) values (now(),:solde_banque,:espece_cloture,:id)');
    $req->execute(array(
      'id'=>$_SESSION['id'],
      'solde_banque'=>$banque,
      'espece_cloture'=>$esp
    ));
    $req->closecursor();



    //On remplit par la même occasion la table rapport. Cette table ne recevant qu'une seule entree par jour par utilisateur, on la vide avant inscription de données

    $req=$bdd->prepare('delete from rapport where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
    $req->execute(array(
      'id'=>$_SESSION['id']));
    $req->closecursor();


	$req = $bdd->prepare('insert into rapport (date, solde_ouverture,  retrait_moneygram, retrait_western, retrait_ria, envoi_moneygram, envoi_western, envoi_ria, id_utilisateur) values (now(),:solde_ouverture,:retrait_moneygram, :retrait_western, :retrait_ria, :envoi_moneygram, :envoi_western, :envoi_ria, :id_utilisateur)');
	$req->execute(array(
		'solde_ouverture'=>$_SESSION['solde_ouverture'],
		'retrait_moneygram'=>$total_moneygram_retrait, 
		'retrait_western'=>$total_western_retrait, 
		'retrait_ria'=>$total_ria_retrait, 
		'envoi_moneygram'=>$total_moneygram_envoi, 
		'envoi_western'=>$total_western_envoi, 
		'envoi_ria'=>$total_ria_envoi, 
		'id_utilisateur'=>$_SESSION['id']
	));

	$req->closecursor();
  	}
	else
	{
		echo 'solde non OK!';
		?><br/><a href="accueil_money_transfert.php">Back <=======</a><br/><?php

	?>
	</section><?php

	include('footer.php');

	}}
else
{
		include('doctype.php');
		include('header.php');
		?>
		<body >
			<?php
		echo 'Solde cloture absent!';?>
		<br/><a href="accueil_money_transfert.php">Back <=======</a><br/><?php
		include('footer.php');
}
?>
