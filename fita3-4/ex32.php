<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex32</title>
    <style>

 		table,td {
 			border: 1px solid black;
 			border-spacing: 0px;
 		}
 	</style>
</head>
<body>
    <h1>Exercici 3.2: filtre per llengua</h1>
    <form action="ex32.php" method="post">
        <label for="min">Llengua:</label>
        <input type="text" name="lang" id="lang">
        <br>
        <input type="submit" value="Filtra">
    </form>
    <?php
        $lang = $_POST["lang"];
 		# (1.1) Connectem a MySQL (host,usuari,contrassenya)
 		$conn = mysqli_connect('localhost','admin','admin123');
 
 		# (1.2) Triem la base de dades amb la que treballarem
 		mysqli_select_db($conn, 'mundo');
 
 		# (2.1) creem el string de la consulta (query)
		$consulta = "SELECT DISTINCT Language, IsOfficial FROM countrylanguage ORDER BY Language asc;";
        if ($lang != null) {
            $consulta = "SELECT DISTINCT Language, IsOfficial FROM countrylanguage WHERE Language LIKE '%$lang%' ORDER BY Language asc;";
        }
 
 		# (2.2) enviem la query al SGBD per obtenir el resultat
 		$resultat = mysqli_query($conn, $consulta);
 
 		# (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
 		#     posem un missatge d'error i acabem (die) l'execució de la pàgina web
 		if (!$resultat) {
     			$message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
     			$message .= 'Consulta realitzada: ' . $consulta;
     			die($message);
 		}
 	?>
 
 	<!-- (3.1) aquí va la taula HTML que omplirem amb dades de la BBDD -->
 	<table>
 	<!-- la capçalera de la taula l'hem de fer nosaltres -->
 	<thead>
		<tr>
			<th colspan="4" align="center" bgcolor="cyan">Llistat de llengües</th>
		</tr>
	</thead>
	<tbody>
 	<?php
 		# (3.2) Bucle while
 		while( $registre = mysqli_fetch_assoc($resultat) )
 		{
 			# els \t (tabulador) i els \n (salt de línia) son perquè el codi font quedi llegible
  
 			# (3.3) obrim fila de la taula HTML amb <tr>
 			echo "\t\t<tr>\n";
 
 			# (3.4) cadascuna de les columnes ha d'anar precedida d'un <td>
 			#	després concatenar el contingut del camp del registre
 			#	i tancar amb un </td>
 			echo "\t\t\t<td>".$registre["Language"];
			if ($registre["IsOfficial"] == 'T'){
				echo "[OFFICIAL]</td>\n";
			} else {
				echo "</td>\n";
			}
 
 			# (3.5) tanquem la fila
 			echo "\t\t</tr>\n";
 		}
 	?>
  	<!-- (3.6) tanquem la taula -->
	</tbody>
 	</table>
</body>
</html>