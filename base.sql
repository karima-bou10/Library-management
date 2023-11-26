-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Serveur : MySQL (127.0.0.1 via TCP/IP)
-- Type de serveur : MySQL
-- Server version: 8.0.22 - MySQL Community Server - GPL
-- Version du protocole : 10
-- Utilisateur : root@localhost
-- PHP Version: 8.0.26

--
-- Database: `gestion_biblio`
--

-- --------------------------------------------------------

--
-- Structure du table `admin`
--
CREATE TABLE Admin (
  id_admin INT PRIMARY KEY,
  username VARCHAR(255),
  password VARCHAR(255)
);
--
-- Insertion du données dans la table `admin`
--
INSERT INTO `admin`(`id_admin`, `username`, `password`) VALUES ('1','karimasamar@gmail.com','1234');



--
-- Structure du table `livres`
--
CREATE TABLE Livres (
  id_livre INT PRIMARY KEY,
  titre VARCHAR(255),
  auteurs VARCHAR(255),
  maison_edition VARCHAR(255),
  nb_pages INT,
  nb_exemplaires INT
);
--
-- Insertion du données dans la table `livres`
--
INSERT INTO Livres (id_livre, titre, auteurs, maison_edition, nb_pages, nb_exemplaires)
VALUES (1, 'Guerre et Paix', 'Léon Tolstoï', 'Folio', 1440, 3),
       (2, 'Les Misérables', 'Victor Hugo', 'Gallimard', 1488, 5),
       (3, 'Le Rouge et le Noir', 'Stendhal', 'GF Flammarion', 608, 2),
       (4, '1984', 'George Orwell', 'Folio', 416, 4),
       (5, 'Le Comte de Monte-Cristo', 'Alexandre Dumas', 'Le Livre de Poche', 1312, 7),
       (6, 'L\'Étranger', 'Albert Camus', 'Gallimard', 123, 1),
       (7, 'La Nausée', 'Jean-Paul Sartre', 'Gallimard', 288, 2),
       (8, 'Les Fleurs du mal', 'Charles Baudelaire', 'Le Livre de Poche', 286, 3),
       (9, 'Le Petit Prince', 'Antoine de Saint-Exupéry', 'Gallimard', 96, 6),
       (10, 'La Promesse de l'aube', 'Romain Gary', 'Gallimard', 400, 2);



--
-- Structure du table `usagers`
--
CREATE TABLE Usagers (
  id_usager INT PRIMARY KEY,
  nom VARCHAR(255),
  prenom VARCHAR(255),
  adresse VARCHAR(255),
  statut VARCHAR(50),
  email VARCHAR(255),
  password VARCHAR(255)
);
--
-- Insertion du données dans la table `usagers`
--
INSERT INTO usagers (id_usager,nom, prenom, adresse, statut, email,password)
VALUES (1,'Durand', 'Pierre', '2 Rue des Lilas, 75010 Paris', 'Enseignant', 'pierre.durand@gmail.com','123'),
       (2,'Dupont', 'Sophie', '15 Rue des Champs, 13002 Marseille', 'Etudiant', 'sophie.dupont@etu.univ-amu.fr','pass'),
       (3,'Martin', 'Jean', '28 Rue de la Paix, 69002 Lyon', 'Enseignant', 'jean.martin@univ-lyon.fr','123'),
       (4,'Leclerc', 'Marie', '4 Avenue des Roses, 31000 Toulouse', 'Etudiant', 'marie.leclerc@etu.ut-capitole.fr','345'),
       (5,'Dubois', 'Luc', '21 Rue de la Gare, 59000 Lille', 'Etudiant', 'luc.dubois@etu.univ-lille.fr','678'),
       (6,'Bernard', 'Alice', '6 Rue de la Liberté, 75003 Paris', 'Etudiant', 'alice.bernard@etu.sorbonne.fr','567'),
       (7,'Girard', 'Thomas', '13 Rue des Fleurs, 33000 Bordeaux', 'Enseignant', 'thomas.girard@u-bordeaux.fr','160'),
       (8,'Lefebvre', 'Camille', '8 Rue du Commerce, 44000 Nantes', 'Etudiant', 'camille.lefebvre@etu.univ-nantes.fr','654'),
       (9,'Roux', 'Antoine', '10 Avenue des Platanes, 13008 Marseille', 'Enseignant', 'antoine.roux@univ-amu.fr','194'),
       (10,'Moreau', 'Julie', '3 Rue des Cerisiers, 69006 Lyon', 'Etudiant', 'julie.moreau@etu.univ-lyon.fr','980');



--
-- Structure du table `emprunts`
--
CREATE TABLE Emprunts (
  id_emprunt INT PRIMARY KEY,
  id_livre INT,
  id_usager INT,
  date_emprunt DATE,
  date_retour DATE,
  FOREIGN KEY (id_livre) REFERENCES Livres(id_livre),
  FOREIGN KEY (id_usager) REFERENCES Usagers(id_usager)
);
--
-- Insertion du données dans la table `emprunts`
--
INSERT INTO Emprunts (id_emprunt,id_livre, id_usager, date_emprunt, date_retour)
VALUES (1,1, 2, '2023-05-01', '2023-06-01'),
       (2,3, 4, '2023-05-02', '2023-06-02'),
       (3,2, 5, '2023-05-03', '2023-06-03'),
       (4,4, 1, '2023-05-04', '2023-06-04'),
       (5,1, 3, '2023-05-05', '2023-06-05'),
       (6,5, 2, '2023-05-06', '2023-06-06'),
       (7,3, 1, '2023-05-07', '2023-06-07'),
       (8,2, 4, '2023-05-08', '2023-06-08'),
       (9,1, 5, '2023-05-09', '2023-06-09'),
       (10,4, 3, '2023-05-10', '2023-06-10');


--
-- mettre id_livre auto_increment
--
ALTER TABLE emprunts DROP FOREIGN KEY emprunts_ibfk_1;
ALTER TABLE livres MODIFY id_livre INT AUTO_INCREMENT;
ALTER TABLE emprunts ADD CONSTRAINT emprunts_ibfk_1 FOREIGN KEY (id_livre) REFERENCES livres (id_livre);

--
-- mettre id_usager auto_increment
--
ALTER TABLE emprunts DROP FOREIGN KEY emprunts_ibfk_2;
ALTER TABLE usagers MODIFY id_usager INT AUTO_INCREMENT;
ALTER TABLE emprunts ADD CONSTRAINT emprunts_ibfk_2 FOREIGN KEY (id_usager) REFERENCES usagers (id_usager);

--
-- mettre id_emprunt auto_increment
--
ALTER TABLE emprunts MODIFY id_emprunt INT AUTO_INCREMENT;


--
-- Contraintes :
--

--
-- 1- Ajouter une contrainte CHECK sur la table "Emprunts" pour s'assurer qu'une personne ne peut emprunter plus de 5 livres.
--
ALTER TABLE Emprunts
ADD CONSTRAINT CK_Emprunts_Limit
CHECK (id_personne IN (SELECT id_personne FROM Emprunts GROUP BY id_personne HAVING COUNT(*) <= 5));

--
-- 2- Ajouter une contrainte CHECK sur la table "Emprunts" pour s'assurer que la durée de l'emprunt ne dépasse pas 30 jours.
--
ALTER TABLE Emprunts
ADD CONSTRAINT CK_Emprunts_Duration
CHECK (DATEDIFF(day, date_emprunt, date_retour) <= 30);