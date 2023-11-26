<?php
// Démarrer la session
session_start();

// Vérifier si l'usager est connecté
if (!isset($_SESSION['email'])) {
    echo "Vous devez vous connecter pour réserver un livre.";
    exit;
}

// Vérifier si l'ID du livre est passé en paramètre
if (isset($_GET['id'])) {
    // Récupérer l'ID du livre à reserver
    $idLivre = $_GET['id'];
    // Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion à la base de données
    if (!$conn) {
        die('Erreur de connexion à la base de données: ' . mysqli_connect_error());
    }
    // Requête SQL pour récupérer le nb d'exemplaires existant dans la base correspondant à l'id du livre
    $sql = "SELECT nb_exemplaires FROM livres WHERE id_livre = '$idLivre'";
    $result = mysqli_query($conn, $sql);

// Vérification si la requête a renvoyé un résultat
if (mysqli_num_rows($result) == 1) {
    // Récupération de nb d'exemplairesr et stockage dans la variable $nb_exemplaires
    $row = mysqli_fetch_assoc($result);
    $nb_exemplaires= $row['nb_exemplaires'];
}
    
    // Requête SQL pour modifier la date de retour d'emprunt
$currentDate = date("Y-m-d");
$sql = "UPDATE emprunts SET date_retour='$currentDate' WHERE id_livre=$idLivre";

// vérifie si la requête a réussi
if ($conn->query($sql) === TRUE) {
    // Afficher une alerte si la modification a réussi
    echo '<script>alert("Le livre a été rendu avec succès");</script>';
    // Arrêter l'exécution du script et afficher l'alerte avant la redirection
    echo '<script>window.location.href = "userDashboard.php";</script>';
    $sql = "UPDATE livres SET nb_exemplaires = nb_exemplaires + 1 WHERE id_livre = '$idLivre'";
    $result = $conn->query($sql);
    exit();
}
 else {
    echo "Erreur lors du rendre du livre : " . $conn->error;
    echo '<script>alert("Erreur de rendre du livre");</script>';
}

    // Fermer la connexion à la base de données
    mysqli_close($conn);
}
else{
    echo "L ID du livre est manquant";
    exit();
}
?>