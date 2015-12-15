<?php
/**
 * visualizza una prenotazione
 * da sistemare
 * 
 */
$id = ($_GET ['Codice']);

$db = new PDO ( 'sqlite:noiMarano_PDO.sqlite' );

$statment = $db->prepare ( 'SELECT A.Nome as NomeAula, P.Titolo as Titolo, P.Descrizione as Descrizione, P.Data as Data, P.OraInizio as OraInizio, P.OraFine as OraFine,P.Telefono as Telefono, U.Nome as NomeUtente, U.Cognome as CognomeUtente FROM ((aula as A join prenotazione as P on Aula.codice=Prenotazione.CodiceAula) join utente as U on utente.Codice=Prenotazione.CodiceUtente) where prenotazione.Codice= :codice' );
$statment->bindParam ( ':codice', $id );

$statment->execute ();
$row = $statment->fetchObject ();

echo ($row->NomeAula) . "<br>";
echo ($row->Titolo) . "<br>";
echo ($row->Descrizione) . "<br>";
echo ($row->Data) . "<br>";
echo ($row->OraInizio) . "<br>";
echo ($row->OraFine) . "<br>";
echo ($row->Telefono) . "<br>";
echo ($row->NomeUtente) . "<br>";
echo ($row->CognomeUtente) . "<br>";

?>