<?php
//On demare la session sur sur cette page 
session_start() ;
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password_db= "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Requête SQL pour récupérer tous les livres
$sql = "SELECT * FROM livres";
$result = $conn->query($sql);

// Vérification si des livres ont été trouvés
if ($result->num_rows > 0) {
    // Tableau pour stocker les livres
    $livres = array();

    // Parcourir les résultats de la requête
    while ($row = $result->fetch_assoc()) {
        // Ajouter chaque livre au tableau
        $livre = array(
            'id' => $row['id_livre'],
            'titre' => $row['titre'],
            'auteurs' => $row['auteurs'],
            'maison_edition' => $row['maison_edition'],
            'nb_pages' => $row['nb_pages'],
            'nb_exemplaires' => $row['nb_exemplaires']
        );
        $livres[] = $livre;
    }

    // Convertir le tableau de livres en format JSON
    $livres_json = json_encode($livres);

    // Envoyer la réponse JSON au client
    header('Content-Type: application/json');
    echo $livres_json;
} else {
    // Aucun livre trouvé
    echo "Aucun livre trouvé dans la base de données.";
}

// Fermer la connexion à la base de données
$conn->close();
?>