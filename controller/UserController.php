<?php
require_once '../repository/UserRepository.php';
class userController {
	public function index() {
		$view = new View ('login');
		$view->title = 'Login';
		$view->display ();
	}
	public function register() {
		$view = new View ( 'register' );
		$view->title = 'Registrieren';
		$view->display ();
	}
	public function profile() {
		$view = new View ( 'profile' );
		$view->title = 'Profil';
		$view->display ();
	}
	/*
	 * Lösche ein Benutzer;
	 */
	public function delete() {
		$id = $_SESSION ['id'];		
		$userRepo = new UserRepository ();
		$userRepo->deleteById ( $id );
		session_unset ( $_SESSION ['name'] );
		session_destroy ();		
		header ( "Location: /user" );
		header ( 'Location:/user' );
	}
	
	/*
	 * Funktion um die Benutzerdaten zu verändern.
	 */
	public function update() {
		$userRepo = new UserRepository ();
		
		$benutzernameold = $_SESSION ['name'];
		
		$email = $_POST ['email2'];
		$benutzername = $_POST ['benutzername2'];
		$passwort1 = $_POST ['passwort4'];
		$passwort2 = $_POST ['passwort5'];
		
		// Hier passiert das gleiche wie im LoginController bei der Funktion register
		
		$regexBenutzername = preg_match ( '/^[A-Za-z0-9\._%+-]{5,30}$/', $benutzername );
		$regexPasswort = preg_match ( '/^[A-Za-z0-9\._%+-]{6,35}$/', $passwort1 );
		
		$message = null;
		
		if (empty ( $benutzername ) || ! $regexBenutzername) {
			$message = 'Benutzername wurde falsch eingegeben';
		}		// FILTER_VALIDATE_EMAIL ist eine spezielle Validierung für eMails
		
		elseif (empty ( $email ) || ! filter_var ( $email, FILTER_VALIDATE_EMAIL )) {
			$message = 'Email wurde falsch eingegeben';
		} 

		elseif (empty ( $passwort1 ) || empty ( $passwort2 ) || ! $regexPasswort || ! ($passwort1 == $passwort2)) {
			$message = 'Passwörter wurden falsch eingegeben';
		}
		
		if ($message === null) {
			$result = $userRepo->isBenutzerExist ( $benutzername );
			
			if ($result == false||$benutzername == $benutzernameold) {
				$update = $userRepo->updateBenutzer ( $benutzername, $passwort1, $email, $benutzernameold );
				$_SESSION ['loggedin'] = true;
				$_SESSION ['name'] = $benutzername;
				$_SESSION ['passwort'] = $passwort1;
				$_SESSION ['email'] = $email;
				header ( 'Location:/user/profile' );
			} else {
				$message = "Benutzer schon vergeben";
				$view = new View ( 'profile' );
				$view->title = 'Profil';
				$view->message = $message;
				$view->display ();
			}
		} else {
			$view = new View ( 'profile' );
			$view->title = 'Profil';
			$view->message = $message;
			$view->display ();
		}
	}
}