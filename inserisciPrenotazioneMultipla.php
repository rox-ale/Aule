<?php

/**
 * sisalvanole prenotazioni multiple
 * */


date_default_timezone_set('UTC');
$db = new PDO ( 'sqlite:noiMarano_PDO.sqlite' );

$termine = $_POST ['termine'];
$oraInizio = $_POST ['oraInizio'];
$oraFine = $_POST ['oraFine'];
$titolo = $_POST ['titolo'];
$descrizione = $_POST ['descrizione'];
$aula = $_POST ['aula'];
$giorno=$_POST['giorno'];



$data= date("d-m-Y");//ottiene la data del giorno
$dividi=explode("-", $data);
$gg=$dividi[0];
$mm=$dividi[1];
$yy=$dividi[2];

$datamktime=mktime(0,0,0,$mm,$gg,$yy);//creola data in modo diverso altrimenti la funzione date rompe
echo $data."<br>";

//dalla data di oggi cerca la prima data utile col giorno della settimana selezionata
while(date("w",$datamktime)!=$giorno){
	$data=date( "d-m-Y", strtotime( "$data +1 day" ) );
	echo $data."<br>";
	$dividi=explode("-", $data);
	$gg=$dividi[0];
	$mm=$dividi[1];
	$yy=$dividi[2];
	
	$datamktime=mktime(0,0,0,$mm,$gg,$yy);
	//echo $data."<br>";
}

/*
 * sistemo la data col / invece che - per poterla salvare sul database
 */
$dividi=explode("-", $data);
$data=$dividi[0]."/".$dividi[1]."/".$dividi[2];

$dividi=explode("/", $data);
// echo "<h1>" . $dividi[0] . "</h1>";
if((strlen($dividi[0]))==1){
	$data="0".$dividi[0]."/".$dividi[1]."/".$dividi[2];
}
echo $data."<br>";
// $data contiene il primo giorno utile per salvarlo sul database a partire dal giorno corrente

// if ((! (isset ( $titolo ) && ! empty ( $titolo )  && isset ( $aula ) && ! empty ( $aula ))) || ($oraInizio >= $oraFine)) {
// 	echo "<p>Errore nell'inserimento dei dati</p>";
// }else{
	
// 	/*
// 	 * inserisco le prenotazioni affinche la data è minore della data termine
// 	 * */
// 	while(datediff("G", $data, $termine)>=0){
// 		//non controllo se c'è già una prenotazione per quell'aula
		
// 		try {

		
			
// 				$sth = $db->prepare ( "INSERT INTO Prenotazione (Data,OraInizio,OraFine,Descrizione,Titolo,Telefono,CodiceUtente,CodiceAula) values (:data, :oraInizio, :oraFine, :descrizione, :titolo, :telefono, :codiceUtente, :codiceAula)" );
					
// 				$sth->bindParam ( ':data', $data );
// 				$sth->bindParam ( ':oraInizio', $oraInizio );
// 				$sth->bindParam ( ':oraFine', $oraFine );
// 				$sth->bindParam ( ':descrizione', $descrizione );
// 				$sth->bindParam ( ':titolo', $titolo );
// 				$sth->bindParam ( ':telefono', $telefono );
// 				$codiceUtente = '1';
// 				$sth->bindParam ( ':codiceUtente', $codiceUtente );
// 				$sth->bindParam ( ':codiceAula', $aula );
// 				$sth->execute ();
					
// 				echo "<p> dati inseriti </p>";
// 				$data=date( "d-m-Y", strtotime( "$data +7 day" ) );
				
		
// 		} catch ( Exception $e ) {
// 			echo "Errore nel salvataggio dei dati";
// 		}		
		
//	}
	
//}

?>


<?php 
/*Creiamo la funzione e prevediamo i parametri che deve accettare; effettuiamo dei calcoli in base al tipo di intervallo scelto, in modo da ricevere il valore numerico richiesto; dividiamo le due date in array di stringa, in funzione del carattere "/", e recuperiamo per entrambe giorno, mese ed anno.

A questo punto creiamo il timestamp della data finale, sottraendo il timestamp di quella di partenza: in partenza abbiamo due stringhe che formano le date che ci interessano, ma al fine di effettuare una sottrazione, dobbiamo disporre di due numeri; ecco che trasformiamo in timestamp le date, opportunamente divise in elementi quali giorno, mese ed anno.

Arrotondiamo quindi il risultato, dividendolo prima in modo da ottenere il numero di giorni, quindi dividendolo per il tipo di intervallo specificato.

Possiamo naturalmente potenziarla con dei controlli che prevedono che il tipo di intervallo non dev'essere diverso diverso da quelli predefiniti e che le date siano passate in formato corretto.

Le convenzioni che useremo per identificare il tipo di intervallo da calcolare sono le seguenti:

A - calcolo differenza in anni.
M - calcolo differenza in mesi.
S - calcolo differenza in settimane.
G - calcolo differenza in giorni.

Entrambe le date, quella di partenza e quella finale, accettano il formato data gg/mm/aaaa.*/
function datediff($tipo, $partenza, $fine)
{
	switch ($tipo)
	{
		case "A" : $tipo = 365;
		break;
		case "M" : $tipo = (365 / 12);
		break;
		case "S" : $tipo = (365 / 52);
		break;
		case "G" : $tipo = 1;
		break;
	}
	$arr_partenza = explode("/", $partenza);
	$partenza_gg = $arr_partenza[0];
	$partenza_mm = $arr_partenza[1];
	$partenza_aa = $arr_partenza[2];
	$arr_fine = explode("/", $fine);
	$fine_gg = $arr_fine[0];
	$fine_mm = $arr_fine[1];
	$fine_aa = $arr_fine[2];
	$date_diff = mktime(12, 0, 0, $fine_mm, $fine_gg, $fine_aa) - mktime(12, 0, 0, $partenza_mm, $partenza_gg, $partenza_aa);
	$date_diff  = floor(($date_diff / 60 / 60 / 24) / $tipo);
	return $date_diff;
}
?>