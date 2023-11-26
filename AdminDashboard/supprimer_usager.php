<?php
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

// Vérifier si l'ID du usager est passé en paramètre
if (isset($_GET['id'])) {
    // Récupérer l'ID du usager à supprimer
    $idUsager = $_GET['id'];

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion à la base de données
    if (!$conn) {
        die('Erreur de connexion à la base de données: ' . mysqli_connect_error());
    }

        // Supprimer le usager de la table usagers
        $sql = "DELETE FROM usagers WHERE id_usager = $idUsager";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Usager a été supprimé avec succès.");</script>';

            // Récupérer tous les usagers restants avec leurs anciens ID
            $sql = "SELECT * FROM usagers ORDER BY id_usager";
            $result = $conn->query($sql);

            // Réorganiser les ID des livres existants
            if ($result->num_rows > 0) {
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    $oldId = $row['id_usager'];
                    $newId = $count;

                    // Mettre à jour l'ID du livre
                    $sql = "UPDATE livres SET id_usager = $newId WHERE id_usager = $oldId";
                    $conn->query($sql);

                    $count++;
                }

            } else {
                echo "Il n'y a aucun usager restant dans la base de données.";
            }
        } else {
            echo '<script>alert("Erreur de suppression du usager");</script>';
        }
    
    // Fermer la connexion à la base de données
    mysqli_close($conn);
}
?>
