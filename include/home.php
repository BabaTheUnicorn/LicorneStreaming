<?php

$html = "";

try {
	// Open connection
	$connection = new PDO(
		'mysql:host=localhost;dbname=l3_projet_web',
		'root',
		'root'
	);
	
	$query = "SELECT name, poster_path FROM series ORDER BY popularity ASC LIMIT 12";
	$statement = $connection->prepare($query);
	$statement->execute();

	$rows = $statement->fetchAll();

	$url = "https://image.tmdb.org/t/p/";
	for($i = 0; $i < sizeof($rows); $i++) {
		$html .= '
			<a href="fiche_serie.php?param=' . $rows[$i]["name"] . '" class="serie_conteneur">
				
					<img src="' . $url . "w342" . $rows[$i]['poster_path'] . '" alt="poster"/>
					<span class="filtre"><p>' . $rows[$i]['name'] . '</p></span>
					
				
			</a>';
	}

	echo $html;

	// Close connection
	$connection = null;
} catch(PDOException $e) {
	echo $e->getMessage();
}

/*
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
*/

?>