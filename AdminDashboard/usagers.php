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

// Requête SQL pour récupérer tous les utilisateurs
$sql = "SELECT * FROM Usagers";
$result = $conn->query($sql);

// Vérification si des utilisateurs ont été trouvés
if ($result->num_rows > 0) {
    // Tableau pour stocker les utilisateurs
    $utilisateurs = array();

    // Parcourir les résultats de la requête
    while ($row = $result->fetch_assoc()) {
        // Ajouter chaque utilisateur au tableau
        $utilisateur = array(
            'id' => $row['id_usager'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'adresse' => $row['adresse'],
            'statut' => $row['statut'],
            'email' => $row['email'],
            'password' => $row['password']
        );
        $utilisateurs[] = $utilisateur;
    }

    // Convertir le tableau d'utilisateurs en format JSON
    $utilisateurs_json = json_encode($utilisateurs);

    // Envoyer la réponse JSON au client
    header('Content-Type: application/json');
    echo $utilisateurs_json;
} else {
    // Aucun utilisateur trouvé
    echo "Aucun utilisateur trouvé dans la base de données.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
