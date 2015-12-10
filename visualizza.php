<?php

/***
 * 
 * visualizza le aule
 * gli utenti
 * e prenotazioni
 */
try {
	// open the database
	$db = new PDO ( 'sqlite:noiMarano_PDO.sqlite' );
	print "<table border=1>";
	print "<tr><td>Codice</td><td>Nome</td><td>Descrizione</td></tr>";
	$result = $db->query ( 'SELECT * FROM Aula' );
	foreach ( $result as $row ) {
		print "<tr><td>" . $row ['Codice'] . "</td>";
		print "<td>" . $row ['Nome'] . "</td>";
		// print "<td>".$row['descrizione']."</td>";
		print "<td>" . $row ['Descrizione'] . "</td></tr>";
	}
	print "</table>";
	
	print "<table border=1>";
	print "<tr><td>Codice</td><td>Nome</td><td>Cognome</td>><td>Nickname</td>><td>password</td></tr>";
	$result = $db->query ( 'SELECT * FROM utente' );
	foreach ( $result as $row ) {
		print "<tr><td>" . $row ['Codice'] . "</td>";
		print "<td>" . $row ['Nome'] . "</td>";
		print "<td>" . $row ['Cognome'] . "</td>";
		print "<td>" . $row ['Nickname'] . "</td>";
		print "<td>" . $row ['Password'] . "</td></tr>";
	}
	print "</table>";
	
	
	
	
	
	print "<table border=1>";
	//print "<tr><td>Codice</td><td>Nome</td><td>Cognome</td>><td>Nickname</td>><td>password</td></tr>";
	$result = $db->query ( 'SELECT * FROM Prenotazione' );
	foreach ( $result as $row ) {
		print "<tr><td>" . $row ['Codice'] . "</td>";
		print "<td>" . $row ['Data'] . "</td>";
		print "<td>" . $row ['OraInizio'] . "</td>";
		print "<td>" . $row ['OraFine'] . "</td>";
		print "<td>" . $row ['Titolo'] . "</td>";
		print "<td>" . $row ['CodiceAula'] . "</td>";
		print "<td>" . $row ['Telefono'] . "</td></tr>";
	}
	print "</table>";
	
	
	// close the database connection
	$db = NULL;
} catch ( PDOException $e ) {
	print 'Exception : ' . $e->getMessage ();
}
?>