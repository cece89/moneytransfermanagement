<?php 
  session_start();
  
  //Si l'utilisateur est authentifié pour le service mobile money, on affiche le corps de la page mobile money
  if(isset($_SESSION['login']) and isset($_SESSION['mm']))
  {
  	include('doctype.php');
	  include('header.php');  
    ?>

<body>
    <!-- Insertion du formulaire d'ouverture dans la section prevue à cet effet. on inserera les resultats dans la section d'en face -->
    <section class="entete">
      <h1>MOBILE MONEY</h1>
    </section>


    <section class="ouverture_mm">
    <h2>INFORMATIONS OUVERTURE</h2>

    <h3>SOLDE DES COMPTES MOBILE MONEY</h3>

    <form method="post" action="accueil_mobile_money.php">
       
       <label for="orange">ORANGE</label>
       <input type="text" name="orange" id="orange" />

       <label for="MTN">MTN</label>
       <input type="text" name="mtn" id="mtn" />
 
       <label for="moov">MOOV</label>
       <input type="text" name="moov" id="moov" />

    <h3>BILLETTAGE</h3>

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

       <input type="submit" name="valider" id="valider" />
      </form>
    </section>

<section class="resultat_ouverture">

  <?php
// Connexion à la base de données
  try
    {
        $bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }


// On verifie que tous les champs pour les soldes mobile money ne sont pas vide. Sinon, on demande à l'utilisateur de les renseigner.
  if (isset($_POST['orange']) and isset($_POST['mtn']) and isset($_POST['moov']))
    {
    
    //On fait le total des especes qu'on stocke dans une variable globale
    $_SESSION['espece_ouverture']=(int)($_POST['10000'])*10000+(int)($_POST['5000'])*5000+ (int)($_POST['2000'])*2000+ (int)($_POST['1000'])*1000+ (int)($_POST['500'])*500+ (int)($_POST['200'])*200+ (int)($_POST['100'])*100+ (int)($_POST['50'])*50+ (int)($_POST['25'])*25;


    //On stocke egalement le solde des comptes mobile money à l'ouverture

    $_SESSION['solde_ouverture_mm']=(int)($_POST['orange'])+(int)($_POST['mtn'])+ (int)($_POST['moov']);

    $_SESSION['solde_orange']=$_POST['orange'];
    $_SESSION['solde_moov']=$_POST['moov'];
    $_SESSION['solde_mtn']=$_POST['mtn'];

    // Avant d'enregistrer une entrée dans la table ouverture, on supprime la donnée correspondante à la date du jour pour eviter les doublons. La ne recevant une entree par jour par utilisateur
    $req=$bdd->prepare('delete from ouverture_mm where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
    $req->execute(array(
      'id'=>$_SESSION['id']));
    $req->closecursor();

    $req=$bdd->prepare('insert into ouverture_mm(date,solde_orange, solde_mtn, solde_moov, espece_ouverture,id_utilisateur) values (now(),:solde_orange,:solde_mtn,:solde_moov,:espece_ouverture,:id)');
    $req->execute(array(
      'id'=>$_SESSION['id'],
      'solde_orange'=>$_SESSION['solde_orange'],
      'solde_mtn'=>$_SESSION['solde_mtn'],
      'solde_moov'=>$_SESSION['solde_moov'],
      'espece_ouverture'=>$_SESSION['espece_ouverture']
    ));
    $req->closecursor();
  }

  // On verifie tout de même dans dans la base de donnée pour savoir si une entree correspondant à la date du jour est renseignée. Si oui on l'affiche.Ceci permettra d'afficher cette information de maniere permanente, les variables globales existant à coup sûr, sur la page de l'utilisateur authentifié.

  else
 {
  $response=$bdd->prepare('select * from ouverture_mm where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
    $response->execute(array(
      'id'=>$_SESSION['id']));
    $donnees=$response->fetch();

    $_SESSION['solde_orange']=$donnees['solde_orange'];
    $_SESSION['solde_mtn']=$donnees['solde_mtn'];
    $_SESSION['solde_moov']=$donnees['solde_moov'];
    $_SESSION['solde_ouverture']=$_SESSION['solde_orange']+$_SESSION['solde_mtn']+$_SESSION['solde_moov'];
    $_SESSION['espece_ouverture']=$donnees['espece_ouverture'];

    $response->closecursor();
  }


  $response = $bdd->prepare('select * from ouverture_mm where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
    $response->execute(array(
      'id'=>$_SESSION['id']
      ));
    $donnees=$response->fetch();
    $response->closecursor();

    echo 'Especes= '.$donnees['espece_ouverture'];?><br/><?php
    echo 'Solde Orange= '.$donnees['solde_orange'];?><br/><?php
    echo 'Solde MTN= '.$donnees['solde_mtn'];?><br/><?php
    echo 'Solde Moov= '.$donnees['solde_moov'];?><br/><?php
    
    ?>
</section>


<section class="impayes_mm">

<h2>IMPAYES:</h2>
<form method="post" action="accueil_mobile_money.php">
       <label for="montant_credit">MONTANT DU CREDIT</label>
       <input type="text" name="montant_credit" id="montant_credit" />
 
       <label for="commentaire">COMMENTAIRE</label>
       <input type="text" name="commentaire" id="commentaire" />

       <input type="submit" name="valider" id="valider" /> <br/>
</form>
</section> 

<section class="resultat_impayes"> 
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

       $req=$bdd->prepare('select date, montant, commentaire from credit where(year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()) and id_utilisateur=:id) order by id_credit desc limit 3');
       $req->execute(array(
          'id'=>$_SESSION['id']       
       ));

       while($donnees=$req->fetch())
       {
        echo 'date: '. $donnees['date'];
        echo ',montant: '. $donnees['montant'];
        echo ',commentaire: '. $donnees['commentaire'];?><br/><?php
       }
       $req->closecursor();
?>
</section >

<section class="cloture_mm">

<h2>INFORMATIONS CLOTURE</h2>
<h3>SOLDE DES COMPTES MOBILE MONEY </h3> 

<form method="post" action="cloture_mm.php">

       <label for="orange">ORANGE</label>
       <input type="text" name="orange" id="orange" />

       <label for="MTN">MTN</label>
       <input type="text" name="mtn" id="mtn" />
 
       <label for="moov">MOOV</label>
       <input type="text" name="moov" id="moov" />

       <h3>BILLETAGE:</h3> 

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
   <input type="submit" name="valider" id="valider" />
  </form>
</section >

<?php
    include('footer.php');
  }
    
  //S'il n'est pas encore authentifié, on verifie que les champs login et password ont été renseignés. si oui on vérifie dans la base de donnee que les informations renseignés existe. Si oui, on affiche le corps de la page mobile money     

  elseif (isset($_POST['login']) and isset($_POST['password']))
  {

    $authentication=FALSE;

    //Connection à la base de données
    try
    {
        $bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

    //On reccupere tous les logins de la base.     
    $response=$bdd->prepare('select * from utilisateur where fonction=:fonction');
    $response->execute(array(
      'fonction'=>'ag_mob_mon'));
       
       //On compare chaque entrees des données obtenues aux informations fournies par l'utilisateur. Si on trouve une correspondance, on definit les paramètres de session et on sort de la boucle.
    while ($donnees = $response->fetch())
    {
      if (($donnees['login']==$_POST['login']) and ($donnees['password']==$_POST['password']))
          {
            $authentication=TRUE;
            $_SESSION['login']=$_POST['login'];
            $_SESSION['mm']=True;
            $_SESSION['id']=$donnees['id_utilisateur'];
            $_SESSION['id_societe']=$donnees['id_societe'];
            $_SESSION['fonction']=$donnees['fonction'];
            break;
          }
    }
    $response->closecursor();


    // Si l'utilisateur a été authentifié, on affiche le corps de la page mobile money
    if ($authentication)
    {

    include('doctype.php');
    include('header.php'); 
    ?>

    <body>
    <!-- Insertion du formulaire d'ouverture dans la section prevue à cet effet. on inserera les resultats dans la section d'en face -->
    <section class="entete">
      <h1>MOBILE MONEY</h1>
    </section>

    <section class="ouverture_mm">
    <h2>INFORMATIONS OUVERTURE</h2>

    <h3>SOLDE DES COMPTES MOBILE MONEY</h3>

    <form method="post" action="accueil_mobile_money.php">
       
       <label for="orange">ORANGE</label>
       <input type="text" name="orange" id="orange" />

       <label for="MTN">MTN</label>
       <input type="text" name="mtn" id="mtn" />
 
       <label for="moov">MOOV</label>
       <input type="text" name="moov" id="moov" />

    <h3>BILLETTAGE</h3>

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

       <input type="submit" name="valider" id="valider" />
      </form>
    </section>

    <section class="resultat_ouverture">

  <?php
// Connexion à la base de données
  try
    {
        $bdd= new PDO('mysql:host=localhost;dbname=mon_trans_man;charset=utf8','root','');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }


// On verifie que tous les champs pour les soldes mobile money ne sont pas vide. Sinon, on demande à l'utilisateur de les renseigner.
  if (isset($_POST['orange']) and isset($_POST['mtn']) and isset($_POST['moov']))
    {
    
    //On fait le total des especes qu'on stocke dans une variable globale
    $_SESSION['espece_ouverture']=(int)($_POST['10000'])*10000+(int)($_POST['5000'])*5000+ (int)($_POST['2000'])*2000+ (int)($_POST['1000'])*1000+ (int)($_POST['500'])*500+ (int)($_POST['200'])*200+ (int)($_POST['100'])*100+ (int)($_POST['50'])*50+ (int)($_POST['25'])*25;


    //On stocke egalement le solde des comptes mobile money à l'ouverture

    $_SESSION['solde_ouverture_mm']=(int)($_POST['orange'])+(int)($_POST['mtn'])+ (int)($_POST['moov']);

    $_SESSION['solde_orange']=$_POST['orange'];
    $_SESSION['solde_moov']=$_POST['moov'];
    $_SESSION['solde_mtn']=$_POST['mtn'];

    // Avant d'enregistrer une entrée dans la table ouverture, on supprime la donnée correspondante à la date du jour pour eviter les doublons. La ne recevant une entree par jour par utilisateur
    $req=$bdd->prepare('delete from ouverture_mm where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
    $req->execute(array(
      'id'=>$_SESSION['id']));
    $req->closecursor();

    $req=$bdd->prepare('insert into ouverture_mm(date,solde_orange, solde_mtn, solde_moov, espece_ouverture,id_utilisateur) values (now(),:solde_orange,:solde_mtn,:solde_moov,:espece_ouverture,:id)');
    $req->execute(array(
      'id'=>$_SESSION['id'],
      'solde_orange'=>$_SESSION['solde_orange'],
      'solde_mtn'=>$_SESSION['solde_mtn'],
      'solde_moov'=>$_SESSION['solde_moov'],
      'espece_ouverture'=>$_SESSION['espece_ouverture']
    ));
    $req->closecursor();
  }

  // On verifie tout de même dans dans la base de donnée pour savoir si une entree correspondant à la date du jour est renseignée. Si oui on l'affiche.Ceci permettra d'afficher cette information de maniere permanente, les variables globales existant à coup sûr, sur la page de l'utilisateur authentifié.

  else
  
  {
  $response=$bdd->prepare('select * from ouverture_mm where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
    $response->execute(array(
      'id'=>$_SESSION['id']));
    $donnees=$response->fetch();

    $_SESSION['solde_orange']=$donnees['solde_orange'];
    $_SESSION['solde_mtn']=$donnees['solde_mtn'];
    $_SESSION['solde_moov']=$donnees['solde_moov'];
    $_SESSION['solde_ouverture']=$_SESSION['solde_orange']+$_SESSION['solde_mtn']+$_SESSION['solde_moov'];
    $_SESSION['espece_ouverture']=$donnees['espece_ouverture'];

    $response->closecursor();
  }


  $response = $bdd->prepare('select * from ouverture_mm where (id_utilisateur=:id and year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()))');
    $response->execute(array(
      'id'=>$_SESSION['id']
      ));
    $donnees=$response->fetch();
    $response->closecursor();

    echo 'Especes= '.$donnees['espece_ouverture'];?><br/><?php
    echo 'Solde Orange= '.$donnees['solde_orange'];?><br/><?php
    echo 'Solde MTN= '.$donnees['solde_mtn'];?><br/><?php
    echo 'Solde Moov= '.$donnees['solde_moov'];?><br/><?php  
    ?>
  </section>

<section class="impayes_mm">
<h2>IMPAYES:</h2>
<form method="post" action="accueil_mobile_money.php">
       <label for="montant_credit">MONTANT DU CREDIT</label>
       <input type="text" name="montant_credit" id="montant_credit" />
 
       <label for="commentaire">COMMENTAIRE</label>
       <input type="text" name="commentaire" id="commentaire" />

       <input type="submit" name="valider" id="valider" /> <br/>
</form>
</section>

<section class="resultat_impayes">
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

       $req=$bdd->prepare('select date, montant, commentaire from credit where(year(date)=year(now()) and month(date)=month(now()) and day(date)=day(now()) and id_utilisateur=:id) order by id_credit desc limit 3');
       $req->execute(array(
          'id'=>$_SESSION['id']       
       ));

       while($donnees=$req->fetch())
       {
        echo 'date: '. $donnees['date'];
        echo ',montant: '. $donnees['montant'];
        echo ',commentaire: '. $donnees['commentaire'];?><br/><?php
       }
       $req->closecursor();
?>

</section>

<section class="cloture_mm">

<h2>INFORMATIONS CLOTURE</h2>
<h3>SOLDE DES COMPTES MOBILE MONEY</h3>

<form method="post" action="cloture_mm.php">
       <label for="orange">ORANGE</label>
       <input type="text" name="orange" id="orange" />

       <label for="MTN">MTN</label>
       <input type="text" name="mtn" id="mtn" />
 
       <label for="moov">MOOV</label>
       <input type="text" name="moov" id="moov" />

       <p>Billetage:</p> 

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
   <input type="submit" name="valider" id="valider" />
  </form>

</section>
<?php

    include('footer.php');
	  }
    // Sinon on affiche un message d'erreur
    else
    {
          include('doctype.php');
          include('header.php');?>
          <body>

          <section class="entete">
            <h1>MOBILE MONEY</h1>
          </section>

          <?php
          echo 'Authentication failed!';
          ?>
          <br/>
          <a title="Produits" href="authentication.php?service=mobile_money"> <====== Back</a>
          <?php
          include('footer.php');
    }

  }

// Si l'utilisateur n'a pas entré le login ou le mot de passe, on l'invite à la faire
else
{
   include('doctype.php');
   include('header.php');?>

   <body>

          <section class="entete">
            <h1>MOBILE MONEY</h1>
          </section>
    <?php

   echo 'Veuillez saisir un nom d\'utilisateur et un mot de pass svp';
          ?>
          <br/> 
          <a title="Produits" href="authentication.php?service=mobile_money"> <====== Back</a>
          <?php

    include('footer.php');
}
?>