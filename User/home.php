<?php 
//On demare la session sur sur cette page 
session_start() ;
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password_db = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

// Connexion à la base de données
$conn = mysqli_connect($servername, $username, $password_db, $dbname);

// Vérifie si la connexion a réussi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_SESSION['email']) && isset($_SESSION['password'])){
  // Obtenir la date actuelle
$currentDate = date("Y-m-d");
// Requête SQL combinée pour récupérer le nombre d'usagers, de livres et d'emprunts
$sql_combined = "
    SELECT
        (SELECT COUNT(*) FROM livres) AS count_livres,
        (SELECT COUNT(*) FROM emprunts INNER JOIN usagers ON emprunts.id_usager = usagers.id_usager
            WHERE usagers.email = '{$_SESSION['email']}'
            AND usagers.password = '{$_SESSION['password']}'
            AND (date_retour > '$currentDate' OR date_retour IS NULL)) AS count_emprunts_encours,
        (SELECT COUNT(*) FROM emprunts INNER JOIN usagers ON emprunts.id_usager = usagers.id_usager
            WHERE usagers.email = '{$_SESSION['email']}'
            AND usagers.password = '{$_SESSION['password']}'
            AND date_retour <= '$currentDate') AS count_emprunts_histo";  

$result_combined = mysqli_query($conn, $sql_combined);

// Vérifie si la requête a réussi
if ($result_combined) {
    $row_combined = mysqli_fetch_assoc($result_combined);
    $nombreLivres = $row_combined['count_livres'];
    $nombreEmprunts_encours = $row_combined['count_emprunts_encours'];
    $nombreEmprunts_histo = $row_combined['count_emprunts_histo'];

    
  // Stocker les statistiques dans un tableau
  $statistiques = array(
    "nombreLivres" => $nombreLivres,
    "nombreEmprunts_encours" => $nombreEmprunts_encours,
    "nombreEmprunts_histo" => $nombreEmprunts_histo
  );
    // Convertir le tableau de livres en format JSON
    $statistiques_json = json_encode($statistiques);

    // Envoyer la réponse JSON au client
    header('Content-Type: application/json');
    echo $statistiques_json;
} else {
    $nombreLivres = 0;
    $nombreEmprunts_encours = 0;
    $nombreEmprunts_histo = 0;
}
}
// Ferme la connexion à la base de données
mysqli_close($conn);

?>