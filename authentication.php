<!-- Cette page gere l'authentification pour acceder aux pages des sous menus de Services hormis new company, Reports et Users management  -->

<!-- Pour les utilisateurs deja authentifies il faut verifier qu'ils sont soit administrateurs, utilisateur de mobile money ou utilisateur de money transfert -->

<?php 
session_start();

// Pour acceder au service mobile money, ce devra etre un simple utilisateur mobile money déja authentifié. Dans le cas contraire on affiche le formulaire pour authentification

if ($_GET['service'] == 'mobile_money')
{

  if (isset($_SESSION['mm']))
  {
    header('location:accueil_mobile_money.php');
  }

  else
  {

  include('doctype.php');
  include("header.php");
  ?>

  <body>
        <section class="entete">
          <h1>AUTHENTIFICATION MOBILE MONEY</h1>
        </section>

        <section class="form">              
          <form method="post" action="accueil_mobile_money.php"> 

            <label for="login">Login: </label>
            <input type="text" name="login" id="login" /><br/>

            <label for="password">Mot de passe: </label>
            <input type="password" name="password" id="password" /><br/>
 
            <label for="connecter">Se connecter</label>
            <input type="submit" name="connecter" id="connecter" /><br/>

          </form>
        </section>

          <?php 
    include('footer.php');
    }
  }



// Pour acceder au service money transfer, ce devra etre un simple utilisateur money transfer déja authentifié. Dans le cas contraire on affiche le formulaire pour authentification

elseif ($_GET['service'] == 'money_transfert')
{ 
    if (isset($_SESSION['mt']))
    {
      header('location:accueil_money_transfert.php');
    }
    else
    {

    include('doctype.php');
    include("header.php");
?>
    <body>
        <section class="entete">
          <h1>AUTHENTIFICATION MONEY TRANSFERT</h1>
        </section>
        
        <section class="form">
        
        <form method="post" action="accueil_money_transfert.php">

         <label for="login">Login: </label>
         <input type="text" name="login" id="login" /><br/><br/>

         <label for="password">Mot de passe: </label>
         <input type="password" name="password" id="password" /><br/><br/>
 
         <label for="connecter">Se connecter</label>
         <input type="submit" name="connecter" id="connecter" /><br/><br/>

        </form>

        </section>

<?php 
    include("footer.php");
    }
  }


// Pour acceder au service add user, ce devra etre un administrateur déja authentifié. Dans le cas contraire on affiche le formulaire pour authentification  

elseif ($_GET['service'] == 'add_user')
{
    if (isset($_SESSION['admin']))
    {
    header('location:add_user.php');
    }
    else
    {

    include('doctype.php');
    include("header.php");
?>

    <body>
        <section class="entete">
          <h1>AUTHENTIFICATION ADMINISTRATEUR</h1>
        </section>
        
        <section class="form">
        
        <form method="post" action="add_user.php">
        <fieldset>
        <label for="login">Login: </label>
        <input type="text" name="login" id="login" /><br/><br/>

        <label for="password">Mot de passe: </label>
        <input type="password" name="password" id="password" /><br/><br/>
 
        <label for="connecter">Se connecter</label>
        <input type="submit" name="connecter" id="connecter" /><br/><br/>

        </fieldset>
        </form>

      </section>
    <?php 
    include('footer.php');
    }
  }




// Pour acceder au service delete user, ce devra etre un administrateur déja authentifié. Dans le cas contraire on affiche le formulaire pour authentification 

elseif ($_GET['service'] == 'delete_user')
{

    if (isset($_SESSION['admin']))
    {
    header('location:delete_user.php');
    }
    else
    {
    include('doctype.php');
    include("header.php");
?>

    <body>
        <section class="entete">
          <h1>AUTHENTIFICATION ADMINISTRATEUR</h1>
        </section>
        
        <section class="form">
        <form method="post" action="delete_user.php">
 
       <label for="login">Login: </label>
       <input type="text" name="login" id="login" /><br/><br/>

       <label for="password">Mot de passe: </label>
       <input type="password" name="password" id="password" /><br/><br/>
 
       <label for="connecter">Se connecter</label>
       <input type="submit" name="connecter" id="connecter" /><br/><br/>

        </form>
      </section>

      <?php 
    include('footer.php');
    }
  }




