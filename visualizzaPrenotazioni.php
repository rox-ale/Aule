<?php

/**
 * 
 * visualizza tutte le prenotazioni effettuate e da la possibilità di eliminarle
 */
$db = new PDO ( 'sqlite:noiMarano_PDO.sqlite' );

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


	echo "<td> <a href=eliminaPrenotazione.php?Codice=".$row['Codice'].">Elimina</a>";
	echo "<td> <a href=visualizzaPrenotazione.php?Codice=".$row['Codice'].">Visualizza</a>";
	print "<td>" . $row ['Telefono'] . "</td></tr>";
}
print "</table>";

?>