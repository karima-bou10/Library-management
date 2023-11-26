
 // Appeler la fonction pour afficher les statistiques au chargement de la page
 window.addEventListener("load", function () {
  afficherStatistiques();
});

function afficherUsagers() {
  // Supprimer le contenu existant de la section principale
  var sectionMain = document.querySelector('.main');
  sectionMain.innerHTML = '';

   // Supprimer le contenu existant de la section principale
   var sectionMain = document.querySelector('.main');
   sectionMain.innerHTML = '';
  // Créer la barre de recherche
  var searchInput = document.createElement('input');
  searchInput.classList.add('styled-search');

  searchInput.setAttribute('type', 'text');
  searchInput.setAttribute('id', 'search-input');
  searchInput.setAttribute('placeholder', 'Rechercher...');
  searchInput.addEventListener('input', RechercherUsager); // Ajouter un écouteur d'événement pour la recherche en temps réel

  // Ajouter la barre de recherche à la section principale
  sectionMain.insertBefore(searchInput, sectionMain.firstChild);

  // Appel du fichier PHP pour récupérer les utilisateurs
  fetch('usagers.php')
    .then(response => response.json())
    .then(data => {
      // Créer le tableau
      var table = document.createElement('table');
      table.classList.add('styled-table');

      // Créer la ligne d'en-tête du tableau
      var headerRow = document.createElement('tr');
      var headers = ['ID', 'Nom', 'Prénom', 'Adresse', 'Statut', 'Email', 'Mot de passe','Action'];

      headers.forEach(headerText => {
        var th = document.createElement('th');
        th.textContent = headerText;
        headerRow.appendChild(th);
      });

      table.appendChild(headerRow);

      // Parcourir les utilisateurs et créer les lignes du tableau
      data.forEach(utilisateur => {
        var row = document.createElement('tr');
        row.classList.add('ligne-utilisateur');

        var idCell = document.createElement('td');
        idCell.textContent = utilisateur.id;
        row.appendChild(idCell);

        var nomCell = document.createElement('td');
        nomCell.textContent = utilisateur.nom;
        row.appendChild(nomCell);

        var prenomCell = document.createElement('td');
        prenomCell.textContent = utilisateur.prenom;
        row.appendChild(prenomCell);

        var adresseCell = document.createElement('td');
        adresseCell.textContent = utilisateur.adresse;
        row.appendChild(adresseCell);

        var statutCell = document.createElement('td');
        statutCell.textContent = utilisateur.statut;
        row.appendChild(statutCell);

        var emailCell = document.createElement('td');
        emailCell.textContent = utilisateur.email;
        row.appendChild(emailCell);

        var passwordCell = document.createElement('td');
        passwordCell.textContent = utilisateur.password;
        row.appendChild(passwordCell);

        table.appendChild(row);
        // Ajouter une colonne pour les liens de suppression et de modification
        var actionsCell = document.createElement('td');
  
 
        // Lien de suppression
        var supprimerLink = document.createElement('a');
        supprimerLink.href = 'supprimer_usager.php?id=' + utilisateur.id; // Lien vers le fichier PHP de suppression avec l'ID du emprunt
        supprimerLink.textContent = 'Supprimer';
        supprimerLink.classList.add('supprimer-link'); // Ajouter la classe CSS au lien

        actionsCell.appendChild(supprimerLink);
       
      row.appendChild(actionsCell); 

        table.appendChild(row);
      });

      // Ajouter le tableau à la section principale
      sectionMain.appendChild(table);
    })
    .catch(error => {
      console.error('Une erreur s\'est produite lors de la récupération des utilisateurs:', error);
    });

  
}

// Appeler la fonction pour afficher les usagers au chargement de la page
//window.addEventListener('load', afficherUsagers);
var lienUsagers = document.getElementById('lien-usagers');
lienUsagers.addEventListener('click', afficherUsagers);


