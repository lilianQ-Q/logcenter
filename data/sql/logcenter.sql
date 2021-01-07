-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mer 26 Août 2020 à 17:26
-- Version du serveur :  10.1.26-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-0+deb9u6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `rhinoshield`
--

-- --------------------------------------------------------

--
-- Structure de la table `ATTEMPT`
--

CREATE TABLE `ATTEMPT` (
  `id_attempt` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `modified` date NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Structure de la table `BANNED`
--

CREATE TABLE `BANNED` (
  `id_banned` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `IPADDRESS`
--

CREATE TABLE `IPADDRESS` (
  `id_ipaddress` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `IPADDRESS`
--

INSERT INTO `IPADDRESS` (`id_ipaddress`, `address`, `created`, `modified`, `id_user`) VALUES
(1, '192.168.1.83', '2020-07-26', '2020-07-26', 1);

-- --------------------------------------------------------

--
-- Structure de la table `LICENCE`
--

CREATE TABLE `LICENCE` (
  `id_licence` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `LICENCE`
--

INSERT INTO `LICENCE` (`id_licence`, `token`, `created`, `modified`, `id_user`) VALUES
(1, '7245101164134318', '2020-07-26', '2020-07-26', 1);

-- --------------------------------------------------------

--
-- Structure de la table `USER`
--

CREATE TABLE `USER` (
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `USER`
--

INSERT INTO `USER` (`id_user`, `email`, `name`, `created`, `modified`) VALUES
(1, 'lilianpierredamiens@gmail.com', 'lilianQ_Q', '2020-07-26', '2020-07-26');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `ATTEMPT`
--
ALTER TABLE `ATTEMPT`
  ADD PRIMARY KEY (`id_attempt`);

--
-- Index pour la table `BANNED`
--
ALTER TABLE `BANNED`
  ADD PRIMARY KEY (`id_banned`);

--
-- Index pour la table `IPADDRESS`
--
ALTER TABLE `IPADDRESS`
  ADD PRIMARY KEY (`id_ipaddress`),
  ADD KEY `fk_ipaddresses1` (`id_user`);

--
-- Index pour la table `LICENCE`
--
ALTER TABLE `LICENCE`
  ADD PRIMARY KEY (`id_licence`),
  ADD KEY `fk_1` (`id_user`);

--
-- Index pour la table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `ATTEMPT`
--
ALTER TABLE `ATTEMPT`
  MODIFY `id_attempt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `BANNED`
--
ALTER TABLE `BANNED`
  MODIFY `id_banned` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `IPADDRESS`
--
ALTER TABLE `IPADDRESS`
  MODIFY `id_ipaddress` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `LICENCE`
--
ALTER TABLE `LICENCE`
  MODIFY `id_licence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `USER`
--
ALTER TABLE `USER`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `IPADDRESS`
--
ALTER TABLE `IPADDRESS`
  ADD CONSTRAINT `fk_ipaddresses1` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id_user`);

--
-- Contraintes pour la table `LICENCE`
--
ALTER TABLE `LICENCE`
  ADD CONSTRAINT `fk_1` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id_user`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
