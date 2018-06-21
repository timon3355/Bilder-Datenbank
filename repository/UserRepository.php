<?php
require_once '../lib/Repository.php';
class UserRepository extends Repository {
	protected $tableName = 'benutzer';
	/*
	 * mache Benutzer.
	 */
	public function create($benutzername, $password, $email) {
		$password = sha1 ( $password );
		
		$query = "INSERT INTO $this->tableName (name, passwort, email) VALUES (?, ?, ?)";
		
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'sss', htmlspecialchars ($benutzername), htmlspecialchars ($password), htmlspecialchars ($email) );
		
		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}
	/*
	 * Testen ob login Daten valid sind.
	 */
	public function isValidLogin($name, $password) {
		$query = "SELECT name, passwort,id, email from $this->tableName where name = ? AND passwort = ?";

		$password = sha1 ( $password );
		
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'ss', $name, $password );
		
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
	/*
	 * Testen ob Benutzer bereits existiert.
	 */
	public function isBenutzerExist($benutzername) {
		$query = "SELECT name, email, id FROM $this->tableName where name = ?";
		
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 's', $benutzername );
		
		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
		$result = $statement->get_result ();
		if ($result->num_rows >= 1) {
			return true;
		} else {
			return false;
		}
	}
	/*
	 * update'e die Daten des Benutzer
	 */
	public function updateBenutzer($benutzername, $password, $email, $benutzernameold) {
		$query = "UPDATE $this->tableName SET name = ?, passwort = ?, email = ? WHERE name = ?";
        $password = sha1 ( $password );
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'ssss', htmlspecialchars ($benutzername), htmlspecialchars ($password), htmlspecialchars ($email), $benutzernameold );
		
		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}



}
	

