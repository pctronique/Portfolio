-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : portfolio_mariadb:3306
-- Généré le : mer. 15 juin 2022 à 13:28
-- Version du serveur : 10.4.18-MariaDB-1:10.4.18+maria~focal
-- Version de PHP : 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `portfolio`
--
CREATE DATABASE IF NOT EXISTS `portfolio` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `portfolio`;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(10) NOT NULL,
  `nom_admin` varchar(40) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `nom_admin`) VALUES
(1, 'Administrateur'),
(4, 'Banni'),
(2, 'Gestionnaire'),
(3, 'Utilisateur');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_cat` int(10) NOT NULL,
  `nom_cat` varchar(40) NOT NULL DEFAULT '',
  `description_cat` text NOT NULL,
  `id_user` int(10) NOT NULL,
  `avatar_cat` varchar(255) NOT NULL DEFAULT '',
  `display_cat` tinyint(1) NOT NULL DEFAULT 1,
  `date_cat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_cat`, `nom_cat`, `description_cat`, `id_user`, `avatar_cat`, `display_cat`, `date_cat`) VALUES
(1, 'WEB', '', 1, 'icons8-domaine-50_62a9a5fdacbaa.png', 1, '2022-06-03 20:18:13'),
(6, 'JAVA', '', 1, '', 0, '2022-06-09 12:52:51');

-- --------------------------------------------------------

--
-- Structure de la table `cat_produit`
--

CREATE TABLE `cat_produit` (
  `id_cat_produit` int(10) NOT NULL,
  `id_cat` int(10) NOT NULL,
  `id_produit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `cat_produit`
--

INSERT INTO `cat_produit` (`id_cat_produit`, `id_cat`, `id_produit`) VALUES
(48, 6, 7),
(50, 1, 4),
(51, 1, 3),
(52, 1, 5);

-- --------------------------------------------------------

--
-- Structure de la table `competences`
--

