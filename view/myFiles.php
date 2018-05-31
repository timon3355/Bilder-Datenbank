<?php
if ((isset ( $_SESSION ['loggedin'] ))) {
	if ($_SESSION ['loggedin']) {
	}
} else {
	$view = new View ( 'login' );
	$view->title = 'Login';
	$view->display ();
	die ();
}

?>

<div id="container-usual">
	<h1>Meine Galerien</h1>

	<div class="beschrieb">
		<p>Wenn sie schon galerien erstellt haben .</p>

	</div>
    <div><a href="/File/createGalerie">NEUE GALERIE</a></div>



	<?php
	require_once '../repository/galerieRepository.php';
	require_once '../controller/FileController.php';
	$gRepo = new GalerieRepository ();
	$FileCon = new FileController ();
	$result = $gRepo->myGalerie ();
	if (! $result) {
		$message = 'Keine galerien vorhanden. ';
	}
	if (isset ( $message )) {
		echo "<h3>$message</h3>";
	}



	foreach ( $result as $row ) {
		
		echo "<div    >
                <a href='/file/galerie/$row->name'>$row->name</a>
                


</div>";




        }
echo"</div>";