function RechercherUsager() {
 // Récupérer la valeur de l'entrée de recherche
 var input = document.getElementById('search-input');
 var filter = input.value.toUpperCase();

 // Récupérer les lignes de livres
 var lignesUsagers = document.querySelectorAll('.ligne-utilisateur');

 // Parcourir les lignes de livres et masquer celles qui ne correspondent pas à la recherche
 for (var i = 0; i < lignesUsagers.length; i++) {
   var nomUsager = lignesUsagers[i].getElementsByTagName('td')[1];
   var textenomUsager = nomUsager.textContent.toUpperCase();
   if (textenomUsager.indexOf(filter) > -1) {
     lignesUsagers[i].style.display = '';
   } else {
     lignesUsagers[i].style.display = 'none';
   }
 }
}




function afficherLivres() {

   // Supprimer le contenu existant de la section principale
   var sectionMain = document.querySelector('.main');
   sectionMain.innerHTML = '';
  // Créer la barre de recherche
  var searchInput = document.createElement('input');
  searchInput.classList.add('styled-search');

  searchInput.setAttribute('type', 'text');
  searchInput.setAttribute('id', 'search-input');
  searchInput.setAttribute('placeholder', 'Rechercher...');
  searchInput.addEventListener('input', RechercherLivre); // Ajouter un écouteur d'événement pour la recherche en temps réel

  // Ajouter la barre de recherche à la section principale
  sectionMain.insertBefore(searchInput, sectionMain.firstChild);

  // Appel du fichier PHP pour récupérer les livres
  fetch('livres.php')
    .then(response => response.json())
    .then(data => {
      // Créer le tableau
      var table = document.createElement('table');
      table.classList.add('styled-table');

      // Créer la ligne d'en-tête du tableau
      var headerRow = document.createElement('tr');
      var headers = ['ID', 'Titre', 'Auteurs', 'Maison Edition', 'Nombre de Pages', 'Nombres des exemplaires','ACTION'];

      headers.forEach(headerText => {
        var th = document.createElement('th');
        th.textContent = headerText;
        headerRow.appendChild(th);
      });

      table.appendChild(headerRow);

      // Parcourir les livres et créer les lignes du tableau
      data.forEach(livre => {
        var row = document.createElement('tr');
        row.classList.add('ligne-livre');

        var idCell = document.createElement('td');
        idCell.textContent = livre.id;
        row.appendChild(idCell);

        var titreCell = document.createElement('td');
        titreCell.textContent = livre.titre;
        row.appendChild(titreCell);

        var auteurCell = document.createElement('td');
        auteurCell.textContent = livre.auteurs;
        row.appendChild(auteurCell);

        var maisoneditionCell = document.createElement('td');
        maisoneditionCell.textContent = livre.maison_edition;
        row.appendChild(maisoneditionCell);

        var nbpagesCell = document.createElement('td');
        nbpagesCell.textContent = livre.nb_pages;
        row.appendChild(nbpagesCell);

        var nbexemplairesCell = document.createElement('td');
        nbexemplairesCell.textContent = livre.nb_exemplaires;
        row.appendChild(nbexemplairesCell);

        table.appendChild(row);
        // Ajouter une colonne pour les liens de suppression et de modification
        var actionsCell = document.createElement('td');
        actionsCell.classList.add('actions-container');

        // Lien de suppression
        var supprimerLink = document.createElement('a');
        supprimerLink.href = 'supprimer_livre.php?id=' + livre.id; // Lien vers le fichier PHP de suppression avec l'ID du livre
        supprimerLink.textContent = 'Supprimer';
        supprimerLink.classList.add('supprimer-link'); // Ajouter la classe CSS au lien

        actionsCell.appendChild(supprimerLink);

        var modifierLink = document.createElement('a');
        modifierLink.href = 'modifier_livre.php?id=' + livre.id;
        modifierLink.textContent = 'Modifier';
        modifierLink.classList.add('modifier-link');

      // Ajouter un séparateur entre les deux liens (par exemple, une virgule)
      var separator = document.createTextNode(' ');

      actionsCell.appendChild(separator);
      actionsCell.appendChild(modifierLink);
      row.appendChild(actionsCell); 

        table.appendChild(row);

      });

      // Ajouter le tableau à la section principale
      sectionMain.appendChild(table);
    })
    .catch(error => {
      console.error('Une erreur s\'est produite lors de la récupération des livres:', error);
    });
    
}
var lienLivres = document.getElementById('lien-livres');
lienLivres.addEventListener('click', afficherLivres);

