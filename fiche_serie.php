<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" media="screen" type="text/css" title="page_web" href="style.css"/>
		<title>Formulaire</title>
	</head>

	<body>
		<div id="page">
			<!--<header id="menu">
				<ul id="navigation">
					<li><a class="active" href="#" title="aller à la section ..."><!--<img src="logo_radiant.jpg" alt="logo" id="logo"/>--><!--LOGO</a></li>
					<li><a href="#" title="aller à la section ...">Series</a></li>
					<li><a href="#" title="aller à la section ...">Actu</a></li>
					<li><a href="#" title="aller à la section ...">Contact</a></li>
					<li class="right" id="srch">
						<a href="#" title="aller à la section ...">
							<!--<form id="request" method="post" action="fiche_serie.php">
								<input type="text" id="recherche" name="recherche" />
							</form>--><!--
							<img src="img/search_icon.png" alt="recherche" />
						</a>
					</li>
					<li class="right"><a href="#" title="aller à la section ...">Connexion</a></li>
					<li class="right"><a href="#" title="aller à la section ...">Inscription</a></li>
				</ul>
			</header>-->
			<? include("include/menu.html") ?>

			<!-- Image de fond / carousel -->
			<section id="image_presentation">
					<img src="" alt=""/>
			</section>


			<div id="conteneur">


				<!-- Barre d'indication de navigation -->
				<section id="menu_lateral">
					<p>R</p>
					<p></p>
				</section>


<?php

$html = '';
$serie_name = "";

if(isset($_POST["recherche"])) {
	$serie_name = $_POST["recherche"];
} else if(isset($_GET)) {
	$serie_name = $_GET["param"];
} else {
	$serie_name = "Lost";
}

$seasonsID = array();

try {
	// Open connection
	$connection = new PDO(
		'mysql:host=localhost;dbname=l3_projet_web',
		'root',
		'root'
	);
	
	//selectNameActor($connection);
	selectInfosSerie($serie_name);

	echo $html;

	// Close connection
	$connection = null;
} catch(PDOException $e) {
	echo $e->getMessage();
}



function selectNameActor($connec) {
	$query = "SELECT id FROM actors WHERE name= :name";
	$statement = $connec->prepare($query);

	$statement->bindValue(":name", "Harrison Ford", PDO::PARAM_STR);
	$statement->execute();

	$rows = $statement->fetch();
	echo "Id d'Harrison Ford : " . $rows[0];
}


// Recupère les informations de la base de donnée sur une série précise 
function selectInfosSerie($name) {
	global $connection;
	$query = "SELECT * FROM series WHERE name= :name";
	$statement = $connection->prepare($query);

	$statement->bindValue(":name", $name, PDO::PARAM_STR);
	$statement->execute();

	$row = $statement->fetch();

	$idSerie = $row["id"]; // 66732
	$url = "https://image.tmdb.org/t/p/";
	global $html, $seasonsID;
	$html .= "<section id=\"infos\">
				<div id=\"presentation\">
					<div id=\"cadre_affiche\">
						<img src=\"" . $url . "w185" . $row["poster_path"] . "\" alt=\"affiche\" id=\"affiche\"/>
 					</div>
 					<div id=\"texte_infos\">
	 					<h1>" . $row["name"] . "</h1>
	 					<p id=\"date_diffusion\">" . substr($row["first_air_date"], 0, 4) . "
	 						<span class=\"espace\"><a href=\"\">"; 
	 							serieCompany($idSerie); $html .= "
	 						</a></span>
	 					</p>
	 					<div id=\"position_rating\">
	 					<div class=\"rating\">
	 						<a href=\"#10\" title=\"Donner 10 étoiles\">☆</a>
	 						<a href=\"#9\" title=\"Donner 9 étoiles\">☆</a>
	 						<a href=\"#8\" title=\"Donner 8 étoiles\">☆</a>
	 						<a href=\"#7\" title=\"Donner 7 étoiles\">☆</a>
	 						<a href=\"#6\" title=\"Donner 6 étoiles\">☆</a>
	 						<a href=\"#5\" title=\"Donner 5 étoiles\">☆</a>
	 						<a href=\"#4\" title=\"Donner 4 étoiles\">☆</a>
	 						<a href=\"#3\" title=\"Donner 3 étoiles\">☆</a>
	 						<a href=\"#2\" title=\"Donner 2 étoiles\">☆</a>
	 						<a href=\"#1\" title=\"Donner 1 étoiles\">☆</a>
	 					</div>
	 					</div>"/*
 						<p>" . $row["overview"] . "</p>*/."
 						<div class=\"infos_annexes\">
 							<p>Nombre d'épisodes " . $row["number_of_episodes"] . "</p>
 							<p>"; seriesGenres($idSerie); $html .="</p>
 						</div>
 					</div>
 				</div>";
	
	$html .= "	<div id=\"synopsis\">
					<h2>Synopsis</h2>
					<p>" . $row["overview"] . "</p>
				</div>

				<div id=\"episodes\"> 
					<h2>Liste des épisodes</h2>
					<div id=\"saison\">
						<ul id=\"liste_saison\">";
							seriesSeasons($idSerie);
						$html .= "</ul>
						<div id=\"liste_episodes\"> ";
						for($i = 0; $i < sizeof($seasonsID); $i++) {
							episodesSeasons($seasonsID[$i]);
						}
						$html .= "</div>
					</div>
				</div>";
	//seriesSeasons($idSerie);
	
}

