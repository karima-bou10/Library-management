<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>modifier mes informations</title>
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

<?php
// Démarrer la session
session_start();

// Vérifier si l'usager est connecté
if (!isset($_SESSION['email'])) {
    echo "Vous devez vous connecter pour réserver un livre.";
    exit;
}
// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password_db = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

    // Récupérer l'email d'usager
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Vérifier la connexion à la base de données
    if (!$conn) {
        die('Erreur de connexion à la base de données: ' . mysqli_connect_error());
    }

       // Requête SQL pour récupérer l'id correspondant à l'email de l'utilisateur
     $sql = "SELECT id_admin FROM admin WHERE email = '$email'";
     $result = mysqli_query($conn, $sql);

    // Vérification si la requête a renvoyé un résultat
     if (mysqli_num_rows($result) == 1) {
    // Récupération de l'id de l'utilisateur et stockage dans la variable $id_usager
    $row = mysqli_fetch_assoc($result);
    $id_admin = $row['id_admin'];
}else {
    // Erreur si la requête ne renvoie pas de résultat
    echo "Erreur: l'utilisateur avec l'email $email n'a pas été trouvé.";
}

    // Récupérer les informations de l'usager à partir de la base de données
    $sql = "SELECT * FROM admin WHERE id_admin = $id_admin";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();

        // Afficher le formulaire de modification du livre
        echo '
        <form method="POST" >
            <input type="hidden" name="id_admin" value="' . $admin['id_admin'] . '">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="' . $admin['email'] . '"><br>
            <label for="password">Password :</label>
            <input type="password" name="password" id="password" value="' . $admin['password'] . '"><br>
            <input type="submit" value="Modifier">
        </form>
        ';
    

    } else {
        echo 'usager introuvable.';
    }

    // Fermer la connexion à la base de données
    mysqli_close($conn);

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer les données du formulaire et effectuer une validation si nécessaire
  $id_admin = $_POST["id_admin"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Créer une connexion à la base de données
  $conn = new mysqli($servername, $username, $password_db, $dbname);

  // Vérifier la connexion à la base de données
  if ($conn->connect_error) {
      die("Erreur de connexion à la base de données: " . $conn->connect_error);
  }

  // Construire la requête de mise à jour sans paramètres de substitution
  $sql = "UPDATE admin SET email='$email', password='$password' WHERE id_admin='$id_admin'";

  // Exécuter la requête de mise à jour
  if ($conn->query($sql) === TRUE) {
    // Afficher une alerte si la modification a réussi
    echo '<script>alert("vos informations ont été modifié avec succès.");</script>';
    // Arrêter l'exécution du script et afficher l'alerte avant la redirection
    echo '<script>window.location.href = "AdminDashboard.php";</script>';
    exit();
  } else {
    echo '<script>alert("Erreur de modification ");</script>';
  }
  // Fermer la connexion à la base de données
  $conn->close();
}

?>


</body>
</html>