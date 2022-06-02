-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 02 juin 2022 à 11:20
-- Version du serveur : 5.7.33
-- Version de PHP : 7.4.19

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
(2, 'Gestionnaire'),
(3, 'Utilisateur'),
(4, 'Banni');

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
  `date_cat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `cat_produit`
--

CREATE TABLE `cat_produit` (
  `id_cat_produit` int(10) NOT NULL,
  `id_cat` int(10) NOT NULL,
  `id_produit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `experiences`
--

CREATE TABLE `experiences` (
  `id_experiences` int(10) NOT NULL,
  `id_list_competences` int(10) NOT NULL,
  `date_experiences` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `id_fomations` int(10) NOT NULL,
  `id_list_competences` int(10) NOT NULL,
  `obtenu_fomations` tinyint(1) NOT NULL DEFAULT '0',
  `date_formations` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `info_competences`
--

CREATE TABLE `info_competences` (
  `id_info_competences` int(10) NOT NULL,
  `title_info_competence` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description_competences` text COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(10) NOT NULL,
  `date_info_competences` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `language`
--

CREATE TABLE `language` (
  `id_language` int(10) NOT NULL,
  `nom_language` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_user` int(10) NOT NULL,
  `date_language` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `language_produit`
--

CREATE TABLE `language_produit` (
  `id_language_produit` int(10) NOT NULL,
  `id_language` int(10) NOT NULL,
  `id_produit` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `version_language` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `list_competences`
--

CREATE TABLE `list_competences` (
  `id_list_competences` int(10) NOT NULL,
  `title_compt` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_denut_competence` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_fin_competences` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type_competence` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lieu_competence` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description_competence` text COLLATE utf8_unicode_ci NOT NULL,
  `in_progress_competence` tinyint(1) NOT NULL DEFAULT '0',
  `id_user` int(10) NOT NULL,
  `date_competences` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `loisir`
--

CREATE TABLE `loisir` (
  `id_loisir` int(10) NOT NULL,
  `name_loisir` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description_loisir` text COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(10) NOT NULL,
  `date_loisir` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `lu_msg` tinyint(2) NOT NULL DEFAULT '0',
  `date_msg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
-- Structure de la table `pass_perdu`
--

CREATE TABLE `pass_perdu` (
  `id_pass_perdu` int(10) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jeton_pass_perdu` varchar(255) NOT NULL DEFAULT '',
  `date_pass_perdu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expiration_pass_perdu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valide_pass_perdu` tinyint(2) NOT NULL DEFAULT '1'
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
  `date_photo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_produit` int(10) NOT NULL,
  `nom_produit` varchar(40) NOT NULL DEFAULT '',
  `description_produit` text NOT NULL,
  `id_user` int(10) NOT NULL,
  `date_produit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `date_user` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  ADD PRIMARY KEY (`id_admin`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_cat`),
  ADD KEY `key_cat_user` (`id_user`);

--
-- Index pour la table `cat_produit`
--
ALTER TABLE `cat_produit`
  ADD PRIMARY KEY (`id_cat_produit`),
  ADD KEY `key_cat_produit_cat` (`id_cat`),
  ADD KEY `key_cat_produit_produit` (`id_produit`);

--
-- Index pour la table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id_experiences`),
  ADD KEY `key_expe_list_competences` (`id_list_competences`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id_fomations`),
  ADD KEY `key_formation_list_competences` (`id_list_competences`);

--
-- Index pour la table `info_competences`
--
ALTER TABLE `info_competences`
  ADD PRIMARY KEY (`id_info_competences`),
  ADD KEY `info_competences_user` (`id_user`);

--
-- Index pour la table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id_language`),
  ADD KEY `key_language_user` (`id_user`);

--
-- Index pour la table `language_produit`
--
ALTER TABLE `language_produit`
  ADD PRIMARY KEY (`id_language_produit`),
  ADD KEY `key_language_produit_produit` (`id_produit`),
  ADD KEY `key_language_produit_language` (`id_language`),
  ADD KEY `key_language_produit_user` (`id_user`);

--
-- Index pour la table `list_competences`
--
ALTER TABLE `list_competences`
  ADD PRIMARY KEY (`id_list_competences`),
  ADD KEY `key_list_competences_user` (`id_user`);

--
-- Index pour la table `loisir`
--
ALTER TABLE `loisir`
  ADD PRIMARY KEY (`id_loisir`),
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
  ADD KEY `key_produit_user` (`id_user`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_user`),
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
  MODIFY `id_cat` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cat_produit`
--
ALTER TABLE `cat_produit`
  MODIFY `id_cat_produit` int(10) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT pour la table `info_competences`
--
ALTER TABLE `info_competences`
  MODIFY `id_info_competences` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `language`
--
ALTER TABLE `language`
  MODIFY `id_language` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `language_produit`
--
ALTER TABLE `language_produit`
  MODIFY `id_language_produit` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `list_competences`
--
ALTER TABLE `list_competences`
  MODIFY `id_list_competences` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `loisir`
--
ALTER TABLE `loisir`
  MODIFY `id_loisir` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `Id_msg` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages_utilisateur`
--
ALTER TABLE `messages_utilisateur`
  MODIFY `id_msg_user` int(10) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_produit` int(10) NOT NULL AUTO_INCREMENT;

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
-- Contraintes pour la table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `key_expe_list_competences` FOREIGN KEY (`id_list_competences`) REFERENCES `list_competences` (`id_list_competences`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `formations`
--
ALTER TABLE `formations`
  ADD CONSTRAINT `key_formation_list_competences` FOREIGN KEY (`id_list_competences`) REFERENCES `list_competences` (`id_list_competences`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `info_competences`
--
ALTER TABLE `info_competences`
  ADD CONSTRAINT `info_competences_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `key_language_produit_produit` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_language_produit_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `list_competences`
--
ALTER TABLE `list_competences`
  ADD CONSTRAINT `key_list_competences_user` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

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
