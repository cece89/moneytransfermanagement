<!-- Entete du site -->


<header id="masthead" class="site-header">
            	<!-- Construction du menu -->
		<nav class="mtn-navbar">
				
				<div class="mtn-navbar__container">
					


					<!-- Insertion du logo -->
					<div class="mtn-navbar__header">
						<a class="mtn-navbar__logo" href="index.php"><img width="45px" src="image/logo.png" alt="MTN"></a>
					</div>

					<!-- Menu services -->
					<!-- Il faut cliquer sur les sous-menus, les menus renvoyant directement à l'accueil. Chancun des sous menu hormis New company et les sous-menus de About us, revoi vers la page Authentication.php avec un parametre par url (service) specifiant le type d'authentification (administrateur ou utilisateur). -->
					<div id="navbar" class="mtn-navbar__collapse">
						
						<ul id="mtn-navbar__accordion" class="mtn-navbar__nav mtn-accordion">
							
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1634" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children accordion-dropdown depth-0 menu-item-1634 mtn-accordion__panel nav-item">
								
								<div class="mtn-accordion__title">
								<a title="Particuliers" href="index.php" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link" id="menu-item-dropdown-1634">Services</a>
								</div>

								<!--Les sous-menus de service  -->
								<ul class="mtn-accordion__content accordion-dropdown" aria-labelledby="menu-item-dropdown-1634" role="menu">
									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1629" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-1629 mtn-accordion__item">
										<div class="p-l"><a title="" href="authentication.php?service=mobile_money" class="dropdown-item depth-1">Mobile Money</a></div>
									</li>
							
									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1637" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-1637 mtn-accordion__item">
										<div class="p-l"><a title="Produits" href="authentication.php?service=money_transfert" class="dropdown-item depth-1">Money Transfert</a></div>
									</li>
	
									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1628" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-1628 mtn-accordion__item">
										<div class="p-l"><a title="" href="new_company.php" class="dropdown-item depth-1">New company</a></div>
									</li>
								</ul>
							</li>



							<!-- Le menu Reports etses trois sous menus-->
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1633" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children accordion-dropdown depth-0 menu-item-1633 mtn-accordion__panel nav-item">
								<div class="mtn-accordion__title">
									<div class="mtn-accordion__toggle mtn-accordion--toggle"> </div>
									<a title="Business" href="index.php" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link" id="menu-item-dropdown-1633">Reports</a>
								</div>
							
								<ul class="mtn-accordion__content accordion-dropdown" aria-labelledby="menu-item-dropdown-1633" role="menu">
									
									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1631" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-1631 mtn-accordion__item">
									<div class="p-l"><a title="Solutions" href="authentication.php?service=report_mm" class="dropdown-item depth-1">Mobile Money</a></div>
									</li>
	
									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-2453" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-2453 mtn-accordion__item">
									<div class="p-l"><a title="Secteurs" href="authentication.php?service=report_mt" class="dropdown-item depth-1">Money Transfer</a></div>
									</li>

									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-2453" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-2453 mtn-accordion__item">
									<div class="p-l"><a title="Secteurs" href="authentication.php?service=global_report" class="dropdown-item depth-1">Global Report</a></div>
									</li>

								</ul>
							</li>

							<!--le Menu User Management et ses sous menus  -->

							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1630" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children accordion-dropdown depth-0 menu-item-1630 mtn-accordion__panel nav-item">
								<div class="mtn-accordion__title">
									<div class="mtn-accordion__toggle mtn-accordion--toggle"></div>
									<a title="MoMo" href="index.php" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link" id="menu-item-dropdown-1630">Users Management</a>
								</div>

								<ul class="mtn-accordion__content accordion-dropdown" aria-labelledby="menu-item-dropdown-1630" role="menu">
									
									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1900" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-1900 mtn-accordion__item">
									<div class="p-l"><a title="Particuliers" href="authentication.php?service=add_user" class="dropdown-item depth-1">Add user</a></div>
									</li>

									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1699" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-1699 mtn-accordion__item">
									<div class="p-l"><a title="Marchands" href="authentication.php?service=delete_user" class="dropdown-item depth-1">Delete user</a></div>
									</li>
									
									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1696" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-1696 mtn-accordion__item">
									<div class="p-l"><a title="Business" href="authentication.php?service=password_reset" class="dropdown-item depth-1">Password reset</a></div>
									</li>
	
								</ul>
							</li>	

							<!--le Menu About us et ses sous menus  -->

							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1633" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children accordion-dropdown depth-0 menu-item-1633 mtn-accordion__panel nav-item">
								<div class="mtn-accordion__title">
									<div class="mtn-accordion__toggle mtn-accordion--toggle"> </div>
									<a title="Business" href="index.php" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link" id="menu-item-dropdown-1633">About us</a>
								</div>
							
								<ul class="mtn-accordion__content accordion-dropdown" aria-labelledby="menu-item-dropdown-1633" role="menu">
									
									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-1631" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-1631 mtn-accordion__item">
									<div class="p-l"><a title="Solutions" href="auteur.php" class="dropdown-item depth-1">Author</a></div>
									</li>
	
									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-2453" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-2453 mtn-accordion__item">
									<div class="p-l"><a title="Secteurs" href="realisation.php" class="dropdown-item depth-1">Our Achievements</a></div>
									</li>

									<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-2453" class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-2453 mtn-accordion__item">
									<div class="p-l"><a title="Secteurs" href="assistance.php" class="dropdown-item depth-1">Help</a></div>
									</li>

								</ul>
							</li>

						</ul>


						<!--la section à droite du menu pour afficher le nom des utilisateurs authentifiés et le lien pour la deconnexion  -->
						<ul class="nav-list--desktop">
							<li class="menu-item menu-item-type-post_type menu-item-object-page item-has-no-children depth-1 menu-item-2453 mtn-accordion__item">
								<div class="p-l">
								<div class="p-l">
								<form role="search" method="get" id="searchform" class="searchform" action="https://www.mtn.ci">

									<!-- Si les variables de session utilisateur et administrateur existent, afficher le login de l'utilisateur et le lien de deconnexion dans cette section -->
									<?php
									if (isset($_SESSION['login']))
									{
										echo ''. $_SESSION['login'];
									?> 
									<br/>
										<a title="deconnexion" href="deconnexion.php">Deconnexion</a>
										<?php
									}


									elseif (isset($_SESSION['admin']))
									{
										echo ''. $_SESSION['admin'].'[admin]';
									?> 
									<br/>
										<a title="deconnexion" href="deconnexion.php">Deconnexion</a>
										<?php
									}

									?>
								</form>
								</div>
								</div>
							</li>
						</ul>


					</div>
				</div>
		</nav>
	</header>