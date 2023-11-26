// Appeler la fonction pour afficher les statistiques au chargement de la page
window.addEventListener("load", function () {
  afficherStatistiques();
});

//Afficher les Livres

function afficherLivres() {
  // Supprimer le contenu existant de la section principale
  var sectionMain = document.querySelector(".main");
  sectionMain.innerHTML = "";

  // Créer la barre de recherche
  var searchInput = document.createElement("input");
  searchInput.classList.add("styled-search");

  searchInput.setAttribute("type", "text");
  searchInput.setAttribute("id", "search-input");
  searchInput.setAttribute("placeholder", "Rechercher...");
  searchInput.addEventListener("input", RechercherLivre); // Ajouter un écouteur d'événement pour la recherche en temps réel

  // Ajouter la barre de recherche à la section principale
  sectionMain.insertBefore(searchInput, sectionMain.firstChild);

  // Créer le tableau
  var table = document.createElement("table");
  table.classList.add("styled-table");

  // Créer la ligne d'en-tête du tableau
  var headerRow = document.createElement("tr");
  var headers = [
    "ID",
    "Titre",
    "Auteurs",
    "Maison Edition",
    "Nombre de Pages",
    "Nombres des exemplaires",
    "Action",
  ];

  headers.forEach((headerText) => {
    var th = document.createElement("th");
    th.textContent = headerText;
    headerRow.appendChild(th);
  });

  table.appendChild(headerRow);
  sectionMain.appendChild(table);

  // Appel du fichier PHP pour récupérer les livres
  fetch("afficherLivres.php")
    .then((response) => response.json())
    .then((data) => {
      // Parcourir les livres et créer les lignes du tableau
      data.forEach((livre) => {
        var row = document.createElement("tr");
        row.classList.add("ligne-livre");

        var idCell = document.createElement("td");
        idCell.textContent = livre.id;
        row.appendChild(idCell);

        var titreCell = document.createElement("td");
        titreCell.textContent = livre.titre;
        row.appendChild(titreCell);

        var auteurCell = document.createElement("td");
        auteurCell.textContent = livre.auteurs;
        row.appendChild(auteurCell);

        var maisoneditionCell = document.createElement("td");
        maisoneditionCell.textContent = livre.maison_edition;
        row.appendChild(maisoneditionCell);

        var nbpagesCell = document.createElement("td");
        nbpagesCell.textContent = livre.nb_pages;
        row.appendChild(nbpagesCell);

        var nbexemplairesCell = document.createElement("td");
        nbexemplairesCell.textContent = livre.nb_exemplaires;
        row.appendChild(nbexemplairesCell);

        // Ajouter une colonne pour les liens de suppression et de modification
        var actionsCell = document.createElement("td");
        actionsCell.classList.add("actions-container");
        // Lien de reservation
        var reserverLink = document.createElement("a");
        reserverLink.href = "reserver_livre.php?id=" + livre.id; // Lien vers le fichier PHP de reservation avec l'ID du livre
        reserverLink.textContent = "Reserver";
        reserverLink.classList.add("reserver-link"); // Ajouter la classe CSS au lien

        actionsCell.appendChild(reserverLink);

        row.appendChild(actionsCell);

        table.appendChild(row);
      });

      // Ajouter le tableau à la section principale
      sectionMain.appendChild(table);
    })
    .catch((error) => {
      console.error(
        "Une erreur s'est produite lors de la récupération des livres:",
        error
      );
    });
}

// Appeler la fonction pour afficher les livres au chargement de la page
//window.addEventListener("load", afficherLivres);
var lienLivres = document.getElementById("lien-livres");
lienLivres.addEventListener("click", afficherLivres);

function RechercherLivre() {
  // Récupérer la valeur de l'entrée de recherche
  var input = document.getElementById("search-input");
  var filter = input.value.toUpperCase();

  // Récupérer les lignes de livres
  var lignesLivres = document.querySelectorAll(".ligne-livre");

  // Parcourir les lignes de livres et masquer celles qui ne correspondent pas à la recherche
  for (var i = 0; i < lignesLivres.length; i++) {
    var titreLivre = lignesLivres[i].getElementsByTagName("td")[1];
    var texteTitreLivre = titreLivre.textContent.toUpperCase();
    if (texteTitreLivre.indexOf(filter) > -1) {
      lignesLivres[i].style.display = "";
    } else {
      lignesLivres[i].style.display = "none";
    }
  }
}

