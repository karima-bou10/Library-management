<?php
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}
// Obtenir la date actuelle
$currentDate = date("Y-m-d");
// Requête SQL pour récupérer tous les livres
$sql = "SELECT id_emprunt, id_livre, id_usager, date_emprunt, date_retour FROM emprunts WHERE date_retour < '$currentDate'";
$result = $conn->query($sql);

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

// Fermer la connexion à la base de données
$conn->close();
?>
