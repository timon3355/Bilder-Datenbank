<?php
if ((isset ( $_SESSION ['loggedin'] ))) {
	if ($_SESSION ['loggedin']) {
	}
} else {
	$view = new View ( 'login' );
	$view->title = 'Login';
	$view->display ();
	die ();
}
?>
<div id="container-usual">
	<div class="titel-upload">
		<h1>Hochladen</h1>
	</div>
	<p>Laden Sie hier ihre eigenen Dateien hoch. Wählen Sie die Datei aus,
		schreiben Sie eine Beschreibung dazu und wählen Sie ob die Datei
		öffentlich (also für alle Personen sichtbar) oder nicht ist. Danach
		drücken Sie auf den Upload Button und Ihre Datei ist jetzt unter Meine
		Dateien zu finden.</p>
	<div class="upload">
		<form class="form-horizontal" enctype="multipart/form-data" action="/file/upload" method="POST">
			<div class="datei-select">
				<div class="fehlermeldung">
					<?php
					if (isset ( $message )) {
						echo "<h3>$message</h3>";
					}
					?>
				</div>
				<div class="form-group">
					<input type="file" name="userfile" id="exampleInputFile">
				</div>

			</div>
			<div>
				<div class="links">
					<textarea name="beschreibung" class="textfeld" rows="4" cols="50"
						maxlength="200" placeholder="Deine Beschreibung"></textarea>
				</div>
				<div class="rechts">
					<input name="public" type="checkbox" value="true"> public
				</div>



			</div>
			<!-- 
		<div class="freigabe">

				<div class="form-group">
					<input type="text" class="form-control" id="freigabe"
						placeholder="Freigabe fuer-> Work in Progress">
				</div>
				<button type="submit" class="btn btn-default">Bestaetigen</button>

		</div>
		
		 -->
			<div>
				<div class="upload">
					<button type="submit" class="btn btn-default" value="Send File">Upload</button>
				</div>
			</div>
		</form>
	</div>



</div>