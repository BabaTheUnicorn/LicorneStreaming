<?

try {
	// Open connection
	$connection = new PDO(
		'mysql:host=localhost;dbname=l3_projet_web',
		'root',
		'root'
	);
	
	$url = "https://image.tmdb.org/t/p/";
	$term = $_GET["term"];

	$query = "SELECT name, poster_path, first_air_date FROM series WHERE name LIKE :term LIMIT 5";
	$statement = $connection->prepare($query);
	$statement->execute(array('term' => '%' . $term . '%'));

	$names = array();
	$posters = array();
	while($donnee = $statement->fetch()) {
		//array_push($names, $donnee['name']);
		$new_row['name'] = htmlentities(stripcslashes($donnee['name']));
		$new_row['poster_path'] = htmlentities(stripcslashes($url . "w92" . $donnee['poster_path']));
		//$new_row['first_air_date'] = htmlentities(stripcslashes(substr($donnee['first_air_date']), 0, 4));
		$row_set[] = $new_row;
	}

	echo json_encode($row_set);
	//echo json_encode($names);

	// Close connection
	$connection = null;
} catch(PDOException $e) {
	echo $e->getMessage();
}

?>