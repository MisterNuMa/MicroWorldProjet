-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 08 mai 2022 à 17:40
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `microworld`
--

DELIMITER $$
--
-- Fonctions
--
DROP FUNCTION IF EXISTS `InitCap`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `InitCap` (`chaine` VARCHAR(45)) RETURNS VARCHAR(45) CHARSET utf8 BEGIN
declare machaine varchar(45);
set machaine=concat(upper(substring(chaine,1,1)),lower(substring(chaine,2)));
RETURN machaine;
END$$

DROP FUNCTION IF EXISTS `nombre_produit`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `nombre_produit` (`id` INT) RETURNS INT BEGIN
DECLARE nbrproduit int;
SELECT count(*) INTO nbrproduit FROM produit WHERE id_utilisateur = id AND active_produit = 1;
RETURN nbrproduit;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `acheter`
--

DROP TABLE IF EXISTS `acheter`;
CREATE TABLE IF NOT EXISTS `acheter` (
  `id_acheter` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `id_produit` int NOT NULL,
  `quantite_acheter_produit` int NOT NULL,
  `date_achat` datetime NOT NULL,
  `prix_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_acheter`),
  KEY `id_utilisateur_idx` (`id_utilisateur`),
  KEY `id_produit_idx` (`id_produit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id_menu` int NOT NULL,
  `nom_menu` varchar(45) NOT NULL,
  `url_menu` varchar(100) DEFAULT NULL,
  `habilitation_menu` varchar(10) NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`id_menu`, `nom_menu`, `url_menu`, `habilitation_menu`) VALUES
