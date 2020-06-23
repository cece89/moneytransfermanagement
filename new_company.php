<?php
session_start();

include ("doctype.php");
include("header.php");
?>

<body>

  <section class="entete">
    <h1>NOUVELLE COMPAGNIE</h1>
  </section>

  <section class="info_perso">
    <h2>INFORMATIONS PERSONNELLES</h2>
  
  <form method="post" action="enregistrement.php">

       <label for="nom">Quel est votre nom ?</label>
       <input type="text" name="nom" id="nom" /><br/>

       <label for="prenom">Quel est votre prénom ?</label>
       <input type="text" name="prenom" id="prenom" /><br/>
 
       <label for="email">Quel est votre e-mail ?</label>
       <input type="email" name="email" id="email" /><br/>

       <label for="contact">Quel est votre numero de telehone ?</label>
       <input type="text" name="contact" id="contact" /><br/><br/>

       <h2>PARAMETRES DE CONNEXION</h2> <!-- Titre du fieldset --> 

       <label for="login">Entrer un login ?</label>
       <input type="text" name="login" id="login" /><br/>

       <label for="password">Entrer un mot de passe ?</label>
       <input type="password" name="password" id="password" /><br/>

       <h2>VOTRE COMPAGNIE</h2> <!-- Titre du fieldset -->

       <label for="company_name">Quel est le nom de votre compagnie?</label><br/>
       <input type="text" name="company_name" id="company_name" />    
       <p>
           De combien de points de ventes disposez-vous?

           <input type="radio" name="branch" value="1" id="un" checked="checked"/> <label for="un">1</label>
           <input type="radio" name="branch" value="2" id="deux" /> <label for="deux">2</label>
           <input type="radio" name="branch" value="3" id="trois" /> <label for="trois">3</label>
           <input type="radio" name="branch" value="4" id="quatre" /> <label for="quatre">4</label>
           <input type="radio" name="branch" value="5" id="cinq" /> <label for="cinq">5</label>

       </p>

       <label for="submit">S'enregistrer</label>
       <input type="submit" name="submit" id="submit" /><br/><br/>
</form>
</section>
<?php
include("footer.php");
?>
