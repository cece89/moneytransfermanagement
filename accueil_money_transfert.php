<?php 
  session_start();
  
  if(isset($_SESSION['login']) and isset($_SESSION['mt']))
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

?>
<body>

<section class="entete">
<h1>MONEY TRANSFERT </h1>
</section>


<section class="ouverture_mt">
<h2>INFORMATION OUVERTURE</h2>

<form method="post" action="accueil_money_transfert.php">
  <fieldset>
       <legend>SOLDE COMPTE BANQUE:</legend> 
       <input type="text" name="solde_ouverture" id="solde_ouverture" />
  </fieldset>

  <fieldset>
       <legend>BILLETAGE:</legend> <!-- Titre du fieldset --> 

       <label for="10000">10 000F</label>
       <input type="text" name="10000" id="10000" />

       <label for="5000">5 000F</label>
       <input type="text" name="5000" id="5000" />
 
       <label for="2000">2 000F</label>
       <input type="text" name="2000" id="2000" />

       <label for="1000">1 000F</label>
       <input type="text" name="1000" id="1000" />

       <label for="500">500F</label>
       <input type="text" name="500" id="500" />
 
       <label for="200">200F</label>
       <input type="text" name="200" id="200" />

       <label for="100">100F</label>
       <input type="text" name="100" id="100" />

       <label for="50">50F</label>
       <input type="text" name="50" id="50" />

       <label for="25">25F</label>
       <input type="text" name="25" id="25" />
   </fieldset>
   <input type="submit" name="valider" id="valider" />
</form>
</section>

<section class="resultat_ouverture_mt">

