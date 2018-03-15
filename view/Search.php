
<div id="container-usual">
	<div class="titel">
		<h1>Suche</h1>
	</div>

	<div class="search">
		<form action="/File/search" method="GET">
			<div class="col-sm-3">
				<input type="text" name="filename" class="form-control"
					placeholder="Search">

			</div>
			<div class="col-sm-9">
				<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
				</button>

			</div>

		</form>
	</div>

	<div class="beschrieb">
		<p>Hier können Sie nach verschiedenen Dateien und Files suchen. Geben
			Sie ihre Suche ein und bestätigen sie den Suchen button. Jetzt werden
			die gesuchten Files in einer Liste ausgelesen und Sie können ihr
			gewünschtes herunterladen</p>

	</div>
	

<?php
require_once '../controller/FileController.php';
$FileCon = new FileController ();

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
					</tr>
				</thead>
			<tbody>';

foreach ( $result as $row ) {
	
	$endName = $FileCon->dateiname ( $row->id, $row->dateiname );
	$size = $FileCon->devidedBy ( $row->groesse );
	
	echo "	<tr>	<td>$row->dateiname</td>
						<td class='beschreibung-lenght'>$row->beschreibung</td>
						<td>$row->datum</td>
						<td>$size</td>
						<td><a class='btn btn-default' href='/files/$endName'>Download</a></td>
				</tr>";
}

echo '	</tbody>
		</table>';

?>
	
</div>
