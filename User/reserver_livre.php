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
    $email=$_SESSION['email'];
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
if($nb_exemplaires > 0){ 

    // Requête SQL pour récupérer l'id correspondant à l'email de l'utilisateur
$sql = "SELECT id_usager FROM usagers WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

// Vérification si la requête a renvoyé un résultat
if (mysqli_num_rows($result) == 1) {
    // Récupération de l'id de l'utilisateur et stockage dans la variable $id_usager
    $row = mysqli_fetch_assoc($result);
    $id_usager = $row['id_usager'];
}else {
    // Erreur si la requête ne renvoie pas de résultat
    echo "Erreur: l'utilisateur avec l'email $email n'a pas été trouvé.";
}
    $id_emprunt="\N";
    $currentDate = date("Y-m-d");
    // Ajouter 30 jours à la date actuelle
    $newDate = date("Y-m-d", strtotime($currentDate . "+30 days"));

        // Requête SQL pour récupérer le nombre d'emprunts en cours de l'utilisateur
        $sql = "SELECT COUNT(*) AS count_emprunts_encours FROM emprunts WHERE id_usager = '$id_usager' AND (date_retour > '$currentDate' OR date_retour IS NULL)";
        $result = $conn->query($sql);

        // Vérification si la requête a renvoyé un résultat
        if ($result->num_rows == 1) {
            // Récupération du nombre d'emprunts en cours de l'utilisateur
            $row = $result->fetch_assoc();
            $count_emprunts_encours = $row['count_emprunts_encours'];
        }
        if ($count_emprunts_encours < 5) {

        // inserer livre à la table emprunts
        $sql = "INSERT INTO emprunts (id_livre, id_usager, date_emprunt) VALUES ($idLivre, $id_usager, '$currentDate')";
        // vérifie si la requête a réussi
        if ($conn->query($sql) === TRUE) {
            // Afficher une alerte si l'insertion a réussi
            echo '<script>alert("Le livre a été réservé avec succès");</script>';
            // Arrêter l'exécution du script et afficher l'alerte avant la redirection
            echo '<script>window.location.href = "userDashboard.php";</script>';
            // soustraire un exemplaire la table des livres
            $sql = "UPDATE livres SET nb_exemplaires = nb_exemplaires - 1 WHERE id_livre = '$idLivre'";
            $result = $conn->query($sql);

            // Récupérer tous les emprunts restants avec leurs anciens ID
            $sql = "SELECT * FROM emprunts ORDER BY id_emprunt";
            $result = $conn->query($sql);

            // Réorganiser les ID des emprunts existants
            if ($result->num_rows > 0) {
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    $oldId = $row['id_emprunt'];
                    $newId = $count;

                    // Mettre à jour l'ID du livre
                    $sql = "UPDATE emprunts SET id_emprunt = $newId WHERE id_emprunt = $oldId";
                    $conn->query($sql);
                    $count++;
                }
            } else {
                echo "Il n'y a aucun emprunt restant dans la base de données.";
            }
            exit();
        }
         else {
            echo "Erreur lors de la reservation du livre : " . $conn->error;
            echo '<script>alert("Erreur de reservation du livre");</script>';
        }}
        else{
             // Affichage d'un message si l'utilisateur a atteint la limite de 5 emprunts en cours
        echo '<script>alert("Vous avez atteint la limite de 5 emprunts en cours. \nVous devez rendre au moins un livre avant '.$newDate.'.");</script>';
        echo '<script>window.location.href = "userDashboard.php";</script>';
        exit();
        }
    }else{
        echo '<script>alert("Aucun livre à emprunter");</script>';
        echo '<script>window.location.href = "userDashboard.php";</script>';
        exit();
    }
    // Fermer la connexion à la base de données
    mysqli_close($conn);
}
else{
    echo "L ID du livre est manquant";
    exit();
}
?>