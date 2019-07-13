-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2019 at 01:41 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_specialist`
--

-- --------------------------------------------------------

--
-- Table structure for table `drzavljanstva`
--

CREATE TABLE `drzavljanstva` (
  `d_id` int(11) NOT NULL,
  `d_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `drzavljanstva`
--

INSERT INTO `drzavljanstva` (`d_id`, `d_title`) VALUES
(1, 'Austrija'),
(2, 'Bugarska'),
(3, 'Bosna i Hercegovina'),
(4, 'Cipar'),
(5, 'Češka'),
(6, 'Danska'),
(7, 'Estonija'),
(8, 'Finska'),
(9, 'Francuska'),
(10, 'Grčka'),
(11, 'Hrvatska'),
(12, 'Irska'),
(13, 'Italija'),
(14, 'Latvija'),
(15, 'Litva'),
(16, 'Luksemburg'),
(17, 'Mađarska'),
(18, 'Malta'),
(19, 'Nizozemska'),
(20, 'Njemačka'),
(21, 'Poljska'),
(22, 'Portugal'),
(23, 'Rumunjska'),
(24, 'Slovačka'),
(25, 'Slovenija'),
(26, 'Srbija'),
(27, 'Španjolska'),
(28, 'Švedska'),
(29, 'Ujedinjena Kraljevina');

-- --------------------------------------------------------

--
-- Table structure for table `fakulteti`
--