CREATE TABLE `competences` (
  `id_competences` int(10) NOT NULL,
  `title_competence` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description_competences` text COLLATE utf8_unicode_ci NOT NULL,
  `display_competences` tinyint(1) NOT NULL DEFAULT 1,
  `id_user` int(10) NOT NULL,
  `date_competences` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `competences`
--

INSERT INTO `competences` (`id_competences`, `title_competence`, `description_competences`, `display_competences`, `id_user`, `date_competences`) VALUES
(1, 'électronique', 'Programmation de circuits électroniques, Conception et mise en oeuvre d\'appareils électroniques, Utilisation des composants CMS, Lecture de documents constructeurs (généralement en anglais).', 1, 1, '2022-06-03 20:42:02'),
(2, 'informatique', 'Langages : C, C++, PHP, xml, java, javascript, html, CSS.\r\nLogiciels : Eclipse, Netbeans, android-studio, visual studio code, sublime text, Git, Docker.\r\nSGBD : Utilisation d\'une base de données (MySQL, Oracle, PostgreSQL, java DB, SQLite).\r\nSystèmes d\'exploitation : MSDOS, WINDOWS, LINUX.', 1, 1, '2022-06-03 20:42:14');

-- --------------------------------------------------------

--
-- Structure de la table `competences_logo`
--

CREATE TABLE `competences_logo` (
  `id_competences_logo` int(10) NOT NULL,
  `title_competences_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nom_competences_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `img_competence_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `src_competences_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_user_creator` int(10) NOT NULL,
  `date_competences_logo` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `competences_logo`
--

INSERT INTO `competences_logo` (`id_competences_logo`, `title_competences_logo`, `nom_competences_logo`, `img_competence_logo`, `src_competences_logo`, `id_user_creator`, `date_competences_logo`) VALUES
(6, 'HTML 5', 'HTML 5', '', 'html_5_0_629dbeac30092.png', 1, '2022-06-06 08:45:32'),
(7, 'CSS', 'CSS', '', 'css_0_629dbeba14ee8.png', 1, '2022-06-06 08:45:46'),
(8, 'JS', 'JS', '', 'js_0_629dbec667703.png', 1, '2022-06-06 08:45:58'),
(9, 'GIT', 'GIT', '', 'git_0_629dbede2112e.png', 1, '2022-06-06 08:46:22'),
(10, 'GITLAB', 'GITLAB', '', 'gitlab_0_629dbef6dbf47.png', 1, '2022-06-06 08:46:46'),
(11, 'GITHUB', 'GITHUB', '', 'github_0_629dbf060fa63.png', 1, '2022-06-06 08:47:02'),
(12, 'DOCKER', 'DOCKER', '', 'docker_0_629dbf1a50559.png', 1, '2022-06-06 08:47:22'),
(13, 'LINUX', 'LINUX', '', 'linux_0_629dbf33bf9cb.png', 1, '2022-06-06 08:47:47'),
(14, 'NODEJS', 'NODEJS', '', 'nodejs_0_629dbf520a49d.png', 1, '2022-06-06 08:48:18'),
(15, 'ANGULAR', 'ANGULAR', '', 'angular_0_629dbf6224418.png', 1, '2022-06-06 08:48:34'),
(16, 'JAVA', 'JAVA', '', 'java_0_629dbfa9bbf87.png', 1, '2022-06-06 08:49:45');

-- --------------------------------------------------------

--
-- Structure de la table `competences_logo_user`
--

CREATE TABLE `competences_logo_user` (
  `id_competences_logo_user` int(10) NOT NULL,
  `id_competences_logo` int(10) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `competences_logo_user`
--

INSERT INTO `competences_logo_user` (`id_competences_logo_user`, `id_competences_logo`, `id_user`) VALUES
(7, 6, 1),
(8, 7, 1),
(9, 8, 1),
(10, 9, 1),
(11, 10, 1),
(12, 11, 1),
(13, 12, 1),
(14, 13, 1),
(15, 14, 1),
(16, 15, 1),
(17, 16, 1);

-- --------------------------------------------------------

--
-- Structure de la table `cv`
--

CREATE TABLE `cv` (
  `id_cv` int(10) NOT NULL,
  `title_cv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom_cv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `src_cv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `display_cv` tinyint(1) NOT NULL DEFAULT 1,
  `id_user` int(10) NOT NULL,
  `date_cv` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `cv`
--

INSERT INTO `cv` (`id_cv`, `title_cv`, `nom_cv`, `src_cv`, `display_cv`, `id_user`, `date_cv`) VALUES
(4, 'stage développeur web', 'stage développeur web', 'Copie de Développeur web V2-1_629ecff8c3969.pdf', 1, 1, '2022-06-07 04:11:36');

-- --------------------------------------------------------

--
-- Structure de la table `cv_display`
--

CREATE TABLE `cv_display` (
  `id_cv_display` int(10) NOT NULL,
  `id_cv` int(10) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `cv_display`
--

INSERT INTO `cv_display` (`id_cv_display`, `id_cv`, `id_user`) VALUES
(2, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `experiences`
--

CREATE TABLE `experiences` (
  `id_experiences` int(10) NOT NULL,
  `id_parcours` int(10) NOT NULL,
  `date_experiences` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `experiences`
--

INSERT INTO `experiences` (`id_experiences`, `id_parcours`, `date_experiences`) VALUES
(39, 11, '2022-06-06 09:42:47'),
(40, 12, '2022-06-06 09:44:06'),
(41, 13, '2022-06-06 09:45:44'),
(42, 14, '2022-06-06 09:47:08'),
(43, 15, '2022-06-06 09:48:43'),
(44, 16, '2022-06-06 09:49:58');

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `id_fomations` int(10) NOT NULL,
  `id_parcours` int(10) NOT NULL,
  `obtenu_fomations` tinyint(1) NOT NULL DEFAULT 0,
  `date_formations` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`id_fomations`, `id_parcours`, `obtenu_fomations`, `date_formations`) VALUES
(10, 9, 0, '2022-06-06 09:39:03'),
(11, 10, 0, '2022-06-06 09:40:32'),
(12, 18, 0, '2022-06-08 17:09:59'),
(15, 8, 0, '2022-06-10 14:36:18');

-- --------------------------------------------------------

--
-- Structure de la table `framework`
--

CREATE TABLE `framework` (
  `id_framework` int(10) NOT NULL,
  `nom_framework` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_user` int(10) NOT NULL,
  `date_framework` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `framework`
--

INSERT INTO `framework` (`id_framework`, `nom_framework`, `id_user`, `date_framework`) VALUES
(5, 'Bootstrap', 1, '2022-06-09 01:40:33');

-- --------------------------------------------------------

--
-- Structure de la table `framework_produit`
--

CREATE TABLE `framework_produit` (
  `id_framework_produit` int(10) NOT NULL,
  `id_framework` int(10) NOT NULL,
  `id_produit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `framework_produit`
--

INSERT INTO `framework_produit` (`id_framework_produit`, `id_framework`, `id_produit`) VALUES
(12, 5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `language`
--

CREATE TABLE `language` (
  `id_language` int(10) NOT NULL,
  `nom_language` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_user` int(10) NOT NULL,
  `date_language` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `language`
--

INSERT INTO `language` (`id_language`, `nom_language`, `id_user`, `date_language`) VALUES
(1, 'PHP', 1, '2022-06-03 05:17:33'),
(2, 'Java', 1, '2022-06-03 05:17:33'),
(4, 'JavaScript', 1, '2022-06-06 15:49:27'),
(5, 'CSS', 1, '2022-06-06 15:49:32'),
(6, 'HTML 5', 1, '2022-06-06 15:50:47');

-- --------------------------------------------------------

--
-- Structure de la table `language_produit`
--

CREATE TABLE `language_produit` (
  `id_language_produit` int(10) NOT NULL,
  `id_language` int(10) NOT NULL,
  `id_produit` int(10) NOT NULL,
  `version_language` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `language_produit`
--

INSERT INTO `language_produit` (`id_language_produit`, `id_language`, `id_produit`, `version_language`) VALUES
(102, 4, 4, ''),
(103, 5, 4, ''),
(104, 6, 4, ''),
(105, 5, 3, ''),
(106, 6, 3, ''),
(107, 1, 5, ''),
(108, 4, 5, ''),
(109, 5, 5, ''),
(110, 6, 5, '');

-- --------------------------------------------------------

--
-- Structure de la table `loisir`
--

CREATE TABLE `loisir` (
  `id_loisir` int(10) NOT NULL,
  `name_loisir` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description_loisir` text COLLATE utf8_unicode_ci NOT NULL,
  `display_loisir` tinyint(1) NOT NULL DEFAULT 1,
  `id_user` int(10) NOT NULL,
  `date_loisir` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `loisir`
--

INSERT INTO `loisir` (`id_loisir`, `name_loisir`, `description_loisir`, `display_loisir`, `id_user`, `date_loisir`) VALUES
(3, 'électronique', 'Réparation d\'appareils d\'électroniques (ordinateurs fixes et portables, téléviseurs, etc..).', 1, 1, '2022-06-07 02:50:09'),
(4, 'forum', '8/2014 - 1/2017 : Aide sur les forum d\'openclassrooms (aider, écouter et trouver des solutions).', 1, 1, '2022-06-07 02:50:31'),
(5, 'languages', 'Le C, C++, nodeJS, Angular, docker, git en Autodidacte.', 1, 1, '2022-06-07 02:50:54');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `Id_msg` int(10) NOT NULL,
  `Nom_msg` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Prenom_msg` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Email_msg` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Objet_msg` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Message_msg` text COLLATE utf8_unicode_ci NOT NULL,
  `lu_msg` tinyint(2) NOT NULL DEFAULT 0,
  `date_msg` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages_utilisateur`
--

CREATE TABLE `messages_utilisateur` (
  `id_msg_user` int(10) NOT NULL,
  `id_msg` int(10) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

CREATE TABLE `parcours` (
  `id_parcours` int(10) NOT NULL,
  `nom_parcours` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_parcours` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entreprise_parcours` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_debut_parcours` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_fin_parcours` timestamp NOT NULL DEFAULT current_timestamp(),
  `type_parcours` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lieu_parcours` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description_parcours` text COLLATE utf8_unicode_ci NOT NULL,
  `in_progress_parcours` tinyint(1) NOT NULL DEFAULT 0,
  `display_parcours` tinyint(1) NOT NULL DEFAULT 1,
  `id_user` int(10) NOT NULL,
  `date_parcours` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `parcours`
--

INSERT INTO `parcours` (`id_parcours`, `nom_parcours`, `title_parcours`, `entreprise_parcours`, `date_debut_parcours`, `date_fin_parcours`, `type_parcours`, `lieu_parcours`, `description_parcours`, `in_progress_parcours`, `display_parcours`, `id_user`, `date_parcours`) VALUES
(8, 'BTS Electronique', 'BTS Electronique', 'Lycée Jules Renard', '2002-09-06 00:00:00', '2004-06-06 00:00:00', '', 'Nevers', 'Programmation de circuits électroniques, Conception et mise en oeuvre d\'appareils électroniques, Utilisation des composants CMS, Lecture de documents constructeurs (généralement en anglais).', 0, 1, 1, '2022-06-06 09:37:09'),
(9, 'Bachelor 3 informatique', 'Bachelor 3 informatique', 'CS2I', '2011-09-06 00:00:00', '2012-06-06 00:00:00', '', 'Nevers', 'Langages : C, C++, PHP, xml, java, javascript, html, CSS.\r\nLogiciels : Eclipse, Netbeans, android-studio, visual studio code, sublime text, Git, Docker.\r\nSGBD : Utilisation d\'une base de données (MySQL, Oracle, PostgreSQL, java DB, SQLite).\r\nSystèmes d\'exploitation : MSDOS, WINDOWS, LINUX.', 0, 1, 1, '2022-06-06 09:38:56'),
(10, 'ITIL Foundation V3', 'ITIL Foundation V3', 'IT Servive Management', '2019-03-06 00:00:00', '2019-03-06 00:00:00', '', 'Lyon', '1 semaine.', 0, 1, 1, '2022-06-06 09:40:32'),
(11, 'Monteur - Installateur de matériel d\'alarme et de vidéo surveillance', 'Monteur - Installateur de matériel d\'alarme et de vidéo surveillance', 'ATN', '2006-06-06 00:00:00', '2007-02-06 00:00:00', '', 'Nevers', 'Tirage de lignes et câblage. Choix de l\'emplacement du matériel et mise en place du matériel. Programmation, tests et réglages. Explication du fonctionnement et\r\nmaintenance du matériel.', 0, 1, 1, '2022-06-06 09:42:47'),
(12, 'Technicien de maintenance informatique et bureautique', 'Technicien de maintenance informatique et bureautique', 'SARL NEVERS LAN', '2011-06-06 00:00:00', '2011-07-06 00:00:00', '', 'Fourchambault', '', 0, 1, 1, '2022-06-06 09:44:06'),
(13, 'Technicien informatique(Stage et Adecco)', 'Technicien informatique(Stage et Adecco)', 'TECHNICENTRE Auvergne Nivernais', '2012-02-06 00:00:00', '2012-12-06 00:00:00', '', 'Nevers', 'Développement et maintenance de programmes en VBA.', 0, 1, 1, '2022-06-06 09:45:44'),
(14, 'Technicien informatique et telecom', 'Technicien informatique et telecom', 'NEOSERV', '2015-02-06 00:00:00', '2015-03-06 00:00:00', '', 'Nevers', 'Installation et dépannage modem de ligne internet et configuration de pc.\r\nCours informatique. Migration monétique (carte bancaire).', 0, 1, 1, '2022-06-06 09:47:08'),
(15, 'Technicien support (déploiement)', 'Technicien support (déploiement)', 'intérimaire', '2015-09-06 00:00:00', '2015-11-06 00:00:00', '', 'Nevers', 'Déploiement des postes Windows :\r\n    =&gt; DALKIA de nevers et decize. (Lynx RH)\r\n    =&gt; MGEN de nevers et moulins.  (pour Ergalis IT)\r\n    =&gt; SITA à nevers. (Ergalis IT)', 0, 1, 1, '2022-06-06 09:48:43'),
(16, 'Développeur d\'applications et technicien hotline niveau 1 et 2', 'Développeur d\'applications et technicien hotline niveau 1 et 2', 'Réseau canopé', '2017-01-06 00:00:00', '2019-03-06 00:00:00', '', 'Moulins', 'Assistance utilisateur hotline niveau 1 et 2 (osTicket). Gestion des codes barres. Gestion du parc des tablettes. Développement PHP / MySQL / Javascript / html5 / CSS, java, nodeJS, Angular. Conversion des bases documentaires.', 0, 1, 1, '2022-06-06 09:49:58'),
(18, 'Titre de développeur Web et Web mobile (Niveau 5, anc III)', 'Titre de développeur Web et Web mobile (Niveau 5, anc III)', 'onlineFormation (Access Code School)', '2022-03-07 00:00:00', '0000-00-00 00:00:00', '', 'Nevers', '', 1, 1, 1, '2022-06-08 17:09:59');

-- --------------------------------------------------------

--
-- Structure de la table `pass_perdu`
--

CREATE TABLE `pass_perdu` (
  `id_pass_perdu` int(10) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jeton_pass_perdu` varchar(255) NOT NULL DEFAULT '',
  `date_pass_perdu` timestamp NOT NULL DEFAULT current_timestamp(),
  `expiration_pass_perdu` timestamp NOT NULL DEFAULT current_timestamp(),
  `valide_pass_perdu` tinyint(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pass_perdu`
--

INSERT INTO `pass_perdu` (`id_pass_perdu`, `id_user`, `jeton_pass_perdu`, `date_pass_perdu`, `expiration_pass_perdu`, `valide_pass_perdu`) VALUES
(1, 1, 'ea5205d7627329fc41c5b5723a715e54', '2022-06-08 03:06:36', '2022-06-08 17:06:36', 0);

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `id_photo` int(10) NOT NULL,
  `src_photo` varchar(100) NOT NULL DEFAULT '',
  `alt_photo` varchar(255) NOT NULL DEFAULT '',
  `titre_photo` varchar(255) NOT NULL DEFAULT '',
  `id_produit` int(10) NOT NULL,
  `date_photo` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`id_photo`, `src_photo`, `alt_photo`, `titre_photo`, `id_produit`, `date_photo`) VALUES
(9, 'Screenshot_20220606_174255_629e224c2c5fb.png', 'maquette jadoo', 'maquette jadoo', 3, '2022-06-06 15:50:36'),
(10, 'Screenshot_20220606_174347_629e228532b3e.png', 'ACS Voyages', 'ACS Voyages', 4, '2022-06-06 15:51:33'),
(11, 'Screenshot_20220606_174542_629e229e95aef.png', 'Office du tourisme de Springfield', 'Office du tourisme de Springfield', 5, '2022-06-06 15:51:58'),
(12, 'Shiny-3d-word-PNG_62a203da4b902.png', 'test', 'test', 7, '2022-06-09 14:29:46');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_produit` int(10) NOT NULL,
  `nom_produit` varchar(40) NOT NULL DEFAULT '',
  `description_produit` text NOT NULL,
  `src_produit` varchar(255) NOT NULL DEFAULT '',
  `src_git_produit` varchar(255) NOT NULL DEFAULT '',
  `display_produit` tinyint(2) NOT NULL DEFAULT 1,
  `id_user` int(10) NOT NULL,
  `date_produit` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_produit`, `nom_produit`, `description_produit`, `src_produit`, `src_git_produit`, `display_produit`, `id_user`, `date_produit`) VALUES
(3, 'maquette jadoo', 'Projet 1 : maquette d\'un site de restaurant (Je construis mon site web) [onlineFormation (Access Code School)]\r\n\r\nIntégrer la maquette d\'un site de restaurant - Partie 1\r\nIntégrer le site &quot;Restaurant Jadoo&quot;, à partir des notions apprises dans les modules et vidéos du niveau Débutant.\r\n\r\nIntégrer la maquette d\'un site de restaurant - Partie 2\r\nIntégrer le site &quot;Restaurant Jadoo&quot;, à partir des notions apprises dans les modules et vidéos du niveau Intermédiaire.\r\n\r\nIntégrer la maquette d\'un site de restaurant - Partie 3\r\nIntégrer le site &quot;Restaurant Jadoo&quot;, à partir des notions apprises dans les modules et vidéos du niveau Confirmé.', 'https://pctronique.github.io/maquette_jadoo/project/www/', 'https://github.com/pctronique/maquette_jadoo', 1, 1, '2022-06-06 15:50:36'),
(4, 'ACS Voyages', 'Projet 2 : Agence de Voyages [onlineFormation (Access Code School)]\r\n\r\nDescription\r\nIl s\'agit de créer le site d\'une agence de voyages qui offre quelques destinations de\r\nvotre choix.\r\nL\'agence doit promouvoir les voyages avec de belles photos, une description, le prix,\r\nnombre de personnes maximum, etc.\r\nIl doit exister plusieurs catégories de voyages (par exemple : croisières, séjour dans un\r\nhôtel, visite guidées, etc.)\r\n\r\nContenu du site\r\nPage d\'accueil\r\n    Il faut une page d\'accueil avec de belles photos, les offres spéciales du moment à\r\n    mettre en valeur ainsi qu’une barre de recherche (non fonctionnelle).\r\n    \r\nPages des voyages\r\n    Il faudra une page par catégorie de voyages ainsi qu\'une page par voyage.\r\n    Chaque page de voyage permet de voir les détails de celui-ci.\r\n    \r\nBonus\r\n    Créer un “back-office” qui permettrait à l’agence de gérer les différents voyages (listing,\r\n    ajout, modification, suppression, mise en avant sur la page d\'accueil).\r\n    \r\nLes tâches\r\n    Créer une maquette à valider avec le formateur\r\n    Réfléchir au contenu du site\r\n    Créer le front-end en se répartissant les tâches\r\n    \r\nLivrable\r\n    Site en ligne sur le serveur de promo\r\n    Dépôt distant sur GitHub', 'https://aguinot58.github.io/ACS_Voyages/Project/www/', 'https://github.com/aguinot58/ACS_Voyages', 1, 1, '2022-06-06 15:51:33'),
(5, 'Springfield', 'Projet 3 : Catalogue [onlineFormation (Access Code School)]\r\n\r\nTechnologies : HTML, CSS, Bootstrap/Tailwind, PHP, MySQL\r\nProjet par groupes de 2\r\nDurée : 3 semaines\r\n\r\nDescription\r\n    Le but est de créer un catalogue dont le choix du thème vous appartient (on parle\r\n    d’un catalogue du type Allociné pour les films, le but n’est pas de faire un site e-\r\n    commerce). Ce catalogue doit permettre de visualiser une grille de produits (films,\r\n    musiques, objets...). En cliquant sur un produit de cette grille, on pourra consulter la\r\n    page individuelle de celui-ci. Cette page individuelle fournira une description et des\r\n    informations supplémentaires.\r\n\r\n    Chaque produit appartient à une catégorie. On pourra trier les produits par\r\n    catégorie.\r\n\r\n    Il faudra également créer un back-office permettant aux administrateurs du\r\n    catalogue d’ajouter de nouveaux produits, de les modifier et de les supprimer.\r\n    \r\nPages\r\n    Une page d’accueil avec la grille de produits\r\n    Une page individuelle par produit. Un produit contiendra au minimum :\r\n        Un nom\r\n        Une description\r\n        Une image/photo\r\n        Une catégorie\r\n    Une page par catégorie\r\n    Une page de connexion pour les administrateurs\r\n    Une back-office permettant :\r\n        d’ajouter des produits via un formulaire\r\n        de modifier les produits existants\r\n        de supprimer les produits existants\r\n        \r\nBase de données\r\nLa base de données sera composée d’au moins trois tables :\r\n    une table pour les produits\r\n    une table pour les catégories\r\n    une table pour les utilisateurs\r\n    \r\nGestion des utilisateurs\r\n\r\nOption 1 :\r\nLa table des utilisateurs sert uniquement à s’identifier.\r\nTous les utilisateurs ont les mêmes droits d’aministration qui permettent d’accéder\r\nau back-office. Ils peuvent agir sur l’ensemble des produits.\r\n\r\nOption 2 :\r\nLa table des utilisateurs permet de savoir qui a ajouté un produit.\r\nUn administrateur principal peut agir sur l’ensemble des produits.\r\nLes autres gestionnaires ne peuvent agir que sur les produits qu’ils ont ajouté eux-\r\nmêmes.\r\nBonus : l’administrateur principal gère les comptes des autres utilisateurs.\r\n\r\nBack-office\r\nPour l’apparence du back-office, il faudra utiliser un framework CSS, Bootstrap ou\r\nTailwind.', 'https://pctronique.fr/project/springfield/', 'https://github.com/DevMan3158/Projet-Springfield', 1, 1, '2022-06-06 15:51:58'),
(7, 'test', '', '', '', 0, 1, '2022-06-09 14:29:46');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_user` int(10) NOT NULL,
  `nom_user` varchar(40) NOT NULL DEFAULT '',
  `prenom_user` varchar(40) NOT NULL DEFAULT '',
  `login_user` varchar(40) NOT NULL DEFAULT '',
  `avatar_user` varchar(150) NOT NULL DEFAULT '',
  `email_user` varchar(255) NOT NULL DEFAULT '',
  `mot_pass_user` varchar(255) NOT NULL,
  `description_user` text NOT NULL,
  `id_admin` int(10) NOT NULL,
  `date_user` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `nom_user`, `prenom_user`, `login_user`, `avatar_user`, `email_user`, `mot_pass_user`, `description_user`, `id_admin`, `date_user`) VALUES
(1, 'NAULOT', 'Ludovic', 'root', 'signe-github_1_629cb13b3dc11.png', 'l.naulot@codeur.online', 'SlU4YllSeFFaVVFXei9nSQ$/2nbqG+98a9/MyLs4Atc93Mf7stLbtozYcuFI9gf2tk', 'Actuellement en formation de développeur web et web mobile.\r\nA la recherche d\'un stage 5 septembre au 28 octobre 2022, pour valider la formation.\r\n\r\nJe suis un développeur objet et MVC (Modèle-vue-contrôleur), qui fait surtout de la programmation JAVA, mais aussi du web.', 1, '2022-06-02 07:30:10');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `nom_admin` (`nom_admin`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_cat`),
  ADD UNIQUE KEY `nom_cat` (`nom_cat`),
  ADD KEY `key_cat_user` (`id_user`);

--
-- Index pour la table `cat_produit`
--
ALTER TABLE `cat_produit`
  ADD PRIMARY KEY (`id_cat_produit`),
  ADD KEY `key_cat_produit_cat` (`id_cat`),
  ADD KEY `key_cat_produit_produit` (`id_produit`);

--
-- Index pour la table `competences`
--
ALTER TABLE `competences`
  ADD PRIMARY KEY (`id_competences`),
  ADD UNIQUE KEY `title_competence` (`title_competence`),
  ADD KEY `info_competences_user` (`id_user`);

--
-- Index pour la table `competences_logo`
--
ALTER TABLE `competences_logo`
  ADD PRIMARY KEY (`id_competences_logo`),
  ADD UNIQUE KEY `title_competences_logo` (`title_competences_logo`),
  ADD KEY `key_comp_logo_user` (`id_user_creator`);

--
-- Index pour la table `competences_logo_user`
--
ALTER TABLE `competences_logo_user`
  ADD PRIMARY KEY (`id_competences_logo_user`),
  ADD KEY `key_comp_logo` (`id_competences_logo`),
  ADD KEY `key_comp_logo_user_user` (`id_user`);

--
-- Index pour la table `cv`
--
ALTER TABLE `cv`
  ADD PRIMARY KEY (`id_cv`),
  ADD UNIQUE KEY `title_cv` (`title_cv`),
  ADD KEY `key_cv_user` (`id_user`);

--
-- Index pour la table `cv_display`
--
ALTER TABLE `cv_display`
  ADD PRIMARY KEY (`id_cv_display`),
  ADD KEY `key_cv_display` (`id_cv`),
  ADD KEY `key_cv_display_user` (`id_user`);

--
-- Index pour la table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id_experiences`),
  ADD KEY `key_expe_list_competences` (`id_parcours`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id_fomations`),
  ADD KEY `key_formation_list_competences` (`id_parcours`);

--
-- Index pour la table `framework`
--
ALTER TABLE `framework`
  ADD PRIMARY KEY (`id_framework`),
  ADD UNIQUE KEY `nom_framework` (`nom_framework`),
  ADD KEY `key_framework_user` (`id_user`);

--
-- Index pour la table `framework_produit`
--
ALTER TABLE `framework_produit`
  ADD PRIMARY KEY (`id_framework_produit`),
  ADD KEY `key_framework_framework` (`id_framework`),
  ADD KEY `key_framework_produit` (`id_produit`);

--
-- Index pour la table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id_language`),
  ADD UNIQUE KEY `nom_language` (`nom_language`),
  ADD KEY `key_language_user` (`id_user`);

--
-- Index pour la table `language_produit`
--
ALTER TABLE `language_produit`
  ADD PRIMARY KEY (`id_language_produit`),
  ADD KEY `key_language_produit_produit` (`id_produit`),
  ADD KEY `key_language_produit_language` (`id_language`);

--
-- Index pour la table `loisir`
--
ALTER TABLE `loisir`
  ADD PRIMARY KEY (`id_loisir`),
  ADD UNIQUE KEY `name_loisir` (`name_loisir`),
  ADD KEY `key_loisir_user` (`id_user`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`Id_msg`);

--
-- Index pour la table `messages_utilisateur`
--
ALTER TABLE `messages_utilisateur`
  ADD PRIMARY KEY (`id_msg_user`),
  ADD KEY `key_msg_user_msg` (`id_msg`),
  ADD KEY `key_msg_user_user` (`id_user`);

--
-- Index pour la table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`id_parcours`),
  ADD UNIQUE KEY `nom_competences` (`nom_parcours`),
  ADD KEY `key_list_competences_user` (`id_user`);

--
-- Index pour la table `pass_perdu`
--
ALTER TABLE `pass_perdu`
  ADD PRIMARY KEY (`id_pass_perdu`),
  ADD KEY `key_pass_perdu_user` (`id_user`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `key_photo_produit` (`id_produit`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id_produit`),
  ADD UNIQUE KEY `nom_produit` (`nom_produit`),
  ADD KEY `key_produit_user` (`id_user`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login_user` (`login_user`),
  ADD UNIQUE KEY `email_user` (`email_user`),
  ADD KEY `key_user_admin` (`id_admin`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_cat` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `cat_produit`
--
ALTER TABLE `cat_produit`
  MODIFY `id_cat_produit` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `competences`
--
ALTER TABLE `competences`
  MODIFY `id_competences` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `competences_logo`
--
ALTER TABLE `competences_logo`
  MODIFY `id_competences_logo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `competences_logo_user`
--
ALTER TABLE `competences_logo_user`
  MODIFY `id_competences_logo_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `cv`
--
ALTER TABLE `cv`
  MODIFY `id_cv` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `cv_display`
--
ALTER TABLE `cv_display`
  MODIFY `id_cv_display` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id_experiences` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `id_fomations` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `framework`
--
ALTER TABLE `framework`
  MODIFY `id_framework` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `framework_produit`
--
ALTER TABLE `framework_produit`
  MODIFY `id_framework_produit` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `language`
--
ALTER TABLE `language`
  MODIFY `id_language` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `language_produit`
--
ALTER TABLE `language_produit`
  MODIFY `id_language_produit` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT pour la table `loisir`
--
ALTER TABLE `loisir`
  MODIFY `id_loisir` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `Id_msg` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `messages_utilisateur`
--
ALTER TABLE `messages_utilisateur`
  MODIFY `id_msg_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `parcours`
--
ALTER TABLE `parcours`
  MODIFY `id_parcours` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `pass_perdu`
--
ALTER TABLE `pass_perdu`
  MODIFY `id_pass_perdu` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id_photo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id_produit` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `key_cat_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cat_produit`
--
ALTER TABLE `cat_produit`
  ADD CONSTRAINT `key_cat_produit_cat` FOREIGN KEY (`id_cat`) REFERENCES `categorie` (`id_cat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_cat_produit_produit` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `competences`
--
ALTER TABLE `competences`
  ADD CONSTRAINT `info_competences_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `competences_logo`
--
ALTER TABLE `competences_logo`
  ADD CONSTRAINT `key_comp_logo_user` FOREIGN KEY (`id_user_creator`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `competences_logo_user`
--
ALTER TABLE `competences_logo_user`
  ADD CONSTRAINT `key_comp_logo` FOREIGN KEY (`id_competences_logo`) REFERENCES `competences_logo` (`id_competences_logo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_comp_logo_user_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cv`
--
ALTER TABLE `cv`
  ADD CONSTRAINT `key_cv_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cv_display`
--
ALTER TABLE `cv_display`
  ADD CONSTRAINT `key_cv_display` FOREIGN KEY (`id_cv`) REFERENCES `cv` (`id_cv`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_cv_display_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `key_exp_parc` FOREIGN KEY (`id_parcours`) REFERENCES `parcours` (`id_parcours`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `formations`
--
ALTER TABLE `formations`
  ADD CONSTRAINT `parc_forma_parc` FOREIGN KEY (`id_parcours`) REFERENCES `parcours` (`id_parcours`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `framework`
--
ALTER TABLE `framework`
  ADD CONSTRAINT `key_framework_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `framework_produit`
--
ALTER TABLE `framework_produit`
  ADD CONSTRAINT `key_framework_framework` FOREIGN KEY (`id_framework`) REFERENCES `framework` (`id_framework`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_framework_produit` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `language`
--
ALTER TABLE `language`
  ADD CONSTRAINT `key_language_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `language_produit`
--
ALTER TABLE `language_produit`
  ADD CONSTRAINT `key_language_produit_language` FOREIGN KEY (`id_language`) REFERENCES `language` (`id_language`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_language_produit_produit` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `loisir`
--
ALTER TABLE `loisir`
  ADD CONSTRAINT `key_loisir_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `messages_utilisateur`
--
ALTER TABLE `messages_utilisateur`
  ADD CONSTRAINT `key_msg_user_msg` FOREIGN KEY (`id_msg`) REFERENCES `messages` (`Id_msg`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_msg_user_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `parcours`
--
ALTER TABLE `parcours`
  ADD CONSTRAINT `key_list_competences_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `pass_perdu`
--
ALTER TABLE `pass_perdu`
  ADD CONSTRAINT `key_pass_perdu_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `key_photo_produit` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `key_produit_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `key_user_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
