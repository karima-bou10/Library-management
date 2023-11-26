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

$sql = "SELECT id_emprunt, id_livre, id_usager, date_emprunt, date_retour FROM emprunts WHERE date_retour >= '$currentDate'";
$result = $conn->query($sql);

$empruntsEnCours = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $emprunt = array(
      'id_emprunt' => $row['id_emprunt'],
      'id_livre' => $row['id_livre'],
      'id_usager' => $row['id_usager'],
      'date_emprunt' => $row['date_emprunt'],
      'date_retour' => $row['date_retour']
    );
    
    $empruntsEnCours[] = $emprunt;
  }
}

// Fermer la connexion à la base de données
$conn->close();

// Retourner les données des emprunts en cours au format JSON
header('Content-Type: application/json');
echo json_encode($empruntsEnCours);
?>
