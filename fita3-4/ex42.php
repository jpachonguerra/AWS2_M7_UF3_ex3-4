<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex42</title>
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
		$continentArr = [];
		if (isset($_POST["continent"])) {
			$continentArr = $_POST["continent"];
            $llistatContinents = implode("','", $continentArr);
            $consultaList = "SELECT Name FROM country WHERE Continent IN ('" . $llistatContinents. "') ORDER BY Name asc;";
            $resultatList = mysqli_query($conn, $consultaList);
            if (!$resultatList) {
                $message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
                $message .= 'Consulta realitzada: ' . $consultaList;
                die($message);
            }           
        } else {
            $resultatList = null;
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
     <h1>Exercici 4.2: checkboxes</h1>
    <form action="ex42.php" method="post">
		<?php
			while( $registreOptions = mysqli_fetch_assoc($resultatOptions) ){
				echo '<input type="checkbox" name="continent[]" value="'. $registreOptions["Continent"] .'"'.((in_array($registreOptions["Continent"], $continentArr))?'checked':"").'>' . $registreOptions["Continent"] . '<br>';
			}
		?>

        <input type="submit" value="Tramet la consulta">
    </form>
 	<!-- (3.1) aquí va la taula HTML que omplirem amb dades de la BBDD -->
 	<ul>
 	<?php
 		# (3.2) Bucle while
if ($resultatList !== null) {
    while ($registreList = mysqli_fetch_assoc($resultatList)) {
        echo "\t\t\t<li>".$registreList["Name"]."</li>\n";
    }
}
 	?>
	</ul>
  	<!-- (3.6) tanquem la taula -->

</body>
</html>