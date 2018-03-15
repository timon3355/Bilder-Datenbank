
<div class="loginfeld">
	<div class="jumbotron">
		<form class="form-horizontal" action="/Login/index" method="POST">
		<?php
		if (isset ( $message )) {
			echo "<h3>$message</h3>";
		}
		?>
			<div class="form-group">
				<label for="benutzername" class="col-sm-4 control-label">Benutzername</label>
				<div class="col-sm-8">
					<input name="benutzername" type="text" size="15"
						class="form-control" id="benutzername" placeholder="Benutzername">
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-4 control-label">Passwort</label>
				<div class="col-sm-8">
					<input name="passwort" type="password" class="form-control"
						id="inputPassword3" placeholder="Passwort">
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">Login</button>
					<a class="btn btn-default" href="/User/register" role="button">registrieren</a>
				</div>
				.
			</div>
		</form>
	</div>
</div>
<div class="slogan">
	<h2>Anonym</h2>
	<h2>unlimited data volume</h2>
	<h2>upload</h2>
	<h2>download</h2>
</div>
