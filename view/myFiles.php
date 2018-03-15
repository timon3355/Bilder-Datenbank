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
	<h1>Meine Dateien</h1>

	<div class="beschrieb">
		<p>Wenn sie schon Dateien und Files hochgeladen haben können Sie hier
			ihre eigenen wieder Herunterladen. Drücken Sie auf den Download
			Button und wählen sie aus wo Sie ihre Datei speichern wollen.</p>

	</div>
	
	<?php
	require_once '../repository/FileRepository.php';
	require_once '../controller/FileController.php';
	$fileRepo = new FileRepository ();
	$FileCon = new FileController ();
	$result = $fileRepo->myFiles ();
	if (! $result) {
		$message = 'Keine Datei vorhanden. Laden Sie Dateien unter Datei hochladen hoch!';
	}
	if (isset ( $message )) {
		echo "<h3>$message</h3>";
	}
	
	echo '<table class="table table-hover">
				<thead>
					<tr>
						<th>Dateiname</th>
						<th>Beschreibung</th>
						<th>Datum</th>
						<th>Size(MB)</th>
						<th>Download</th>
						<th>löschen</th>
					</tr>
				</thead>
			<tbody>';

	foreach ( $result as $row ) {
		
		$EndName = $FileCon->dateiname ( $row->id, $row->dateiname );
		
		/**
		 * Hier wird jedes einzelne Ergebnis in die Tabelle eingefügt
		 */
		$size = $FileCon->devidedBy ( $row->groesse );
		
		$dateiname = $row->id;

		echo "	<tr>	<td>$row->dateiname</td>
						<td class='beschreibung-lenght'>$row->beschreibung</td>
						<td>$row->datum</td>
						<td>$size</td>
						<td><a class='btn btn-default' href='/files/$EndName'>Download</a></td>
						<td><a class='btn btn-default' href='/file/delete?id=$dateiname&end=$EndName'>löschen</a></td>
				</tr>";
	}
	
	echo '	</tbody>
		</table>';
	
	?>
</div>