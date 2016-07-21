<?php
	define('TOKEN', 'Védelem');

	include_once('modulok/sio.php');
	include_once('modulok/consts.php');
	//include_once('modulok/session_kosar.php');
	include_once('modulok/session_login.php');
	$felhasznalok = adat_betoltes($FELHASZNALOK);
	$loggedIn = '';
	if(IsLoggedIn()){
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
				<!--	<p>A bejelentkezéshez kattints <a href="login.php">I D E</a> a regisztrációhoz meg <a href="reg.php">I D E</a></p> -->
					<p><a href="login.php">BEJELENTKEZÉS</a> | <a href="reg.php">REGISZTRÁCIÓ</a></p>
				<?php endif; ?>
			</div>
			
			<div class="megoldas well">
				<p><img src="logo.png" alt="logo" style="height:228px;"></p>
				<p>
					Az ősi Kínában – a feljegyzések legalábbis erre utalnak – jóval az időszámításunk előtt volt egy furcsa megmérettetés: kínai vitézek rátermettségüket azzal bizonyították, hogy minél tovább próbálták megülni Chai-Si hegyvidék varázslatos sárkányát. A legjobb vitéz lett az év sárkányharcosa.
					
					A szerencsét próbáló vitézek egy arénánál gyülekeztek. Egyesével ültek fel az aréna bejáratánál a sárkány hátára, majd a sárkányt beengedték az arénába. A cél az volt, hogy a sárkánnyal minél több tekercset gyűjtsön be a vitéz. Egyszerre egy tekercset dobtak az aréna véletlenszerű helyére. Ha a sárkány felvette a tekercset, akkor annak hatására bölcsebb és nagyobb lett. Voltak azonban olyan tekercsek, amelyek egyéb varázslatot tartalmaztak. Az arénában ezek mellett lehettek tereptárgyak is.

					A játékban Te a fiatal és ügyes vitézt, Teng Lenget alakítod. Segíts neki sárkányharcossá válni!
				</p>
				<a href="jatek.html">Játék</a>
				
			</div>
        
        </div><!--/span-->
		</div><!--/row-->
		</div>
	</body>
</html>