// Pour acceder au service password reset, ce devra etre un administrateur déja authentifié. Dans le cas contraire on affiche le formulaire pour authentification 

elseif ($_GET['service'] == 'password_reset')
{

  if (isset($_SESSION['admin']))
  {
    header('location:password_reset.php');
  }
  else
  {

  include('doctype.php');
  include("header.php");

?>
  <body>
        <section class="entete">
          <h1>AUTHENTIFICATION ADMINISTRATEUR</h1>
        </section>
        
        <section class="form">
        <form method="post" action="password_reset.php">
       
       <label for="login">Login: </label>
       <input type="text" name="login" id="login" /><br/><br/>

       <label for="password">Mot de passe: </label>
       <input type="password" name="password" id="password" /><br/><br/>
 
       <label for="connecter">Se connecter</label>
       <input type="submit" name="connecter" id="connecter" /><br/><br/>

         </form>
       </section>

      <?php 
        include('footer.php');
  }
}



// Pour acceder au dayly report, ce devra etre un administrateur déja authentifié. Dans le cas contraire on affiche le formulaire pour authentification 

elseif ($_GET['service'] == 'report_mm')
{

  if (isset($_SESSION['admin']))
  {
    header('location:report_mm.php');
  }
  else
  {
  include('doctype.php');
  include("header.php");

?>

  <body>
        <section class="entete">
          <h1>AUTHENTIFICATION ADMINISTRATEUR</h1>
        </section>
        
        <section class="form">
      <form method="post" action="report_mm.php">

       <label for="login">Login: </label>
       <input type="text" name="login" id="login" /><br/><br/>

       <label for="password">Mot de passe: </label>
       <input type="password" name="password" id="password" /><br/><br/>
 
       <label for="connecter">Se connecter</label>
       <input type="submit" name="connecter" id="connecter" /><br/><br/>

      </form>

      </section>

 <?php 
 include('footer.php');
    }
  }




// Pour acceder au monthly report, ce devra etre un administrateur déja authentifié. Dans le cas contraire on affiche le formulaire pour authentification 

elseif ($_GET['service'] == 'global_report')
{

  if (isset($_SESSION['admin']))
  {
    header('location:global_report.php');
  }
  else
  {
  include('doctype.php');
  include("header.php");

?>

  <body>
        <section class="entete">
          <h1>AUTHENTIFICATION ADMINISTRATEUR</h1>
        </section>
        
    <section class="form">
    <form method="post" action="global_report.php">

       <label for="login">Login: </label>
       <input type="text" name="login" id="login" /><br/><br/>

       <label for="password">Mot de passe: </label>
       <input type="password" name="password" id="password" /><br/><br/>
 
       <label for="connecter">Se connecter</label>
       <input type="submit" name="connecter" id="connecter" /><br/><br/>
    </form>

    </section>

 <?php 
 include('footer.php');
    }
  }




// Pour acceder au weekly report, ce devra etre un administrateur déja authentifié. Dans le cas contraire on affiche le formulaire pour authentification 

elseif ($_GET['service'] == 'report_mt')
{

    if (isset($_SESSION['admin']))
  {
    header('location:report_mt.php');
  }
  else
  {
  include('doctype.php');
  include("header.php");

?>
  <body>
        <section class="entete">
          <h1>AUTHENTIFICATION ADMINISTRATEUR</h1>
        </section>
        
        <section class="form">
      <form method="post" action="report_mt.php">
    
       <label for="login">Login: </label>
       <input type="text" name="login" id="login" /><br/><br/>

       <label for="password">Mot de passe: </label>
       <input type="password" name="password" id="password" /><br/><br/>
 
       <label for="connecter">Se connecter</label>
       <input type="submit" name="connecter" id="connecter" /><br/><br/>

        </form>
      </section>

 <?php 
 include('footer.php');
    }
  }

else
{
    header('location:index.php');
}

?>


