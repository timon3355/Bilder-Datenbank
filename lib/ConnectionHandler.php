<?php
class ConnectionHandler {
	private static $connection = null;
	private function __construct() {
		// Privater Konstruktor um die Verwendung von getInstance zu erzwingen.
	}
	public static function getConnection() {
		// Prüfen ob bereits eine Verbindung existiert
		if (self::$connection === null) {
			
			// Konfigurationsdatei auslesen
			$config = require '../config.php';
			$host = $config ['database'] ['host'];
			$username = $config ['database'] ['username'];
			$password = $config ['database'] ['password'];
			$database = $config ['database'] ['database'];
			
			// Verbindung initialisieren
			self::$connection = new MySQLi ( $host, $username, $password, $database );
			if (self::$connection->connect_error) {
				$error = self::$connection->connect_error;
				throw new Exception ( "Verbindungsfehler: $error" );
			}
			
			self::$connection->set_charset ( 'utf8' );
		}
		
		// Verbindung zurückgeben
		return self::$connection;
	}
}