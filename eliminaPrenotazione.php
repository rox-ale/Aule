<?php
/**
 * elimina una prenotazione
 * 
 * @var Ambiguous $id*/

$id=($_GET['Codice']);

$db = new PDO ( 'sqlite:noiMarano_PDO.sqlite' );

 $db->exec ( "
 delete from prenotazione where codice=$id;
 " );

?>