(1, 'Produits', NULL, 'AECV'),
(11, 'Voir tous les produits', 'voirProduit.php', 'AECV'),
(2, 'Profil', NULL, 'AEC'),
(21, 'Voir profil', 'voirProfil.php', 'AEC'),
(3, 'Espace Administrateur', NULL, 'A'),
(31, 'Gerer Utilisateur', 'gererUtilisateur.php', 'A'),
(23, 'Desincription', 'desincription.php', 'C'),
(32, 'Ajout Tag', 'ajoutTag.php', 'A'),
(33, 'Gerer Tag', 'gererTag.php', 'A'),
(34, 'Gerer Produit', 'gererProduit.php', 'A'),
(4, 'Espace Employe', '', 'E'),
(41, 'Ajout Tag', 'ajoutTag.php', 'E'),
(42, 'Vendre Produit', 'ajoutProduit.php', 'E'),
(22, 'Vos commandes', 'voirCommande.php', 'C');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id_panier` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `id_produit` int NOT NULL,
  `quantite_produit_panier` int NOT NULL,
  PRIMARY KEY (`id_panier`),
  KEY `id_utilisateur_idx` (`id_utilisateur`),
  KEY `id_produit_idx` (`id_produit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int NOT NULL AUTO_INCREMENT,
  `titre_produit` varchar(45) NOT NULL,
  `description_produit` varchar(2000) NOT NULL,
  `caracteristique_produit` varchar(2000) NOT NULL,
  `prix_produit` decimal(10,2) NOT NULL,
  `quantite_produit` int NOT NULL,
  `photo_produit_1` varchar(44) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `photo_produit_2` varchar(44) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `photo_produit_3` varchar(44) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `active_produit` tinyint NOT NULL DEFAULT '0',
  `id_tag` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_produit`),
  KEY `id_tag_idx` (`id_tag`),
  KEY `id_utilisateur_idx` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `titre_produit`, `description_produit`, `caracteristique_produit`, `prix_produit`, `quantite_produit`, `photo_produit_1`, `photo_produit_2`, `photo_produit_3`, `active_produit`, `id_tag`, `id_utilisateur`) VALUES
(1, 'Logitech G PRO X SUPERLIGHT', 'Logitech présente PRO X SUPERLIGHT, notre souris la plus rapide et la plus légère. Alimentée par LIGHTSPEED, elle est là pour vous aider à éliminer tous les obstacles, afin que vous puissiez vous concentrer exclusivement sur la victoire. Devenez incroyablement précis, rapide et cohérent grâce au capteur HERO. Prenez la première place plus rapidement grâce aux patins PTFE sans additif qui assurent une glisse nettement plus douce. La souris PRO X SUPERLIGHT pèse moins de 63 g sans avoir eu besoin de faire des trous ridicules. Développée en collaboration avec un regroupement des meilleurs professionnels d’eSports au monde, la souris PRO X SUPERLIGHT se caractérise par un design hyper-minimal, tout en étant dotée de nos dernières technologies et avancées. Disponible en noir et en blanc.', 'Conçue avec et pour les Gamers Pro: conçue en collaboration avec les meilleurs professionnels du gaming au monde, cette souris Logitech G est faite pour atteindre le plus haut niveau de performance\r\nConception ultra légère: cette souris pèse moins de 63 g. Grâce à son nouveau design épuré, elle pèse 25% de moins que la souris PRO sans fil\r\nTechnologie sans fil LIGHTSPEED: la technologie sans fil de qualité professionnelle LIGHTSPEED offre une connexion USB très fiable et un taux de rapport super rapide de 1 ms, sans fils encombrants\r\nCapteur HERO 25K: cette souris est équipée de la dernière version du capteur HERO, le capteur le plus précis, performant et efficient, excédant les 400 ips et avec un suivi de 25600 PPP\r\nGlissement en douceur: les grands patins PTFE sans additif de la souris gaming Logitech G assurent son glissement en douceur pour rester connecté avec le jeu de manière pure et fluide\r\nDisponible en 2 couleurs: la souris gaming sans fil Logitech G PRO X SUPERLIGHT est disponible en noir et en blanc\r\nSANS FIL. SANS LIMITE : le n° 1 mondial des périphériques de gaming sans fil - D\'après des données de ventes agrégées indépendantes (fév. 2019 - fév. 2020) sur le nombre d\'unités de périphériques de gaming sans fil', '99.99', 250, '8yp4CMTjtvh8oQsDQwYn_2022_05_08_13_44_03.jpg', 'j3zXXtoUwadi8t37TRd2_2022_05_08_13_44_03.jpg', 'JfIPV2HXW2rjzrqVBmZI_2022_05_08_13_44_03.jpg', 1, 3, 3),
(2, 'Logitech G915 TKL Tenkeyless LIGHTSPEED', 'Le clavier G915 TKL est une nouvelle classe de clavier gaming mécanique sans fil comportant 3 sélections de switchs GL ultra-plats et la technologie sans fil LIGHTSPEED 1 ms de qualité professionnelle. Il peut fournir 40 heures de jeu continu avec une charge complète. Entièrement personnalisable touche par touche, la technologie LIGHTSYNC RVB réagit également à l\'action du jeu, à l\'audio et à la couleur de l\'écran en fonction de vos choix. Le format compact sans pavé numérique laisse davantage d\'espace pour bouger la souris. Avec un design élégant, incroyablement mince, résistant et robuste, le clavier G915 TKL apporte aux joueurs une nouvelle dimension de jeu. La roulette de contrôle de volume et les touches multimédia vous permettent de contrôler rapidement et facilement la vidéo, l\'audio et la diffusion en direct.', 'LIGHTSPEED PRO-GRADE SANS FIL : une performance professionnelle et un taux de rapport de 1 ms. Créez une esthétique épurée et sans fil pour vos stations de combat avec une liberté de gaming ultime. Bluetooth: appareil compatible Bluetooth avec Windows 8 ou version ultérieure, macOS X 10.11 ou version ultérieure, Chrome OS ou Android 4.3 ou version ultérieure, iOS 10 ou version ultérieure. Distance totale de déplacement : 2,7 mm\r\nLIGHTSYNC RVB : l\'éclairage RVB de nouvelle génération synchronise l\'éclairage avec le contenu de vos jeux et médias et personnalisez chaque touche ou créez des animations personnalisées\r\nSwitchs Mécaniques Ultra-Plats : les nouveaux switchs gaming hautes performances offrent la vitesse, la précision et les performances d\'un Switch mécanique tout en étant deux fois plus petit\r\nCONCEPTION COMPACTE TKL : la conception sans pavé numérique offre les technologies avancées attendues et design compact pour les gamers. Rangez votre récepteur à l’arrière pour plus de portabilité\r\nÉLÉGANTE ESTHÉTIQUE MÉTALLIQUE : ce clavier d\'une grande qualité de fabrication est conçu dans un alliage aluminium de qualité aéronautique qui permet une grande robustesse et une finesse incroyable\r\nBATTERIE LONGUE DURÉE : 40 heures de jeu avec une seule charge. Batterie chargée en 3 heures seulement, signaux lorsqu\'elle atteint 15 % de charge pour que vous ne soyez jamais pris au dépourvu\r\nLe n° 1 mondial des périphériques gaming : d\'après des données de ventes agrégées indépendantes (fév. 2019 - fév. 2020) sur le nombre d\'unités de périphériques de gaming', '139.99', 250, 'v25DBITjg7TKkCO91t5q_2022_05_08_14_05_27.jpg', 'Cyg2NDrORX5fHkLgcQ7j_2022_05_08_14_05_27.jpg', 'soe6Qiwi6MEYlP2OdRKI_2022_05_08_14_05_27.jpg', 1, 4, 3),
(3, 'ASUS Vivobook S S433EA-EB855T', 'ASUS est l\'une des entreprises les plus admirées au monde du magazine Fortune et se consacre à la création de produits pour la vie intelligente d\'aujourd\'hui et de demain.\r\nASUS est l\'une des entreprises les plus admirées au monde du magazine Fortune et se consacre à la création de produits pour la vie intelligente d\'aujourd\'hui et de demain.\r\nASUS est l\'une des entreprises les plus admirées au monde du magazine Fortune et se consacre à la création de produits pour la vie intelligente d\'aujourd\'hui et de demain.', 'Ecran : 14-14.9 FHD IPS (1920 x 1080 pixels LED)\r\nProcesseur : Intel Core i5-1135G7 Processor 2.4 GHz (8M Cache, up to 4.2 GHz)\r\nMémoire : RAM 16G\r\nStockage : 512G SSD PCIE\r\nSystème d\'exploitation : WINDOWS 10\r\nDescription du clavier : ‎AZERTY + CLAVIER RETRO-ECLAIRE\r\nGarantie constructeur : ‎2 year manufacturer\r\nCouleur : TRANSPARENT SILVER\r\nDescription de la carte graphique : Integrated Iris X\r\nDurée de vie moyenne (en heures) : ‎9 heures\r\nEcran : 14-14.9 FHD IPS (1920 x 1080 pixels LED)\r\nProcesseur : Intel Core i5-1135G7 Processor 2.4 GHz (8M Cache, up to 4.2 GHz)\r\nMémoire : RAM 16G\r\nStockage : 512G SSD PCIE\r\nSystème d\'exploitation : WINDOWS 10\r\nDescription du clavier : ‎AZERTY + CLAVIER RETRO-ECLAIRE\r\nGarantie constructeur : ‎2 year manufacturer\r\nCouleur : TRANSPARENT SILVER\r\nDescription de la carte graphique : Integrated Iris X\r\nDurée de vie moyenne (en heures) : ‎9 heures', '999.00', 250, 'pvhc17SP79IfzTavbtgA_2022_05_08_18_51_13.jpg', 'lcwaHcnA2BdsVnGISWNI_2022_05_08_18_51_13.jpg', 'G34kX3SttPw1oZh3JCvh_2022_05_08_18_51_13.jpg', 1, 1, 3),
(4, 'HyperX HX-HSCA-RD Cloud Alpha', 'Description du produit\r\nLa conception révolutionnaire des transducteurs à chambre double du HyperX Cloud Alpha apporte à votre écoute une meilleure distinction entre medium / aigus / graves, une plus grande clarté du son, tout en réduisant la distorsion. Les chambres doubles séparent les basses pour générer un son plus clair et plus homogène. Le Cloud Alpha réunit les avantages de la mousse à mémoire de forme rouge, un arceau élargi, un cuir plus doux et plus souple, un cadre en aluminium, un câble tressé amovible, et un microphone à suppression de bruit. Il est compatible multiplateforme, avec des commandes en ligne sur toutes les plateformes équipées d\'un port 3,5 mm, telles que PC, PS5, PS4, Xbox One et Xbox Series X|S. Appuyez fermement sur le câble détachable dans le pinna pour vous assurer qu\'il est bien serré. La fiche est bloquée lorsqu\'aucune zone grise de la fiche n\'est visible. En cas de doute, débranchez le câble de la voie et reconnectez-le fermement. REMARQUE: veuillez vous assurer que le câble audio en ligne est complètement inséré dans le casque\r\n\r\nContenu du coffret\r\n1 x Cloud Alpha Casque-micro Pro Gaming', 'À propos de cet article\r\nCompatible avec PC, PS5, PS4, Xbox One, Xbox Series X|S et d\'autres plateformes avec un port de 3,5 mm\r\nLes transducteurs à chambre double HyperX génèrent un son cristallin et moins de distorsions acoustiques. Niveau de pression acoustique : 98dBSPL/mW à 1kHz\r\nConfort certifié par Discord et TeamSpeak\r\nCadre aluminium durable avec arceau élargi\r\nCâble tressé amovible avec commandes audio en ligne\r\nMicrophone amovible à réduction de bruit\r\nImpédance: 65 Ω\r\nRéponse en fréquence : 50Hz-18,000Hz', '73.99', 250, '6peVUm0i5LNgJWukKYcf_2022_05_08_19_17_35.jpg', 'KqoZEsYrOPiRfEGySbPd_2022_05_08_19_17_35.jpg', '77kXiipMzh7lYhkJXBaR_2022_05_08_19_17_35.jpg', 1, 5, 3),
(5, 'SAMSUNG C27F396FHR', 'L’écran à la courbure la plus profonde qui vous offre une expérience visuelle profondément immersive. Découvrez une expérience visuelle incroyablement immersive grâce au moniteur Samsung à la courbure la plus profonde qui soit. Enveloppant votre champ de vision comme dans une salle de cinéma iMax, l’écran 1800R (avec son rayon d’arc de 1800 mm pour une courbure encore plus importante) crée un champ de vision plus étendu, améliore la perception de la profondeur et réduit les distractions périphériques afin de vous attirer au cœur de vos contenus. Qu’il s’agisse d’un film en ligne, de votre émission de télévision préférée ou d’un jeu haletant, la profondeur de l’écran incurvé de Samsung vous immergera totalement dans vos contenus multimédia. Écran 1800R et mode Eye Saver pour plus de confort visuel. - Courbe de l’écran 1800R: la courbure plus importante de l’écran 1800R permet à vos yeux de parcourir l’ensemble de l’écran en douceur, tout en conservant une distance de visionnage constante. Les essais cliniques réalisés par le service d’ophtalmologie du Seoul National University Hospital ont montré que les yeux des utilisateurs étaient moins fatigués que lorsqu’ils regardaient un écran de moniteur plat.. - Mode Eye Saver: en réduisant les émissions de lumière bleue (qui stimulent davantage la rétine que les autres longueurs d’onde de couleur), le mode Eye Saver fatigue moins vos yeux et offre une expérience visuelle plus confortable.. - Flicker Free: la technologie Flicker Free de Samsung permet de réduire les scintillements de l’écran qui peuvent s’avérer gênants, afin de vous laisser travailler et jouer plus longtemps et avec plus de confort. Une qualité d’image exceptionnelle grâce à la technologie d’écran de pointe de Samsung.', 'L’écran à la courbure la plus profonde qui vous offre une expérience visuelle profondément immersive. Découvrez une expérience visuelle incroyablement immersive grâce au moniteur Samsung à la courbure la plus profonde qui soit. Enveloppant votre champ de vision comme dans une salle de cinéma iMax, l’écran 1800R (avec son rayon d’arc de 1800 mm pour une courbure encore plus importante) crée un champ de vision plus étendu, améliore la perception de la profondeur et réduit les distractions périphériques afin de vous attirer au cœur de vos contenus. Qu’il s’agisse d’un film en ligne, de votre émission de télévision préférée ou d’un jeu haletant, la profondeur de l’écran incurvé de Samsung vous immergera totalement dans vos contenus multimédia. Écran 1800R et mode Eye Saver pour plus de confort visuel. - Courbe de l’écran 1800R: la courbure plus importante de l’écran 1800R permet à vos yeux de parcourir l’ensemble de l’écran en douceur, tout en conservant une distance de visionnage constante. Les essais cliniques réalisés par le service d’ophtalmologie du Seoul National University Hospital ont montré que les yeux des utilisateurs étaient moins fatigués que lorsqu’ils regardaient un écran de moniteur plat.. - Mode Eye Saver: en réduisant les émissions de lumière bleue (qui stimulent davantage la rétine que les autres longueurs d’onde de couleur), le mode Eye Saver fatigue moins vos yeux et offre une expérience visuelle plus confortable.. - Flicker Free: la technologie Flicker Free de Samsung permet de réduire les scintillements de l’écran qui peuvent s’avérer gênants, afin de vous laisser travailler et jouer plus longtemps et avec plus de confort. Une qualité d’image exceptionnelle grâce à la technologie d’écran de pointe de Samsung.', '173.90', 250, 'DmZLcT2TDYcrJsqDp6gv_2022_05_08_19_23_48.jpg', 'Oe40iMww4Ro47Rsa3lcc_2022_05_08_19_23_48.jpg', 'b0xlvtwE3Ita4RQddBxI_2022_05_08_19_23_48.jpg', 1, 6, 3),
(6, 'Samsung Galaxy S22', 'Dimensions du colis	‎16.2 x 8.7 x 2.7 cm; 270 grammes\r\nPile(s) / Batterie(s) :	‎1 Lithium-ion - incluse(s)\r\nNuméro du modèle de l\'article	‎SM-S901BZKDEUH\r\nCouleur	‎Noir\r\nType de connectique	‎USB Type C\r\nTaille	‎128Go\r\nBattery Power Rating	‎3700 Modificateur inconnu\r\nType de pile	‎Lithium-ion\r\nSystème d\'exploitation	‎Android 12.0\r\nTaille de la mémoire vive	‎8 Go\r\nTaille de l\'écran	‎6.1 Pouces\r\nPoids de l\'article	‎270 g\r\nDisponibilité des pièces détachées	‎Information indisponible sur les pièces détachées\r\nDimensions du colis	‎16.2 x 8.7 x 2.7 cm; 270 grammes\r\nPile(s) / Batterie(s) :	‎1 Lithium-ion - incluse(s)\r\nNuméro du modèle de l\'article	‎SM-S901BZKDEUH\r\nCouleur	‎Noir\r\nType de connectique	‎USB Type C\r\nTaille	‎128Go\r\nBattery Power Rating	‎3700 Modificateur inconnu\r\nType de pile	‎Lithium-ion\r\nSystème d\'exploitation	‎Android 12.0\r\nTaille de la mémoire vive	‎8 Go\r\nTaille de l\'écran	‎6.1 Pouces\r\nPoids de l\'article	‎270 g\r\nDisponibilité des pièces détachées	‎Information indisponible sur les pièces détachées\r\n', 'Composants inclus	Câble USB\r\nMarque	Samsung\r\nOpérateur sans fil	Débloqué\r\nCapacité de stockage de la mémoire	8 Go\r\nTechnologie cellulaire	5G, 4G LTE\r\nNom de modèle	Samsung Galaxy S22, Téléphone mobile 5G 128Go Noir, sans carte SIM, smartphone Android, Version FR\r\nCouleur	Noir\r\nTaille de l\'écran	6.1 Pouces\r\nFacteur de forme	Smartphone\r\nPuissance de la batterie	3700 Modificateur inconnu\r\nComposants inclus	Câble USB\r\nMarque	Samsung\r\nOpérateur sans fil	Débloqué\r\nCapacité de stockage de la mémoire	8 Go\r\nTechnologie cellulaire	5G, 4G LTE\r\nNom de modèle	Samsung Galaxy S22, Téléphone mobile 5G 128Go Noir, sans carte SIM, smartphone Android, Version FR\r\nCouleur	Noir\r\nTaille de l\'écran	6.1 Pouces\r\nFacteur de forme	Smartphone\r\nPuissance de la batterie	3700 Modificateur inconnu', '830.52', 250, 'nVRD9KzYaSdXk6GXETkP_2022_05_08_19_28_25.jpg', 'GRZzu4xwq7EnvMmrx4Is_2022_05_08_19_28_25.jpg', '3Grt4xuwzZhwso5IqqXz_2022_05_08_19_28_25.jpg', 1, 2, 3),
(7, 'Razer BlackWidow V3 - Green Switch', 'Razer BlackWidow V3 - Clavier mécanique de jeu haut de gamme, clavier mécanique avec touches vertes, touches tactiles et cliquables, éclairage chromatique RVB, touches multimédia.\r\nRazer BlackWidow V3 - Clavier mécanique de jeu haut de gamme, clavier mécanique avec touches vertes, touches tactiles et cliquables, éclairage chromatique RVB, touches multimédia.\r\nRazer BlackWidow V3 - Clavier mécanique de jeu haut de gamme, clavier mécanique avec touches vertes, touches tactiles et cliquables, éclairage chromatique RVB, touches multimédia.', '\r\nDescription du clavier	Gaming, AZERTY\r\nCaractéristique spéciale	Backlit, Hotkeys_and_media_keys\r\nMarque	Razer\r\nséries	BlackWidow V3\r\nCouleur	Green Switch\r\nGestion de la couleur de rétro-éclairage du clavier	RVB\r\nStyle	BlackWidow V3\r\nType d\'interrupteur	Tactile\r\n\r\nDescription du clavier	Gaming, AZERTY\r\nCaractéristique spéciale	Backlit, Hotkeys_and_media_keys\r\nMarque	Razer\r\nséries	BlackWidow V3\r\nCouleur	Green Switch\r\nGestion de la couleur de rétro-éclairage du clavier	RVB\r\nStyle	BlackWidow V3\r\nType d\'interrupteur	Tactile', '134.95', 250, 'vs5AD38dXcDpQiHcDQSB_2022_05_08_19_31_44.jpg', 'RQSiKvKNu8KkMpGRZfFX_2022_05_08_19_31_44.jpg', 'HJINWqOUAFTHL4ovs5rn_2022_05_08_19_31_44.jpg', 1, 4, 3),
(8, 'BenQ ZOWIE EC2 Souris Esports', 'MOUSE ZOWIE EC2 Small size Right Hand (9H.N26BB.A2E)*0654/P1+A ZOWIE a été fondée à la fin de 2008. C’est une marque dédiée au développement de l’équipement d’esports professionnel. Nous nous efforçons de ne pas devenir la plus grande marque de sport électronique, mais la plus professionnelle.\r\nMOUSE ZOWIE EC2 Small size Right Hand (9H.N26BB.A2E)*0654/P1+A ZOWIE a été fondée à la fin de 2008. C’est une marque dédiée au développement de l’équipement d’esports professionnel. Nous nous efforçons de ne pas devenir la plus grande marque de sport électronique, mais la plus professionnelle.', 'Type de connecteur	USB\r\nUsages recommandés pour le produit	Jeu\r\nMarque	BenQ\r\nCompatibilité du périphérique	Spielkonsole, Personal Computer\r\nséries	Zowie EC2\r\nCaractéristique spéciale	Conception ergonomique\r\nTechnologie de détection des mouvements	Optique\r\nCouleur	Noir\r\nNombre de boutons	3\r\nStyle	3360 Sensor, Large mouse feet\r\n\r\nType de connecteur	USB\r\nUsages recommandés pour le produit	Jeu\r\nMarque	BenQ\r\nCompatibilité du périphérique	Spielkonsole, Personal Computer\r\nséries	Zowie EC2\r\nCaractéristique spéciale	Conception ergonomique\r\nTechnologie de détection des mouvements	Optique\r\nCouleur	Noir\r\nNombre de boutons	3\r\nStyle	3360 Sensor, Large mouse feet', '59.99', 250, 'WoSiISrWOYGcCjeQ5fvI_2022_05_08_19_34_18.jpg', 'D7nnNF6UN9QrGWxmb718_2022_05_08_19_34_18.jpg', 'EQVp4f9iEKlGm7LIfH9e_2022_05_08_19_34_18.jpg', 1, 3, 3);

--
-- Déclencheurs `produit`
--
DROP TRIGGER IF EXISTS `produit_AFTER_INSERT`;
DELIMITER $$
CREATE TRIGGER `produit_AFTER_INSERT` AFTER INSERT ON `produit` FOR EACH ROW BEGIN
INSERT INTO produit_sauv
VALUES ((SELECT id_produit FROM produit WHERE id_produit = NEW.id_produit LIMIT 1),
(SELECT titre_produit FROM produit WHERE titre_produit = NEW.titre_produit LIMIT 1),
(SELECT description_produit FROM produit WHERE description_produit = NEW.description_produit LIMIT 1),
(SELECT caracteristique_produit FROM produit WHERE caracteristique_produit = NEW.caracteristique_produit LIMIT 1),
(SELECT prix_produit FROM produit WHERE prix_produit = NEW.prix_produit LIMIT 1),
(SELECT quantite_produit FROM produit WHERE quantite_produit = NEW.quantite_produit LIMIT 1),
(SELECT photo_produit_1	 FROM produit WHERE photo_produit_1 = NEW.photo_produit_1 LIMIT 1),
(SELECT photo_produit_2	 FROM produit WHERE photo_produit_2 = NEW.photo_produit_2 LIMIT 1),
(SELECT photo_produit_3	 FROM produit WHERE photo_produit_3 = NEW.photo_produit_3 LIMIT 1),
(SELECT active_produit FROM produit WHERE active_produit = NEW.active_produit LIMIT 1),
(SELECT id_tag FROM produit WHERE id_tag = NEW.id_tag LIMIT 1),
(SELECT id_utilisateur FROM produit WHERE id_utilisateur = NEW.id_utilisateur LIMIT 1),
"A");
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `produit_AFTER_UPDATE`;
DELIMITER $$
CREATE TRIGGER `produit_AFTER_UPDATE` AFTER UPDATE ON `produit` FOR EACH ROW BEGIN
INSERT INTO produit_sauv
VALUES ((SELECT id_produit FROM produit WHERE id_produit = NEW.id_produit LIMIT 1),
(SELECT titre_produit FROM produit WHERE titre_produit = NEW.titre_produit LIMIT 1),
(SELECT description_produit FROM produit WHERE description_produit = NEW.description_produit LIMIT 1),
(SELECT caracteristique_produit FROM produit WHERE caracteristique_produit = NEW.caracteristique_produit LIMIT 1),
(SELECT prix_produit FROM produit WHERE prix_produit = NEW.prix_produit LIMIT 1),
(SELECT quantite_produit FROM produit WHERE quantite_produit = NEW.quantite_produit LIMIT 1),
(SELECT photo_produit_1	 FROM produit WHERE photo_produit_1 = NEW.photo_produit_1 LIMIT 1),
(SELECT photo_produit_2	 FROM produit WHERE photo_produit_2 = NEW.photo_produit_2 LIMIT 1),
(SELECT photo_produit_3	 FROM produit WHERE photo_produit_3 = NEW.photo_produit_3 LIMIT 1),
(SELECT active_produit FROM produit WHERE active_produit = NEW.active_produit LIMIT 1),
(SELECT id_tag FROM produit WHERE id_tag = NEW.id_tag LIMIT 1),
(SELECT id_utilisateur FROM produit WHERE id_utilisateur = NEW.id_utilisateur LIMIT 1),
"M");
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `produit_BEFORE_DELETE`;
DELIMITER $$
CREATE TRIGGER `produit_BEFORE_DELETE` BEFORE DELETE ON `produit` FOR EACH ROW BEGIN
INSERT INTO produit_sauv
VALUES ((SELECT id_produit FROM produit WHERE id_produit = OLD.id_produit LIMIT 1),
(SELECT titre_produit FROM produit WHERE titre_produit = OLD.titre_produit LIMIT 1),
(SELECT description_produit FROM produit WHERE description_produit = OLD.description_produit LIMIT 1),
(SELECT caracteristique_produit FROM produit WHERE caracteristique_produit = OLD.caracteristique_produit LIMIT 1),
(SELECT prix_produit FROM produit WHERE prix_produit = OLD.prix_produit LIMIT 1),
(SELECT quantite_produit FROM produit WHERE quantite_produit = OLD.quantite_produit LIMIT 1),
(SELECT photo_produit_1	 FROM produit WHERE photo_produit_1 = OLD.photo_produit_1 LIMIT 1),
(SELECT photo_produit_2	 FROM produit WHERE photo_produit_2 = OLD.photo_produit_2 LIMIT 1),
(SELECT photo_produit_3	 FROM produit WHERE photo_produit_3 = OLD.photo_produit_3 LIMIT 1),
(SELECT active_produit FROM produit WHERE active_produit = OLD.active_produit LIMIT 1),
(SELECT id_tag FROM produit WHERE id_tag = OLD.id_tag LIMIT 1),
(SELECT id_utilisateur FROM produit WHERE id_utilisateur = OLD.id_utilisateur LIMIT 1),
"S");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `produit_sauv`
--

DROP TABLE IF EXISTS `produit_sauv`;
CREATE TABLE IF NOT EXISTS `produit_sauv` (
  `id_produit` int NOT NULL,
  `titre_produit` varchar(45) NOT NULL,
  `description_produit` varchar(2000) NOT NULL,
  `caracteristique_produit` varchar(2000) NOT NULL,
  `prix_produit` decimal(10,2) NOT NULL,
  `quantite_produit` int NOT NULL,
  `photo_produit_1` varchar(44) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `photo_produit_2` varchar(44) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `photo_produit_3` varchar(44) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `active_produit` tinyint NOT NULL DEFAULT '0',
  `id_tag` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  `type_sauv` char(1) NOT NULL,
  KEY `id_tag_idx` (`id_tag`),
  KEY `id_utilisateur_idx` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit_sauv`
