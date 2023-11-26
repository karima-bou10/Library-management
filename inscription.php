<?php
 //Nous allons démarrer la session avant toute chose
 session_start();
?>
<?php
if(isset($_POST['submit_admin'])) { // vérifie si le bouton "se connecter" a été cliqué
	if(isset($_POST['email']) && isset($_POST['password'])) { //On verifie ici si l'utilisateur/admin a rentré des informations
	// récupère les valeurs des champs email et password
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password_db = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données
	$conn = mysqli_connect($servername, $username, $password_db, $dbname);

	// vérifie si la connexion a réussi
	if(!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

  	// requête SQL pour vérifier si l'admin existe
	$sql_admin = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
	$result_admin = mysqli_query($conn, $sql_admin);

  // vérifie si la requête a réussi
	if(!$result_admin) {
		echo "Erreur: " . mysqli_error($conn);
		exit();
	}

  // vérifie si l'admin existe dans la base de données
	if(mysqli_num_rows($result_admin) == 1) {
		// ouvre une session pour l'admin
		// Nous allons créer une variable de type session qui vas contenir l'email de l'admin 
		$_SESSION['email'] = $email;
    $_SESSION['password'] = $password;

		// redirige l'admin vers la page "AdminDashboard.php"
		header("Location: AdminDashboard/AdminDashboard.php");
		exit(); // Il est important d'utiliser la fonction exit() après une redirection avec header()
	} else {
		// affiche un message d'erreur si l'utilisateur n'existe pas dans la base de données
        $erreur = "Adresse Mail ou Mots de passe incorrecte !"; 
	}

	// ferme la connexion à la base de données
	mysqli_close($conn);
}
}
?>
<?php
if(isset($_POST['submit_user'])) { // vérifie si le bouton "se connecter" a été cliqué
	if(isset($_POST['email']) && isset($_POST['password'])) { //On verifie ici si l'utilisateur/admin a rentré des informations
	// récupère les valeurs des champs email et password
	$email = $_POST['email'];
	$password = $_POST['password'];

// Configuration de la connexion à la base de données
$servername = "localhost";  // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password_db = "1234"; // Mot de passe MySQL
$dbname = "gestion_biblio"; // Nom de la base de données

	$conn = mysqli_connect($servername, $username, $password_db, $dbname);

	// vérifie si la connexion a réussi
	if(!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// requête SQL pour vérifier si l'utilisateur existe
	$sql_user = "SELECT * FROM usagers WHERE email='$email' AND password='$password'";
	$result_user = mysqli_query($conn, $sql_user);

	// vérifie si la requête a réussi
	if(!$result_user) {
		echo "Erreur: " . mysqli_error($conn);
		exit();
	}

	// vérifie si l'utilisateur existe dans la base de données
	if(mysqli_num_rows($result_user) == 1) {
		// ouvre une session pour l'utilisateur
		// Nous allons créer une variable de type session qui vas contenir l'email de l'utilisateur 
		$_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
		// redirige l'utilisateur vers la page "userDashboard.php"
		header("Location: User/userDashboard.php");
		exit(); // Il est important d'utiliser la fonction exit() après une redirection avec header()
	} else {
		// affiche un message d'erreur si l'utilisateur n'existe pas dans la base de données
        $erreur = "Adresse Mail ou Mots de passe incorrecte !"; 
	}

	// ferme la connexion à la base de données
	mysqli_close($conn);
}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in || Sign up from</title>
    <!-- font awesome icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <!-- css stylesheet -->
    <link rel="stylesheet" href="inscription.css" />
  </head>
  <body>
    <div class="container" id="container">
      <div class="form-container sign-up-container">
        <form action="" method="POST">
          <h1>Usager</h1>
          <br/>
          <span>or use your email for registration</span>
          <?php 
           if(isset($erreur)){// si la variable $erreur existe , on affiche le contenu ;
           echo "<p class= 'Erreur'>".$erreur."</p>"  ;
          }
          ?>
          <div class="infield">
            <input type="email" placeholder="Email" name="email" />
          </div>
          <div class="infield">
            <input type="password" placeholder="Password" name="password" />
          </div>
            <a href="#" class="forgot">Forgot your password?</a>
            <a href="signUp.php" class="compte">Créer Compte</a>
            <button type="submit" name="submit_user">se connecter</button>
        </form>
      </div>


      <div class="form-container sign-in-container">
        <form action="" method="POST">
          <h1>Admin</h1>
          <br/>
          <span>or use your account</span><br />
          <?php 
       if(isset($erreur)){// si la variable $erreur existe , on affiche le contenu ;
           echo "<p class= 'Erreur'>".$erreur."</p>"  ;
       }
       ?>
          <div class="infield">
            <input type="email" placeholder="Email" name="email" />
          </div>
          <div class="infield">
            <input type="password" placeholder="Password" name="password" />
          </div>
          <a href="#" class="forgot">Forgot your password?</a>
          <button type="submit" name="submit_admin">se connecter</button>
        </form>
      </div>


      <div class="overlay-container" id="overlayCon">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1>Salut Usager !</h1>
            <p>Entrer vos infos et reserver votre livre</p>
            <button>ADMIN</button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>Salut Admin!</h1>
            <p>commencer votre gestion de bibliothèque</p>
            <button>Usager</button>
          </div>
        </div>
        <button id="overlayBtn"></button>
      </div>
    </div>

    <!-- js code -->
    <script>
      const container = document.getElementById("container");
      const overlayCon = document.getElementById("overlayCon");
      const overlayBtn = document.getElementById("overlayBtn");

      overlayBtn.addEventListener("click", () => {
        container.classList.toggle("right-panel-active");
        overlayBtn.classList.remove("btnScaled");
        window.requestAnimationFrame(() => {
          overlayBtn.classList.add("btnScaled");
        });
      });
    </script>
  </body>
</html>
