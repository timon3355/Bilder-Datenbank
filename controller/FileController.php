<?php
class FileController {
	/**
	 * Es werden die 15 erten dateien die in der DB sind geladen.
	 */
	public function index() {
		require_once '../repository/FileRepository.php';
		$fileRepo = new fileRepository ();
		$result = $fileRepo->allLimit15 ();
		
		$view = new View ( 'search' );
		$view->title = 'Suchen';
		$view->result = $result;
		$view->display ();
	}
	public function uploadsite() {
		$view = new View ( 'upload' );
		$view->title = 'Datei hochladen';
		$view->display ();
	}
	public function myFile() {
		$view = new View ( 'myFiles' );
		$view->title = 'Meine Dateien';
		$view->display ();
	}
	/*
	 * Es wird nach einer Datei gesucht mit dem Gleichen Namen wie der Suchbegriff.
	 */
	public function search() {
		$filename = $_GET ["filename"];
		require_once '../repository/FileRepository.php';
		$fileRepo = new FileRepository ();
		$result = $fileRepo->search ( $filename );
		$message = null;
		if (! $result) {
			$message = 'Keine Dateien gefunden';
		}
		
		$view = new View ( 'search' );
		$view->title = 'Suchen';
		$view->message = $message;
		$view->result = $result;
		$view->display ();
	}
	
	/*
	 * Ein eindeutiger dateiname wird aus der ID in der DB und der Dateiendung erstellt
	 */
	public function dateiname($id, $ende) {
		$temp = explode ( ".", $ende );
		$newFileName = $id . '.' . end ( $temp );
		
		return $newFileName;
	}
	/*
	 * Mit Hilfe der id in der DB und dem Dateinamen mit der Endung,
	 * wird die Datei aus der DB& dem Verzeichnis gelöscht.
	 */
	public function delete() {
		require_once '../repository/FileRepository.php';
		$id = $_GET ['id'];
		$ende = $_GET ['end'];
		
		$Repo = new FileRepository ();
		$Repo->deleteById ( $id );
		
		$temp = explode ( ".", $ende );
		$newFileName = $id . '.' . end ( $temp );
		
		unlink ( "../public/files/$newFileName" );
		
		header ( 'Location: /file/myFile' );
	}
	/*
	 * um von byte zu Megabyte zu kommen.
	 */
	public function devidedBy($size) {
		return ($size / 1000000);
	}
	/*
	 * Eintrag in DB wird erstellt, datei in "files"-Verzeichnis verschoben.
	 */
	public function upload() {
		require_once '../repository/FileRepository.php';
		$fileRepo = new FileRepository ();
		// testen ob die Datei für jeden öffentlich sein soll.
		if (isset ( $_POST ['public'] )) {
			$public = 1;
		} else {
			$public = 0;
		}
		$time = time ();
		// Zeit zone setzen
		date_default_timezone_set ( 'Europe/Zurich' );
		// heutiges Datum
		$today = date ( 'd/m/Y' );
		// testen ob ein Datei zum hochladen ausgewählt ist.
		if (! file_exists ( $_FILES ['userfile'] ['tmp_name'] ) || ! is_uploaded_file ( $_FILES ['userfile'] ['tmp_name'] )) {
			$message = 'Sie müssen eine Datei zum hochladen auswählen.';
			$view = new View ( 'upload' );
			$view->title = 'Datei hochladen';
			$view->message = $message;
			$view->display ();
		} else {
			$id = $_SESSION ['id'];
			$size = $_FILES ['userfile'] ['size'];
			
			$name = $_FILES ['userfile'] ['name'];
			// testen ob Namen der Datei valid ist.
			$regexName = preg_match ( '/^[A-Za-z0-9-?\_%+.]{2,50}$/', $name );
			
			// mache eintrag in DB, verschiebe Datei von temporären verzeichnis.
			if ($regexName) {
				$path = getcwd() . "/files/";
				try {
					$tmpName = $_FILES ['userfile'] ['tmp_name'];
					$beschreibung = $_POST ['beschreibung'];
					$fileRepo->upload ( $name, $beschreibung, $today, $public, $size, $id );
					$result = $fileRepo->clearId ( $name, $beschreibung, $today, $public, $size, $id );
					// mache aus dem Dateiname und id in DB einen "eindeutigen-einmahligen" Namen.
					$temp = explode ( ".", $_FILES ["userfile"] ["name"] );
					$newfilename = $result->id . '.' . end ( $temp );

					move_uploaded_file ( $tmpName, $path . $newfilename );
				} catch(Exception $e) {
					print_r($e);
					die();
				}
				// wechsle Seite.
				header ( 'Location:/file/myFile' );
			} else {
				// gib fehler Meldung aus.
				$message = 'Dieser Dateiname ist ungültig';
				$view = new View ( 'upload' );
				$view->title = 'Datei hochladen';
				$view->message = $message;
				$view->display ();
			}
		}
	}
}