function seriesSeasons($id) {
	global $connection, $html, $seasonsID;
	$query = "SELECT seasons.name, seasons.id, seasons.number 
	FROM seasons, seriesseasons 
	WHERE seriesseasons.season_id = seasons.id
	AND seriesseasons.series_id = :id
	ORDER BY seasons.number ASC";
	$statement = $connection->prepare($query);

	$statement->bindValue(":id", $id, PDO::PARAM_STR);
	$statement->execute();

	$rows = $statement->fetchAll();
	
	/*$nbSaisons = sizeof($rows);
	for($i = 0; $i < sizeof($rows); $i++) {
		$row = $rows[$i];
		$html .= "y" . $row[0];
		/*$html .= "Saison " . $row[0];*/
	//}
	//return $rows[0];
	//echo $rows[0];*/

	for($i = 0; $i < sizeof($rows); $i++) {
		/*if($rows[$i]["number"] == 0) {

		} else*/ if(/*$rows[*/$i/*]["number"]*/ == 0/*1*/) {
			$html .= "<li class=\"active\" value=\"" . $rows[$i]["number"] . "\">" . $rows[$i]["name"] . "</li>";
		} else {
			$html .= "<li value=\"" . $rows[$i]["number"] . "\">" . $rows[$i]["name"] . "</li>";
		}
		array_push($seasonsID, $rows[$i]["id"]);
	}
}

// Recupere les épisodes d'une saison
function episodesSeasons($idSeason) {
	global $connection, $html;
	$query = "SELECT episodes.number, episodes.name, episodes.overview
	FROM episodes, seasonsepisodes 
	WHERE seasonsepisodes.episode_id = episodes.id
	AND seasonsepisodes.season_id = :id
	ORDER BY episodes.number ASC";
	$statement = $connection->prepare($query);

	$statement->bindValue(":id", $idSeason, PDO::PARAM_STR);
	$statement->execute();

	$rows = $statement->fetchAll();

	$html .= "<div class=\"episodes_active\">";
	for($i = 0; $i < sizeof($rows); $i++) {
		$html .=
		"<div class=\"episode\">
			<div class=\"numero_episode\">" . $rows[$i]["number"] . "</div>
			<p class=\"titre_episode\">" . utf8_encode($rows[$i]["name"]) . "</p>
			<p class=\"plus\">+</p>
			<div class=\"resume_episode\">" . $rows[$i]["overview"] . "</div>
		</div>";
	}
	$html .= "</div>";
}

//Recupere les 

// Recupere les genres de la série
function seriesGenres($id) {
	global $connection, $html;
	$query = "SELECT genre_id FROM seriesgenres WHERE series_id= :id";
	$statement = $connection->prepare($query);

	$statement->bindValue(":id", $id, PDO::PARAM_STR);
	$statement->execute();

	$rows = $statement->fetchAll();
	for($i = 0; $i < sizeof($rows); $i++) {
		$row = $rows[$i]["genre_id"];
		if($i != sizeof($rows)-1) {
			idGenres($row);
			$html .= " | ";
		} else {
			idGenres($row);
		}
	}
}


// Recupere les genres a partir de leur id
function idGenres($id) {
	global $connection, $html;
	$query = "SELECT name FROM genres WHERE id= :id";
	$statement = $connection->prepare($query);

	$statement->bindValue(":id", $id, PDO::PARAM_STR);
	$statement->execute();

	$rows = $statement->fetchAll();
	for($i = 0; $i < sizeof($rows); $i++) {
		$html .= $rows[$i]["name"];
	}
}


// Recupere le nom de la compagnie qui a créée la série
function serieCompany($id) {
	global $connection, $html;
	$query = "SELECT companies.name 
	FROM companies, seriescompanies 
	WHERE seriescompanies.company_id = companies.id
	AND seriescompanies.series_id= :id";
	$statement = $connection->prepare($query);

	$statement->bindValue(":id", $id, PDO::PARAM_STR);
	$statement->execute();

	$rows = $statement->fetch();
	//for($i = 0; $i < sizeof($rows); $i++) {
		$html .= $rows[0];
	//}
}


?>


		</section>

				<div class="frame">
					<span class="cnrTL"></span>
					<span class="cnrTR"></span>
					<span class="cnrBL"></span>
					<span class="cnrBR"></span>
				</div>
			</div>

		</div>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/js.js"></script>
		<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
		<script type="text/javascript" src="js/autocompletion.js"></script>
	</body>
</html>