<?php
  if (isset($_POST['solde_ouverture']))
    {
    $especes=(int)($_POST['10000'])*10000+(int)($_POST['5000'])*5000+ (int)($_POST['2000'])*2000+ (int)($_POST['1000'])*1000+ (int)($_POST['500'])*500+ (int)($_POST['200'])*200+ (int)($_POST['100'])*100+ (int)($_POST['50'])*50+ (int)($_POST['25'])*25;

    $_SESSION['solde_ouverture']=$_POST['solde_ouverture'];
    $_SESSION['espece_ouverture']=$especes;


    $req=$bdd->prepare('delete from ouverture where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
   	$req->execute(array(
   		'id'=>$_SESSION['id']));
   	$req->closecursor();

   	$req=$bdd->prepare('insert into ouverture(date,solde_ouverture,espece_ouverture,id_utilisateur) values (now(),:solde_ouverture,:espece_ouverture,:id)');
   	$req->execute(array(
   		'id'=>$_SESSION['id'],
   		'solde_ouverture'=>$_SESSION['solde_ouverture'],
   		'espece_ouverture'=>$_SESSION['espece_ouverture']
   	));
   	$req->closecursor();
}
else
{
	$response=$bdd->prepare('select * from ouverture where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
   	$response->execute(array(
   		'id'=>$_SESSION['id']));
   	$donnees=$response->fetch();

   	$_SESSION['solde_ouverture']=$donnees['solde_ouverture'];
   	$response->closecursor();
}


   	$response = $bdd->prepare('select * from ouverture where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
   	$response->execute(array(
   		'id'=>$_SESSION['id']
   		));
   	$donnees=$response->fetch();
   	$response->closecursor();

    echo 'Especes= '.$donnees['espece_ouverture'];?><br/><?php
    echo 'Solde Ouverture= '.$donnees['solde_ouverture'];
    
   ?>
</section>

<section class="operation_client">
<form method="post" action="accueil_money_transfert.php">
       <legend>OPERATION CLIENT:</legend> <!-- Titre du fieldset --> 
       <label for="nom_client">NOM CLIENT</label>
       <input type="text" name="nom_client" id="nom_client" />

       <label for="prenom_client">PRENOM CLIENT</label>
       <input type="text" name="prenom_client" id="prenom_client" />

       <label for="telephone">TELEPHONE CLIENT</label>
       <input type="text" name="telephone" id="telephone" />
 
       <p>SERVICE:

       <select name="service">
       <option value="western">WESTERN UNION</option>
       <option value="money_gram">MONEY GRAM</option>
       <option value="ria">RIA</option>
       </select></p>

       <p>OPERATION:

       <select name="operation">
       <option value="retrait">RETRAIT</option>
       <option value="depot">DEPOT</option>      
       </select></p>

       <label for="montant">MONTANT</label>
       <input type="text" name="montant" id="montant" /><br/>

       <input type="submit" name="enregistrer" id="enregistrer" />

</form>
  
  </section>


  <section class="resultat_operation">
<?php 

  if(isset($_POST['nom_client']) and isset($_POST['prenom_client']) and isset($_POST['telephone']) and isset($_POST['service']) and isset($_POST['operation']) and isset($_POST['montant']))
  {
       $req=$bdd->prepare('insert into operation (date, type_operation, montant, id_utilisateur, service, nom_client, prenom_client, tel_client) values(now(),:type,:montant,:id,:service,:nom,:prenom,:tel)');
       $req->execute(array(
          'nom'=>$_POST['nom_client'],
          'prenom'=>$_POST['prenom_client'],
          'tel'=>$_POST['telephone'],
          'type'=>$_POST['operation'],
          'montant'=>$_POST['montant'],
          'id'=>$_SESSION['id'],
          'service'=>$_POST['service']              
       ));
       $req->closecursor();
       }

       $response=$bdd->prepare('select * from operation where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now())) order by id_operation desc limit 3');
       $response->execute(array(
          'id'=>$_SESSION['id']            
       ));

       while($donnees=$response->fetch())
       {
        echo ''.$donnees['id_operation'].':'.$donnees['date'].':'.$donnees['nom_client'].':'.$donnees['prenom_client'].':'.$donnees['tel_client'].':'.$donnees['service'].':'.$donnees['type_operation'].':'.$donnees['montant'];
        ?> <br/> <?php
       }
       $response->closecursor();
?>
</section>


<section class="impayes_mt">
<form method="post" action="accueil_money_transfert.php">
 <fieldset>
       <legend>IMPAYES:</legend>
       <label for="montant_credit">MONTANT DU CREDIT</label>
       <input type="text" name="montant_credit" id="montant_credit" />
 
       <label for="commentaire">COMMENTAIRE</label>
       <input type="text" name="commentaire" id="commentaire" />

       <input type="submit" name="valider" id="valider" />
  </fieldset>
</form>

</section>

<section class="resultat_impayes_mt">
  
<?php 

  if(isset($_POST['montant_credit']) and isset($_POST['commentaire']))
  {
       $req=$bdd->prepare('insert into credit (date, montant, commentaire, id_utilisateur) values(now(),:montant,:commentaire,:id)');
       $req->execute(array(
          'montant'=>(int)$_POST['montant_credit'],
          'commentaire'=>$_POST['commentaire'],
          'id'=>$_SESSION['id']       
       ));
       $req->closecursor();
}
       $response=$bdd->prepare('select * from credit where(id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now())) order by id_credit desc limit 3');
       $response->execute(array(
          'id'=>$_SESSION['id']       
       ));

       while($donnees=$response->fetch())
       {
        echo 'date: '. $donnees['date'];
        echo ',montant: '. $donnees['montant'];
        echo ',commentaire: '. $donnees['commentaire'];?><br/><?php
       }
       $response->closecursor();
   
?>

  </section>

  <section class="cloture_mt">

<h2>INFORMATION CLOTURE</h2>



<form method="post" action="cloture_mt.php">
  <fieldset>
       <legend>SOLDE COMPTE BANQUE:</legend> 
       <input type="text" name="solde_cloture" id="solde_cloture" />
   </fieldset>

   <fieldset>
       <legend>BILLETAGE:</legend> 

       <label for="10000">10 000F</label>
       <input type="text" name="10000" id="10000" />

       <label for="5000">5 000F</label>
       <input type="text" name="5000" id="5000" />
 
       <label for="2000">2 000F</label>
       <input type="text" name="2000" id="2000" />

       <label for="1000">1 000F</label>
       <input type="text" name="1000" id="1000" />

       <label for="500">500F</label>
       <input type="text" name="500" id="500" />
 
       <label for="200">200F</label>
       <input type="text" name="200" id="200" />

       <label for="100">100F</label>
       <input type="text" name="100" id="100" />

       <label for="50">50F</label>
       <input type="text" name="50" id="50" />

       <label for="25">25F</label>
       <input type="text" name="25" id="25" />

   </fieldset>
   <input type="submit" name="valider" id="valider" />
  </form>
</section>


<?php

  include('footer.php');
}
        

elseif (isset($_POST['login']) and isset($_POST['password']))
{

  $authentication=FALSE;
  try
    {
        $bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
    }
  catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

        
    $response=$bdd->prepare('select * from utilisateur where fonction=:fonction');
    $response->execute(array(
    	'fonction'=>'ag_mon_trans'));
       
        while ($donnees = $response->fetch())
        {
          if (($donnees['login']==$_POST['login']) and ($donnees['password']==$_POST['password']))
          {
            $authentication=TRUE;
            $_SESSION['login']=$_POST['login'];
            $_SESSION['id']=$donnees['id_utilisateur'];
            $_SESSION['mt']=True;
            $_SESSION['id_societe']=$donnees['id_societe'];
            $_SESSION['fonction']=$donnees['fonction'];
            break;
          }

        }
    $response->closecursor();
  
    if ($authentication)
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

?>
<body>
<section class="entete">
<h1>MONEY TRANSFERT </h1>
</section>

<section class="ouverture_mt">
<h2> INFORMATION OUVERTURE </h2>


<form method="post" action="accueil_money_transfert.php">
  <fieldset>
       <legend>SOLDE COMPTE BANQUE:</legend> 
       <input type="text" name="solde_ouverture" id="solde_ouverture" />
  </fieldset>

  <fieldset>
       <legend>BILLETAGE:</legend> <!-- Titre du fieldset --> 

       <label for="10000">10 000F</label>
       <input type="text" name="10000" id="10000" />

       <label for="5000">5 000F</label>
       <input type="text" name="5000" id="5000" />
 
       <label for="2000">2 000F</label>
       <input type="text" name="2000" id="2000" />

       <label for="1000">1 000F</label>
       <input type="text" name="1000" id="1000" />

       <label for="500">500F</label>
       <input type="text" name="500" id="500" />
 
       <label for="200">200F</label>
       <input type="text" name="200" id="200" />

       <label for="100">100F</label>
       <input type="text" name="100" id="100" />

       <label for="50">50F</label>
       <input type="text" name="50" id="50" />

       <label for="25">25F</label>
       <input type="text" name="25" id="25" />
   </fieldset>
   <input type="submit" name="valider" id="valider" />

<a href="refresh.php?code=mt">Refresh</a><br/>
</form>

</section>

<section class="resultat_ouverture_mt">

<?php
  if (isset($_POST['solde_ouverture']))
    {
    $especes=(int)($_POST['10000'])*10000+(int)($_POST['5000'])*5000+ (int)($_POST['2000'])*2000+ (int)($_POST['1000'])*1000+ (int)($_POST['500'])*500+ (int)($_POST['200'])*200+ (int)($_POST['100'])*100+ (int)($_POST['50'])*50+ (int)($_POST['25'])*25;

    $_SESSION['solde_ouverture']=$_POST['solde_ouverture'];
    $_SESSION['espece_ouverture']=$especes;

    $req=$bdd->prepare('delete from ouverture where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
   	$req->execute(array(
   		'id'=>$_SESSION['id']));
   	$req->closecursor();

   	$req=$bdd->prepare('insert into ouverture(date,solde_ouverture,espece_ouverture,id_utilisateur) values (now(),:solde_ouverture,:espece_ouverture,:id)');
   	$req->execute(array(
   		'id'=>$_SESSION['id'],
   		'solde_ouverture'=>$_SESSION['solde_ouverture'],
   		'espece_ouverture'=>$_SESSION['espece_ouverture']
   	));
   	$req->closecursor();

}

else
{
	$response=$bdd->prepare('select * from ouverture where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
   	$response->execute(array(
   		'id'=>$_SESSION['id']));
   	$donnees=$response->fetch();

   	$_SESSION['solde_ouverture']=$donnees['solde_ouverture'];
   	$response->closecursor();
}


   	$response = $bdd->prepare('select * from ouverture where id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
   	$response->execute(array(
   		'id'=>$_SESSION['id']
   		));
   	$donnees=$response->fetch();
   	$response->closecursor();

    echo 'Especes= '.$donnees['espece_ouverture'];?><br/><?php
    echo 'Solde Ouverture= '.$donnees['solde_ouverture'];

?>

</section>

<section class="operation_client">

<form method="post" action="accueil_money_transfert.php">
       <legend>OPERATION CLIENT:</legend> <!-- Titre du fieldset --> 
       <label for="nom_client">NOM CLIENT</label>
       <input type="text" name="nom_client" id="nom_client" />

       <label for="prenom_client">PRENOM CLIENT</label>
       <input type="text" name="prenom_client" id="prenom_client" />

       <label for="telephone">TELEPHONE CLIENT</label>
       <input type="text" name="telephone" id="telehone" />
 
       <p>SERVICE:

       <select name="service">
       <option value="western">WESTERN UNION</option>
       <option value="money_gram">MONEY GRAM</option>
       <option value="ria">RIA</option>
       </select></p>

       <p>OPERATION:

       <select name="operation">
       <option value="retrait">RETRAIT</option>
       <option value="depot">DEPOT</option>      
       </select></p>

       <label for="montant">MONTANT</label>
       <input type="text" name="montant" id="montant" /><br/>

       <input type="submit" name="enregistrer" id="enregistrer" />

</form>
  
  </section>

  <section class="resultat_operation">
<?php 

  if(isset($_POST['nom_client']) and isset($_POST['prenom_client']) and isset($_POST['telephone']) and isset($_POST['service']) and isset($_POST['operation']) and isset($_POST['montant']))
  {
       $req=$bdd->prepare('insert into operation (date, type_operation, montant, id_utilisateur, service, nom_client, prenom_client, tel_client) values(now(),:type,:montant,:id,:service,:nom,:prenom,:tel)');
       $req->execute(array(
          'nom'=>$_POST['nom_client'],
          'prenom'=>$_POST['prenom_client'],
          'tel'=>$_POST['telephone'],
          'type'=>$_POST['operation'],
          'montant'=>$_POST['montant'],
          'id'=>$_SESSION['id'],
          'service'=>$_POST['service']              
       ));
       $req->closecursor();
	}

       $response=$bdd->prepare('select * from operation where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now())) order by id_operation desc limit 3');
       $response->execute(array(
          'id'=>$_SESSION['id']            
       ));

       while($donnees=$response->fetch())
       {
        echo ''.$donnees['id_operation'].':'.$donnees['date'].':'.$donnees['nom_client'].':'.$donnees['prenom_client'].':'.$donnees['tel_client'].':'.$donnees['service'].':'.$donnees['type_operation'].':'.$donnees['montant'];?><br/><?php
       }

       $response->closecursor();
?>


  </section>

  <section class="impayes_mt">

<form method="post" action="accueil_money_transfert.php">
 <fieldset>
       <legend>IMPAYES:</legend> <!-- Titre du fieldset --> 
       <label for="montant_credit">MONTANT DU CREDIT</label>
       <input type="text" name="montant_credit" id="montant_credit" />
 
       <label for="commentaire">COMMENTAIRE</label>
       <input type="textarea" name="commentaire" id="commentaire" />

       <input type="submit" name="valider" id="valider" />
  </fieldset>
</form>
</section>

<section class="resultat_impayes_mt">
<?php 

  if(isset($_POST['montant_credit']) and isset($_POST['commentaire']))
  {
       $req=$bdd->prepare('insert into credit (date, montant, commentaire, id_utilisateur) values(now(),:montant,:commentaire,:id)');
       $req->execute(array(
          'montant'=>(int)$_POST['montant_credit'],
          'commentaire'=>$_POST['commentaire'],
          'id'=>$_SESSION['id']       
       ));
       $req->closecursor();
   }

       $req=$bdd->prepare('select date, montant, commentaire from credit where(id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now())) order by id_credit desc limit 3');
       $req->execute(array(
          'id'=>$_SESSION['id']       
       ));

       while($donnees=$req->fetch())
       {
        echo 'date: '. $donnees['date'];
        echo ',montant: '. $donnees['montant'];
        echo ',commentaire: '. $donnees['commentaire'];
       }
       $req->closecursor();

?>
</section>

<section class="cloture_mt">
  

<h3>INFORMATION CLOTURE</h3>

<form method="post" action="cloture_mt.php">
 
   <fieldset>
       <legend>SOLDE COMPTE BANQUE</legend> <!-- Titre du fieldset --> 
       <input type="text" name="solde_cloture" id="solde_cloture" />

   </fieldset>

   <fieldset>
       <legend>BILLETAGE:</legend> 

       <label for="10000">10 000F</label>
       <input type="text" name="10000" id="10000" />

       <label for="5000">5 000F</label>
       <input type="text" name="5000" id="5000" />
 
       <label for="2000">2 000F</label>
       <input type="text" name="2000" id="2000" />

       <label for="1000">1 000F</label>
       <input type="text" name="1000" id="1000" />

       <label for="500">500F</label>
       <input type="text" name="500" id="500" />
 
       <label for="200">200F</label>
       <input type="text" name="200" id="200" />

       <label for="100">100F</label>
       <input type="text" name="100" id="100" />

       <label for="50">50F</label>
       <input type="text" name="50" id="50" />

       <label for="25">25F</label>
       <input type="text" name="25" id="25" />

   </fieldset>
   <input type="submit" name="valider" id="valider" />
  </form>
</section>

<?php

  include('footer.php');
}    


else
        
   {
          include('doctype.php');
          include('header.php');?>

          <body>
            <section class="entete">
              <h1>MONEY TRANSFERT</h1>
              </section>
              <?php

          echo 'Authentication failed!';
          ?>
          <br/> <br/>
          <a title="Produits" href="authentication.php?service=money_transfert" class="center-div"> <====== Back</a>
          <?php
          include('footer.php');
    }
}

else
{
   include('doctype.php');
   include('header.php');?>
   <body>
            <section class="entete">
              <h1>MONEY TRANSFERT</h1>
              </section>
              <?php

  echo 'Veuillez saisir un nom d\'utilisateur et un mot de pass svp';
          ?>
          <br/> <br/>
          <a title="Produits" href="authentication.php?service=money_transfert" class="center-div"> <====== Back</a>
          <?php

          include('footer.php');
}
?>