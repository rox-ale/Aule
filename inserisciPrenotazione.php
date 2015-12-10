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
echo "aula".$aula."<br>";

if ((! (isset ( $titolo ) && ! empty ( $titolo ) && isset ( $data ) && ! empty ( $data )&&isset ( $aula ) && ! empty ( $aula ))) || ($oraInizio >= $oraFine)) {
	echo "<p>Errore nell'inserimento dei dati</p>";
} else {
	try {
		
		//PRd4gRZtV80tHsVLxOKfxGUt
		$sth = $db->prepare ( "INSERT INTO Prenotazione (Data,OraInizio,OraFine,Descrizione,Titolo,Telefono,CodiceUtente,CodiceAula) values (:data, :oraInizio, :oraFine, :descrizione, :titolo, :telefono, :codiceUtente, :codiceAula)" );
		
		$sth->bindParam ( ':data', $data );
		$sth->bindParam ( ':oraInizio', $oraInizio );
		$sth->bindParam ( ':oraFine', $oraFine );
		$sth->bindParam ( ':descrizione', $descrizione );
		$sth->bindParam ( ':titolo', $titolo );
		$sth->bindParam ( ':telefono', $telefono );
		$codiceUtente='1';
		$sth->bindParam ( ':codiceUtente', $codiceUtente );
		$sth->bindParam ( ':codiceAula', $aula );
		$sth->execute ();
		
		echo "<p> dati inseriti </p>";
	} catch ( Exception $e ) {
		echo "Errore nel salvataggio dei dati";
	}
}
?>