<?php 
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérifie si la connexion a réussi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Requête SQL combinée pour récupérer le nombre d'usagers, de livres et d'emprunts
$sql_combined = "
    SELECT
        (SELECT COUNT(*) FROM usagers) AS count_usagers,
        (SELECT COUNT(*) FROM livres) AS count_livres,
        (SELECT COUNT(*) FROM emprunts) AS count_emprunts
";
$result_combined = mysqli_query($conn, $sql_combined);

// Vérifie si la requête a réussi
if ($result_combined) {
    $row_combined = mysqli_fetch_assoc($result_combined);
    $nombreUsagers = $row_combined['count_usagers'];
    $nombreLivres = $row_combined['count_livres'];
    $nombreEmprunts = $row_combined['count_emprunts'];
    // Stocker les statistiques dans un tableau
  $statistiques = array(
    "nombreLivres" => $nombreLivres,
    "nombreEmprunts" => $nombreEmprunts,
    "nombreUsagers" => $nombreUsagers
  );
    // Convertir le tableau de livres en format JSON
    $statistiques_json = json_encode($statistiques);

    // Envoyer la réponse JSON au client
    header('Content-Type: application/json');
    echo $statistiques_json;
} else {
    $nombreUsagers = 0;
    $nombreLivres = 0;
    $nombreEmprunts = 0;
}

// Ferme la connexion à la base de données
mysqli_close($conn);

?>