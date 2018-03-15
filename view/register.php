
<div class="register">
	<div class="jumbotron">
		<form class="form-horizontal" method="post" action="/Login/register">
		<?php
		if (isset ( $message )) {
			echo "<h3>$message</h3>";
		}
		?>
			<div class="form-group">
				<label for="benutzername" class="col-sm-4 control-label">Benutzername</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="benutzername"
						id="benutzername" placeholder="Benutzername"
						value="<?= isset($_POST['benutzername']) ? $_POST['benutzername'] : '';  ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail" class="col-sm-4 control-label">Email</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="email"
						id="inputEmail" placeholder="Email"
						value="<?= isset($_POST['email']) ? $_POST['email'] : '';  ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword1" class="col-sm-4 control-label">Passwort</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" name="passwort1"
						id="inputPassword1" placeholder="Passwort">
				</div>
			</div>

			<div class="form-group">
				<label for="inputPassword2" class="col-sm-4 control-label">Passwort
					bestätigen</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" name="passwort2"
						id="inputPassword2" placeholder="Passwort bestaetigen">
				</div>
			</div>


			<div class="form-group">
				<div class="col-sm-offset-5 col-sm-5">
					<button type="submit" class="btn btn-default">Jetzt registrieren</button>
				</div>
			</div>

		</form>
	</div>





	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>


	<script type="text/javascript">


	
			var emailPattern = /^[A-Za-z0-9\._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/g;
             
             $(document).ready(function (){

                    $('#inputEmail').keyup(function (){

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

                    $('#benutzername').keyup(function (){

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

                    $('#inputPassword1').keyup(function (){

                           $(this).parent().removeClass('has-success');
                           $(this).parent().removeClass('has-error');


                           
                           if ($(this).val().match(passwortPattern)) {
                                  $(this).parent().addClass('has-success');

                           } else {
                           
                                  $(this).parent().addClass('has-error');

                           }
                    });

             });

             
            
             $(document).ready(function (){

                    $('#inputPassword2').keyup(function (){
                           $(this).parent().removeClass('has-success');
                           $(this).parent().removeClass('has-error');           
                    
                           if ((document.getElementById("inputPassword1").value) != (document.getElementById("inputPassword2").value)){
                        	   $(this).parent().addClass('has-error');

                           } else {                         
                           		$(this).parent().addClass('has-success');
                           }
                    });
             });      

</script>
</div>


<div class="slogan">
	<h2>Anonym</h2>
	<h2>unlimited data volume</h2>
	<h2>upload</h2>
	<h2>download</h2>
</div>