//Afficher les emprunts en cours
function mesEmprunts() {
  // Supprimer le contenu existant de la section principale
  var sectionMain = document.querySelector(".main");
  sectionMain.innerHTML = "";

  // Créer le tableau
  var table = document.createElement("table");
  table.classList.add("styled-table");

  // Créer la ligne d'en-tête du tableau
  var headerRow = document.createElement("tr");
  var headers = [
    "ID_EMPRUNT",
    "ID_LIVRE",
    "ID_USAGERS",
    "DATE EMPRUNT",
    "DATE RETOUR",
    "Action",
  ];

  headers.forEach((headerText) => {
    var th = document.createElement("th");
    th.textContent = headerText;
    headerRow.appendChild(th);
  });

  table.appendChild(headerRow);
  sectionMain.appendChild(table);

  // Appel du fichier PHP pour récupérer les livres
  fetch("mesEmprunts.php")
    .then((response) => response.json())
    .then((data) => {
      // Parcourir les emprunts et créer les lignes du tableau
      data.forEach((emprunt) => {
        var row = document.createElement("tr");

        var idEmpruntCell = document.createElement("td");
        idEmpruntCell.textContent = emprunt.id_emprunt;
        row.appendChild(idEmpruntCell);

        var idLivreCell = document.createElement("td");
        idLivreCell.textContent = emprunt.id_livre;
        row.appendChild(idLivreCell);

        var idUsagerCell = document.createElement("td");
        idUsagerCell.textContent = emprunt.id_usager;
        row.appendChild(idUsagerCell);

        var dateECell = document.createElement("td");
        dateECell.textContent = emprunt.date_emprunt;
        row.appendChild(dateECell);

        var dateReCell = document.createElement("td");
        dateReCell.textContent = emprunt.date_retour;
        row.appendChild(dateReCell);

        // Ajouter une colonne pour le lien pour rendre le livre
        var actionsCell = document.createElement("td");
        actionsCell.classList.add("actions-container");
        // Lien de rendre
        var rendreLink = document.createElement("a");
        rendreLink.href = "rendre_livre.php?id=" + emprunt.id_livre; // Lien vers le fichier PHP avec l'ID du livre
        rendreLink.textContent = "Rendre";
        rendreLink.classList.add("rendre-link"); // Ajouter la classe CSS au lien

        actionsCell.appendChild(rendreLink);

        row.appendChild(actionsCell);

        table.appendChild(row);
      });

      // Ajouter le tableau à la section principale
      sectionMain.appendChild(table);
    })
    .catch((error) => {
      console.error(
        "Une erreur s'est produite lors de la récupération des emprunts:",
        error
      );
      console.error("Message d'erreur du serveur:", error.message);
    });
}

// Appeler la fonction pour afficher les emprunts au chargement de la page
var lienEmprunts = document.getElementById("lien-emprunts");
lienEmprunts.addEventListener("click", mesEmprunts);

//Afficher l'historique des emprunts

function histoEmprunts() {
  // Supprimer le contenu existant de la section principale
  var sectionMain = document.querySelector(".main");
  sectionMain.innerHTML = "";

  // Créer le tableau
  var table = document.createElement("table");
  table.classList.add("styled-table");

  // Créer la ligne d'en-tête du tableau
  var headerRow = document.createElement("tr");
  var headers = [
    "ID_EMPRUNT",
    "ID_LIVRE",
    "ID_USAGERS",
    "DATE EMPRUNT",
    "DATE RETOUR",
  ];

  headers.forEach((headerText) => {
    var th = document.createElement("th");
    th.textContent = headerText;
    headerRow.appendChild(th);
  });

  table.appendChild(headerRow);
  sectionMain.appendChild(table);

  // Appel du fichier PHP pour récupérer les livres
  fetch("histoEmpr.php")
    .then((response) => response.json())
    .then((data) => {
      // Parcourir les emprunts et créer les lignes du tableau
      data.forEach((emprunt) => {
        var row = document.createElement("tr");

        var idEmpruntCell = document.createElement("td");
        idEmpruntCell.textContent = emprunt.id_emprunt;
        row.appendChild(idEmpruntCell);

        var idLivreCell = document.createElement("td");
        idLivreCell.textContent = emprunt.id_livre;
        row.appendChild(idLivreCell);

        var idUsagerCell = document.createElement("td");
        idUsagerCell.textContent = emprunt.id_usager;
        row.appendChild(idUsagerCell);

        var dateECell = document.createElement("td");
        dateECell.textContent = emprunt.date_emprunt;
        row.appendChild(dateECell);

        var dateReCell = document.createElement("td");
        dateReCell.textContent = emprunt.date_retour;
        row.appendChild(dateReCell);

        table.appendChild(row);
      });

      // Ajouter le tableau à la section principale
      sectionMain.appendChild(table);
    })
    .catch((error) => {
      console.error(
        "Une erreur s'est produite lors de la récupération des emprunts:",
        error
      );
      console.error("Message d'erreur du serveur:", error.message);
    });
}

