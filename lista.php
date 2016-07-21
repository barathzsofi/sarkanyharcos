<?php
	define('TOKEN', 'Védelem');
	include_once('modulok/session_login.php');
	include_once("modulok/sio.php");
	include_once("modulok/consts.php");
	$loggedIn = '';
	$felhasznalok = adat_betoltes($FELHASZNALOK);
	if (!(IsLoggedIn())) {
		header('Location: index.php');
		exit('Az oldal megtekintéséhez be kell <a href="login.php">jelentkezni</a>t!');
	}else{
		$em = WhoLoggedIn();
		$loggedIn = $felhasznalok[$em]['felhasznalonev'];
	}
	
	$palyak = adat_betoltes($PALYAK);
	
	
	
	function legjobb($palyanev,$file){
		$legjobbneve = '';
		$legjobbpont = 0;
		$palyak = adat_betoltes($file);
		$felhasznalok = adat_betoltes('adatok/felhasznalok.json');
		foreach($palyak[$palyanev]['felhasznalok'] as $felhasznalo){
				if($felhasznalo['felhpontsz'] > $legjobbpont){
					$legjobbneve = $felhasznalo['felhemail'];
					$legjobbpont = $felhasznalo['felhpontsz'];
				}
		}
		$leg = $felhasznalok[$legjobbneve]['felhasznalonev'];
		
		//$ret = "(Legjobb: ".$legjobbneve." - ".$legjobbpont.")";
		$ret = "(Legjobb: ".$leg." - ".$legjobbpont.")";
		return $ret;
	}
	
	
	function sajat($palyanev,$file){
		$nev = WhoLoggedIn();
		$palyak = adat_betoltes($file);
		
		foreach($palyak[$palyanev]['felhasznalok'] as $felhasznalo){
				if($felhasznalo['felhemail'] == $nev){
					$pont = $palyak[$palyanev]['felhasznalok'][$nev]['felhpontsz'];
					$ret = "(Saját: ". $pont .")";
					return $ret;
				}
		}
		return "";
		
	}
	
	

	
	//------------------------
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sárkányharcos</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/sablon.css" rel="stylesheet" media="screen">
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
		
		<script type="text/javascript" src = "pontszamok.js"></script>
		<script type="text/javascript" src = "ajax.js"></script>
		
	</head>
	<body>
		<div class="well">
			<h1>Sárkányharcos</h1>
			
			<?php if (IsLoggedIn()) : ?>
				<p><?php echo $loggedIn ?> |<a href="logout.php"> Kijelentkezés</a></p>
				<?php if (WhoLoggedIn() == "admin@admin.hu") : ?>
					<p><a href = "ujPalya.php">Új pálya felvétele</a></p>
				<?php endif; ?>
			<?php else : ?>
				<p>A bejelentkezéshez kattints <a href="login.php">I D E</a> a regisztrációhoz meg <a href="reg.php">I D E</a></p>
			<?php endif; ?>
			
		</div>
		
		<div class = "megoldas well">
			<?php if($palyak != '') : ?>
			<ul>
			<?php foreach($palyak as $palya) : ?>
				<li>
					<?php foreach($palya as $key => $p) : ?>
					<?php if($key != "felhasznalok") : ?>
						<?= $key; ?>: 
						<?= $p; ?>,
					<?php else : ?>
							
							<?= legjobb($palya['nev'],$PALYAK) ?>
							<?= sajat($palya['nev'],$PALYAK) ?>
							
					<?php endif; ?>
					<?php endforeach; ?>
				</li>
				<a href = palya.php?n=<?= urlencode($palya['nev']) ?>&m=<?= urlencode($palya['magassag']) ?>&sz=<?= urlencode($palya['szelesseg']) ?>&t=<?= urlencode($palya['terept']) ?>>játszom</a>
			<?php endforeach; ?>
			</ul>
			<?php endif; ?>
			
		</div>
		
		<div class="megoldas well">
				<p><a href = "index.php">Vissza a főoldalra</a></p>
			</div>
		
	</body>
</html>