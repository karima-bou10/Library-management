<!-- Début du fichier PHP -->
<!DOCTYPE html>
<html>
<head>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");
*{
  margin: 5px 0px;
  padding: 0;
  outline: none;
  border: none;
  text-decoration: none;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
  
}
 form {
    max-width: 600px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 4px  #4CAF50;
    
}

label {
  font-weight: bold;
  margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
input[type="submit"] {
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: #fff;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}

  </style>


</head>
<body>

<?php
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

// Vérifier si l'ID du livre est passé en paramètre
if (isset($_GET['id'])) {
    // Récupérer l'ID du livre à modifier
    $idLivre = $_GET['id'];

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion à la base de données
    if (!$conn) {
        die('Erreur de connexion à la base de données: ' . mysqli_connect_error());
    }

    // Récupérer les informations du livre à partir de la base de données
    $sql = "SELECT * FROM livres WHERE id_livre = $idLivre";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $livre = $result->fetch_assoc();

        // Afficher le formulaire de modification du livre
        echo '
        <form method="POST" >
            <input type="hidden" name="id_livre" value="' . $livre['id_livre'] . '">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" id="titre" value="' . $livre['titre'] . '"><br>
            <label for="auteurs">Auteurs :</label>
            <input type="text" name="auteurs" id="auteurs" value="' . $livre['auteurs'] . '"><br>
            <label for="maison_edition">Maison d\'édition :</label>
            <input type="text" name="maison_edition" id="maison_edition" value="' . $livre['maison_edition'] . '"><br>
            <label for="nb_pages">Nombre de pages :</label>
            <input type="number" name="nb_pages" id="nb_pages" value="' . $livre['nb_pages'] . '"><br>
            <label for="nb_exemplaires">Nombre d\'exemplaires :</label>
            <input type="number" name="nb_exemplaires" id="nb_exemplaires" value="' . $livre['nb_exemplaires'] . '"><br>
            <input type="submit" value="Modifier" onclick="afficherMessage()">
        </form>
        ';
    

    } else {
        echo 'Livre introuvable.';
    }

    // Fermer la connexion à la base de données
    mysqli_close($conn);
} else {
    echo 'ID du livre non spécifié.';
}
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer les données du formulaire et effectuer une validation si nécessaire
  $idLivre = $_POST["id_livre"];
  $titre = $_POST["titre"];
  $auteurs = $_POST["auteurs"];
  $maisonEdition = $_POST["maison_edition"];
  $nbPages = $_POST["nb_pages"];
  $nbExemplaires = $_POST["nb_exemplaires"];

  // Créer une connexion à la base de données
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Vérifier la connexion à la base de données
  if ($conn->connect_error) {
      die("Erreur de connexion à la base de données: " . $conn->connect_error);
  }

  // Construire la requête de mise à jour sans paramètres de substitution
  $sql = "UPDATE livres SET titre='$titre', auteurs='$auteurs', maison_edition='$maisonEdition', nb_pages='$nbPages', nb_exemplaires='$nbExemplaires' WHERE id_livre='$idLivre'";

  // Exécuter la requête de mise à jour
  if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Le livre a été modifié avec succès.");</script>';
  } else {
    echo '<script>alert("Errour de modification ");</script>';
  }
  // Fermer la connexion à la base de données
  $conn->close();
}

?>


</body>
</html>