CREATE TABLE `fakulteti` (
  `fak_id` int(11) NOT NULL,
  `fak_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_mysql561_ci NOT NULL,
  `fak_city` varchar(30) CHARACTER SET utf8 COLLATE utf8_croatian_mysql561_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fakulteti`
--

INSERT INTO `fakulteti` (`fak_id`, `fak_title`, `fak_city`) VALUES
(1, 'Akademija likovnih umjetnosti', 'Sarajevo'),
(2, 'Akademija scenskih umjetnosti', 'Sarajevo'),
(3, 'Arhitektonski fakultet', 'Sarajevo'),
(4, 'Ekonomski fakultet', 'Sarajevo'),
(5, 'Elektrotehnički fakultet', 'Sarajevo'),
(6, 'Fakultet Islamskih nauka', 'Sarajevo'),
(7, 'Fakultet kriminalistiku, kriminologiju i sigurnosne studije', 'Sarajevo'),
(8, 'Fakultet političkih nauka', 'Sarajevo'),
(9, 'Fakultet sporta i tjelesnog odgoja', 'Sarajevo'),
(10, 'Fakultet za saobraćaj i komunikacije', 'Sarajevo'),
(11, 'Farmaceutski fakultet', 'Sarajevo'),
(12, 'Filozofski fakultet', 'Sarajevo'),
(13, 'Građevinski fakultet', 'Sarajevo'),
(14, 'Mašinski fakultet', 'Sarajevo'),
(15, 'Medicinski fakultet', 'Sarajevo'),
(16, 'Muzička akademija', 'Sarajevo'),
(17, 'Pedagoški fakultet', 'Sarajevo'),
(18, 'Poljoprivredno-prehrambeni fakultet', 'Sarajevo'),
(19, 'Poslovna škola', 'Sarajevo'),
(20, 'Pravni fakultet', 'Sarajevo'),
(21, 'Prirodno-matematički fakultet', 'Sarajevo'),
(22, 'Stomatološki fakultet', 'Sarajevo'),
(23, 'Šumarski fakultet', 'Sarajevo'),
(24, 'Veterinarski fakultet', 'Sarajevo'),
(25, 'Fakultet zdravstvenih studija', 'Sarajevo'),
(26, 'Akademija dramskih umjetnosti', 'Tuzla'),
(27, 'Ekonomski fakultet', 'Tuzla'),
(28, 'Fakultet za tjelesni odgoj i sport', 'Tuzla'),
(29, 'Filozofski fakultet', 'Tuzla'),
(30, 'Medicinski fakultet', 'Tuzla'),
(31, 'Prirodno-matematički fakultet', 'Tuzla'),
(32, 'Tehnološki fakultet', 'Tuzla'),
(33, 'Edukacijsko-rehabilitacijski fakultet', 'Tuzla'),
(34, 'Fakultet elektrotehnike', 'Tuzla'),
(35, 'Farmaceutski fakultet', 'Tuzla'),
(36, 'Mašinski fakultet', 'Tuzla');

-- --------------------------------------------------------

--
-- Table structure for table `nerez_specijalizacije`
--

CREATE TABLE `nerez_specijalizacije` (
  `spec_id` int(11) NOT NULL,
  `fak_id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `vs_id` int(11) NOT NULL,
  `broj_evid_godina` varchar(50) DEFAULT NULL,
  `ime_prezime` varchar(50) DEFAULT NULL,
  `datum_rodjenja` date DEFAULT NULL,
  `dozvola_broj` varchar(50) DEFAULT NULL,
  `dozvola_datum` date DEFAULT NULL,
  `dozvola_izdato` varchar(50) DEFAULT NULL,
  `fak_broj_diplome` varchar(40) DEFAULT NULL,
  `fak_datum` date DEFAULT NULL,
  `fak_nostro_rjesenje` varchar(50) DEFAULT NULL,
  `fak_nostro_izdato` varchar(50) DEFAULT NULL,
  `sluzbeni_jezik` varchar(50) DEFAULT NULL,
  `izjava_broj` varchar(50) DEFAULT NULL,
  `izjava_datum` date DEFAULT NULL,
  `izjava_izdato` varchar(50) DEFAULT NULL,
  `broj_rjesenja_godina` varchar(50) DEFAULT NULL,
  `datum_poc_staza` date DEFAULT NULL,
  `uplata_prva_rata` varchar(25) DEFAULT NULL,
  `datum_prva_rata` date DEFAULT NULL,
  `broj_rjesenja_datum` varchar(50) DEFAULT NULL,
  `povrat_sredstava` varchar(50) DEFAULT NULL,
  `datum_pres_staza` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_unio` varchar(100) DEFAULT NULL,
  `datum_unosa` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nerez_specijalizacije`
--

INSERT INTO `nerez_specijalizacije` (`spec_id`, `fak_id`, `d_id`, `vs_id`, `broj_evid_godina`, `ime_prezime`, `datum_rodjenja`, `dozvola_broj`, `dozvola_datum`, `dozvola_izdato`, `fak_broj_diplome`, `fak_datum`, `fak_nostro_rjesenje`, `fak_nostro_izdato`, `sluzbeni_jezik`, `izjava_broj`, `izjava_datum`, `izjava_izdato`, `broj_rjesenja_godina`, `datum_poc_staza`, `uplata_prva_rata`, `datum_prva_rata`, `broj_rjesenja_datum`, `povrat_sredstava`, `datum_pres_staza`, `image`, `user_unio`, `datum_unosa`) VALUES
(1, 1, 20, 10, '1/21', 'Eva (Magdalene) Braun', '1948-01-02', '15348633', '1966-01-14', 'UNDEDE', '23435555', '1955-01-08', '2342341234555', 'UNDEDE', 'Hrvatski jezik', '131635431066', '1962-01-14', 'UNDE', '103161321 / 60', '1960-01-13', '', '1970-01-01', '', '', '1970-01-01', 'doctor-1149149_960_720.jpg', 'edis', '2019-01-13 09:12:16');

-- --------------------------------------------------------

--
-- Table structure for table `nerez_subspecijalizacije`
--

CREATE TABLE `nerez_subspecijalizacije` (
  `subspec_id` int(11) NOT NULL,
  `spec_id` int(11) NOT NULL,
  `fak_id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `vs_id` int(11) NOT NULL,
  `broj_evid_godina` varchar(50) DEFAULT NULL,
  `ime_prezime` varchar(50) DEFAULT NULL,
  `datum_rodjenja` date DEFAULT NULL,
  `dozvola_broj` varchar(50) DEFAULT NULL,
  `dozvola_datum` date DEFAULT NULL,
  `dozvola_izdato` varchar(50) DEFAULT NULL,
  `fak_broj_diplome` varchar(40) DEFAULT NULL,
  `fak_datum` date DEFAULT NULL,
  `fak_nostro_rjesenje` varchar(50) DEFAULT NULL,
  `fak_nostro_izdato` varchar(50) DEFAULT NULL,
  `sluzbeni_jezik` varchar(50) DEFAULT NULL,
  `izjava_broj` varchar(50) DEFAULT NULL,
  `izjava_datum` date DEFAULT NULL,
  `izjava_izdato` varchar(50) DEFAULT NULL,
  `broj_rjesenja_godina` varchar(50) DEFAULT NULL,
  `datum_poc_staza` date DEFAULT NULL,
  `uplata_prva_rata` varchar(25) DEFAULT NULL,
  `datum_prva_rata` date DEFAULT NULL,
  `broj_rjesenja_datum` varchar(50) DEFAULT NULL,
  `povrat_sredstava` varchar(50) DEFAULT NULL,
  `datum_pres_staza` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_unio` varchar(100) DEFAULT NULL,
  `datum_unosa` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nerez_subspecijalizacije`
--

INSERT INTO `nerez_subspecijalizacije` (`subspec_id`, `spec_id`, `fak_id`, `d_id`, `vs_id`, `broj_evid_godina`, `ime_prezime`, `datum_rodjenja`, `dozvola_broj`, `dozvola_datum`, `dozvola_izdato`, `fak_broj_diplome`, `fak_datum`, `fak_nostro_rjesenje`, `fak_nostro_izdato`, `sluzbeni_jezik`, `izjava_broj`, `izjava_datum`, `izjava_izdato`, `broj_rjesenja_godina`, `datum_poc_staza`, `uplata_prva_rata`, `datum_prva_rata`, `broj_rjesenja_datum`, `povrat_sredstava`, `datum_pres_staza`, `image`, `user_unio`, `datum_unosa`) VALUES
(2, 1, 9, 6, 10, '1/22', 'Lauri (Stefan) Markannen', '1999-01-15', '31566131444', '2007-01-15', 'UNDA', '31566131416', '2007-01-15', '31566131416', 'UNDA', 'Srpski jezik', '31566131416', '2007-01-15', 'UNDA', '31566131416 / 10', '2007-01-15', '', '1970-01-01', '', '', '1970-01-01', 'Klinika za anesteziju i reanimaciju KCUS foto 1.jpg', 'edis', '2019-01-15 03:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `rez_specijalizacije`
--

CREATE TABLE `rez_specijalizacije` (
  `spec_id` int(11) NOT NULL,
  `fak_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `l_id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `vs_id` int(11) NOT NULL,
  `broj_evid_godina` varchar(50) DEFAULT NULL,
  `ime_prezime` varchar(50) DEFAULT NULL,
  `jmbg` varchar(13) DEFAULT NULL,
  `adresa` varchar(100) DEFAULT NULL,
  `fak_broj_diplome` varchar(40) DEFAULT NULL,
  `fak_datum` date DEFAULT NULL,
  `fak_nostro_rjesenje` varchar(50) DEFAULT NULL,
  `fak_nostro_izdato` varchar(50) DEFAULT NULL,
  `strucni_ispit_mjesto` varchar(50) DEFAULT NULL,
  `strucni_ispit_datum` date DEFAULT NULL,
  `strucni_ispit_broj` varchar(50) DEFAULT NULL,
  `radni_staz_dokaz` varchar(50) DEFAULT NULL,
  `broj_rjesenja_godina` varchar(50) DEFAULT NULL,
  `datum_poc_staza` date DEFAULT NULL,
  `uplata_prva_rata` varchar(25) DEFAULT NULL,
  `datum_prva_rata` date DEFAULT NULL,
  `uplata_druga_rata` varchar(25) DEFAULT NULL,
  `datum_druga_rata` date DEFAULT NULL,
  `broj_rjesenja_datum` varchar(50) DEFAULT NULL,
  `povrat_sredstava` varchar(50) DEFAULT NULL,
  `datum_pres_staza` date DEFAULT NULL,
  `user_unio` varchar(100) DEFAULT NULL,
  `datum_unosa` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rez_specijalizacije`
--

INSERT INTO `rez_specijalizacije` (`spec_id`, `fak_id`, `u_id`, `l_id`, `d_id`, `vs_id`, `broj_evid_godina`, `ime_prezime`, `jmbg`, `adresa`, `fak_broj_diplome`, `fak_datum`, `fak_nostro_rjesenje`, `fak_nostro_izdato`, `strucni_ispit_mjesto`, `strucni_ispit_datum`, `strucni_ispit_broj`, `radni_staz_dokaz`, `broj_rjesenja_godina`, `datum_poc_staza`, `uplata_prva_rata`, `datum_prva_rata`, `uplata_druga_rata`, `datum_druga_rata`, `broj_rjesenja_datum`, `povrat_sredstava`, `datum_pres_staza`, `user_unio`, `datum_unosa`, `image`) VALUES
(8, 5, 5, 1, 3, 10, '1/19', 'edis (adil) veličanin', '0911982120015', 'Travnička 30', '24011985', '2018-12-30', '123', 'UNSA', 'Sarajevo', '2008-05-28', '456', 'CV', '123/19', '2019-01-01', '', '1970-01-01', '', '2018-12-01', NULL, NULL, NULL, 'edis', '2018-12-31 05:25:03', NULL),
(9, 6, 14, 10, 25, 9, '2/19', 'adis (sinan) fazlić', '0911982120013', 'bajvati bb', '24011999', '2005-12-31', '999', 'U N S A', 'Sarajevo, Sarajevo', '2008-02-29', '999', 'C V', '999/19', '2019-01-03', '', '1970-01-01', '', '2018-12-31', NULL, NULL, NULL, 'edis', '2018-12-31 05:43:33', NULL),
(10, 3, 10, 2, 6, 9, '3/19', 'mirza (adil) vmustafić', '0911982120015', 'Travnička 30', '24011985', '2018-12-30', '123', 'UNSA', 'Sarajevo', '2008-05-28', '456', 'CV', '123/19', '2019-01-01', '', '2019-01-01', '', '2018-12-02', NULL, NULL, NULL, 'edis', '2018-12-31 05:21:26', NULL),
(12, 4, 13, 1, 3, 10, '4/19', 'emir (mirza) bavčić', '1234567891239', 'sarajevska bb', '8712/98', '2019-01-07', '1241244123123', 'UNSA', 'Sarajevo', '1970-01-01', '123412974912874', 'Uvjerenje o stažiranju', '123/15', '2019-01-01', '', '1970-01-01', '', '1970-01-01', '', '', '1970-01-01', 'edis', '2019-01-13 08:51:34', ''),
(13, 9, 2, 1, 3, 1, '5/19', 'Ahmed (Esad) Omerčević', '0911982120015', 'Zavidoviaćnska bb', '112018', '2019-01-07', '12345', 'UNSA', 'Sarajevo', '2018-01-07', '98567', 'Diploma', '1001/15', '2015-01-15', '', '1970-01-01', '', '1970-01-01', '', '', '1970-01-01', 'edis', '2019-01-07 04:25:02', 'Screenshot_2.png'),
(15, 12, 12, 1, 3, 9, '8/19', 'aldin (adis) đonko', '0922384768835', 'Bistrik bb', '453513641961321', '2019-01-07', '531651203', 'UNSA', 'Sarajevo', '2019-01-08', '0253034', 'diploma filozofa', '312684310', '2019-01-07', '', '1970-01-01', '', '1970-01-01', '', '', '1970-01-01', 'edis', '2019-01-13 09:14:02', 'computer-1149148_960_720.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rez_subspecijalizacije`
--

CREATE TABLE `rez_subspecijalizacije` (
  `subspec_id` int(11) NOT NULL,
  `spec_id` int(11) NOT NULL,
  `fak_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `l_id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `vs_id` int(11) NOT NULL,
  `broj_evid_godina` varchar(50) DEFAULT NULL,
  `ime_prezime` varchar(50) DEFAULT NULL,
  `jmbg` varchar(13) DEFAULT NULL,
  `adresa` varchar(100) DEFAULT NULL,
  `fak_broj_diplome` varchar(40) DEFAULT NULL,
  `fak_datum` date DEFAULT NULL,
  `fak_nostro_rjesenje` varchar(50) DEFAULT NULL,
  `fak_nostro_izdato` varchar(50) DEFAULT NULL,
  `strucni_ispit_mjesto` varchar(50) DEFAULT NULL,
  `strucni_ispit_datum` date DEFAULT NULL,
  `strucni_ispit_broj` varchar(50) DEFAULT NULL,
  `radni_staz_dokaz` varchar(50) DEFAULT NULL,
  `broj_rjesenja_godina` varchar(50) DEFAULT NULL,
  `datum_poc_staza` date DEFAULT NULL,
  `uplata_prva_rata` varchar(25) DEFAULT NULL,
  `datum_prva_rata` date DEFAULT NULL,
  `uplata_druga_rata` varchar(25) DEFAULT NULL,
  `datum_druga_rata` date DEFAULT NULL,
  `broj_rjesenja_datum` varchar(50) DEFAULT NULL,
  `povrat_sredstava` varchar(50) DEFAULT NULL,
  `datum_pres_staza` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_unio` varchar(100) DEFAULT NULL,
  `datum_unosa` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rez_subspecijalizacije`
--

INSERT INTO `rez_subspecijalizacije` (`subspec_id`, `spec_id`, `fak_id`, `u_id`, `l_id`, `d_id`, `vs_id`, `broj_evid_godina`, `ime_prezime`, `jmbg`, `adresa`, `fak_broj_diplome`, `fak_datum`, `fak_nostro_rjesenje`, `fak_nostro_izdato`, `strucni_ispit_mjesto`, `strucni_ispit_datum`, `strucni_ispit_broj`, `radni_staz_dokaz`, `broj_rjesenja_godina`, `datum_poc_staza`, `uplata_prva_rata`, `datum_prva_rata`, `uplata_druga_rata`, `datum_druga_rata`, `broj_rjesenja_datum`, `povrat_sredstava`, `datum_pres_staza`, `image`, `user_unio`, `datum_unosa`) VALUES
(8, 12, 1, 10, 2, 3, 7, '1/20', 'edis (adil) veličaninovski', '0911982120015', 'Bjelave bb, Sarajevo', '333333333333', '2012-01-07', '235567546', 'UNSA ALU', 'Sarajevo  ALU', '2012-01-08', '2423545', 'Diploma (ovjerena kopija)', '2325234/12', '2013-01-07', '', '1970-01-01', '', '1970-01-01', '', '', '1970-01-01', 'computer-1149148_960_720.jpg', 'edis', '2019-01-13 09:15:39');

-- --------------------------------------------------------

--
-- Table structure for table `strani_jezici`
--

CREATE TABLE `strani_jezici` (
  `l_id` int(11) NOT NULL,
  `l_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `strani_jezici`
--

INSERT INTO `strani_jezici` (`l_id`, `l_title`) VALUES
(1, 'Engleski jezik'),
(2, 'Njemački jezik'),
(3, 'Bosanski jezik'),
(4, 'Hrvatski jezik'),
(5, 'Srpski jezik'),
(6, 'Francuski jezik'),
(7, 'Španski jezik'),
(8, 'Italijanski jezik'),
(9, 'Turski jezik'),
(10, 'Arapski jezik'),
(11, 'Finski jezik'),
(12, 'Švedski jezik'),
(13, 'Norveški jezik'),
(14, 'Danski jezik'),
(15, 'Holandski jezik'),
(16, 'Slovenski jezik'),
(17, 'Albanski jezik'),
(18, 'Japanski jezik'),
(19, 'Kineski jezik');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_mysql561_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`) VALUES
(1, 'edis', 'velicanin.edis@gmail.com', 'edis');

-- --------------------------------------------------------

--
-- Table structure for table `ustanove`
--

CREATE TABLE `ustanove` (
  `u_id` int(11) NOT NULL,
  `u_title` varchar(255) NOT NULL,
  `u_city` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ustanove`
--

INSERT INTO `ustanove` (`u_id`, `u_title`, `u_city`) VALUES
(1, 'Ustanova 1', 'Sarajevo'),
(2, 'Ustanova 2', 'Sarajevo'),
(3, 'Ustanova 3', 'Sarajevo'),
(4, 'Ustanova 4', 'Sarajevo'),
(5, 'Ustanova 44', 'Sarajevo'),
(6, 'Ustanova 5', 'Zenica'),
(7, 'Ustanova 55', 'Zenica'),
(8, 'Ustanova 6', 'Zenica'),
(9, 'Ustanova 66', 'Zenica'),
(10, 'Ustanova 7', 'Zenica'),
(11, 'Ustanova 8', 'Tuzla'),
(12, 'Ustanova 9', 'Tuzla'),
(13, 'Ustanova 10', 'Tuzla'),
(14, 'Ustanova 101', 'Tuzla');

-- --------------------------------------------------------

--
-- Table structure for table `ustanove_staz`
--

CREATE TABLE `ustanove_staz` (
  `us_id` int(11) NOT NULL,
  `spec_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `iznos` varchar(50) DEFAULT NULL,
  `oznaka` varchar(10) DEFAULT NULL,
  `user_unio` varchar(100) DEFAULT NULL,
  `datum_unosa` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ustanove_staz`
--

INSERT INTO `ustanove_staz` (`us_id`, `spec_id`, `u_id`, `iznos`, `oznaka`, `user_unio`, `datum_unosa`) VALUES
(16, 12, 3, '3000', 'RS', 'edis', '2019-01-03 05:41:50'),
(17, 9, 6, '5000', 'RS', 'edis', '2019-01-03 07:54:38'),
(18, 10, 5, '444', 'RS', 'edis', '2019-01-02 09:04:52'),
(20, 10, 10, '7000', 'RS', 'edis', '2019-01-02 15:19:31'),
(21, 10, 9, '6600', 'RS', 'edis', '2019-01-02 15:21:17'),
(28, 9, 3, '3000', 'RS', 'edis', '2019-01-03 07:51:54'),
(35, 8, 11, '8400', 'RSS', 'edis', '2019-01-08 22:15:18'),
(38, 8, 5, '4500', 'RS', 'edis', '2019-01-08 22:15:00'),
(39, 12, 1, '6000', 'RS', 'edis', '2019-01-08 22:09:53');

-- --------------------------------------------------------

--
-- Table structure for table `ustanove_staz_nerez`
--

CREATE TABLE `ustanove_staz_nerez` (
  `us_id` int(11) NOT NULL,
  `spec_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `iznos` varchar(50) DEFAULT NULL,
  `oznaka` varchar(10) DEFAULT NULL,
  `period_staza` varchar(10) DEFAULT NULL,
  `user_unio` varchar(100) DEFAULT NULL,
  `datum_unosa` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ustanove_staz_nerez`
--

INSERT INTO `ustanove_staz_nerez` (`us_id`, `spec_id`, `u_id`, `iznos`, `oznaka`, `period_staza`, `user_unio`, `datum_unosa`) VALUES
(1, 1, 8, '6000', 'NS', '66', 'edis', '2019-01-15 03:46:29'),
(3, 2, 12, '99000', 'NSS', '9', 'edis', '2019-01-15 03:45:12');

-- --------------------------------------------------------

--
-- Table structure for table `ustanove_uplate`
--

CREATE TABLE `ustanove_uplate` (
  `upl_id` int(11) NOT NULL,
  `us_id` int(11) NOT NULL,
  `iznos_uplate` varchar(50) DEFAULT NULL,
  `datum_uplate` date DEFAULT NULL,
  `broj_fakture` varchar(50) DEFAULT NULL,
  `user_unio` varchar(100) DEFAULT NULL,
  `datum_unosa` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ustanove_uplate`
--

INSERT INTO `ustanove_uplate` (`upl_id`, `us_id`, `iznos_uplate`, `datum_uplate`, `broj_fakture`, `user_unio`, `datum_unosa`) VALUES
(14, 16, '1000.00', '2019-01-04', '128/19', 'edis', '2019-01-06 19:05:03'),
(15, 16, '30', '2019-01-04', '129/19', 'edis', '2019-01-03 09:05:08'),
(20, 18, '144', '2019-01-06', '200/18', 'edis', '2019-01-06 22:45:42'),
(22, 35, '1700', '2019-01-09', '4444', 'edis', '2019-01-08 22:03:26');

-- --------------------------------------------------------

--
-- Table structure for table `ustanove_uplate_nerez`
--

CREATE TABLE `ustanove_uplate_nerez` (
  `upl_id` int(11) NOT NULL,
  `us_id` int(11) NOT NULL,
  `iznos_uplate` varchar(50) DEFAULT NULL,
  `datum_uplate` date DEFAULT NULL,
  `broj_fakture` varchar(50) DEFAULT NULL,
  `user_unio` varchar(100) DEFAULT NULL,
  `datum_unosa` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ustanove_uplate_nerez`
--

INSERT INTO `ustanove_uplate_nerez` (`upl_id`, `us_id`, `iznos_uplate`, `datum_uplate`, `broj_fakture`, `user_unio`, `datum_unosa`) VALUES
(2, 1, '400', '2019-01-14', '332367', 'edis', '2019-01-15 04:08:03'),
(3, 3, '5000', '2019-01-15', '111', 'edis', '2019-01-15 04:08:27'),
(5, 3, '2000', '2019-01-16', '112', 'edis', '2019-01-15 04:07:40');

-- --------------------------------------------------------

--
-- Table structure for table `vrste_specijalizacija`
--

CREATE TABLE `vrste_specijalizacija` (
  `vs_id` int(11) NOT NULL,
  `vs_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vrste_specijalizacija`
--

INSERT INTO `vrste_specijalizacija` (`vs_id`, `vs_title`) VALUES
(1, 'Specijalizacija 1'),
(2, 'Specijalizacija 2 '),
(3, 'Specijalizacija 3 '),
(4, 'Specijalizacija 4 '),
(5, 'Specijalizacija 5 '),
(6, 'Specijalizacija 6 '),
(7, 'Specijalizacija 7 '),
(8, 'Specijalizacija 8 '),
(9, 'Specijalizacija 9 '),
(10, 'Specijalizacija 10');

-- --------------------------------------------------------

--
-- Table structure for table `vrste_subspecijalizacija`
--

CREATE TABLE `vrste_subspecijalizacija` (
  `vss_id` int(11) NOT NULL,
  `vss_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vrste_subspecijalizacija`
--

INSERT INTO `vrste_subspecijalizacija` (`vss_id`, `vss_title`) VALUES
(1, 'Subspecijalizacija 1 '),
(2, 'Subspecijalizacija 2 '),
(3, 'Subspecijalizacija 3 '),
(4, 'Subspecijalizacija 4 '),
(5, 'Subspecijalizacija 5 '),
(6, 'Subspecijalizacija 6 '),
(7, 'Subspecijalizacija 7 '),
(8, 'Subspecijalizacija 8 '),
(9, 'Subspecijalizacija 9 '),
(10, 'Subspecijalizacija 10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drzavljanstva`
--
ALTER TABLE `drzavljanstva`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `fakulteti`
--
ALTER TABLE `fakulteti`
  ADD PRIMARY KEY (`fak_id`);

--
-- Indexes for table `nerez_specijalizacije`
--
ALTER TABLE `nerez_specijalizacije`
  ADD PRIMARY KEY (`spec_id`),
  ADD KEY `fak_key` (`fak_id`),
  ADD KEY `d_key` (`d_id`),
  ADD KEY `vs_key` (`vs_id`);

--
-- Indexes for table `nerez_subspecijalizacije`
--
ALTER TABLE `nerez_subspecijalizacije`
  ADD PRIMARY KEY (`subspec_id`),
  ADD KEY `spec_id` (`spec_id`),
  ADD KEY `fak_key` (`fak_id`),
  ADD KEY `d_key` (`d_id`),
  ADD KEY `vs_key` (`vs_id`);

--
-- Indexes for table `rez_specijalizacije`
--
ALTER TABLE `rez_specijalizacije`
  ADD PRIMARY KEY (`spec_id`),
  ADD KEY `fak_key` (`fak_id`),
  ADD KEY `u_key` (`u_id`),
  ADD KEY `l_key` (`l_id`),
  ADD KEY `d_key` (`d_id`),
  ADD KEY `vs_key` (`vs_id`);

--
-- Indexes for table `rez_subspecijalizacije`
--
ALTER TABLE `rez_subspecijalizacije`
  ADD PRIMARY KEY (`subspec_id`),
  ADD KEY `specid_key` (`spec_id`),
  ADD KEY `fak_key` (`fak_id`),
  ADD KEY `u_key` (`u_id`),
  ADD KEY `l_key` (`l_id`),
  ADD KEY `d_key` (`d_id`),
  ADD KEY `vs_key` (`vs_id`);

--
-- Indexes for table `strani_jezici`
--
ALTER TABLE `strani_jezici`
  ADD PRIMARY KEY (`l_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ustanove`
--
ALTER TABLE `ustanove`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `ustanove_staz`
--
ALTER TABLE `ustanove_staz`
  ADD PRIMARY KEY (`us_id`);

--
-- Indexes for table `ustanove_staz_nerez`
--
ALTER TABLE `ustanove_staz_nerez`
  ADD PRIMARY KEY (`us_id`);

--
-- Indexes for table `ustanove_uplate`
--
ALTER TABLE `ustanove_uplate`
  ADD PRIMARY KEY (`upl_id`);

--
-- Indexes for table `ustanove_uplate_nerez`
--
ALTER TABLE `ustanove_uplate_nerez`
  ADD PRIMARY KEY (`upl_id`);

--
-- Indexes for table `vrste_specijalizacija`
--
ALTER TABLE `vrste_specijalizacija`
  ADD PRIMARY KEY (`vs_id`);

--
-- Indexes for table `vrste_subspecijalizacija`
--
ALTER TABLE `vrste_subspecijalizacija`
  ADD PRIMARY KEY (`vss_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drzavljanstva`
--
ALTER TABLE `drzavljanstva`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `fakulteti`
--
ALTER TABLE `fakulteti`
  MODIFY `fak_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `nerez_specijalizacije`
--
ALTER TABLE `nerez_specijalizacije`
  MODIFY `spec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nerez_subspecijalizacije`
--
ALTER TABLE `nerez_subspecijalizacije`
  MODIFY `subspec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rez_specijalizacije`
--
ALTER TABLE `rez_specijalizacije`
  MODIFY `spec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rez_subspecijalizacije`
--
ALTER TABLE `rez_subspecijalizacije`
  MODIFY `subspec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `strani_jezici`
--
ALTER TABLE `strani_jezici`
  MODIFY `l_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ustanove`
--
ALTER TABLE `ustanove`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ustanove_staz`
--
ALTER TABLE `ustanove_staz`
  MODIFY `us_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `ustanove_staz_nerez`
--
ALTER TABLE `ustanove_staz_nerez`
  MODIFY `us_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ustanove_uplate`
--
ALTER TABLE `ustanove_uplate`
  MODIFY `upl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ustanove_uplate_nerez`
--
ALTER TABLE `ustanove_uplate_nerez`
  MODIFY `upl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vrste_specijalizacija`
--
ALTER TABLE `vrste_specijalizacija`
  MODIFY `vs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vrste_subspecijalizacija`
--
ALTER TABLE `vrste_subspecijalizacija`
  MODIFY `vss_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
