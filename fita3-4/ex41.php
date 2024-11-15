<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex41</title>
    <style>

 		table,td {
 			border: 1px solid black;
 			border-spacing: 0px;
 		}
 	</style>
</head>
<body>

    <?php

 		# (1.1) Connectem a MySQL (host,usuari,contrassenya)
 		$conn = mysqli_connect('localhost','admin','admin123');
 
 		# (1.2) Triem la base de dades amb la que treballarem
 		mysqli_select_db($conn, 'mundo');
 
 		# (2.1) creem el string de la consulta (query)
 		$consultaOptions = "SELECT DISTINCT Continent FROM country ORDER BY Continent asc;";
		 if (isset($_POST["Continents"])) {
			$continent = $_POST["Continents"];
			$consultaList = "SELECT Name FROM country WHERE Continent = '$continent' ORDER BY Name asc;";

			$resultatList = mysqli_query($conn, $consultaList);
			if (!$resultatList) {
				$message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
				$message .= 'Consulta realitzada: ' . $consultaList;
				die($message);
			}

		}


 		# (2.2) enviem la query al SGBD per obtenir el resultat
 		$resultatOptions = mysqli_query($conn, $consultaOptions);
 
 		# (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
 		#     posem un missatge d'error i acabem (die) l'execució de la pàgina web
 		if (!$resultatOptions) {
     			$message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
     			$message .= 'Consulta realitzada: ' . $consultaOptions;
     			die($message);
 		}
 	?>
     <h1>Exercici 4.1: menú de selecció</h1>
    <form action="ex41.php" method="post">
		<select name="Continents" id="Continents">
		<?php
			while( $registreOptions = mysqli_fetch_assoc($resultatOptions) ){
				echo '<option value="'. $registreOptions["Continent"] .'"'.(($continent==$registreOptions["Continent"])?'selected="selected"':"").'>' . $registreOptions["Continent"] . '</option>';
			}
		?>
		</select>

        <input type="submit" value="Tramet la consulta">
    </form>
 	<!-- (3.1) aquí va la taula HTML que omplirem amb dades de la BBDD -->
 	<ul>
 	<?php
 		# (3.2) Bucle while
 		while( $registreList = mysqli_fetch_assoc($resultatList) )
 		{

 			echo "\t\t\t<li>".$registreList["Name"]."</li>\n";

 		}
 	?>
	</ul>
  	<!-- (3.6) tanquem la taula -->

</body>
</html>