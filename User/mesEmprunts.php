<?php
//On demare la session sur sur cette page 
session_start() ;
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password_db = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données
// Création de la connexion
$conn = new mysqli($servername, $username, $password_db, $dbname);
// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}
if(isset($_SESSION['email']) && isset($_SESSION['password'])){
// Obtenir la date actuelle
$currentDate = date("Y-m-d");
$email = $_SESSION['email'];

// Requête SQL pour récupérer les emprunts en cours de l'usager ouvrant la session
$sql = "SELECT * FROM emprunts INNER JOIN usagers ON emprunts.id_usager = usagers.id_usager
WHERE usagers.email = '$email'
AND (date_retour > '$currentDate' OR date_retour IS NULL)
";

$result = $conn->query($sql);

	// vérifie si la requête a réussi
	if(!$result) {
		echo "Erreur: " . mysqli_error($conn);
		exit();
	}

// Vérification si des livres ont été trouvés
if ($result->num_rows > 0) {
    // Tableau pour stocker les livres
    $emprunts= array();

    // Parcourir les résultats de la requête
    while ($row = $result->fetch_assoc()) {
        // Ajouter chaque livre au tableau
        $emprunt = array(
            'id_emprunt' => $row['id_emprunt'],
            'id_livre' => $row['id_livre'],
            'id_usager' => $row['id_usager'],
            'date_emprunt' => $row['date_emprunt'],
            'date_retour' => $row['date_retour'],
            
        );
        $emprunts[] = $emprunt;
    }

    // Convertir le tableau de livres en format JSON
    $emprunts_json = json_encode($emprunts);

    // Envoyer la réponse JSON au client
    header('Content-Type: application/json');
    echo $emprunts_json;
} else {
    // Aucun livre trouvé
    echo "Aucun emprunt trouvé dans la base de données.";
}
}
// Fermer la connexion à la base de données
$conn->close();


?>