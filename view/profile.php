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

	<div class="row titel">
		<h1>Profil</h1>

	</div>
	<div class="profil-daten row">

		<div class="form-group">
			<label for="benutzername" class="col-sm-5 control-label">Benutzername</label>
			<label for="benutzername" class="col-sm-3 control-label"><?php echo $_SESSION ['name']; ?></label>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-5 control-label">Passwort</label>
			<label for="inputPassword3" class="col-sm-3 control-label"><?php echo $_SESSION ['passwort']; ?></label>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-5 control-label">E-mail</label>
			<label for="inputPassword3" class="col-sm-3 control-label"><?php echo $_SESSION ['email']; ?></label>
		</div>
	</div>


	<div class="row">
		<div class="col-sm-12 profil-löschen">
			<a class="btn btn-default" href="/User/delete">Profil löschen</a>
		</div>

	</div>

	<div class="row">
		<div class="col-sm-12 new-register">
			<div class="fehlermeldung">
				<!-- Bei einer Fehlermeldunt durch die PHP-Validierung wird hier die message geschrieben -->
				<?php
				if (isset ( $message )) {
					echo "<h3>$message</h3>";
				}
				?>
			</div>

			<form class="form-horizontal" method="POST" action="/User/update">
				<div class="form-group">
					<label for="benutzername2" class="col-sm-5 control-label">Benutzername</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="benutzername2"
							id="benutzername2" placeholder="Benutzername"
							value="<?=/*** Hier wird geschaut ob schon ein Benutzername geschrieben wurde und wenn er gültig ist aber sonst noch ein Fehler vorhanden ist wird er beim neuladen der Seite automatisch hingeschrieben */isset ( $_POST ['benutzername2'] ) ? $_POST ['benutzername2'] : '';?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail2" class="col-sm-5 control-label">Email</label>
					<div class="col-sm-3">
						<input type="email" class="form-control" name="email2"
							id="inputEmail2" placeholder="Email"
							value="<?= isset($_POST['email2']) ? $_POST['email2'] : '';  ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword4" class="col-sm-5 control-label">Passwort</label>
					<div class="col-sm-3">
						<input type="password" class="form-control" name="passwort4"
							id="inputPassword4" placeholder="Passwort">
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword5" class="col-sm-5 control-label">Passwort
						bestätigen</label>
					<div class="col-sm-3">
						<input type="password" class="form-control" name="passwort5"
							id="inputPassword5" placeholder="Passwort bestaetigen">
					</div>
				</div>
				<div class="col-sm-12 profil-löschen">
					<button type="submit" class="btn btn-default">Speichern</button>
				</div>
				<div class="col-sm-12 ausloggen">
					<a class="btn btn-default" href="/Login/destroy">Log out</a>
				</div>
			</form>
		</div>
	</div>

</div>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>


<script type="text/javascript">


			/*
			Hier erfolgt eine Javascript validierung, wenn dass eingegebene mit dem Patter übereinstimmt wird das Feld durch CSS grünn sonst rot
			*/
	
			var emailPattern = /^[A-Za-z0-9\._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/g;
             
             $(document).ready(function (){

                    $('#inputEmail2').keyup(function (){

                           $(this).parent().removeClass('has-success');
                           $(this).parent().removeClass('has-error');

                           if ($(this).val().match(emailPattern)) {
                                  $(this).parent().addClass('has-success');

                           } else {
                           
                                  $(this).parent().addClass('has-error');

                           }
                    });

             });          

             var usernamePattern = /^[A-Za-z0-9\._%+-]{5,30}$/g;
             
             $(document).ready(function (){

                    $('#benutzername2').keyup(function (){

                           $(this).parent().removeClass('has-success');
                           $(this).parent().removeClass('has-error');

                           if ($(this).val().match(usernamePattern)) {
                                  $(this).parent().addClass('has-success');

                           } else {
                           
                                  $(this).parent().addClass('has-error');

                           }
                    });

             });

       var passwortPattern = /^[A-Za-z0-9\._%+-]{6,35}$/g;
             
             $(document).ready(function (){

                    $('#inputPassword4').keyup(function (){

                           $(this).parent().removeClass('has-success');
                           $(this).parent().removeClass('has-error');


                           
                           if ($(this).val().match(passwortPattern)) {
                                  $(this).parent().addClass('has-success');

                           } else {
                           
                                  $(this).parent().addClass('has-error');

                           }
                    });

             });

             /*
             	Hier wird überprüft ob das Passwort 1 mit dem Passwort 2 übereinstimmt
             */
            
             $(document).ready(function (){

                    $('#inputPassword5').keyup(function (){
                           $(this).parent().removeClass('has-success');
                           $(this).parent().removeClass('has-error');           
                    
                           if ((document.getElementById("inputPassword4").value) != (document.getElementById("inputPassword5").value)){
                        	   $(this).parent().addClass('has-error');

                           } else {                         
                           		$(this).parent().addClass('has-success');
                           }
                    });
             });      

</script>


