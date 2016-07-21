<?php
	
	define('TOKEN', 'Védelem');
	include_once('modulok/session_login.php');
	
	include_once('modulok/sio.php');
	include_once('modulok/consts.php');
	
	$palyak = adat_betoltes($PALYAK);
	$felhasznalo = WhoLoggedIn();
	$pont = $_POST['pont'];
	$pnev = $_POST['pnev'];
		

		
	if(!($palyak[$pnev]['felhasznalok'][$felhasznalo])){
		$palyak[$pnev]['felhasznalok'][$felhasznalo] = array(
			'felhemail'		=> $felhasznalo,
			'felhpontsz'	=> $pont
		);
	}elseif($palyak[$pnev]['felhasznalok'][$felhasznalo]['felhpontsz'] < $pont){
		$palyak[$pnev]['felhasznalok'][$felhasznalo]['felhpontsz'] = $pont;
	}
	
	
	
	
	
	adat_mentes($PALYAK,$palyak);
		
	echo json_encode($palyak[$pnev]);

?>