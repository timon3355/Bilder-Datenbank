<?php
require_once '../repository/UserRepository.php';
class LoginController {
	/*
	 * Funktion um sich einzuloggen.
	 */
	public function index() {
		$userRepo = new UserRepository ();
		
		$password = $_POST ['passwort'];
		$name = $_POST ['benutzername'];
		
		// Hier wird überprüft ob das Login Valid ist.
		
		$message = null;
		$result = $userRepo->isValidLogin ( $name, $password );
		if ($result == false) {
			$message = 'Benutzername oder Passwort inkorrekt';
			$view = new View ( 'login' );
			$view->message = $message;
			$view->title = 'Login';
			$view->display ();
		} else {
			
			// Hier wird die Session gestartet und ihr werden noch sachen mitgegeben die später wieder abgerufen werden können
			
			$_SESSION ['loggedin'] = true;
			$_SESSION ['name'] = $_POST ['benutzername'];
			$_SESSION ['passwort'] = $_POST ['passwort'];
			$_SESSION ['id'] = $result->id;
			$_SESSION ['email'] = $result->email;
			header ( "Location: /file/myFile" );
		}
	}
	/*
	 * Funktion um sich auszuloggen
	 */
	public function destroy() {
		session_unset ( $_SESSION );
		session_destroy ();
		
		header ( "Location: /user" );
	}
	/*
	 * Funktion um sich zu registrieren
	 */
	public function register() {
		$userRepo = new UserRepository ();
		$result = $userRepo->readAll ();
		
		$email = $_POST ['email'];
		$benutzername = $_POST ['benutzername'];
		$passwort1 = $_POST ['passwort1'];
		$passwort2 = $_POST ['passwort2'];
		
		/**
		 * *
		 * Hier werden die eingegeben Daten überprüft ob sie verwendet werden können,
		 * wenn nein wird eine Fehlermeldung erscheinen.
		 */
		$regexBenutzername = preg_match ( '/^[A-Za-z0-9\._%+-]{5,30}$/', $benutzername );
		$regexPasswort = preg_match ( '/^[A-Za-z0-9\._%+-]{6,35}$/', $passwort1 );
		
		$message = null;
		
		if (empty ( $benutzername ) || ! $regexBenutzername) {
			$message = 'Benutzername wurde falsch eingegeben';
		} 

		elseif (empty ( $email ) || ! filter_var ( $email, FILTER_VALIDATE_EMAIL )) {
			$message = 'Email wurde falsch eingegeben';
		} 

		elseif (empty ( $passwort1 ) || empty ( $passwort2 ) || ! $regexPasswort || ! ($passwort1 == $passwort2)) {
			$message = 'Passwörter wurden falsch eingegeben';
		}
		
		if ($message === null) {
			$result = $userRepo->isBenutzerExist ( $benutzername );
			if ($result == false) {
				// BenutzerDaten wrde in die DB eingetragen und die Session eingetrtagen.
				$userRepo->create ( $benutzername, $passwort1, $email );
				$result = $userRepo->isValidLogin ( $benutzername, $passwort1 );
				$_SESSION ['loggedin'] = true;
				$_SESSION ['name'] = $benutzername;
				$_SESSION ['passwort'] = $passwort1;
				$_SESSION ['id'] = $result->id;
				$_SESSION ['email'] = $email;
				
				header ( 'Location: /file/myFile' );
			} else {
				$message = "Benutzer schon vergeben";
				$view = new View ( 'register' );
				$view->title = 'Registrieren';
				$view->message = $message;
				$view->display ();
			}
		} else {
			
			$view = new View ( 'register' );
			$view->title = 'Registrieren';
			$view->message = $message;
			$view->display ();
		}
	}
}
			
			