--

INSERT INTO `produit_sauv` (`id_produit`, `titre_produit`, `description_produit`, `caracteristique_produit`, `prix_produit`, `quantite_produit`, `photo_produit_1`, `photo_produit_2`, `photo_produit_3`, `active_produit`, `id_tag`, `id_utilisateur`, `type_sauv`) VALUES
(3, 'ASUS Vivobook S S433EA-EB855T', 'ASUS est l\'une des entreprises les plus admirées au monde du magazine Fortune et se consacre à la création de produits pour la vie intelligente d\'aujourd\'hui et de demain.\r\nASUS est l\'une des entreprises les plus admirées au monde du magazine Fortune et se consacre à la création de produits pour la vie intelligente d\'aujourd\'hui et de demain.\r\nASUS est l\'une des entreprises les plus admirées au monde du magazine Fortune et se consacre à la création de produits pour la vie intelligente d\'aujourd\'hui et de demain.', 'Ecran : 14-14.9 FHD IPS (1920 x 1080 pixels LED)\r\nProcesseur : Intel Core i5-1135G7 Processor 2.4 GHz (8M Cache, up to 4.2 GHz)\r\nMémoire : RAM 16G\r\nStockage : 512G SSD PCIE\r\nSystème d\'exploitation : WINDOWS 10\r\nDescription du clavier : ‎AZERTY + CLAVIER RETRO-ECLAIRE\r\nGarantie constructeur : ‎2 year manufacturer\r\nCouleur : TRANSPARENT SILVER\r\nDescription de la carte graphique : Integrated Iris X\r\nDurée de vie moyenne (en heures) : ‎9 heures\r\nEcran : 14-14.9 FHD IPS (1920 x 1080 pixels LED)\r\nProcesseur : Intel Core i5-1135G7 Processor 2.4 GHz (8M Cache, up to 4.2 GHz)\r\nMémoire : RAM 16G\r\nStockage : 512G SSD PCIE\r\nSystème d\'exploitation : WINDOWS 10\r\nDescription du clavier : ‎AZERTY + CLAVIER RETRO-ECLAIRE\r\nGarantie constructeur : ‎2 year manufacturer\r\nCouleur : TRANSPARENT SILVER\r\nDescription de la carte graphique : Integrated Iris X\r\nDurée de vie moyenne (en heures) : ‎9 heures', '999.00', 250, 'pvhc17SP79IfzTavbtgA_2022_05_08_18_51_13.jpg', 'lcwaHcnA2BdsVnGISWNI_2022_05_08_18_51_13.jpg', 'G34kX3SttPw1oZh3JCvh_2022_05_08_18_51_13.jpg', 0, 1, 3, 'A'),
(3, 'ASUS Vivobook S S433EA-EB855T', 'ASUS est l\'une des entreprises les plus admirées au monde du magazine Fortune et se consacre à la création de produits pour la vie intelligente d\'aujourd\'hui et de demain.\r\nASUS est l\'une des entreprises les plus admirées au monde du magazine Fortune et se consacre à la création de produits pour la vie intelligente d\'aujourd\'hui et de demain.\r\nASUS est l\'une des entreprises les plus admirées au monde du magazine Fortune et se consacre à la création de produits pour la vie intelligente d\'aujourd\'hui et de demain.', 'Ecran : 14-14.9 FHD IPS (1920 x 1080 pixels LED)\r\nProcesseur : Intel Core i5-1135G7 Processor 2.4 GHz (8M Cache, up to 4.2 GHz)\r\nMémoire : RAM 16G\r\nStockage : 512G SSD PCIE\r\nSystème d\'exploitation : WINDOWS 10\r\nDescription du clavier : ‎AZERTY + CLAVIER RETRO-ECLAIRE\r\nGarantie constructeur : ‎2 year manufacturer\r\nCouleur : TRANSPARENT SILVER\r\nDescription de la carte graphique : Integrated Iris X\r\nDurée de vie moyenne (en heures) : ‎9 heures\r\nEcran : 14-14.9 FHD IPS (1920 x 1080 pixels LED)\r\nProcesseur : Intel Core i5-1135G7 Processor 2.4 GHz (8M Cache, up to 4.2 GHz)\r\nMémoire : RAM 16G\r\nStockage : 512G SSD PCIE\r\nSystème d\'exploitation : WINDOWS 10\r\nDescription du clavier : ‎AZERTY + CLAVIER RETRO-ECLAIRE\r\nGarantie constructeur : ‎2 year manufacturer\r\nCouleur : TRANSPARENT SILVER\r\nDescription de la carte graphique : Integrated Iris X\r\nDurée de vie moyenne (en heures) : ‎9 heures', '999.00', 250, 'pvhc17SP79IfzTavbtgA_2022_05_08_18_51_13.jpg', 'lcwaHcnA2BdsVnGISWNI_2022_05_08_18_51_13.jpg', 'G34kX3SttPw1oZh3JCvh_2022_05_08_18_51_13.jpg', 1, 1, 3, 'M'),
(4, 'HyperX HX-HSCA-RD Cloud Alpha', 'Description du produit\r\nLa conception révolutionnaire des transducteurs à chambre double du HyperX Cloud Alpha apporte à votre écoute une meilleure distinction entre medium / aigus / graves, une plus grande clarté du son, tout en réduisant la distorsion. Les chambres doubles séparent les basses pour générer un son plus clair et plus homogène. Le Cloud Alpha réunit les avantages de la mousse à mémoire de forme rouge, un arceau élargi, un cuir plus doux et plus souple, un cadre en aluminium, un câble tressé amovible, et un microphone à suppression de bruit. Il est compatible multiplateforme, avec des commandes en ligne sur toutes les plateformes équipées d\'un port 3,5 mm, telles que PC, PS5, PS4, Xbox One et Xbox Series X|S. Appuyez fermement sur le câble détachable dans le pinna pour vous assurer qu\'il est bien serré. La fiche est bloquée lorsqu\'aucune zone grise de la fiche n\'est visible. En cas de doute, débranchez le câble de la voie et reconnectez-le fermement. REMARQUE: veuillez vous assurer que le câble audio en ligne est complètement inséré dans le casque\r\n\r\nContenu du coffret\r\n1 x Cloud Alpha Casque-micro Pro Gaming', 'À propos de cet article\r\nCompatible avec PC, PS5, PS4, Xbox One, Xbox Series X|S et d\'autres plateformes avec un port de 3,5 mm\r\nLes transducteurs à chambre double HyperX génèrent un son cristallin et moins de distorsions acoustiques. Niveau de pression acoustique : 98dBSPL/mW à 1kHz\r\nConfort certifié par Discord et TeamSpeak\r\nCadre aluminium durable avec arceau élargi\r\nCâble tressé amovible avec commandes audio en ligne\r\nMicrophone amovible à réduction de bruit\r\nImpédance: 65 Ω\r\nRéponse en fréquence : 50Hz-18,000Hz', '73.99', 250, '6peVUm0i5LNgJWukKYcf_2022_05_08_19_17_35.jpg', 'KqoZEsYrOPiRfEGySbPd_2022_05_08_19_17_35.jpg', '77kXiipMzh7lYhkJXBaR_2022_05_08_19_17_35.jpg', 0, 5, 3, 'A'),
(4, 'HyperX HX-HSCA-RD Cloud Alpha', 'Description du produit\r\nLa conception révolutionnaire des transducteurs à chambre double du HyperX Cloud Alpha apporte à votre écoute une meilleure distinction entre medium / aigus / graves, une plus grande clarté du son, tout en réduisant la distorsion. Les chambres doubles séparent les basses pour générer un son plus clair et plus homogène. Le Cloud Alpha réunit les avantages de la mousse à mémoire de forme rouge, un arceau élargi, un cuir plus doux et plus souple, un cadre en aluminium, un câble tressé amovible, et un microphone à suppression de bruit. Il est compatible multiplateforme, avec des commandes en ligne sur toutes les plateformes équipées d\'un port 3,5 mm, telles que PC, PS5, PS4, Xbox One et Xbox Series X|S. Appuyez fermement sur le câble détachable dans le pinna pour vous assurer qu\'il est bien serré. La fiche est bloquée lorsqu\'aucune zone grise de la fiche n\'est visible. En cas de doute, débranchez le câble de la voie et reconnectez-le fermement. REMARQUE: veuillez vous assurer que le câble audio en ligne est complètement inséré dans le casque\r\n\r\nContenu du coffret\r\n1 x Cloud Alpha Casque-micro Pro Gaming', 'À propos de cet article\r\nCompatible avec PC, PS5, PS4, Xbox One, Xbox Series X|S et d\'autres plateformes avec un port de 3,5 mm\r\nLes transducteurs à chambre double HyperX génèrent un son cristallin et moins de distorsions acoustiques. Niveau de pression acoustique : 98dBSPL/mW à 1kHz\r\nConfort certifié par Discord et TeamSpeak\r\nCadre aluminium durable avec arceau élargi\r\nCâble tressé amovible avec commandes audio en ligne\r\nMicrophone amovible à réduction de bruit\r\nImpédance: 65 Ω\r\nRéponse en fréquence : 50Hz-18,000Hz', '73.99', 250, '6peVUm0i5LNgJWukKYcf_2022_05_08_19_17_35.jpg', 'KqoZEsYrOPiRfEGySbPd_2022_05_08_19_17_35.jpg', '77kXiipMzh7lYhkJXBaR_2022_05_08_19_17_35.jpg', 0, 5, 3, 'M'),
(4, 'HyperX HX-HSCA-RD Cloud Alpha', 'Description du produit\r\nLa conception révolutionnaire des transducteurs à chambre double du HyperX Cloud Alpha apporte à votre écoute une meilleure distinction entre medium / aigus / graves, une plus grande clarté du son, tout en réduisant la distorsion. Les chambres doubles séparent les basses pour générer un son plus clair et plus homogène. Le Cloud Alpha réunit les avantages de la mousse à mémoire de forme rouge, un arceau élargi, un cuir plus doux et plus souple, un cadre en aluminium, un câble tressé amovible, et un microphone à suppression de bruit. Il est compatible multiplateforme, avec des commandes en ligne sur toutes les plateformes équipées d\'un port 3,5 mm, telles que PC, PS5, PS4, Xbox One et Xbox Series X|S. Appuyez fermement sur le câble détachable dans le pinna pour vous assurer qu\'il est bien serré. La fiche est bloquée lorsqu\'aucune zone grise de la fiche n\'est visible. En cas de doute, débranchez le câble de la voie et reconnectez-le fermement. REMARQUE: veuillez vous assurer que le câble audio en ligne est complètement inséré dans le casque\r\n\r\nContenu du coffret\r\n1 x Cloud Alpha Casque-micro Pro Gaming', 'À propos de cet article\r\nCompatible avec PC, PS5, PS4, Xbox One, Xbox Series X|S et d\'autres plateformes avec un port de 3,5 mm\r\nLes transducteurs à chambre double HyperX génèrent un son cristallin et moins de distorsions acoustiques. Niveau de pression acoustique : 98dBSPL/mW à 1kHz\r\nConfort certifié par Discord et TeamSpeak\r\nCadre aluminium durable avec arceau élargi\r\nCâble tressé amovible avec commandes audio en ligne\r\nMicrophone amovible à réduction de bruit\r\nImpédance: 65 Ω\r\nRéponse en fréquence : 50Hz-18,000Hz', '73.99', 250, '6peVUm0i5LNgJWukKYcf_2022_05_08_19_17_35.jpg', 'KqoZEsYrOPiRfEGySbPd_2022_05_08_19_17_35.jpg', '77kXiipMzh7lYhkJXBaR_2022_05_08_19_17_35.jpg', 1, 5, 3, 'M'),
(5, 'SAMSUNG C27F396FHR', 'L’écran à la courbure la plus profonde qui vous offre une expérience visuelle profondément immersive. Découvrez une expérience visuelle incroyablement immersive grâce au moniteur Samsung à la courbure la plus profonde qui soit. Enveloppant votre champ de vision comme dans une salle de cinéma iMax, l’écran 1800R (avec son rayon d’arc de 1800 mm pour une courbure encore plus importante) crée un champ de vision plus étendu, améliore la perception de la profondeur et réduit les distractions périphériques afin de vous attirer au cœur de vos contenus. Qu’il s’agisse d’un film en ligne, de votre émission de télévision préférée ou d’un jeu haletant, la profondeur de l’écran incurvé de Samsung vous immergera totalement dans vos contenus multimédia. Écran 1800R et mode Eye Saver pour plus de confort visuel. - Courbe de l’écran 1800R: la courbure plus importante de l’écran 1800R permet à vos yeux de parcourir l’ensemble de l’écran en douceur, tout en conservant une distance de visionnage constante. Les essais cliniques réalisés par le service d’ophtalmologie du Seoul National University Hospital ont montré que les yeux des utilisateurs étaient moins fatigués que lorsqu’ils regardaient un écran de moniteur plat.. - Mode Eye Saver: en réduisant les émissions de lumière bleue (qui stimulent davantage la rétine que les autres longueurs d’onde de couleur), le mode Eye Saver fatigue moins vos yeux et offre une expérience visuelle plus confortable.. - Flicker Free: la technologie Flicker Free de Samsung permet de réduire les scintillements de l’écran qui peuvent s’avérer gênants, afin de vous laisser travailler et jouer plus longtemps et avec plus de confort. Une qualité d’image exceptionnelle grâce à la technologie d’écran de pointe de Samsung.', 'L’écran à la courbure la plus profonde qui vous offre une expérience visuelle profondément immersive. Découvrez une expérience visuelle incroyablement immersive grâce au moniteur Samsung à la courbure la plus profonde qui soit. Enveloppant votre champ de vision comme dans une salle de cinéma iMax, l’écran 1800R (avec son rayon d’arc de 1800 mm pour une courbure encore plus importante) crée un champ de vision plus étendu, améliore la perception de la profondeur et réduit les distractions périphériques afin de vous attirer au cœur de vos contenus. Qu’il s’agisse d’un film en ligne, de votre émission de télévision préférée ou d’un jeu haletant, la profondeur de l’écran incurvé de Samsung vous immergera totalement dans vos contenus multimédia. Écran 1800R et mode Eye Saver pour plus de confort visuel. - Courbe de l’écran 1800R: la courbure plus importante de l’écran 1800R permet à vos yeux de parcourir l’ensemble de l’écran en douceur, tout en conservant une distance de visionnage constante. Les essais cliniques réalisés par le service d’ophtalmologie du Seoul National University Hospital ont montré que les yeux des utilisateurs étaient moins fatigués que lorsqu’ils regardaient un écran de moniteur plat.. - Mode Eye Saver: en réduisant les émissions de lumière bleue (qui stimulent davantage la rétine que les autres longueurs d’onde de couleur), le mode Eye Saver fatigue moins vos yeux et offre une expérience visuelle plus confortable.. - Flicker Free: la technologie Flicker Free de Samsung permet de réduire les scintillements de l’écran qui peuvent s’avérer gênants, afin de vous laisser travailler et jouer plus longtemps et avec plus de confort. Une qualité d’image exceptionnelle grâce à la technologie d’écran de pointe de Samsung.', '173.90', 250, 'DmZLcT2TDYcrJsqDp6gv_2022_05_08_19_23_48.jpg', 'Oe40iMww4Ro47Rsa3lcc_2022_05_08_19_23_48.jpg', 'b0xlvtwE3Ita4RQddBxI_2022_05_08_19_23_48.jpg', 0, 6, 3, 'A'),
(6, 'Samsung Galaxy S22', 'Dimensions du colis	‎16.2 x 8.7 x 2.7 cm; 270 grammes\r\nPile(s) / Batterie(s) :	‎1 Lithium-ion - incluse(s)\r\nNuméro du modèle de l\'article	‎SM-S901BZKDEUH\r\nCouleur	‎Noir\r\nType de connectique	‎USB Type C\r\nTaille	‎128Go\r\nBattery Power Rating	‎3700 Modificateur inconnu\r\nType de pile	‎Lithium-ion\r\nSystème d\'exploitation	‎Android 12.0\r\nTaille de la mémoire vive	‎8 Go\r\nTaille de l\'écran	‎6.1 Pouces\r\nPoids de l\'article	‎270 g\r\nDisponibilité des pièces détachées	‎Information indisponible sur les pièces détachées\r\nDimensions du colis	‎16.2 x 8.7 x 2.7 cm; 270 grammes\r\nPile(s) / Batterie(s) :	‎1 Lithium-ion - incluse(s)\r\nNuméro du modèle de l\'article	‎SM-S901BZKDEUH\r\nCouleur	‎Noir\r\nType de connectique	‎USB Type C\r\nTaille	‎128Go\r\nBattery Power Rating	‎3700 Modificateur inconnu\r\nType de pile	‎Lithium-ion\r\nSystème d\'exploitation	‎Android 12.0\r\nTaille de la mémoire vive	‎8 Go\r\nTaille de l\'écran	‎6.1 Pouces\r\nPoids de l\'article	‎270 g\r\nDisponibilité des pièces détachées	‎Information indisponible sur les pièces détachées\r\n', 'Composants inclus	Câble USB\r\nMarque	Samsung\r\nOpérateur sans fil	Débloqué\r\nCapacité de stockage de la mémoire	8 Go\r\nTechnologie cellulaire	5G, 4G LTE\r\nNom de modèle	Samsung Galaxy S22, Téléphone mobile 5G 128Go Noir, sans carte SIM, smartphone Android, Version FR\r\nCouleur	Noir\r\nTaille de l\'écran	6.1 Pouces\r\nFacteur de forme	Smartphone\r\nPuissance de la batterie	3700 Modificateur inconnu\r\nComposants inclus	Câble USB\r\nMarque	Samsung\r\nOpérateur sans fil	Débloqué\r\nCapacité de stockage de la mémoire	8 Go\r\nTechnologie cellulaire	5G, 4G LTE\r\nNom de modèle	Samsung Galaxy S22, Téléphone mobile 5G 128Go Noir, sans carte SIM, smartphone Android, Version FR\r\nCouleur	Noir\r\nTaille de l\'écran	6.1 Pouces\r\nFacteur de forme	Smartphone\r\nPuissance de la batterie	3700 Modificateur inconnu', '830.52', 250, 'nVRD9KzYaSdXk6GXETkP_2022_05_08_19_28_25.jpg', 'GRZzu4xwq7EnvMmrx4Is_2022_05_08_19_28_25.jpg', '3Grt4xuwzZhwso5IqqXz_2022_05_08_19_28_25.jpg', 0, 2, 3, 'A'),
(6, 'Samsung Galaxy S22', 'Dimensions du colis	‎16.2 x 8.7 x 2.7 cm; 270 grammes\r\nPile(s) / Batterie(s) :	‎1 Lithium-ion - incluse(s)\r\nNuméro du modèle de l\'article	‎SM-S901BZKDEUH\r\nCouleur	‎Noir\r\nType de connectique	‎USB Type C\r\nTaille	‎128Go\r\nBattery Power Rating	‎3700 Modificateur inconnu\r\nType de pile	‎Lithium-ion\r\nSystème d\'exploitation	‎Android 12.0\r\nTaille de la mémoire vive	‎8 Go\r\nTaille de l\'écran	‎6.1 Pouces\r\nPoids de l\'article	‎270 g\r\nDisponibilité des pièces détachées	‎Information indisponible sur les pièces détachées\r\nDimensions du colis	‎16.2 x 8.7 x 2.7 cm; 270 grammes\r\nPile(s) / Batterie(s) :	‎1 Lithium-ion - incluse(s)\r\nNuméro du modèle de l\'article	‎SM-S901BZKDEUH\r\nCouleur	‎Noir\r\nType de connectique	‎USB Type C\r\nTaille	‎128Go\r\nBattery Power Rating	‎3700 Modificateur inconnu\r\nType de pile	‎Lithium-ion\r\nSystème d\'exploitation	‎Android 12.0\r\nTaille de la mémoire vive	‎8 Go\r\nTaille de l\'écran	‎6.1 Pouces\r\nPoids de l\'article	‎270 g\r\nDisponibilité des pièces détachées	‎Information indisponible sur les pièces détachées\r\n', 'Composants inclus	Câble USB\r\nMarque	Samsung\r\nOpérateur sans fil	Débloqué\r\nCapacité de stockage de la mémoire	8 Go\r\nTechnologie cellulaire	5G, 4G LTE\r\nNom de modèle	Samsung Galaxy S22, Téléphone mobile 5G 128Go Noir, sans carte SIM, smartphone Android, Version FR\r\nCouleur	Noir\r\nTaille de l\'écran	6.1 Pouces\r\nFacteur de forme	Smartphone\r\nPuissance de la batterie	3700 Modificateur inconnu\r\nComposants inclus	Câble USB\r\nMarque	Samsung\r\nOpérateur sans fil	Débloqué\r\nCapacité de stockage de la mémoire	8 Go\r\nTechnologie cellulaire	5G, 4G LTE\r\nNom de modèle	Samsung Galaxy S22, Téléphone mobile 5G 128Go Noir, sans carte SIM, smartphone Android, Version FR\r\nCouleur	Noir\r\nTaille de l\'écran	6.1 Pouces\r\nFacteur de forme	Smartphone\r\nPuissance de la batterie	3700 Modificateur inconnu', '830.52', 250, 'nVRD9KzYaSdXk6GXETkP_2022_05_08_19_28_25.jpg', 'GRZzu4xwq7EnvMmrx4Is_2022_05_08_19_28_25.jpg', '3Grt4xuwzZhwso5IqqXz_2022_05_08_19_28_25.jpg', 1, 2, 3, 'M'),
(5, 'SAMSUNG C27F396FHR', 'L’écran à la courbure la plus profonde qui vous offre une expérience visuelle profondément immersive. Découvrez une expérience visuelle incroyablement immersive grâce au moniteur Samsung à la courbure la plus profonde qui soit. Enveloppant votre champ de vision comme dans une salle de cinéma iMax, l’écran 1800R (avec son rayon d’arc de 1800 mm pour une courbure encore plus importante) crée un champ de vision plus étendu, améliore la perception de la profondeur et réduit les distractions périphériques afin de vous attirer au cœur de vos contenus. Qu’il s’agisse d’un film en ligne, de votre émission de télévision préférée ou d’un jeu haletant, la profondeur de l’écran incurvé de Samsung vous immergera totalement dans vos contenus multimédia. Écran 1800R et mode Eye Saver pour plus de confort visuel. - Courbe de l’écran 1800R: la courbure plus importante de l’écran 1800R permet à vos yeux de parcourir l’ensemble de l’écran en douceur, tout en conservant une distance de visionnage constante. Les essais cliniques réalisés par le service d’ophtalmologie du Seoul National University Hospital ont montré que les yeux des utilisateurs étaient moins fatigués que lorsqu’ils regardaient un écran de moniteur plat.. - Mode Eye Saver: en réduisant les émissions de lumière bleue (qui stimulent davantage la rétine que les autres longueurs d’onde de couleur), le mode Eye Saver fatigue moins vos yeux et offre une expérience visuelle plus confortable.. - Flicker Free: la technologie Flicker Free de Samsung permet de réduire les scintillements de l’écran qui peuvent s’avérer gênants, afin de vous laisser travailler et jouer plus longtemps et avec plus de confort. Une qualité d’image exceptionnelle grâce à la technologie d’écran de pointe de Samsung.', 'L’écran à la courbure la plus profonde qui vous offre une expérience visuelle profondément immersive. Découvrez une expérience visuelle incroyablement immersive grâce au moniteur Samsung à la courbure la plus profonde qui soit. Enveloppant votre champ de vision comme dans une salle de cinéma iMax, l’écran 1800R (avec son rayon d’arc de 1800 mm pour une courbure encore plus importante) crée un champ de vision plus étendu, améliore la perception de la profondeur et réduit les distractions périphériques afin de vous attirer au cœur de vos contenus. Qu’il s’agisse d’un film en ligne, de votre émission de télévision préférée ou d’un jeu haletant, la profondeur de l’écran incurvé de Samsung vous immergera totalement dans vos contenus multimédia. Écran 1800R et mode Eye Saver pour plus de confort visuel. - Courbe de l’écran 1800R: la courbure plus importante de l’écran 1800R permet à vos yeux de parcourir l’ensemble de l’écran en douceur, tout en conservant une distance de visionnage constante. Les essais cliniques réalisés par le service d’ophtalmologie du Seoul National University Hospital ont montré que les yeux des utilisateurs étaient moins fatigués que lorsqu’ils regardaient un écran de moniteur plat.. - Mode Eye Saver: en réduisant les émissions de lumière bleue (qui stimulent davantage la rétine que les autres longueurs d’onde de couleur), le mode Eye Saver fatigue moins vos yeux et offre une expérience visuelle plus confortable.. - Flicker Free: la technologie Flicker Free de Samsung permet de réduire les scintillements de l’écran qui peuvent s’avérer gênants, afin de vous laisser travailler et jouer plus longtemps et avec plus de confort. Une qualité d’image exceptionnelle grâce à la technologie d’écran de pointe de Samsung.', '173.90', 250, 'DmZLcT2TDYcrJsqDp6gv_2022_05_08_19_23_48.jpg', 'Oe40iMww4Ro47Rsa3lcc_2022_05_08_19_23_48.jpg', 'b0xlvtwE3Ita4RQddBxI_2022_05_08_19_23_48.jpg', 1, 6, 3, 'M'),
(7, 'Razer BlackWidow V3 - Green Switch', 'Razer BlackWidow V3 - Clavier mécanique de jeu haut de gamme, clavier mécanique avec touches vertes, touches tactiles et cliquables, éclairage chromatique RVB, touches multimédia.\r\nRazer BlackWidow V3 - Clavier mécanique de jeu haut de gamme, clavier mécanique avec touches vertes, touches tactiles et cliquables, éclairage chromatique RVB, touches multimédia.\r\nRazer BlackWidow V3 - Clavier mécanique de jeu haut de gamme, clavier mécanique avec touches vertes, touches tactiles et cliquables, éclairage chromatique RVB, touches multimédia.', '\r\nDescription du clavier	Gaming, AZERTY\r\nCaractéristique spéciale	Backlit, Hotkeys_and_media_keys\r\nMarque	Razer\r\nséries	BlackWidow V3\r\nCouleur	Green Switch\r\nGestion de la couleur de rétro-éclairage du clavier	RVB\r\nStyle	BlackWidow V3\r\nType d\'interrupteur	Tactile\r\n\r\nDescription du clavier	Gaming, AZERTY\r\nCaractéristique spéciale	Backlit, Hotkeys_and_media_keys\r\nMarque	Razer\r\nséries	BlackWidow V3\r\nCouleur	Green Switch\r\nGestion de la couleur de rétro-éclairage du clavier	RVB\r\nStyle	BlackWidow V3\r\nType d\'interrupteur	Tactile', '134.95', 250, 'vs5AD38dXcDpQiHcDQSB_2022_05_08_19_31_44.jpg', 'RQSiKvKNu8KkMpGRZfFX_2022_05_08_19_31_44.jpg', 'HJINWqOUAFTHL4ovs5rn_2022_05_08_19_31_44.jpg', 0, 4, 3, 'A'),
(7, 'Razer BlackWidow V3 - Green Switch', 'Razer BlackWidow V3 - Clavier mécanique de jeu haut de gamme, clavier mécanique avec touches vertes, touches tactiles et cliquables, éclairage chromatique RVB, touches multimédia.\r\nRazer BlackWidow V3 - Clavier mécanique de jeu haut de gamme, clavier mécanique avec touches vertes, touches tactiles et cliquables, éclairage chromatique RVB, touches multimédia.\r\nRazer BlackWidow V3 - Clavier mécanique de jeu haut de gamme, clavier mécanique avec touches vertes, touches tactiles et cliquables, éclairage chromatique RVB, touches multimédia.', '\r\nDescription du clavier	Gaming, AZERTY\r\nCaractéristique spéciale	Backlit, Hotkeys_and_media_keys\r\nMarque	Razer\r\nséries	BlackWidow V3\r\nCouleur	Green Switch\r\nGestion de la couleur de rétro-éclairage du clavier	RVB\r\nStyle	BlackWidow V3\r\nType d\'interrupteur	Tactile\r\n\r\nDescription du clavier	Gaming, AZERTY\r\nCaractéristique spéciale	Backlit, Hotkeys_and_media_keys\r\nMarque	Razer\r\nséries	BlackWidow V3\r\nCouleur	Green Switch\r\nGestion de la couleur de rétro-éclairage du clavier	RVB\r\nStyle	BlackWidow V3\r\nType d\'interrupteur	Tactile', '134.95', 250, 'vs5AD38dXcDpQiHcDQSB_2022_05_08_19_31_44.jpg', 'RQSiKvKNu8KkMpGRZfFX_2022_05_08_19_31_44.jpg', 'HJINWqOUAFTHL4ovs5rn_2022_05_08_19_31_44.jpg', 1, 4, 3, 'M'),
(8, 'BenQ ZOWIE EC2 Souris Esports', 'MOUSE ZOWIE EC2 Small size Right Hand (9H.N26BB.A2E)*0654/P1+A ZOWIE a été fondée à la fin de 2008. C’est une marque dédiée au développement de l’équipement d’esports professionnel. Nous nous efforçons de ne pas devenir la plus grande marque de sport électronique, mais la plus professionnelle.\r\nMOUSE ZOWIE EC2 Small size Right Hand (9H.N26BB.A2E)*0654/P1+A ZOWIE a été fondée à la fin de 2008. C’est une marque dédiée au développement de l’équipement d’esports professionnel. Nous nous efforçons de ne pas devenir la plus grande marque de sport électronique, mais la plus professionnelle.', 'Type de connecteur	USB\r\nUsages recommandés pour le produit	Jeu\r\nMarque	BenQ\r\nCompatibilité du périphérique	Spielkonsole, Personal Computer\r\nséries	Zowie EC2\r\nCaractéristique spéciale	Conception ergonomique\r\nTechnologie de détection des mouvements	Optique\r\nCouleur	Noir\r\nNombre de boutons	3\r\nStyle	3360 Sensor, Large mouse feet\r\n\r\nType de connecteur	USB\r\nUsages recommandés pour le produit	Jeu\r\nMarque	BenQ\r\nCompatibilité du périphérique	Spielkonsole, Personal Computer\r\nséries	Zowie EC2\r\nCaractéristique spéciale	Conception ergonomique\r\nTechnologie de détection des mouvements	Optique\r\nCouleur	Noir\r\nNombre de boutons	3\r\nStyle	3360 Sensor, Large mouse feet', '59.99', 250, 'WoSiISrWOYGcCjeQ5fvI_2022_05_08_19_34_18.jpg', 'D7nnNF6UN9QrGWxmb718_2022_05_08_19_34_18.jpg', 'EQVp4f9iEKlGm7LIfH9e_2022_05_08_19_34_18.jpg', 0, 3, 3, 'A'),
(8, 'BenQ ZOWIE EC2 Souris Esports', 'MOUSE ZOWIE EC2 Small size Right Hand (9H.N26BB.A2E)*0654/P1+A ZOWIE a été fondée à la fin de 2008. C’est une marque dédiée au développement de l’équipement d’esports professionnel. Nous nous efforçons de ne pas devenir la plus grande marque de sport électronique, mais la plus professionnelle.\r\nMOUSE ZOWIE EC2 Small size Right Hand (9H.N26BB.A2E)*0654/P1+A ZOWIE a été fondée à la fin de 2008. C’est une marque dédiée au développement de l’équipement d’esports professionnel. Nous nous efforçons de ne pas devenir la plus grande marque de sport électronique, mais la plus professionnelle.', 'Type de connecteur	USB\r\nUsages recommandés pour le produit	Jeu\r\nMarque	BenQ\r\nCompatibilité du périphérique	Spielkonsole, Personal Computer\r\nséries	Zowie EC2\r\nCaractéristique spéciale	Conception ergonomique\r\nTechnologie de détection des mouvements	Optique\r\nCouleur	Noir\r\nNombre de boutons	3\r\nStyle	3360 Sensor, Large mouse feet\r\n\r\nType de connecteur	USB\r\nUsages recommandés pour le produit	Jeu\r\nMarque	BenQ\r\nCompatibilité du périphérique	Spielkonsole, Personal Computer\r\nséries	Zowie EC2\r\nCaractéristique spéciale	Conception ergonomique\r\nTechnologie de détection des mouvements	Optique\r\nCouleur	Noir\r\nNombre de boutons	3\r\nStyle	3360 Sensor, Large mouse feet', '59.99', 250, 'WoSiISrWOYGcCjeQ5fvI_2022_05_08_19_34_18.jpg', 'D7nnNF6UN9QrGWxmb718_2022_05_08_19_34_18.jpg', 'EQVp4f9iEKlGm7LIfH9e_2022_05_08_19_34_18.jpg', 1, 3, 3, 'M');

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `id_tag` int NOT NULL AUTO_INCREMENT,
  `nom_tag` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `active_tag` tinyint(1) NOT NULL DEFAULT '0',
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_tag`),
  KEY `id_utilisateur_idx` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`id_tag`, `nom_tag`, `active_tag`, `id_utilisateur`) VALUES
(1, 'Ordinateur', 1, 1),
(2, 'Téléphone', 1, 3),
(3, 'Souris', 1, 3),
(4, 'Clavier', 1, 3),
(5, 'Casque', 1, 3),
(6, 'Ecran', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `type_utilisateur` varchar(45) NOT NULL,
  `active_utilisateur` tinyint(1) NOT NULL,
  `nom_utilisateur` varchar(45) NOT NULL,
  `prenom_utilisateur` varchar(45) NOT NULL,
  `pseudo_utilisateur` varchar(45) NOT NULL,
  `siren_utilisateur` char(9) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email_utilisateur` varchar(45) NOT NULL,
  `mot_de_passe_utilisateur` char(128) NOT NULL,
  `photo_utilisateur` varchar(44) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `adresse_utilisateur` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ville_utilisateur` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `code_postal_utilisateur` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `telephone_utilisateur` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `type_utilisateur`, `active_utilisateur`, `nom_utilisateur`, `prenom_utilisateur`, `pseudo_utilisateur`, `siren_utilisateur`, `email_utilisateur`, `mot_de_passe_utilisateur`, `photo_utilisateur`, `adresse_utilisateur`, `ville_utilisateur`, `code_postal_utilisateur`, `telephone_utilisateur`) VALUES
(1, 'admin', 1, 'Admin', 'Admin', 'administrateur', NULL, 'admin@gmail.com', 'df6b9fb15cfdbb7527be5a8a6e39f39e572c8ddb943fbc79a943438e9d3d85ebfc2ccf9e0eccd9346026c0b6876e0e01556fe56f135582c05fbdbb505d46755a', 'jjKE330h0q0JhaGUMlHG_2022_05_06_12_58_53.jpg', NULL, NULL, NULL, NULL),
(2, 'client', 1, 'Baie', 'Michel', 'michelbaie', NULL, 'michelbaie@gmail.com', 'df6b9fb15cfdbb7527be5a8a6e39f39e572c8ddb943fbc79a943438e9d3d85ebfc2ccf9e0eccd9346026c0b6876e0e01556fe56f135582c05fbdbb505d46755a', 'n5JMnXNkmPfheXdoE1Wk_2022_05_06_13_05_05.jpg', '7 Rue des Castors', 'Toulouse', '31000', '0678679556'),
(3, 'employe', 1, 'Raimi', 'Sam', 'Electronic & Co.', '702720292', 'samraimi@outlook.com', 'df6b9fb15cfdbb7527be5a8a6e39f39e572c8ddb943fbc79a943438e9d3d85ebfc2ccf9e0eccd9346026c0b6876e0e01556fe56f135582c05fbdbb505d46755a', 'bQxV8OJgUYBz3A1S84g3_2022_05_06_13_34_40.jpg', NULL, NULL, NULL, NULL);

--
-- Déclencheurs `utilisateur`
--
DROP TRIGGER IF EXISTS `utilisateur_AFTER_INSERT`;
DELIMITER $$
CREATE TRIGGER `utilisateur_AFTER_INSERT` AFTER INSERT ON `utilisateur` FOR EACH ROW BEGIN
INSERT INTO utilisateur_sauv
VALUES ((SELECT id_utilisateur FROM utilisateur WHERE id_utilisateur = NEW.id_utilisateur LIMIT 1),
(SELECT type_utilisateur FROM utilisateur WHERE type_utilisateur = NEW.type_utilisateur LIMIT 1),
(SELECT active_utilisateur FROM utilisateur WHERE active_utilisateur = NEW.active_utilisateur LIMIT 1),
(SELECT nom_utilisateur FROM utilisateur WHERE nom_utilisateur = NEW.nom_utilisateur LIMIT 1),
(SELECT prenom_utilisateur FROM utilisateur WHERE prenom_utilisateur = NEW.prenom_utilisateur LIMIT 1),
(SELECT pseudo_utilisateur FROM utilisateur WHERE pseudo_utilisateur = NEW.pseudo_utilisateur LIMIT 1),
(SELECT siren_utilisateur FROM utilisateur WHERE siren_utilisateur = NEW.siren_utilisateur LIMIT 1),
(SELECT email_utilisateur FROM utilisateur WHERE email_utilisateur = NEW.email_utilisateur LIMIT 1),
(SELECT mot_de_passe_utilisateur FROM utilisateur WHERE mot_de_passe_utilisateur = NEW.mot_de_passe_utilisateur LIMIT 1),
(SELECT photo_utilisateur FROM utilisateur WHERE photo_utilisateur = NEW.photo_utilisateur LIMIT 1),
(SELECT adresse_utilisateur FROM utilisateur WHERE adresse_utilisateur = NEW.adresse_utilisateur LIMIT 1),
(SELECT ville_utilisateur FROM utilisateur WHERE ville_utilisateur = NEW.ville_utilisateur LIMIT 1),
(SELECT code_postal_utilisateur FROM utilisateur WHERE code_postal_utilisateur = NEW.code_postal_utilisateur LIMIT 1),
(SELECT telephone_utilisateur FROM utilisateur WHERE telephone_utilisateur = NEW.telephone_utilisateur LIMIT 1),
"A");
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `utilisateur_AFTER_UPDATE`;
DELIMITER $$
CREATE TRIGGER `utilisateur_AFTER_UPDATE` AFTER UPDATE ON `utilisateur` FOR EACH ROW BEGIN
INSERT INTO utilisateur_sauv
VALUES ((SELECT id_utilisateur FROM utilisateur WHERE id_utilisateur = NEW.id_utilisateur LIMIT 1),
(SELECT type_utilisateur FROM utilisateur WHERE type_utilisateur = NEW.type_utilisateur LIMIT 1),
(SELECT active_utilisateur FROM utilisateur WHERE active_utilisateur = NEW.active_utilisateur LIMIT 1),
(SELECT nom_utilisateur FROM utilisateur WHERE nom_utilisateur = NEW.nom_utilisateur LIMIT 1),
(SELECT prenom_utilisateur FROM utilisateur WHERE prenom_utilisateur = NEW.prenom_utilisateur LIMIT 1),
(SELECT pseudo_utilisateur FROM utilisateur WHERE pseudo_utilisateur = NEW.pseudo_utilisateur LIMIT 1),
(SELECT siren_utilisateur FROM utilisateur WHERE siren_utilisateur = NEW.siren_utilisateur LIMIT 1),
(SELECT email_utilisateur FROM utilisateur WHERE email_utilisateur = NEW.email_utilisateur LIMIT 1),
(SELECT mot_de_passe_utilisateur FROM utilisateur WHERE mot_de_passe_utilisateur = NEW.mot_de_passe_utilisateur LIMIT 1),
(SELECT photo_utilisateur FROM utilisateur WHERE photo_utilisateur = NEW.photo_utilisateur LIMIT 1),
(SELECT adresse_utilisateur FROM utilisateur WHERE adresse_utilisateur = NEW.adresse_utilisateur LIMIT 1),
(SELECT ville_utilisateur FROM utilisateur WHERE ville_utilisateur = NEW.ville_utilisateur LIMIT 1),
(SELECT code_postal_utilisateur FROM utilisateur WHERE code_postal_utilisateur = NEW.code_postal_utilisateur LIMIT 1),
(SELECT telephone_utilisateur FROM utilisateur WHERE telephone_utilisateur = NEW.telephone_utilisateur LIMIT 1),
"M");
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `utilisateur_BEFORE_DELETE`;
DELIMITER $$
CREATE TRIGGER `utilisateur_BEFORE_DELETE` BEFORE DELETE ON `utilisateur` FOR EACH ROW BEGIN
INSERT INTO utilisateur_sauv
VALUES ((SELECT id_utilisateur FROM utilisateur WHERE id_utilisateur = OLD.id_utilisateur LIMIT 1),
(SELECT type_utilisateur FROM utilisateur WHERE type_utilisateur = OLD.type_utilisateur LIMIT 1),
(SELECT active_utilisateur FROM utilisateur WHERE active_utilisateur = OLD.active_utilisateur LIMIT 1),
(SELECT nom_utilisateur FROM utilisateur WHERE nom_utilisateur = OLD.nom_utilisateur LIMIT 1),
(SELECT prenom_utilisateur FROM utilisateur WHERE prenom_utilisateur = OLD.prenom_utilisateur LIMIT 1),
(SELECT pseudo_utilisateur FROM utilisateur WHERE pseudo_utilisateur = OLD.pseudo_utilisateur LIMIT 1),
(SELECT siren_utilisateur FROM utilisateur WHERE siren_utilisateur = OLD.siren_utilisateur LIMIT 1),
(SELECT email_utilisateur FROM utilisateur WHERE email_utilisateur = OLD.email_utilisateur LIMIT 1),
(SELECT mot_de_passe_utilisateur FROM utilisateur WHERE mot_de_passe_utilisateur = OLD.mot_de_passe_utilisateur LIMIT 1),
(SELECT photo_utilisateur FROM utilisateur WHERE photo_utilisateur = OLD.photo_utilisateur LIMIT 1),
(SELECT adresse_utilisateur FROM utilisateur WHERE adresse_utilisateur = OLD.adresse_utilisateur LIMIT 1),
(SELECT ville_utilisateur FROM utilisateur WHERE ville_utilisateur = OLD.ville_utilisateur LIMIT 1),
(SELECT code_postal_utilisateur FROM utilisateur WHERE code_postal_utilisateur = OLD.code_postal_utilisateur LIMIT 1),
(SELECT telephone_utilisateur FROM utilisateur WHERE telephone_utilisateur = OLD.telephone_utilisateur LIMIT 1),
"S");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_sauv`
--