// Appeler la fonction pour afficher les emprunts au chargement de la page
var lienEmprunts = document.getElementById("lien-histo");
lienEmprunts.addEventListener("click", histoEmprunts);

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
      var nombreEmprunts_encours = data.nombreEmprunts_encours;
      var nombreEmprunts_histo = data.nombreEmprunts_histo;

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
      box2Title.textContent = "Nombre de mes emprunts en cours";
      var box2Content = document.createElement("p");
      box2Content.textContent = nombreEmprunts_encours;
      box2.appendChild(box2Title);
      box2.appendChild(box2Content);

      var box3 = document.createElement("div");
      box3.classList.add("box");
      var box3Title = document.createElement("h2");
      box3Title.textContent = "Nombre des emprunts dans mon historique";
      var box3Content = document.createElement("p");
      box3Content.textContent = nombreEmprunts_histo;
      box3.appendChild(box3Title);
      box3.appendChild(box3Content);

      boxContainer.appendChild(box1);
      boxContainer.appendChild(box2);
      boxContainer.appendChild(box3);

      sectionMain.appendChild(boxContainer);

      // Ajouter une balise aside avec deux headers à l'intérieur
      var aside = document.createElement("aside");
      aside.classList.add("right");

      // Créer le premier header (Email et téléphone)
      var header1 = document.createElement("header");
      var header1Title = document.createElement("h2");
      header1Title.textContent = "Contact";
      var breakline = document.createElement("br");

      var header1Content = document.createElement("div");
      header1Content.classList.add("content_contact");

      var envelopeIcon = document.createElement("i");
      envelopeIcon.classList.add("fas", "fa-phone");
      var header1Text = document.createElement("p");
      header1Text.textContent = "+ 212 (0)5 28 82 78 95";
      var header1Content1 = document.createElement("div");
      header1Content1.classList.add("content1");
      header1Content1.appendChild(envelopeIcon);
      header1Content1.appendChild(header1Text);

      var envelopeIcon2 = document.createElement("i");
      envelopeIcon2.classList.add("fas", "fa-envelope");
      var header2Text = document.createElement("p");
      header2Text.textContent = "resp_biblio@gmail.com";
      var header1Content2 = document.createElement("div");
      header1Content2.classList.add("content1");
      header1Content2.appendChild(envelopeIcon2);
      header1Content2.appendChild(header2Text);

      header1Content.appendChild(header1Content1);
      header1Content.appendChild(header1Content2);
      header1.appendChild(header1Title);
      header1.appendChild(breakline);
      header1.appendChild(header1Content);

      // Créer le deuxième header (Horaires d’ouverture)
      var header2 = document.createElement("header");
      var header2Title = document.createElement("h2");
      header2Title.textContent = "Horaires d’ouverture";
      var breakline = document.createElement("br");

      var header2Content = document.createElement("div");
      header2Content.classList.add("content_horaire");

      var header2Text = document.createElement("p");
      header2Text.textContent = "Mardi : 09h30-12h00 / 14h30-18h00";
      header2Content.appendChild(header2Text);

      var header3Text = document.createElement("p");
      header3Text.textContent = "Mercredi : 09h30-12h00 / 14h30-18h00";
      header2Content.appendChild(header3Text);

      var header4Text = document.createElement("p");
      header4Text.textContent = "Vendredi : 09h30-12h00 / 14h30-18h00";
      header2Content.appendChild(header4Text);

      var header5Text = document.createElement("p");
      header5Text.textContent = "Lundi / Jeudi : Fermeture hebdomadaire";
      header2Content.appendChild(header5Text);

      header2.appendChild(header2Title);
      header2.appendChild(breakline);
      header2.appendChild(header2Content);

      // Ajouter les deux headers à la balise aside
      aside.appendChild(header1);
      aside.appendChild(header2);

      sectionMain.appendChild(aside);
    });
}
