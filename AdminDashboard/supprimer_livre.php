<?php
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

// Vérifier si l'ID du livre est passé en paramètre
if (isset($_GET['id'])) {
    // Récupérer l'ID du livre à supprimer
    $idLivre = $_GET['id'];

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion à la base de données
    if (!$conn) {
        die('Erreur de connexion à la base de données: ' . mysqli_connect_error());
    }

    // Mettre à jour les enregistrements dans la table emprunts
    $sql = "UPDATE emprunts SET id_livre = NULL WHERE id_livre = $idLivre";

    if ($conn->query($sql) === TRUE) {
        // Les enregistrements dans la table emprunts ont été mis à jour avec succès

        // Supprimer le livre de la table livres
        $sql = "DELETE FROM livres WHERE id_livre = $idLivre";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("livre a été supprimé avec succée");</script>';

            // Récupérer tous les livres restants avec leurs anciens ID
            $sql = "SELECT * FROM livres ORDER BY id_livre";
            $result = $conn->query($sql);

            // Réorganiser les ID des livres existants
            if ($result->num_rows > 0) {
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    $oldId = $row['id_livre'];
                    $newId = $count;

                    // Mettre à jour l'ID du livre
                    $sql = "UPDATE livres SET id_livre = $newId WHERE id_livre = $oldId";
                    $conn->query($sql);

                    $count++;
                }

                
            } else {
                echo "Il n'y a aucun livre restant dans la base de données.";
            }
        } else {
            echo "Erreur lors de la suppression du livre : " . $conn->error;
        }
    } else {
        echo '<script>alert("Erreur de suppression du livre");</script>';
    }

    // Fermer la connexion à la base de données
    mysqli_close($conn);
}
?>