DROP TABLE IF EXISTS `utilisateur_sauv`;
CREATE TABLE IF NOT EXISTS `utilisateur_sauv` (
  `id_utilisateur` int NOT NULL,
  `type_utilisateur` varchar(45) NOT NULL,
  `active_utilisateur` tinyint(1) NOT NULL,
  `nom_utilisateur` varchar(45) NOT NULL,
  `prenom_utilisateur` varchar(45) NOT NULL,
  `pseudo_utilisateur` varchar(45) NOT NULL,
  `siren_utilisateur` char(9) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email_utilisateur` varchar(45) NOT NULL,
  `mot_de_passe_utilisateur` char(128) NOT NULL,
  `photo_utilisateur` varchar(44) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `adresse_utilisateur` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ville_utilisateur` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `code_postal_utilisateur` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `telephone_utilisateur` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `type_sauv` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur_sauv`
--

INSERT INTO `utilisateur_sauv` (`id_utilisateur`, `type_utilisateur`, `active_utilisateur`, `nom_utilisateur`, `prenom_utilisateur`, `pseudo_utilisateur`, `siren_utilisateur`, `email_utilisateur`, `mot_de_passe_utilisateur`, `photo_utilisateur`, `adresse_utilisateur`, `ville_utilisateur`, `code_postal_utilisateur`, `telephone_utilisateur`, `type_sauv`) VALUES
(3, 'employe', 0, 'Raimi', 'Sam', 'Electronic & Co.', '702720292', 'samraimi@outlook.com', 'df6b9fb15cfdbb7527be5a8a6e39f39e572c8ddb943fbc79a943438e9d3d85ebfc2ccf9e0eccd9346026c0b6876e0e01556fe56f135582c05fbdbb505d46755a', 'bQxV8OJgUYBz3A1S84g3_2022_05_06_13_34_40.jpg', NULL, NULL, NULL, NULL, 'M'),
(3, 'employe', 1, 'Raimi', 'Sam', 'Electronic & Co.', '702720292', 'samraimi@outlook.com', 'df6b9fb15cfdbb7527be5a8a6e39f39e572c8ddb943fbc79a943438e9d3d85ebfc2ccf9e0eccd9346026c0b6876e0e01556fe56f135582c05fbdbb505d46755a', 'bQxV8OJgUYBz3A1S84g3_2022_05_06_13_34_40.jpg', NULL, NULL, NULL, NULL, 'M');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
