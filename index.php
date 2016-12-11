<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" media="screen" type="text/css" title="page_web" href="style/index.css"/>
		<link rel="stylesheet" media="screen" type="text/css" title="page_web" href="style_autocompletion.css"/>
		<title>Autocompletion</title>
	</head>

	<body>
		<div id="page">
			<? include("include/menu.html") ?>

			<div id="conteneur">
				<div id="recherche">
					<form id="request" method="post" action="fiche_serie.php">
						<input type="text" id="recherche" name="recherche" />
						<input type="submit" value="Envoyer" />
					</form>
				</div>

				<section id="infos">
					<div>
						<h1>Bienvenue sur notre site</h1>
						
						<div id="presentation">
							<? include("include/home.php") ?>
						</div>
					</div>
				</section>
			</div>


		</div>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
		<script type="text/javascript" src="js/js.js"></script>
		<script type="text/javascript" src="js/autocompletion.js"></script>
	</body>
</html>