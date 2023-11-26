<?php 
//On demare la session sur sur cette page 
session_start() ;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion d'une bibliothèque</title>
    <link rel="stylesheet" href="userDashboard.css" />
    <!-- Font Awesome Cdn Link -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <script src="listeLivres.js"></script>
  </head>
  <body>
    <div class="container">
      <nav>
            <div class="logo">
            <img src="../images/CLICK book.png" alt="Logo" />
            </div>
        <ul>
          <li>
            <a href="#" onclick="afficherStatistiques()">
              <i class="fas fa-home"></i>
              <span class="nav-item">Home</span>
            </a>
          </li>

          <li>
            <a href="#" onclick="afficherLivres()" id="lien-livres">
              <i class="fas fa-book"></i>
              <span class="nav-item">Liste des livres</span>
            </a>
          </li>

          <li>
            <div class="dropdown">
              <a href="#">
                <i class="fas fa-check"></i>
                <span class="nav-item">Mes emprunts</span>
              </a>
              <div class="dropdown-content">
                <a href="#" onclick="mesEmprunts()" id="lien-emprunts"
                  >Mes emprunts en cours
                </a>
                <a href="#" onclick="histoEmprunts()" id="lien-histo"
                  >L’historique de mes emprunts
                </a>
              </div>
            </div>
          </li>

          <li>
            <a href="mesInfos.php">
              <i class="fas fa-cog"></i>
              <span class="nav-item">Mes informations</span>
            </a>
          </li>

          <li>
            <a href="../inscription.php" class="logout">
              <i class="fas fa-sign-out-alt"></i>
              <span class="nav-item">Log out</span>
            </a>
          </li>
        </ul>
      </nav>

      <section class="main">
     
      </section>
    </div>

  </body>
</html>
