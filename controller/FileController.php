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
    public function createGalerie() {
        $view = new View ( 'createGalerie' );
        $view->title = 'Galerie erstellen';
        $view->display ();
    }
    public function galerie($name) {
        require_once '../repository/galerieRepository.php';
        $gRepo = new GalerieRepository();
	    $result = $gRepo->getGalerieById($gRepo->getGalerieIdByName(urldecode($name))[0]->id);

	    $view = new View ( 'Galerie' );
        $view->message = $result;
        $view->title = 'Galerie verändern';
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
	public function changeImage(){
        require_once '../repository/FileRepository.php';
        $endName = $_POST['id'];
        $Repo = new FileRepository ();
        $id = explode(".",$endName)[0];
        $endung = explode(".",$endName)[1];
        $Repo->changeImage($_POST['titel'].".".$endung, $_POST['beschreibung'],$id );


        header ( "Location: /file/galerie/".$_SESSION['activeGalerie']);




    }
    public function deleteGalerie(){
        require_once '../repository/FileRepository.php';
        require_once '../repository/galerieRepository.php';
        $Repo = new FileRepository ();
        $gRepo = new GalerieRepository();
        $bilder = $Repo->getImageByGalerieId($_SESSION['activeGalerieId']);



        foreach ( $bilder as $row ){

            $endung = explode(".",$row->name)[1];
            $Repo->deleteByID($row->id);
            unlink("../public/files/".$row->id.".".$endung);
            unlink("../public/thumbnails/".$row->id.".".$endung);
        }
        $gRepo->deleteById($_SESSION['activeGalerieId']);
        header ( "Location: /file/myFile");
    }
	public function delete() {
		require_once '../repository/FileRepository.php';
		$endName = $_POST['id'];
		$Repo = new FileRepository ();
        var_dump($endName);
		$id = explode(".",$endName)[0];
		$Repo->deleteByID( $id );
		

		
		unlink ( "../public/files/".$endName );
        unlink ( "../public/thumbnails/".$endName );

        header ( "Location: /file/galerie/".$_SESSION['activeGalerie']);
	/*
	 * um von byte zu Megabyte zu kommen.
	 */}
	public function devidedBy($size) {
		return ($size / 1000000);
	}
	/*
	 * Eintrag in DB wird erstellt, datei in "files"-Verzeichnis verschoben.
	 */

    public function newGalerie(){
        require_once '../repository/galerieRepository.php';
        $gRepo = new GalerieRepository ();
        // TESTEN OB ES GALERIE SCHON GIBT!!!!!!!!
        $name=$_POST['name'];
        $beschreibung=$_POST['beschreibung'];
        $benutzer_id=$_SESSION['id'];

        date_default_timezone_set ( 'Europe/Zurich' );
        // heutiges Datum

        $today = date ( 'Y-m-d' );

        $gRepo->createGalerie($name, $benutzer_id, $beschreibung, $today, "");


        header ( 'Location:/file/myFile' );
    }

	//WEITERMACHEN
    public function updateGalerie($id){
        require_once '../repository/FileRepository.php';
        require_once '../repository/galerieRepository.php';
        $fileRepo = new FileRepository ();
        $gRepo = new GalerieRepository();
        $name =$_POST['galerieName'];
        $beschreibung = $_POST['beschreibung'];
        $beschreibungOld = $_POST['beschreibungOld'];
        $galerieNameOld = $_POST['galerieNameOld'];

        if($name==""){
            $name = $galerieNameOld;
        }
        if($beschreibung==""){
            $beschreibung = $beschreibungOld;
        }
        $gRepo->updateGalerie($name,$beschreibung, $id);


        header ( "Location: /file/galerie/".$name );




    }
	public function upload() {
		require_once '../repository/FileRepository.php';
		require_once '../repository/galerieRepository.php';
		$fileRepo = new FileRepository ();
        $gRepo = new GalerieRepository();
		$time = time ();
		// Zeit zone setzen

		date_default_timezone_set ( 'Europe/Zurich' );
		// heutiges Datum

		$today = date ( 'Y-m-d' );



		// testen ob ein Datei zum hochladen ausgewählt ist.
		if (! file_exists ( $_FILES ['userfile'] ['tmp_name'] ) || ! is_uploaded_file ( $_FILES ['userfile'] ['tmp_name'] )) {
			$message = $_POST['galerieName'];

			$view = new View ( 'Galerie' );
			$view->title = 'galerie X';
			$view->message = $message;
			$view->display ();
		}

		else {
			$galerieId = $gRepo->getGalerieIdByName($_POST['galerieName'])[0]->id;// galerie id
			$size = $_FILES ['userfile'] ['size'];

			$name = $_FILES ['userfile'] ['name'];
			// testen ob Namen der Datei valid ist.
			$regexName = preg_match ( '/^[A-Za-z0-9-?\_%+.]{2,50}$/', $name );
			
			// mache eintrag in DB, verschiebe Datei von temporären verzeichnis.
			if ($regexName) {
				$path = "files/";
				try {


                    $tmpName = $_FILES ['userfile'] ['tmp_name'];
					$beschreibung = $_POST ['beschreibung'];
					$fileRepo->upload ( $name, $beschreibung, $today, $size, $galerieId );  //dateipfad, beschreibung, datum, groesse,galerie_id, schlüssel

					$result = $fileRepo->clearId ( $name, $beschreibung, $today, $size );


					// mache aus dem Dateiname und id in DB einen "eindeutigen-einmahligen" Namen.
					$temp = explode ( ".", $_FILES ["userfile"] ["name"] );
					$newfilename = $result->id . '.' . end ( $temp );
               
					move_uploaded_file ( $tmpName, $path . $newfilename );




                    //MACHE THUMMBNAIL
                    $thumbsize = 192;
                    list($width, $height) = getimagesize("files/".$newfilename);
                    $imgratio=$width/$height;

                    //Ist das Bild höher als breit?
                    if($imgratio>1)
                    {
                        $newwidth = $thumbsize;
                        $newheight = $thumbsize/$imgratio;
                    }
                    else
                    {
                        $newheight = $thumbsize;
                        $newwidth = $thumbsize*$imgratio;
                    }


                    $thumb = imagecreate($newwidth,$newheight);
                    $src = imagecreatefromjpeg("files/".$newfilename);

                    imagecopyresized($thumb, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                    if($newfilename.explode(".")[1] == ".png")
                        imagepng($thumb,"thumbnails/".$newfilename);
                    else
                        imagejpeg($thumb,"thumbnails/".$newfilename,100);
                    ImageDestroy($thumb);




                } catch(Exception $e) {
					print_r($e);
					die();
				}
				// wechsle Seite.
                header ( "Location: /file/galerie/".$_POST['galerieName'] );
				/*
                require_once 'FileController.php';
				$fileCon = new FileController();
				$fileCon->galerie($_POST['galerieName']);
			*/} else {
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