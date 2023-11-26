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
    input[type="email"],
    input[type="password"],
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
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" required><br>
    <label for="prenom">Prenom :</label>
    <input type="text" name="prenom" id="prenom" required><br>
    <label for="adresse">Adresse :</label>
    <input type="text" name="adresse" id="adresse" required><br>
    <label for="statut">Statut :</label>
    <input type="text" name="statut" id="statut" required><br>
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required><br>
    <label for="password">Password :</label>
    <input type="password" name="password" id="password" required><br>
    <input type="submit" value="Confirmer">
</form>

<?php
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password_db = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $statut = $_POST['statut'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Vérifier la connexion à la base de données
    if ($conn->connect_error) {
        die('Erreur de connexion à la base de données: ' . $conn->connect_error);
    }

    // Préparer et exécuter la requête SQL pour ajouter l'usager
    $sql = "INSERT INTO usagers (nom, prenom, adresse, statut, email, password) 
            VALUES ('$nom', '$prenom', '$adresse', '$statut', '$email', '$password')";

  if ($conn->query($sql) === TRUE) {
    // Afficher une alerte si l'insertion a réussi
    echo '<script>alert("Votre compte a été crée avec succès.");</script>';
    // Arrêter l'exécution du script et afficher l'alerte avant la redirection
    echo '<script>window.location.href = "inscription.php";</script>';
    exit();
  } else {
    echo '<script>alert("Erreur de création de compte!");</script>';
}
    // Fermer la connexion à la base de données
    $conn->close();
}
?>
</body>
</html>