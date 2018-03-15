<?php
require_once 'ConnectionHandler.php';
class Repository {
	protected $tableName = 'benutzer';
	public function allLimit15() {
		$query = "SELECT * FROM {$this->tableName} where oeffentlich = 1 LIMIT 15";
		
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		// Das Statement absetzen
		$statement->execute ();
		
		// Resultat der Abfrage holen
		$result = $statement->get_result ();
		if (! $result) {
			throw new Exception ( $statement->error );
		}
		
		$rows = array ();
		while ( $row = $result->fetch_object () ) {
			$rows [] = $row;
		}
		
		// Datenbankressourcen wieder freigeben
		$result->close ();
		
		// Den gefundenen Datensatz zurückgeben
		return $rows;
	}
	public function readById($id) {
		// Query erstellen
		$query = "SELECT * FROM {$this->tableName} WHERE id=?";
		
		// Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
		// und die Parameter "binden"
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'i', $id );
		
		// Das Statement absetzen
		$statement->execute ();
		
		// Resultat der Abfrage holen
		$result = $statement->get_result ();
		if (! $result) {
			throw new Exception ( $statement->error );
		}
		
		// Ersten Datensatz aus dem Reultat holen
		$row = $result->fetch_object ();
		
		// Datenbankressourcen wieder freigeben
		$result->close ();
		
		// Den gefundenen Datensatz zurückgeben
		return $row;
	}
	public function deleteById($id) {
		$query = "DELETE FROM {$this->tableName} WHERE id = ?";
		
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'i', $id );
		
		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}
	public function readAll() {
		// Query erstellen
		$query = "SELECT * FROM {$this->tableName}";
		
		// Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
		// und die Parameter "binden"
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		
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
}