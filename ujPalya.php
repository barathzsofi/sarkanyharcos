<?php
	define('TOKEN', 'Védelem');

	include_once('modulok/sio.php');
	include_once('modulok/consts.php');
	include_once('modulok/session_login.php');
	
	$felhasznalok = adat_betoltes($FELHASZNALOK);
	$loggedIn = '';
	if(IsLoggedIn()){
		$em = WhoLoggedIn();
		$loggedIn = $felhasznalok[$em]['felhasznalonev'];
	}
	
	if (!(IsLoggedIn()) || $loggedIn!="admin") {
		header('Location: index.php');
		exit('Az oldal megtekintéséhez be kell <a href="login.php">jelentkezni</a>t!');
	}
	
	$hibak = array();
	$nev = '';
	$magassag = '';
	$szelesseg = '';
	$terept = '';
	
	if ($_POST) {
		if(isset($_POST['nev'])){
			$nev = trim($_POST['nev']);
		}
		if(isset($_POST['magassag'])){
			$magassag = trim($_POST['magassag']);
		}
		if(isset($_POST['szelesseg'])){
			$szelesseg = trim($_POST['szelesseg']);
		}
		if(isset($_POST['terept'])){
			$terept = trim($_POST['terept']);
		}
		if ($nev == '') {
			$hibak[] = 'Nev kotelezo!';
		}
		if ($magassag == '') {
			$hibak[] = 'Magasság kotelezo!';
		}
		if ($szelesseg == '') {
			$hibak[] = 'Szélesség kotelezo!';
		}
		if ($terept == '') {
			$hibak[] = 'Tereptárgyszám kotelezo!';
		}
		
		$felhemail = "admin@admin.hu";
		$felhpontsz = 0;
		
		$felh[$felhemail] = array(
			'felhemail'		=> $felhemail,
			'felhpontsz'	=> $felhpontsz
		);
		
		if (!$hibak) {
			$palyak = adat_betoltes($PALYAK);
			$palyak[$nev] = array(
				'nev'			=> $nev,
				'magassag'		=> $magassag,
				'szelesseg'		=> $szelesseg,
				'terept'		=> $terept,
				'felhasznalok'	=> $felh
			);
			adat_mentes($PALYAK, $palyak);
			header('Location: lista.php');
			exit();
		}
	}
	
	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sárkányharcos</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/sablon.css" rel="stylesheet" media="screen">
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	</head>
	<body>


		<div class="container-fluid">
		<div class="row-fluid">
        <div class="span9">
		
			<div class="well">
				<h1>Sárkányharcos</h1>
				<?php if (IsLoggedIn()) : ?>
					<p><?php echo $loggedIn ?> |<a href="logout.php"> Kijelentkezés</a></p>
					<p><a href = "lista.php">Lista</a></p>
				<?php else : ?>
					<p>A bejelentkezéshez kattints <a href="login.php">I D E</a> a regisztrációhoz meg <a href="reg.php">I D E</a></p>
				<?php endif; ?>
			</div>
			
			<div class="megoldas well">
			<?php if($hibak) : ?>
				<ul>
					<?php foreach ($hibak as $hiba) : ?>
					<li><?= $hiba; ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<form action="" method="post">
				<p>Pálya neve: <input type="text" name="nev"></p>
				<p>Magasság: <input type="text" name="magassag"></p>
				<p>Szélesség: <input type="text" name="szelesseg"></p>
				<p>Tereptárgyak száma: <input type="text" name="terept"></p>
				<p><label id="Error"></label></p>
				<input type="submit" value="Új pálya felvétele">
			</form>	
			</div>
			
			
			<div class="megoldas well">
				<p><a href = "index.php">Vissza a főoldalra</a></p>
			</div>
        
        </div><!--/span-->
		</div><!--/row-->
		</div>
	</body>
</html>