// Appeler la fonction pour afficher les livres au chargement de la page
//window.addEventListener('load', afficherLivres);


function RechercherLivre() {
  // Récupérer la valeur de l'entrée de recherche
  var input = document.getElementById('search-input');
  var filter = input.value.toUpperCase();

  // Récupérer les lignes de livres
  var lignesLivres = document.querySelectorAll('.ligne-livre');

  // Parcourir les lignes de livres et masquer celles qui ne correspondent pas à la recherche
  for (var i = 0; i < lignesLivres.length; i++) {
    var titreLivre = lignesLivres[i].getElementsByTagName('td')[1];
    var texteTitreLivre = titreLivre.textContent.toUpperCase();
    if (texteTitreLivre.indexOf(filter) > -1) {
      lignesLivres[i].style.display = '';
    } else {
      lignesLivres[i].style.display = 'none';
    }
  }
}






function afficherEmprunts() {
  // Supprimer le contenu existant de la section principale
  var sectionMain = document.querySelector('.main');
  sectionMain.innerHTML = '';

  // Appel du fichier PHP pour récupérer les livres
  fetch('emprunts.php')
    .then(response => response.json())
    .then(data => {
      // Créer le tableau
      var table = document.createElement('table');
      table.classList.add('styled-table');

      // Créer la ligne d'en-tête du tableau
      var headerRow = document.createElement('tr');
      var headers = ['ID_EMPRUNT','ID_LIVRE','ID_USAGERS', 'DATE EMPRUNT', 'DATE RETOUR','ACTION'];

      headers.forEach(headerText => {
        var th = document.createElement('th');
        th.textContent = headerText;
        headerRow.appendChild(th);
      });

      table.appendChild(headerRow);

      // Parcourir les emprunts et créer les lignes du tableau
      data.forEach(emprunt => {
        var row = document.createElement('tr');

        var idEmpruntCell = document.createElement('td');
        idEmpruntCell.textContent = emprunt.id_emprunt;
        row.appendChild(idEmpruntCell);

        var idLivreCell = document.createElement('td');
        idLivreCell.textContent = emprunt.id_livre;
        row.appendChild(idLivreCell);

        var idUsagerCell = document.createElement('td');
        idUsagerCell.textContent = emprunt.id_usager;
        row.appendChild(idUsagerCell);

        var dateECell = document.createElement('td');
        dateECell.textContent = emprunt.date_emprunt;
        row.appendChild(dateECell);

        var dateReCell = document.createElement('td');
        dateReCell.textContent = emprunt.date_retour;
        row.appendChild(dateReCell);

      
        table.appendChild(row);

         // Ajouter une colonne pour les liens de suppression et de modification
         var actionsCell = document.createElement('td');
  
 
         // Lien de suppression
         var supprimerLink = document.createElement('a');
         supprimerLink.href = 'supprimer_emprunt.php?id=' + emprunt.id_emprunt; // Lien vers le fichier PHP de suppression avec l'ID du emprunt
         supprimerLink.textContent = 'Supprimer';
         supprimerLink.classList.add('supprimer-link'); // Ajouter la classe CSS au lien
 
         actionsCell.appendChild(supprimerLink);
        
       row.appendChild(actionsCell); 
 
         table.appendChild(row);
      });

      // Ajouter le tableau à la section principale
      sectionMain.appendChild(table);
    })
    .catch(error => {
      console.error('Une erreur s\'est produite lors de la récupération des emprunts :', error);
    });

    
    
}


//window.addEventListener('load', afficherEmprunts);

var lienEmprunts = document.getElementById('lien-emprunts');
    lienEmprunts.addEventListener('click', afficherEmprunts);
  //


    


