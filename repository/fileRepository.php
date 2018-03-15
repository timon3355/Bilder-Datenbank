<?php
require_once '../lib/Repository.php';
class FileRepository extends Repository {
	protected $tableName = 'datei';
	public function upload($name, $beschreibung, $datum, $oeffentlich, $groesse, $id) {
		$query = "INSERT INTO $this->tableName (dateiname, beschreibung, datum, oeffentlich, groesse,benutzer_id) VALUES (?, ?, ?, ?, ?, ?)";
		
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'sssiii', $name, $beschreibung, $datum, $oeffentlich, $groesse, $id );
		
		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}
	public function search($name) {
		$query = "SELECT * FROM {$this->tableName} where oeffentlich = 1 and dateiname = ? LIMIT 15";
		
		// Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
		// und die Parameter "binden"
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 's', $name );
		// Das Statement absetzen
		$statement->execute ();
		
		// Resultat der Abfrage holen
		$result = $statement->get_result ();
		if (! $result) {
			throw new Exception ( $statement->error );
		}
		
		// Ersten Datensatz aus dem Resultat holen
		$rows = array ();
		while ( $row = $result->fetch_object () ) {
			$rows [] = $row;
		}
		
		// Datenbankressourcen wieder freigeben
		$result->close ();
		
		// Den gefundenen Datensatz zurückgeben
		return $rows;
	}
	public function myFiles() {
		$query = "select * from datei where benutzer_id = ?";
		
		// Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
		// und die Parameter "binden"
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'i', $_SESSION ['id'] );
		// Das Statement absetzen
		$statement->execute ();
		
		// Resultat der Abfrage holen
		$result = $statement->get_result ();
		if (! $result) {
			throw new Exception ( $statement->error );
		}
		
		// Ersten Datensatz aus dem Resultat holen
		$rows = array ();
		while ( $row = $result->fetch_object () ) {
			$rows [] = $row;
		}
		
		// Datenbankressourcen wieder freigeben
		$result->close ();
		
		// Den gefundenen Datensatz zurückgeben
		return $rows;
	}
	/*
	 * Aufgrund verschiedener information genau auf die Datei Schliessen.
	 */
	public function clearId($name, $beschreibung, $today, $public, $size, $id) {
		$query = 'select id from datei where dateiname = ? and beschreibung = ? and datum = ? and oeffentlich = ? and groesse = ? and benutzer_id = ?';
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'sssiii', $name, $beschreibung, $today, $public, $size, $id );
		
		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
		
		$result = $statement->get_result ();
		if (! $result) {
			throw new Exception ( $statement->error );
		}
		
		if ($result->num_rows == 1) {
			return $result->fetch_object ();
		} else {
			return false;
		}
	}
}
	
	

	
	
	