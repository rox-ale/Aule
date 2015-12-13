<!-- 
	grafica per creare una prenotazione cadenziata
 -->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="CalendarControl.css" rel="stylesheet" type="text/css">
	<script src="CalendarControl.js" language="javascript"></script>

<title>Inserisci cadenziata</title>
</head>
<body>


	<div class="form">
		<fieldset>
			<form action="inserisciPrenotazioneMultipla.php" method="post" name="formData">
				<label for="titolo">Titolo</label> <span class="required">*</span>
				 <input	type="text" size="50" id="titolo" name="titolo"><br> 
					<label
						for="descrizione">Descrizione</label> </span><br> <textarea
								rows="4" cols="50" id="descrizione" name="descrizione"></textarea><br></br>
							
							
							<label for="giorno"></label>
							<input type ="radio" name="giorno" value="1" checked>Lunedi</input>
							<input type ="radio" name="giorno" value="2">Martedi</input>
							<input type ="radio" name="giorno" value="3">Mercoledi</input>
							<input type ="radio" name="giorno" value="4">Giovedi</input>
							<input type ="radio" name="giorno" value="5">Venerdi</input>
							<input type ="radio" name="giorno" value="6">Sabato</input>
							<input type ="radio" name="giorno" value="0">Domenica</input>

 							<label for="data"><br></br>DataTermine:</label>
									<span class="required">*</span> <input name="termine"
									onfocus="showCalendarControl(this);" type="text" id="data" /> <br>
						<label for="aula"></br><br>Aula</br> </label> 
						<?php
						$db = new PDO ( 'sqlite:noiMarano_PDO.sqlite' );
						$sql = 'SELECT * FROM Aula';
						
						foreach ( $db->query ( $sql ) as $row ) {
							
							$id = $row ['Codice'];
							$nome = $row ['Nome'];
							echo '<input type="radio" name="aula" checked value="' . $id . '">' . $nome . '</><br>';
						}
						?>
						</br> 
						
						<label for="oraInizio">Ora Inizio </label> <select
									name="oraInizio" id="oraInizio">
						<?php
						
						for($i = 7; $i < 24; $i ++) {
							
							echo '<option value="' . $i . '.00">' . $i . '.00</option>';
							echo '<option value="' . $i . '.30' . '">' . $i . '.30' . '</option>';
						}
						?></select> </br> <label for="oraFine">Ora Fine </label> <select
								name="oraFine" id="oraFine">
						<?php
						
						for($i = 7; $i < 24; $i ++) {
							
							echo '<option value="' . $i . '.00">' . $i . '.00</option>';
							echo '<option value="' . $i . '.30' . '">' . $i . '.30' . '</option>';
						}
						echo '<option value="' . '24' . '">' . '24' . '</option>';
						?></select></br> <input type="submit" value="Inserisci">
			
			</form>
		</fieldset>
	</div>
</body>
</html>
