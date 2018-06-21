<?php
require_once '../lib/Repository.php';
class FileRepository extends Repository {
	protected $tableName = 'datei';
	public function upload($name, $beschreibung, $datum, $groesse, $galerie_id) {
		$query = 'INSERT INTO datei ( beschreibung, name, datum, groesse, galerie_id) VALUES (?, ?, ?, ?,?)';

		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'sssii',  $beschreibung, $name, $datum, $groesse, $galerie_id );
		
		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}
    public function changeImage( $name, $beschreibung, $id){
        $query = 'UPDATE datei set name = ?, beschreibung = ? where id = ?';
        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 'ssi', $name, $beschreibung, $id );

        if (! $statement->execute ()) {
            throw new Exception ( $statement->error );
        }
    }
	public function deleteByID($id){
	    $query = 'DELETE FROM datei where id = ?';
        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param("i",$id);
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
	/*
	 * Aufgrund verschiedener information genau auf die Datei Schliessen.
	 */
	public function clearId($name, $beschreibung, $today, $size) {
		$query = 'select id from datei where name = ? and beschreibung = ? and datum = ?  and groesse = ? ';
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'sssi', $name, $beschreibung, $today,$size);
		
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
	public function getImageByGalerieId($galerieId){

	    $query= 'select * from datei where galerie_id = ?';
        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 'i', $galerieId );
        $statement->execute();
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
	
	

	
	
	
