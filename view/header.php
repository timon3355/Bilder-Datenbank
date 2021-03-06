﻿<!DOCTYPE html>
<html lang="de">
<head>
<title><?= $title ?> | Q-Drive</title>
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab"
	rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Droid+Sans"
	rel="stylesheet">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap core CSS -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
	integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
	crossorigin="anonymous">

<!-- Custom styles for this template -->
<link href="/css/style.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/default"><img alt="Logo"
					src="/img/Logo.PNG"></a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">

					<li
						<?php
						/**
						 * Hier wird geschaut ob man sich auf dieser Seite befindet, wenn ja wird sie active gesetzt das heisst sie ist eingefärbt
						 */
						if (View::$activePage == "Defaultindex") {
							echo ('class="active"');
						}
						
						?>><a class="hover" href="/Default">Über Uns</a></li>
					<li
						<?php
						if (View::$activePage == "Fileindex") {
							echo ('class="active"');
						}
						
						?>><a class="hover" href="/File">Suchen</a></li>

					<!-- Hier wird ein Schloss vor den Link geschoben und durch class=disabled kann man es nicht auswählen -->
					<li class="disabled"><a><span class="glyphicon glyphicon-lock"
							aria-hidden="true"></span>Meine Dateien</a></li>
					<li class="disabled"><a><span class="glyphicon glyphicon-lock"
							aria-hidden="true"></span>Datei hochladen</a></li>
					<li class="disabled"><a><span class="glyphicon glyphicon-lock"
							aria-hidden="true"></span>Profil</a></li>

					<li
						<?php
						if (View::$activePage == "Defaultimprint") {
							echo ('class="active"');
						}
						
						?>><a class="hover" href="/Default/imprint">Impressum</a></li>
					<li
						<?php
						if (View::$activePage == "Userindex") {
							echo ('class="active"');
						}
						
						?>><a class="hover" href="/User/index">Login</a></li>

				</ul>

			</div>

		</div>
	</nav>

<div class="container">