
<?php
// la page de cloture pour le service mobile money

session_start();


if (isset($_POST['orange']) and isset($_POST['mtn']) and isset($_POST['moov']))
{

include('doctype.php');
include('header.php');

?>

<body>
<section class="entete">
	<h1>MOBILE MONEY</h1>
</section>


<section class="resultat_cloture">
	<h2>RESULTAT CLOTURE</h2>
<?php
try
{
   $bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}

//On calcule le nombre d'especes dont dispose la gerante en fin de journée.

$espece_cloture=(int)($_POST['10000']*10000)+(int)($_POST['5000']*5000)+ (int)($_POST['2000']*2000)+ (int)($_POST['1000']*1000)+ (int)($_POST['500']*500)+ (int)($_POST['200']*200)+ (int)($_POST['100']*100)+ (int)($_POST['50']*50)+ (int)($_POST['25']*25);

//On calcule egalement le total des credits disponibles dans les puces

$solde_mm=(int)($_POST['orange'])+(int)($_POST['mtn'])+ (int)($_POST['moov']);

//On calcule le montant des opérations non soldées de la journée
$credit=0;
	$response=$bdd->prepare('select * from credit where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()))');
	$response->execute(array(
		'id'=>$_SESSION['id']
	));
	while($donnees=$response->fetch())
	{
		$credit+=$donnees['montant'];
	}
	$response->closecursor();


//On verifie que le compte est bon avant d'écrire le resultat dans la base de donnée (le total des especes à la fermeture devant être egale au solde à l'ouverture additionné des especes à l'ouverture et soustrait du solde à la cloture. On soustrait egalement les impayés s'il y en a )

	$espece_escompte=abs($_SESSION['espece_ouverture']+$_SESSION['solde_ouverture']-$credit-$solde_mm);

	if ($espece_escompte == $espece_cloture)
	{  
		// Avant d'enregistrer une entrée dans la table cloture_mm, on supprime la donnée correspondante à la date du jour pour eviter les doublons. La table ne recevant q'une entree par jour par utilisateur
    	$req=$bdd->prepare('delete from cloture_mm where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
    		$req->execute(array(
      		'id'=>$_SESSION['id']));
    		$req->closecursor();


    		$req=$bdd->prepare('insert into cloture_mm (date,solde_orange,solde_mtn,solde_moov,espece_cloture,id_utilisateur) values (now(),:solde_orange,:solde_mtn,:solde_moov,:espece_cloture,:id_utilisateur)');
    		$req->execute(array(
    			'solde_orange'=>$_POST['orange'],
    			'solde_mtn'=>$_POST['mtn'],
    			'solde_moov'=>$_POST['moov'],
    			'espece_cloture'=>$espece_cloture,
    			'id_utilisateur'=>$_SESSION['id']
    		));

    		echo'solde OK';?><br/><?php

	}
	else
	{
			echo 'solde pas OK';
		?><br/><a href="accueil_mobile_money.php">Back <=======</a><br/><?php

	}


// Que le solde soit valide ou pas, on affiche les informations sur les operations de la journée. Le point le plus important ici étant l'écart entre les espèces escomptés et les espèces saisis par l'agent.

	echo 'POINT DE LA JOURNEE DU '.date('Y-m-d H:i:s');?> <br/><?php

	echo 'Espece ouverture: '.$_SESSION['espece_ouverture'];?> <br/><?php
	echo 'Total solde ouverture: '.$_SESSION['solde_ouverture'];?> <br/><?php
	echo 'Total impayés: '.$credit;?> <br/><?php

	echo 'Total solde cloture: '.$solde_mm;?> <br/><?php
	echo 'ESPECES LIVRES: '.$espece_cloture;?> <br/><?php
	echo 'ESPECE ESCOMPTE:'.$espece_escompte;?> <br/>

</section>

	<?php
	include('footer.php');

}


// Si toutes les informations de cloture ne sont pas renseignées, on invite l'agent à le faire
else
{
	include('doctype.php');
	include('header.php');
	?>

<body>
<section class="entete">
	<h1>MOBILE MONEY</h1>
</section>


<section class="resultat_cloture">
	<h2>RESULTAT CLOTURE</h2>

<?php
	echo 'Veillez remplir tous les champs svp!';
	?><a href="accueil_mobile_money.php">Back <=======</a><?php
	include('footer.php');
	
}
?>
