<?php 
//On demare la session sur sur cette page 
session_start() ;
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Attendance Dashboard | By Code Info</title>
  <link rel="stylesheet" href="AdminDashboard.css" />
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  <script src="AdminDashboard.js"></script>
  
</head>


<body>
  <div class="container">
    <nav>
         <div class="logo">
          <img src="../images/CLICK-bookAdmin.png" alt="Logo">
        </div>
          
      <ul>
        
        <li>
          
            <a href="#" onclick="afficherStatistiques()">
              <i class="fas fa-home"></i>
              <span class="nav-item">Dashboard</span>
            </a>
          
        </li>
        <li>
          <div class="dropdown">
            <a href="#">
              <i class="fas fa-book"></i>
              <span class="nav-item">Livres</span>
            </a>
          <div class="dropdown-content" >
            <a href="#" onclick="afficherLivres()" id="lien-livres">Liste des Livres</a>
            <a href="ajouter_livre.php" >Ajouter un Livre</a>
          </div>
          </div>
        </li>
        <li>
          <div class="dropdown">
            <a href="#" >
              <i class="fas fa-users"></i>
              <span class="nav-item">Usagers</span>
            </a>
          <div class="dropdown-content" >
            <a href="#" onclick="afficherUsagers()" id="lien-usagers" >Liste des usagers </a>
           
          </div>
          </div>
        </li>
        <li>
          <div class="dropdown">
            <a href="#">
              <i class="fas fa-check"></i>
              <span class="nav-item">Emprunts</span>
            </a>
          <div class="dropdown-content" >
            <a href="#" onclick="afficherEmpruntsCourant()" id="lien-empruntsCourant">Les Emprunts en cours </a>
            <a href="#" onclick="afficherEmprunts() " id="lien-emprunts">l’historique des emprunts </a>
          </div>
          </div>
        </li>
      
      
       
        
        
        <li><a href="modifier_infos.php">
          <i class="fas fa-cog"></i>
          <span class="nav-item">Mes informations</span>
        </a></li>

        <li><a href="/projetWeb/inscription.php" class="logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>

   

    
    <section id="main" class="main">
    
     
    </section>
    
    
  </div>

</body>
</html>
