<?php

/**
 * si salva una prenotazione nel database
 * */
$db = new PDO ( 'sqlite:noiMarano_PDO.sqlite' );

$data = $_POST ['todays_date'];
$oraInizio = $_POST ['oraInizio'];
$oraFine = $_POST ['oraFine'];
$titolo = $_POST ['titolo'];
$telefono = $_POST ['telefono'];
$descrizione = $_POST ['descrizione'];
$aula = $_POST ['aula'];
echo "aula" . $aula . "<br>";

if ((! (isset ( $titolo ) && ! empty ( $titolo ) && isset ( $data ) && ! empty ( $data ) && isset ( $aula ) && ! empty ( $aula ))) || ($oraInizio >= $oraFine)) {
	echo "<p>Errore nell'inserimento dei dati</p>";
} else {
	try {
		// seleziono tutte le pretoazioni dell'aula con $codice di $giorno
		$statment = $db->prepare ( 'SELECT * FROM (aula join prenotazione on Aula.codice=Prenotazione.CodiceAula) where Aula.Codice= :codice and Data= :giorno' );
		$statment->bindParam ( ':codice', $aula );
		$statment->bindParam ( ':giorno', $data );
		$statment->execute ();
		$result = $statment->fetchAll ();
		$arrayOra = creaArray ( $result );
		
		$result = true;
		/**
		 * controllo se l'aula è libera per l'ora richiesta
		 */
		$pieces = explode ( ".", $oraInizio );
		if ($pieces [1] == '00') {
			$i = $oraInizio * 2;
		} else {
			$i = $oraInizio * 2 + 1;
		}
		$pieces = explode ( ".", $oraFine );
		if ($pieces [1] == '00') {
			$fine = $oraFine * 2;
		} else {
			$fine = $oraFine * 2 + 1;
		}
		for(; $i <= $fine; $i ++) {
			if ($arrayOra [$i] ==1)
				$result = false;
		}
		
		/**
		 * se l'orario è disponibile viene inserita la prenotazione
		 */
		if ($result) {
			$sth = $db->prepare ( "INSERT INTO Prenotazione (Data,OraInizio,OraFine,Descrizione,Titolo,Telefono,CodiceUtente,CodiceAula) values (:data, :oraInizio, :oraFine, :descrizione, :titolo, :telefono, :codiceUtente, :codiceAula)" );
			
			$sth->bindParam ( ':data', $data );
			$sth->bindParam ( ':oraInizio', $oraInizio );
			$sth->bindParam ( ':oraFine', $oraFine );
			$sth->bindParam ( ':descrizione', $descrizione );
			$sth->bindParam ( ':titolo', $titolo );
			$sth->bindParam ( ':telefono', $telefono );
			$codiceUtente = '1';
			$sth->bindParam ( ':codiceUtente', $codiceUtente );
			$sth->bindParam ( ':codiceAula', $aula );
			$sth->execute ();
			
			echo "<p> dati inseriti </p>";
		}else{
			
			echo "<p>Aula occupata</p>";
		}
	} catch ( Exception $e ) {
		echo "Errore nel salvataggio dei dati";
	}
}

/**
 * crea un array con selezionate le ore occuppate
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
				if ($i + 1 <= $oraFine) {
					$array [$i * 2] = 1;
					$array [$i * 2 + 1] = 1;
				} else {
					$pieces = explode ( ".", $oraFine );
					if ($pieces [1] == '30') {
						$array [$i * 2] = 1;
					}
				}
			}
		}
	}
	
	return $array;
}

?>