-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 09, 2022 at 03:38 PM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fstage`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `NUM_ADM` bigint(20) NOT NULL,
  `EMAIL_ADM` varchar(50) DEFAULT NULL,
  `MOTDEPASS_ADM` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contenirmotrap`
--

CREATE TABLE `contenirmotrap` (
  `NUM_CLE` bigint(20) NOT NULL,
  `NUM_RAP` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `enseignant`
--

CREATE TABLE `enseignant` (
  `NUM_ENS` bigint(20) NOT NULL,
  `PRENOM_ENS` varchar(25) DEFAULT NULL,
  `NOM_ENS` varchar(25) DEFAULT NULL,
  `DATEDENAISSANCE_ENS` date DEFAULT NULL,
  `EMAIL_ENS_ETU` varchar(50) DEFAULT NULL,
  `TEL_ENS` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `enseignant`
--

INSERT INTO `enseignant` (`NUM_ENS`, `PRENOM_ENS`, `NOM_ENS`, `DATEDENAISSANCE_ENS`, `EMAIL_ENS_ETU`, `TEL_ENS`) VALUES
(1, 'Omar', '    El Beggar', '1975-05-01', 'elbeggar@fstm.ac.ma', '0606060604'),
(2, 'Mohammed', 'Ramdani', '1975-05-01', 'ramdani@fstm.ac.ma', '0606060603'),
(3, 'Abdlekrim', 'bekkhoucha', '1975-05-01', 'bekkhoucha@fstm.ac.ma', '0606060603'),
(4, 'Kissi', 'Mohammed', '1975-05-01', 'kissi@fstm.ac.ma', '0606060603');

-- --------------------------------------------------------

--
-- Table structure for table `enseigner`
--

CREATE TABLE `enseigner` (
  `NUM_ENS` bigint(20) NOT NULL,
  `NUM_FORM` bigint(20) NOT NULL,
  `ACTIVE_ENS` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `enseigner`
--

INSERT INTO `enseigner` (`NUM_ENS`, `NUM_FORM`, `ACTIVE_ENS`) VALUES
(1, 1, NULL),
(2, 1, NULL),
(3, 1, NULL),
(4, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `entreprise`
--

CREATE TABLE `entreprise` (
  `NUM_ENT` bigint(20) NOT NULL,
  `LIBELLE_ENT` varchar(50) DEFAULT NULL,
  `ADRESSE_ENT` varchar(128) DEFAULT NULL,
  `EMAIL_ENT` varchar(50) DEFAULT NULL,
  `IMAGE_ENT` varchar(256) DEFAULT NULL,
  `TEL_ENT` varchar(15) DEFAULT NULL,
  `VILLE_ENT` varchar(25) DEFAULT NULL,
  `PAYS_ENT` varchar(25) DEFAULT NULL,
  `ACTIVE_ENT` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entreprise`
--

INSERT INTO `entreprise` (`NUM_ENT`, `LIBELLE_ENT`, `ADRESSE_ENT`, `EMAIL_ENT`, `IMAGE_ENT`, `TEL_ENT`, `VILLE_ENT`, `PAYS_ENT`, `ACTIVE_ENT`) VALUES
(1, 'google', 'wall street', 'google@google.com', '../ressources/company/images/1entlogo.png', '1122', 'New York', 'USA', NULL),
(2, '2M', 'zerktouni street', '2m@gmail.com', '../ressources/company/images/2entlogo.png', '0659432322', 'Casablanca', 'Maroc', NULL),
(3, 'Spotifty', 'Park yun Sydney suéde', 'spotyof@spotify.com', '../ressources/company/images/spotlogo.png', '+32640516541', 'Seidny', 'Suéde', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etudiant`
--

CREATE TABLE `etudiant` (
  `CNE_ETU` varchar(11) NOT NULL,
  `PRENOM_ETU` varchar(35) DEFAULT NULL,
  `NOM_ETU` varchar(35) DEFAULT NULL,
  `DATENAISS_ETU` date DEFAULT NULL,
  `EMAIL_ENS_ETU` varchar(50) DEFAULT NULL,
  `MOTDEPASSE_ETU` char(100) DEFAULT NULL,
  `CV_ETU` varchar(1024) DEFAULT NULL,
  `IMG_ETU` varchar(1024) DEFAULT NULL,
  `TEL_ETU` varchar(15) DEFAULT NULL,
  `VILLE_ETU` varchar(25) DEFAULT NULL,
  `PAYS_ETU` varchar(25) DEFAULT NULL,
  `ACTIVE_ETU` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etudiant`
--

INSERT INTO `etudiant` (`CNE_ETU`, `PRENOM_ETU`, `NOM_ETU`, `DATENAISS_ETU`, `EMAIL_ENS_ETU`, `MOTDEPASSE_ETU`, `CV_ETU`, `IMG_ETU`, `TEL_ETU`, `VILLE_ETU`, `PAYS_ETU`, `ACTIVE_ETU`) VALUES
('2019000004', 'Brahim Vall', 'Boumouzouna', '2000-11-26', 'bremssvall@gmail.com', '$2y$10$Vpl0v/77y0yF5ITZ1zEqRuMYxL0BGY1olszZJWOWzjGV637v/izzS', '../ressources/EtudiantCV/2019000004CV.pdf', '../ressources/EtudiantPhoto/2019000004profile.jpg', '0695480803', 'nktt', 'mauritanie', 0),
('C13572055', 'Farid', 'Ayoub', '1999-07-03', 'ayoub@gmail.com', '123', '../ressources/EtudiantCV/C13572055CV.pdf', NULL, '0611020304', 'tata', 'maroc', 0),
('CD121232', 'walid', 'ahdouf', '2000-08-15', 'walid@gmail.com', 'hithere', NULL, NULL, '0601020489', 'midelt', 'maroc', 0),
('CD12345612', 'Soufiane', 'lemhoubi', '2000-05-29', 'Soufiane@gmail.com', '$2y$10$Ry1bp6Nwpw7GosPL9bBm3O.u4et1ao83oLpIf/DH6abk3quMkBGTe', NULL, NULL, '0795340721', 'Mohammedia', 'maroc', 0),
('D129854234', 'elmehdi', 'hassani', '2001-12-27', 'mehdi@gmail.com', '123vivaalgerie', NULL, NULL, '0765762323', 'bouznica', 'maroc', 0),
('R1301292054', 'hamza', 'elidrissi', '2001-11-21', 'hamza@gmail.com', 'imcode', NULL, '../ressources/EtudiantPhoto/R1301292054profile.jpeg', '0699039972', 'mohammedia', 'maroc', 0),
('TK28520', 'elhoucine', 'essaidi', '2001-10-31', 'saidihoucine913@etu.fstm.ac.ma', 'imgood', NULL, NULL, '0605292992', 'bouznika', 'maroc', 0);

-- --------------------------------------------------------

--
-- Table structure for table `etudier`
--

CREATE TABLE `etudier` (
  `CNE_ETU` varchar(11) NOT NULL,
  `NUM_NIV` bigint(20) NOT NULL,
  `DATE_NIV` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etudier`
--

INSERT INTO `etudier` (`CNE_ETU`, `NUM_NIV`, `DATE_NIV`) VALUES
('2019000004', 1, '2022-05-26'),
('2019000004', 2, '2023-06-02'),
('C13572055', 1, '2021-10-01'),
('C13572055', 2, '2022-06-14'),
('CD121232', 2, '2022-05-26'),
('CD12345612', 1, '2022-05-29'),
('D129854234', 1, '2022-05-26'),
('D129854234', 2, '2022-06-16'),
('R1301292054', 1, '2022-05-01'),
('TK28520', 2, '2022-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `formation`
--

CREATE TABLE `formation` (
  `NUM_FORM` bigint(20) NOT NULL,
  `LIBELLE_FORM` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formation`
--

INSERT INTO `formation` (`NUM_FORM`, `LIBELLE_FORM`) VALUES
(1, 'ilisi');

-- --------------------------------------------------------

--
-- Table structure for table `juger`
--

CREATE TABLE `juger` (
  `NUM_ENS` bigint(20) NOT NULL,
  `NUM_STG` bigint(20) NOT NULL,
  `NOTE` float DEFAULT NULL,
  `EST_ENCADRER` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `juger`
--

INSERT INTO `juger` (`NUM_ENS`, `NUM_STG`, `NOTE`, `EST_ENCADRER`) VALUES
(2, 0, 12, 0),
(3, 0, 6, 1),
(4, 0, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `motcle`
--

CREATE TABLE `motcle` (
  `NUM_CLE` bigint(20) NOT NULL,
  `LIBELLE_CLE` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `niveau`
--

CREATE TABLE `niveau` (
  `NUM_NIV` bigint(20) NOT NULL,
  `NUM_FORM` bigint(20) NOT NULL,
  `LIBELLE_NIV` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `niveau`
--

INSERT INTO `niveau` (`NUM_NIV`, `NUM_FORM`, `LIBELLE_NIV`) VALUES
(1, 1, 'ilisi2'),
(2, 1, 'ilisi3');

-- --------------------------------------------------------

--
-- Table structure for table `offredestage`
--

CREATE TABLE `offredestage` (
  `NUM_OFFR` bigint(20) NOT NULL,
  `NUM_NIV` bigint(20) NOT NULL,
  `NUM_ENT` bigint(20) NOT NULL,
  `POSTE_OFFR` varchar(50) DEFAULT NULL,
  `EFFECTIF_OFFRE` int(11) DEFAULT NULL,
  `DETAILS_OFFR` varchar(2048) DEFAULT NULL,
  `DATEDEB_OFFR` date DEFAULT NULL,
  `DATEFIN_OFFR` date DEFAULT NULL,
  `DURE_OFFR` int(11) DEFAULT NULL,
  `LIEUX_OFFR` varchar(25) DEFAULT NULL,
  `VILLE_OFFR` varchar(25) DEFAULT NULL,
  `ETATPUB_OFFR` varchar(25) DEFAULT NULL,
  `PAYS_OFFR` varchar(25) DEFAULT NULL,
  `SUJET_OFFR` varchar(60) DEFAULT NULL,
  `DELAI_JOFFR` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `offredestage`
--

INSERT INTO `offredestage` (`NUM_OFFR`, `NUM_NIV`, `NUM_ENT`, `POSTE_OFFR`, `EFFECTIF_OFFRE`, `DETAILS_OFFR`, `DATEDEB_OFFR`, `DATEFIN_OFFR`, `DURE_OFFR`, `LIEUX_OFFR`, `VILLE_OFFR`, `ETATPUB_OFFR`, `PAYS_OFFR`, `SUJET_OFFR`, `DELAI_JOFFR`) VALUES
(1, 2, 2, 'front-end dev', 2, '  <p><strong>Salam test test :&nbsp;</strong><img src=\"https://img-19.commentcamarche.net/WNCe54PoGxObY8PCXUxMGQ0Gwss=/480x270/smart/d8c10e7fd21a485c909a5b4c5d99e611/ccmcms-commentcamarche/20456790.jpg\" style=\"font-size: 1rem;\" alt=\"cat\"></p>', '2022-05-01', '2023-06-10', NULL, 'rue zerktouni', 'casa', 'complete', 'maroc', 'developper un app', 4),
(2, 1, 2, 'dfh', 8, 'kdfhgj dgj drhg kdjrgf', '2022-05-11', '2022-05-17', NULL, 'boulvard MV', 'casablanca', 'complete', 'Maroc', '', 12),
(3, 2, 3, 'Back-end Dev', 2, 'developper une rest Api pour la gestion des offfres\r\nremote\r\nembauché\r\n', '2022-08-06', '2022-10-09', NULL, 'Esch-sur-Alzette', 'Lixemburg', 'nouveau', 'Suéde', NULL, 6),
(11, 1, 2, 'dfbun', 13, 'lmmd fbnojn dioriugh doin fr', '2022-05-03', '2022-05-16', NULL, NULL, 'lmvdo', 'nouveau', 'maroc', NULL, 12);

-- --------------------------------------------------------

--
-- Table structure for table `postuler`
--

CREATE TABLE `postuler` (
  `NUM_OFFR` bigint(20) NOT NULL,
  `CNE_ETU` varchar(11) NOT NULL,
  `DATE_POST` date DEFAULT NULL,
  `ETATS_POST` varchar(15) DEFAULT NULL,
  `date_reponse` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `postuler`
--

INSERT INTO `postuler` (`NUM_OFFR`, `CNE_ETU`, `DATE_POST`, `ETATS_POST`, `date_reponse`) VALUES
(1, '2019000004', '2022-06-09', 'ACCEPTER', '2022-06-07'),
(3, '2019000004', '2022-06-09', 'ANNULER', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rapport`
--

CREATE TABLE `rapport` (
  `NUM_RAP` bigint(20) NOT NULL,
  `NUM_STG` bigint(20) NOT NULL,
  `INTITULE_RAP` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `responsable`
--

CREATE TABLE `responsable` (
  `NUM_ENS` bigint(20) NOT NULL,
  `NUM_FORM` bigint(20) NOT NULL,
  `USERNAME_RES` varchar(50) DEFAULT NULL,
  `MOTDEPASSE_RES` varchar(70) DEFAULT NULL,
  `IMAGE_RESP` varchar(256) DEFAULT NULL,
  `DATE_NOM_RES` date DEFAULT NULL,
  `ACTIVE_RES` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `responsable`
--

INSERT INTO `responsable` (`NUM_ENS`, `NUM_FORM`, `USERNAME_RES`, `MOTDEPASSE_RES`, `IMAGE_RESP`, `DATE_NOM_RES`, `ACTIVE_RES`) VALUES
(1, 1, 'beggar', '$2y$10$3iqMzcbMhM3sHdSzD1q4wesTI019dWyMAbzZ3sONBBQ57zzMJN3ym', '../ressources/ResposablesPhoto/beggar_Respo.png', '2020-05-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stage`
--

CREATE TABLE `stage` (
  `NUM_STG` bigint(20) NOT NULL,
  `NUM_RAP` bigint(20) DEFAULT NULL,
  `NUM_OFFR` bigint(20) NOT NULL,
  `CNE_ETU` varchar(11) NOT NULL,
  `DATEDEB_STG` date DEFAULT NULL,
  `DATEFIN_STG` date DEFAULT NULL,
  `CONTRAT_STG` varchar(1028) DEFAULT NULL,
  `NOTE_ENEX` float DEFAULT NULL,
  `SUJET_STG` varchar(60) DEFAULT NULL,
  `ACTIVE_STG` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stage`
--

INSERT INTO `stage` (`NUM_STG`, `NUM_RAP`, `NUM_OFFR`, `CNE_ETU`, `DATEDEB_STG`, `DATEFIN_STG`, `CONTRAT_STG`, `NOTE_ENEX`, `SUJET_STG`, `ACTIVE_STG`) VALUES
(0, NULL, 3, '2019000004', '2022-06-08', '2022-09-08', NULL, NULL, 'Developper un api a consommer pour la gestion des stage', 0),
(1, NULL, 1, '2019000004', NULL, NULL, NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`NUM_ADM`);

--
-- Indexes for table `contenirmotrap`
--
ALTER TABLE `contenirmotrap`
  ADD PRIMARY KEY (`NUM_CLE`,`NUM_RAP`),
  ADD KEY `FK_CONTENIRMOTRAP2` (`NUM_RAP`);

--
-- Indexes for table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`NUM_ENS`);

--
-- Indexes for table `enseigner`
--
ALTER TABLE `enseigner`
  ADD PRIMARY KEY (`NUM_ENS`,`NUM_FORM`),
  ADD KEY `FK_ENSEIGNER2` (`NUM_FORM`);

--
-- Indexes for table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`NUM_ENT`);

--
-- Indexes for table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`CNE_ETU`);

--
-- Indexes for table `etudier`
--
ALTER TABLE `etudier`
  ADD PRIMARY KEY (`CNE_ETU`,`NUM_NIV`),
  ADD KEY `FK_ETUDIER2` (`NUM_NIV`);

--
-- Indexes for table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`NUM_FORM`);

--
-- Indexes for table `juger`
--
ALTER TABLE `juger`
  ADD PRIMARY KEY (`NUM_ENS`,`NUM_STG`),
  ADD KEY `FK_JUGER2` (`NUM_STG`);

--
-- Indexes for table `motcle`
--
ALTER TABLE `motcle`
  ADD PRIMARY KEY (`NUM_CLE`);

--
-- Indexes for table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`NUM_NIV`),
  ADD KEY `FK_CONCERNER` (`NUM_FORM`);

--
-- Indexes for table `offredestage`
--
ALTER TABLE `offredestage`
  ADD PRIMARY KEY (`NUM_OFFR`),
  ADD KEY `FK_APPARTENIR` (`NUM_NIV`),
  ADD KEY `FK_OFFRIR` (`NUM_ENT`);

--
-- Indexes for table `postuler`
--
ALTER TABLE `postuler`
  ADD PRIMARY KEY (`NUM_OFFR`,`CNE_ETU`),
  ADD KEY `FK_POSTULER2` (`CNE_ETU`);

--
-- Indexes for table `rapport`
--
ALTER TABLE `rapport`
  ADD PRIMARY KEY (`NUM_RAP`),
  ADD KEY `FK_COMPRENDRE` (`NUM_STG`);

--
-- Indexes for table `responsable`
--
ALTER TABLE `responsable`
  ADD PRIMARY KEY (`NUM_ENS`,`NUM_FORM`),
  ADD KEY `FK_RESPONSABLE2` (`NUM_FORM`);

--
-- Indexes for table `stage`
--
ALTER TABLE `stage`
  ADD PRIMARY KEY (`NUM_STG`),
  ADD KEY `FK_AVOIR` (`NUM_OFFR`),
  ADD KEY `FK_EXERCER` (`CNE_ETU`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contenirmotrap`
--
ALTER TABLE `contenirmotrap`
  ADD CONSTRAINT `FK_CONTENIRMOTRAP` FOREIGN KEY (`NUM_CLE`) REFERENCES `motcle` (`NUM_CLE`),
  ADD CONSTRAINT `FK_CONTENIRMOTRAP2` FOREIGN KEY (`NUM_RAP`) REFERENCES `rapport` (`NUM_RAP`);

--
-- Constraints for table `enseigner`
--
ALTER TABLE `enseigner`
  ADD CONSTRAINT `FK_ENSEIGNER` FOREIGN KEY (`NUM_ENS`) REFERENCES `enseignant` (`NUM_ENS`),
  ADD CONSTRAINT `FK_ENSEIGNER2` FOREIGN KEY (`NUM_FORM`) REFERENCES `formation` (`NUM_FORM`);

--
-- Constraints for table `etudier`
--
ALTER TABLE `etudier`
  ADD CONSTRAINT `FK_ETUDIER` FOREIGN KEY (`CNE_ETU`) REFERENCES `etudiant` (`CNE_ETU`),
  ADD CONSTRAINT `FK_ETUDIER2` FOREIGN KEY (`NUM_NIV`) REFERENCES `niveau` (`NUM_NIV`);

--
-- Constraints for table `juger`
--
ALTER TABLE `juger`
  ADD CONSTRAINT `FK_JUGER` FOREIGN KEY (`NUM_ENS`) REFERENCES `enseignant` (`NUM_ENS`),
  ADD CONSTRAINT `FK_JUGER2` FOREIGN KEY (`NUM_STG`) REFERENCES `stage` (`NUM_STG`);

--
-- Constraints for table `niveau`
--
ALTER TABLE `niveau`
  ADD CONSTRAINT `FK_CONCERNER` FOREIGN KEY (`NUM_FORM`) REFERENCES `formation` (`NUM_FORM`);

--
-- Constraints for table `offredestage`
--
ALTER TABLE `offredestage`
  ADD CONSTRAINT `FK_APPARTENIR` FOREIGN KEY (`NUM_NIV`) REFERENCES `niveau` (`NUM_NIV`),
  ADD CONSTRAINT `FK_OFFRIR` FOREIGN KEY (`NUM_ENT`) REFERENCES `entreprise` (`NUM_ENT`);

--
-- Constraints for table `postuler`
--
ALTER TABLE `postuler`
  ADD CONSTRAINT `FK_POSTULER` FOREIGN KEY (`NUM_OFFR`) REFERENCES `offredestage` (`NUM_OFFR`),
  ADD CONSTRAINT `FK_POSTULER2` FOREIGN KEY (`CNE_ETU`) REFERENCES `etudiant` (`CNE_ETU`);

--
-- Constraints for table `rapport`
--
ALTER TABLE `rapport`
  ADD CONSTRAINT `FK_COMPRENDRE` FOREIGN KEY (`NUM_STG`) REFERENCES `stage` (`NUM_STG`);

--
-- Constraints for table `responsable`
--
ALTER TABLE `responsable`
  ADD CONSTRAINT `FK_RESPONSABLE` FOREIGN KEY (`NUM_ENS`) REFERENCES `enseignant` (`NUM_ENS`),
  ADD CONSTRAINT `FK_RESPONSABLE2` FOREIGN KEY (`NUM_FORM`) REFERENCES `formation` (`NUM_FORM`);

--
-- Constraints for table `stage`
--
ALTER TABLE `stage`
  ADD CONSTRAINT `FK_AVOIR` FOREIGN KEY (`NUM_OFFR`) REFERENCES `offredestage` (`NUM_OFFR`),
  ADD CONSTRAINT `FK_EXERCER` FOREIGN KEY (`CNE_ETU`) REFERENCES `etudiant` (`CNE_ETU`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
