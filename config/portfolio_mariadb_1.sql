-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : portfolio_mariadb:3306
-- Généré le : sam. 04 juin 2022 à 17:43
-- Version du serveur : 10.4.18-MariaDB-1:10.4.18+maria~focal-log
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
  `date_cat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_cat`, `nom_cat`, `description_cat`, `id_user`, `avatar_cat`, `date_cat`) VALUES
(1, 'WEB', '', 1, '', '2022-06-03 20:18:13'),
(2, 'Java', '', 1, '', '2022-06-03 20:19:09');

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
(15, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `competences`
--

CREATE TABLE `competences` (
  `id_competences` int(10) NOT NULL,
  `title_competence` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description_competences` text COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(10) NOT NULL,
  `date_competences` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `competences`
--

INSERT INTO `competences` (`id_competences`, `title_competence`, `description_competences`, `id_user`, `date_competences`) VALUES
(1, 'électronique', 'xcccccc11', 1, '2022-06-03 20:42:02'),
(2, 'informatique', 'hghghhgh', 1, '2022-06-03 20:42:14');

-- --------------------------------------------------------

--
-- Structure de la table `competences_logo`
--

CREATE TABLE `competences_logo` (
  `id_competences_logo` int(10) NOT NULL,
  `title_competences_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nom_competences_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `img_competence_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `src_competences_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_user_creator` int(10) NOT NULL,
  `date_competences_logo` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `competences_logo_user`
--

CREATE TABLE `competences_logo_user` (
  `id_competences_logo_user` int(10) NOT NULL,
  `id_competences_logo` int(10) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv`
--

CREATE TABLE `cv` (
  `id_cv` int(10) NOT NULL,
  `title_cv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom_cv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `scr_cv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_user` int(10) NOT NULL,
  `date_cv` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv_display`
--

CREATE TABLE `cv_display` (
  `id_cv_display` int(10) NOT NULL,
  `id_cv` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `experiences`
--

CREATE TABLE `experiences` (
  `id_experiences` int(10) NOT NULL,
  `id_parcours` int(10) NOT NULL,
  `date_experiences` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `framework`
--

CREATE TABLE `framework` (
  `id_framework` int(10) NOT NULL,
  `nom_framework` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(10) NOT NULL,
  `date_framework` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `framework_produit`
--

CREATE TABLE `framework_produit` (
  `id_framework_produit` int(10) NOT NULL,
  `id_framework` int(10) NOT NULL,
  `id_produit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(3, 'JavaScript', 1, '2022-06-03 20:41:28');

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
(15, 1, 1, ''),
(16, 3, 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `loisir`
--

CREATE TABLE `loisir` (
  `id_loisir` int(10) NOT NULL,
  `name_loisir` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description_loisir` text COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(10) NOT NULL,
  `date_loisir` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `loisir`
--

INSERT INTO `loisir` (`id_loisir`, `name_loisir`, `description_loisir`, `id_user`, `date_loisir`) VALUES
(1, 'cxcx', 'fffffffffff', 1, '2022-06-03 20:41:00'),
(2, 'ffff', 'dddffdfdfdfd', 1, '2022-06-03 20:41:07');

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

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`Id_msg`, `Nom_msg`, `Prenom_msg`, `Email_msg`, `Objet_msg`, `Message_msg`, `lu_msg`, `date_msg`) VALUES
(2, 'naulot', 'ludovic', 'amitie58@live.fr', 'hgtyui', 'vvvvvvvvvvvvvvvvvvvvv', 0, '2022-06-02 17:17:56');

-- --------------------------------------------------------

--
-- Structure de la table `messages_utilisateur`
--

CREATE TABLE `messages_utilisateur` (
  `id_msg_user` int(10) NOT NULL,
  `id_msg` int(10) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `messages_utilisateur`
--

INSERT INTO `messages_utilisateur` (`id_msg_user`, `id_msg`, `id_user`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

CREATE TABLE `parcours` (
  `id_parcours` int(10) NOT NULL,
  `nom_competences` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_competences` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_denut_competences` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_fin_competences` timestamp NOT NULL DEFAULT current_timestamp(),
  `type_competences` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lieu_competences` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description_competences` text COLLATE utf8_unicode_ci NOT NULL,
  `in_progress_competences` tinyint(1) NOT NULL DEFAULT 0,
  `id_user` int(10) NOT NULL,
  `date_competences` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_produit` int(10) NOT NULL,
  `nom_produit` varchar(40) NOT NULL DEFAULT '',
  `description_produit` text NOT NULL,
  `src_produit` varchar(255) NOT NULL DEFAULT '',
  `id_user` int(10) NOT NULL,
  `date_produit` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_produit`, `nom_produit`, `description_produit`, `src_produit`, `id_user`, `date_produit`) VALUES
(1, 'web01', 'ggfgfgf', '', 1, '2022-06-03 20:42:38');

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
  `id_admin` int(10) NOT NULL,
  `date_user` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `nom_user`, `prenom_user`, `login_user`, `avatar_user`, `email_user`, `mot_pass_user`, `id_admin`, `date_user`) VALUES
(1, 'root', 'root', 'root', '', 'root@root.fr', 'TmpKMmNCRjI2V2NPU0xCMQ$Gi6Ucz29Na2efDYcEgyx+7s5TT2VHpSiWYx8qo546T4', 1, '2022-06-02 07:30:10');

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
  ADD KEY `key_cv_display` (`id_cv`);

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
  ADD UNIQUE KEY `nom_competences` (`nom_competences`),
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
  MODIFY `id_cat` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `cat_produit`
--
ALTER TABLE `cat_produit`
  MODIFY `id_cat_produit` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `competences`
--
ALTER TABLE `competences`
  MODIFY `id_competences` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `competences_logo`
--
ALTER TABLE `competences_logo`
  MODIFY `id_competences_logo` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `competences_logo_user`
--
ALTER TABLE `competences_logo_user`
  MODIFY `id_competences_logo_user` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cv`
--
ALTER TABLE `cv`
  MODIFY `id_cv` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cv_display`
--
ALTER TABLE `cv_display`
  MODIFY `id_cv_display` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id_experiences` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `id_fomations` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `framework`
--
ALTER TABLE `framework`
  MODIFY `id_framework` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `framework_produit`
--
ALTER TABLE `framework_produit`
  MODIFY `id_framework_produit` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `language`
--
ALTER TABLE `language`
  MODIFY `id_language` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `language_produit`
--
ALTER TABLE `language_produit`
  MODIFY `id_language_produit` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `loisir`
--
ALTER TABLE `loisir`
  MODIFY `id_loisir` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `Id_msg` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `messages_utilisateur`
--
ALTER TABLE `messages_utilisateur`
  MODIFY `id_msg_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `parcours`
--
ALTER TABLE `parcours`
  MODIFY `id_parcours` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pass_perdu`
--
ALTER TABLE `pass_perdu`
  MODIFY `id_pass_perdu` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id_photo` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id_produit` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `key_cv_display` FOREIGN KEY (`id_cv`) REFERENCES `cv` (`id_cv`) ON DELETE CASCADE ON UPDATE CASCADE;

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
