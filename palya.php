<?php
	define('TOKEN', 'Védelem');

	include_once('modulok/sio.php');
	include_once('modulok/consts.php');
	include_once('modulok/session_login.php');
	
	$n = '';
	$m = '';
	$sz = '';
	$t = '';
	if(isset($_GET['n']) && isset($_GET['m']) && isset($_GET['sz']) && isset($_GET['t']) ){
		$n = urldecode($_GET['n']);
		$m = urldecode($_GET['m']);
		$sz = urldecode($_GET['sz']);
		$t = urldecode($_GET['t']);
	}else{
		header('Location: jatek.php');
	}
	
	$loggedIn = '';
	$felhasznalok = adat_betoltes($FELHASZNALOK);
	if (!(IsLoggedIn())) {
		header('Location: index.php');
		exit('Az oldal megtekintéséhez be kell <a href="login.php">jelentkezni</a>t!');
	}else{
		$em = WhoLoggedIn();
		$loggedIn = $felhasznalok[$em]['felhasznalonev'];
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
		<script type="text/javascript" src = "pontszamok.js"></script>
		<script type="text/javascript" src = "ajax.js"></script>
		
		<script type="text/javascript" src="regJatek.js"></script>
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
					<?php if (WhoLoggedIn() == "admin@admin.hu") : ?>
						<p><a href = "ujPalya.php">Új pálya felvétele</a></p>
					<?php endif; ?>
				<?php else : ?>
					<p>A bejelentkezéshez kattints <a href="login.php">I D E</a> a regisztrációhoz meg <a href="reg.php">I D E</a></p>
				<?php endif; ?>
			</div>
			
			<div class="megoldas well">
				<p>Tekercs: <label id="Tekercs"></label></p>
				<p>Pont: <label id="Pont" name = "Pont"></label></p>
				
				<table id="Palya">
				</table>
				
				
				<input id="UjJatek" type="button" value="START">
				
			</div>
			
			
			<div class = "well">
				Név: <label id = "Nev"><?php echo $n; ?></label>
				Magasság: <label id="Magassag"><?php echo $m; ?></label>
				Szélesség: <label id="Szelesseg"><?php echo $sz; ?> </label>
				Tereptárgyak száma: <label id="Terept" type="text" ><?php echo $t ?></label>
				<label id="Error"></label>
			</div>
			
			
			<div class="megoldas well">
				<p><a href = "index.php">Vissza a főoldalra</a></p>
			</div>
        
        </div><!--/span-->
		</div><!--/row-->
		</div>
	</body>
</html>
