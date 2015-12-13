

<?php

/**
 * visualizza le prenotazioni di un intero giorno come una tabella e colora di rosso le aule occupate
 * */
 $giorno = $_GET ['Data'];
//$giorno = "7/12/2015";
//$codice = 1;
// echo "<h1>" . $giorno . "</h1>";
	$dividi=explode("/", $giorno);
	// echo "<h1>" . $dividi[0] . "</h1>";
	if((strlen($dividi[0]))==1){
		$giorno="0".$dividi[0]."/".$dividi[1]."/".$dividi[2];
	}
echo "<h1>" . $giorno . "</h1>";
?>
<table border="1">
	<thead>
		<tr>
			<th>Aula</th>
					<?php
					//stampa le ore come colonna della tabella
					for($i = 7; $i <= 23.30; $i += 1) {
						echo "<th>" . $i . "</th>";
						echo "<th>" . $i . ".30</th>";
					}
					
					?>
	
		</tr>

	</thead>
	<tbody>
				<?php
				// open the database
				$db = new PDO ( 'sqlite:noiMarano_PDO.sqlite' );
				$sth = $db->prepare ( 'SELECT * FROM aula' );
				$sth->execute ();
				// la prima colonna è l'aula
				// ciclo più esterno
				foreach ( $sth as $row ) {
					$codice = $row ['Codice'];
					
					// seleziono tutte le pretoazioni dell'aula con $codice di $giorno
					$statment = $db->prepare ( 'SELECT * FROM (aula join prenotazione on Aula.codice=Prenotazione.CodiceAula) where Aula.Codice= :codice and Data= :giorno' );
					$statment->bindParam ( ':codice', $codice );
					$statment->bindParam ( ':giorno', $giorno );
					$statment->execute ();
					$result = $statment->fetchAll ();
					$arrayOra = creaArray ( $result );
					print "<tr><td>" . $row ['Nome'] . "</td>";
					for($i = 7; $i <= 23.30; $i += 1) {
						if ($arrayOra [$i * 2] == 1)
							echo "<td style=\"background-color: red;\">" . "</th>";
						else
							echo "<td style=\"background-color: green;\">" . "</th>";
						if ($arrayOra [$i * 2 + 1] == 1)
							echo "<td style=\"background-color: red;\">" . "</th>";
						else
							echo "<td style=\"background-color: green;\">" . "</th>";
					}
					print "</tr>";
				}
				
				$db = null;
				?>

	
	</tbody>

</table>


<?php 

$indietro= $_SERVER["HTTP_REFERER"];
echo "<input type=\"image\" src=\"immagini/indietro1.png\" border=\"0\"
							onClick=\"document.location.href='".$indietro."'\" class=\"indietro\"/>";


?>

<?php

/**
 * crea un array con selezionate le ore occuppate
 * $tabella array contentente tutte le prenotazioni per un giorno di un'aula
 * tabella sql
 */
function creaArray($tabella) {
	$array = array ();
	for($i = 0; $i <= 49; $i ++) {
		$array [$i] = 0;
	}
	foreach ( $tabella as $row ) {
		$oraInizio = $row ['OraInizio'];
		$oraFine = $row ['OraFine'];
		
		$pieces = explode ( ".", $oraInizio );
		
		if ($pieces [1] == '30' || $pieces [1] == '3') { // se l'ora inizia per 30
			for($i = $oraInizio; $i <= $oraFine; $i ++) {
				
				$pieces = explode ( ".", $i );
				/*
				 * echo $i . "<br>";
				 * echo $pieces [0] . "<br>";
				 * echo $pieces [1] . "<br>";
				 */
				if ($i == $oraInizio) { // se $i è uguale all'inizio dell'ora
					if ($pieces [1] == 0) {
						$array [$i * 2] = 1;
					}
				} else // l'ora non è uguale a quella iniziale
					$array [$i * 2] = 1;
				if (! empty ( $pieces [1] )) {
					if ($pieces [1] == '30' || $pieces [1] == '3') {
						if ($i != $oraFine)
							$array [$i * 2 + 1] = 1;
					}
				}
			}
		} else { // se l'ora inizia per 00
			
			for($i = $oraInizio; $i <= $oraFine; $i ++) {
				if($i+1<=$oraFine){
					$array[$i*2]=1;
					$array[$i*2+1]=1;
				}else{
					$pieces = explode ( ".", $oraFine );
					if($pieces[1]=='30'){
						$array[$i*2]=1;
					}
				}
			}
		}
	}
	
	return $array;
}
?>