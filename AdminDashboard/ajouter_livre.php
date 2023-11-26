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

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="titre">Titre :</label>
    <input type="text" name="titre" id="titre" required><br>
    <label for="auteurs">Auteurs :</label>
    <input type="text" name="auteurs" id="auteurs" required><br>
    <label for="maison_edition">Maison d'édition :</label>
    <input type="text" name="maison_edition" id="maison_edition" required><br>
    <label for="nb_pages">Nombre de pages :</label>
    <input type="number" name="nb_pages" id="nb_pages" required><br>
    <label for="nb_exemplaires">Nombre d'exemplaires :</label>
    <input type="number" name="nb_exemplaires" id="nb_exemplaires" required><br>
    <input type="submit" value="Ajouter">
</form>

<?php
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $titre = $_POST['titre'];
    $auteurs = $_POST['auteurs'];
    $maison_edition = $_POST['maison_edition'];
    $nb_pages = $_POST['nb_pages'];
    $nb_exemplaires = $_POST['nb_exemplaires'];

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion à la base de données
    if ($conn->connect_error) {
        die('Erreur de connexion à la base de données: ' . $conn->connect_error);
    }

    // Préparer et exécuter la requête SQL pour ajouter le livre
    $sql = "INSERT INTO livres (titre, auteurs, maison_edition, nb_pages, nb_exemplaires) 
            VALUES ('$titre', '$auteurs', '$maison_edition', $nb_pages, $nb_exemplaires)";

  if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Le livre a été ajouté avec succès.");</script>';
    echo '<script>window.location.href = "AdminDashboard.php";</script>';
  } else {
    echo '<script>alert("Erreur dajout de livre ");</script>';
}

    // Fermer la connexion à la base de données
    $conn->close();
}
?>


</body>
</html>
