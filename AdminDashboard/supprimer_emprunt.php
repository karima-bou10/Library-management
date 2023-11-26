<?php
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

// Vérifier si l'ID du livre est passé en paramètre
if (isset($_GET['id'])) {
    // Récupérer l'ID du livre à supprimer
    $idEmprunt = $_GET['id'];

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion à la base de données
    if (!$conn) {
        die('Erreur de connexion à la base de données: ' . mysqli_connect_error());
    }

        // Supprimer le livre de la table livres
        $sql = "DELETE FROM emprunts WHERE id_emprunt = $idEmprunt";

        if ($conn->query($sql) === TRUE) {
            echo "Le livre a été supprimé avec succès.";

            // Récupérer tous les livres restants avec leurs anciens ID
            $sql = "SELECT * FROM emprunts ORDER BY id_emprunt";
            $result = $conn->query($sql);

            // Réorganiser les ID des livres existants
            if ($result->num_rows > 0) {
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    $oldId = $row['id_emprunt'];
                    $newId = $count;

                    // Mettre à jour l'ID du livre
                    $sql = "UPDATE livres SET id_emprunt = $newId WHERE id_emprunt = $oldId";
                    $conn->query($sql);

                    $count++;
                }

                echo "Les ID des livres ont été réorganisés avec succès.";
            } else {
                echo "Il n'y a aucun livre restant dans la base de données.";
            }
        } else {
            echo "Erreur lors de la suppression du livre : " . $conn->error;
        }
    
    // Fermer la connexion à la base de données
    mysqli_close($conn);
}
?>
