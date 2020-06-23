<?php

if($_GET['code']=='mt')
{
	header('location:accueil_money_transfert.php');
}
elseif($_GET['code']=='mm')
{
	header('location:accueil_mobile_money.php');
}

?>