function afficherEmpruntsCourant() {
          // Supprimer le contenu existant de la section principale
          var sectionMain = document.querySelector('.main');
          sectionMain.innerHTML = '';
        
          // Appel du fichier PHP pour récupérer les livres
          fetch('empruntsCourant.php')
            .then(response => response.json())
            .then(data => {
              // Créer le tableau
              var table = document.createElement('table');
              table.classList.add('styled-table');
        
              // Créer la ligne d'en-tête du tableau
              var headerRow = document.createElement('tr');
              var headers = ['ID_Emprunt','ID_LIVRE','ID_USAGERS', 'DATE EMPRUNT', 'DATE RETOUR','ACTION'];
        
              headers.forEach(headerText => {
                var th = document.createElement('th');
                th.textContent = headerText;
                headerRow.appendChild(th);
              });
        
              table.appendChild(headerRow);
        
              // Parcourir les emprunts et créer les lignes du tableau
              data.forEach(empruntCourant => {
                var row = document.createElement('tr');
        
                var idEmpruntCell = document.createElement('td');
                idEmpruntCell.textContent = empruntCourant.id_emprunt;
                row.appendChild(idEmpruntCell);
        
                var idLivreCell = document.createElement('td');
                idLivreCell.textContent = empruntCourant.id_livre;
                row.appendChild(idLivreCell);
        
                var idUsagerCell = document.createElement('td');
                idUsagerCell.textContent = empruntCourant.id_usager;
                row.appendChild(idUsagerCell);
        
                var dateECell = document.createElement('td');
                dateECell.textContent = empruntCourant.date_emprunt;
                row.appendChild(dateECell);
        
                var dateReCell = document.createElement('td');
                dateReCell.textContent = empruntCourant.date_retour;
                row.appendChild(dateReCell);
        
              
                table.appendChild(row);
                // Ajouter une colonne pour les liens de suppression et de modification
                var actionsCell = document.createElement('td');
  
 
               // Lien de suppression
               var supprimerLink = document.createElement('a');
               supprimerLink.href = 'supprimer_emprunt.php?id=' + empruntCourant.id_emprunt; // Lien vers le fichier PHP de suppression avec l'ID du empruntCourant
               supprimerLink.textContent = 'Supprimer';
               supprimerLink.classList.add('supprimer-link'); // Ajouter la classe CSS au lien
 
              actionsCell.appendChild(supprimerLink);
        
               row.appendChild(actionsCell); 
 
              table.appendChild(row);

              });
        
              // Ajouter le tableau à la section principale
              sectionMain.appendChild(table);
            })
            .catch(error => {
              console.error('Une erreur s\'est produite lors de la récupération des emprunts :', error);
            });

           
 }
        
        
   //window.addEventListener('load', afficherEmpruntsCourant);
   var lienEmpruntsCourant = document.getElementById('lien-empruntsCourant');
   lienEmpruntsCourant.addEventListener('click', afficherEmpruntsCourant);
       
   
   function afficherStatistiques() {
    // Supprimer le contenu existant de la section principale
    var sectionMain = document.querySelector(".main");
    sectionMain.innerHTML = "";
  
    // Appel du fichier PHP pour récupérer les statistiques
    fetch("home.php")
      .then((response) => response.json())
      .then((data) => {
        // Récupérer les données du tableau statistiques
        var nombreLivres = data.nombreLivres;
        var nombreEmprunts= data.nombreEmprunts;
        var nombreUsagers = data.nombreUsagers;
  
        // Créer la structure HTML de la section principale
        var boxContainer = document.createElement("div");
        boxContainer.classList.add("box-container");
  
        var box1 = document.createElement("div");
        box1.classList.add("box");
        var box1Title = document.createElement("h2");
        box1Title.textContent = "Nombre de livres";
        var box1Content = document.createElement("p");
        box1Content.textContent = nombreLivres;
        box1.appendChild(box1Title);
        box1.appendChild(box1Content);
  
        var box2 = document.createElement("div");
        box2.classList.add("box");
        var box2Title = document.createElement("h2");
        box2Title.textContent = "Nombre des emprunts";
        var box2Content = document.createElement("p");
        box2Content.textContent = nombreEmprunts;
        box2.appendChild(box2Title);
        box2.appendChild(box2Content);
  
        var box3 = document.createElement("div");
        box3.classList.add("box");
        var box3Title = document.createElement("h2");
        box3Title.textContent = "Nombre des Usagers";
        var box3Content = document.createElement("p");
        box3Content.textContent = nombreUsagers;
        box3.appendChild(box3Title);
        box3.appendChild(box3Content);
  
        boxContainer.appendChild(box1);
        boxContainer.appendChild(box2);
        boxContainer.appendChild(box3);
  
        sectionMain.appendChild(boxContainer);
  
        
      });
  }
 