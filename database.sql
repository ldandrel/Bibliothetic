-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mer 03 Mai 2017 à 15:52
-- Version du serveur :  10.0.30-MariaDB-0+deb8u1
-- Version de PHP :  5.6.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `demo-bibliothetic`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `cover` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `date` date DEFAULT NULL,
  `date_return_planned` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category_id`, `cover`, `available`, `date`, `date_return_planned`) VALUES
(94, 'On m\'avait dit que c\'Ã©tait impossible', 'Jean-Baptiste Rudelle', 5, 'https://images-na.ssl-images-amazon.com/images/I/51IGex2iG4L.jpg', 1, NULL, NULL),
(95, 'Internet : Histoire, enjeux et perspectives critiques', 'Isabelle CompiÃ¨gne', 1, 'https://images-na.ssl-images-amazon.com/images/I/41fwxlCfVBL.jpg', 1, NULL, NULL),
(96, 'Fin de la publicitÃ© ?', 'ValÃ©rie Patrin-LeclÃ¨re, Caroline Marti de Montety, Karine Berthelot-Guiet', 1, 'https://images-na.ssl-images-amazon.com/images/I/41aihEutK7L.jpg', 1, NULL, NULL),
(97, 'Images Interactives', 'Jean Paul Fourmentraux', 1, 'https://images-na.ssl-images-amazon.com/images/I/51XSHBDZ68L.jpg', 1, NULL, NULL),
(98, 'Typographie web', 'Jason Santa Maria', 4, 'https://images-na.ssl-images-amazon.com/images/I/41s5qo50TzL.jpg', 1, NULL, NULL),
(99, 'Metier web designer', 'Mike Monteiro', 4, 'https://images-na.ssl-images-amazon.com/images/I/415KTJPEgBL.jpg', 1, NULL, NULL),
(100, 'Design Ã©motionnel', 'Aarron Walter', 4, 'https://images-na.ssl-images-amazon.com/images/I/41kftZ9jqCL.jpg', 1, NULL, NULL),
(101, 'Ergonomie mobile : design d\'expÃ©rience utilisateur (UX) pour tablettes et smartphones : pour des sites mobiles et efficaces', 'AmÃ©lie Boucher', 4, 'https://images-na.ssl-images-amazon.com/images/I/51YLVdZmy2L.jpg', 1, NULL, NULL),
(102, 'Le responsive design', 'Collectif', 4, 'https://images-na.ssl-images-amazon.com/images/I/51HJZgoU9HL.jpg', 1, NULL, NULL),
(103, 'HTML5 avec CSS3 pour les nuls', 'Ed Tittel, Chris Minnick', 1, 'https://images-na.ssl-images-amazon.com/images/I/51p-5KVeo2L.jpg', 0, NULL, '2017-04-20'),
(104, 'Petite Poucette', 'Michel Serres', 2, 'https://images-na.ssl-images-amazon.com/images/I/51zNKAV0ZbL.jpg', 1, NULL, NULL),
(105, 'La condition numÃ©rique', 'Jean FranÃ§ois Fogel, Bruno Patino', 1, 'https://images-na.ssl-images-amazon.com/images/I/51iEGuHWz1L.jpg', 1, NULL, NULL),
(106, 'TÃ©lÃ©visions ', 'Bruno Patino', 1, 'https://images-na.ssl-images-amazon.com/images/I/417KActengL.jpg', 1, NULL, NULL),
(107, 'Sociologie des mÃ©dias ', 'RÃ©my Rieffel', 1, 'https://images-na.ssl-images-amazon.com/images/I/419OGhxZzEL.jpg', 1, NULL, NULL),
(108, 'Grande Conversion NumÃ©rique', 'Milad Doueihi', 1, 'https://images-na.ssl-images-amazon.com/images/I/61hbWA1hUTL.jpg', 1, NULL, NULL),
(109, 'Sauver les mÃ©dias : Capitalisme, financement participatif et dÃ©mocratie', 'Julia CagÃ©', 1, 'https://images-na.ssl-images-amazon.com/images/I/31dFmfySjUL.jpg', 1, NULL, NULL),
(110, 'La fin de la television', 'Jean-Louis Missika', 1, 'https://images-na.ssl-images-amazon.com/images/I/31xMItLqf0L.jpg', 1, NULL, NULL),
(111, 'Histoire de la sociÃ©tÃ© de l\'information', 'Armand Mattelart', 1, 'https://images-na.ssl-images-amazon.com/images/I/41GKzvN3AJL.jpg', 1, NULL, NULL),
(112, 'Revolution NumÃ©rique, Revolution Culturelle ?', 'Remy Rieffel', 1, 'https://images-na.ssl-images-amazon.com/images/I/51UnotEgy5L.jpg', 1, NULL, NULL),
(113, 'A quoi rÃªvent les algorithmes : Nos vies a  l\'heure des big data', 'Domique Cardon', 1, 'https://images-na.ssl-images-amazon.com/images/I/414QZs7aU1L.jpg', 1, NULL, NULL),
(114, 'Pornotopie ', 'Beatriz Preciado', 1, 'https://images-na.ssl-images-amazon.com/images/I/51TuoBSprJL.jpg', 1, NULL, NULL),
(115, 'Informer n\'est pas communiquer', 'Dominique Wolton', 1, 'https://images-na.ssl-images-amazon.com/images/I/41yEDQaoMHL.jpg', 1, NULL, NULL),
(116, 'Les nuits du bout des ondes', 'Marine Beccarelli', 1, 'https://images-na.ssl-images-amazon.com/images/I/41DMZDafQQL.jpg', 1, NULL, NULL),
(117, 'La vie algorithmique : critique de la raison numÃ©rique', 'Eric Sadin', 1, 'https://images-na.ssl-images-amazon.com/images/I/51fPc0alIbL.jpg', 1, NULL, NULL),
(119, 'Mc Luhan ne rÃ©pond plus : Communiquer c\'est cohabiter', 'Domique Wolton', 1, 'https://images-na.ssl-images-amazon.com/images/I/41X86yH9seL.jpg', 1, NULL, NULL),
(120, '10 Nouvelles Fantastiques ', 'Alain Grousset', 3, 'https://images-na.ssl-images-amazon.com/images/I/51QB83K9PVL.jpg', 1, NULL, NULL),
(121, 'Musicophilia. La Musique, Le Cerveau Et Nous', 'Oliver Sacks', 5, 'https://images-na.ssl-images-amazon.com/images/I/51FXQOnoXfL.jpg', 1, NULL, NULL),
(122, 'Le Petit Prince: le livre du siÃ¨cle ! ', 'Antoine de Saint-Exupery', 3, 'https://images-na.ssl-images-amazon.com/images/I/11WMG6K5HSL.jpg', 1, NULL, NULL),
(123, 'Une Belle Histoire Du Temps ', 'Stephen Hawking', 3, 'https://images-na.ssl-images-amazon.com/images/I/51xnqIAIDPL.jpg', 1, NULL, NULL),
(124, 'Une Breve Histoire Du Temps', 'Stephen Hawking', 3, 'https://images-na.ssl-images-amazon.com/images/I/51RMuOqBUHL.jpg', 1, NULL, NULL),
(125, 'Saga', 'Ton Benacquista', 3, 'https://images-na.ssl-images-amazon.com/images/I/41rMrFabbPL.jpg', 1, NULL, NULL),
(126, 'Le liseur du 6h27 ', 'Jean-Paul Didierlaurent', 3, 'https://images-na.ssl-images-amazon.com/images/I/51KlD%2BfMepL.jpg', 1, NULL, NULL),
(127, 'Le Silence des agneaux', 'Thomas Harris', 3, 'https://images-na.ssl-images-amazon.com/images/I/417CA6ZSzZL.jpg', 1, NULL, NULL),
(128, 'Oh, boy!', 'Marie-Aude Murail', 3, 'https://images-na.ssl-images-amazon.com/images/I/41kwzwve0bL.jpg', 1, NULL, NULL),
(129, 'Autobiographie des objets', 'Franois Bon', 3, 'https://images-na.ssl-images-amazon.com/images/I/51AWQLS5XyL.jpg', 1, NULL, NULL),
(130, 'L\'incolore Tsukuru Tazaki et ses annÃ©es de pÃ¨lerinage', 'Haruki Murakami', 3, 'https://images-na.ssl-images-amazon.com/images/I/51ZkzGS3bFL.jpg', 1, NULL, NULL),
(131, 'L\'homme illustrÃ©', 'Ray Bradbury', 3, 'https://images-na.ssl-images-amazon.com/images/I/41jHbJaQU7L.jpg', 1, NULL, NULL),
(132, 'RhinocÃ©ros ', 'Ionesco Eugene', 3, 'https://images-na.ssl-images-amazon.com/images/I/31hnOOgh79L.jpg', 1, NULL, NULL),
(133, 'L\'assommoir', 'Zola', 3, 'https://images-na.ssl-images-amazon.com/images/I/416E72hWh1L.jpg', 1, NULL, NULL),
(134, 'Madame Bovary ', 'Gustave Flaubert', 3, 'https://images-na.ssl-images-amazon.com/images/I/41xKnFjl3%2BL.jpg', 1, NULL, NULL),
(135, 'Cyrano de Bergerac', 'Edmond Rostand', 3, 'https://images-na.ssl-images-amazon.com/images/I/51A3w4%2BCG0L.jpg', 1, NULL, NULL),
(136, 'Livre de ma mÃ¨re ', 'Albert Cohen', 3, 'https://images-na.ssl-images-amazon.com/images/I/51mWuU83siL.jpg', 1, NULL, NULL),
(137, 'Micromegas: Le Monde comme il va Jeannot et Colin', 'Voltaire', 3, 'https://images-na.ssl-images-amazon.com/images/I/51xz2fYMz8L.jpg', 1, NULL, NULL),
(138, 'Dix petits nÃ¨gres', 'Agatha Christie', 3, 'https://images-na.ssl-images-amazon.com/images/I/41mjr0g4F%2BL.jpg', 1, NULL, NULL),
(139, 'La vie devant soi ', 'Romain Gary', 3, 'https://images-na.ssl-images-amazon.com/images/I/51ngDrrywVL.jpg', 1, NULL, NULL),
(140, 'La SociÃ©tÃ© du spectacle ', 'Guy Debord', 3, 'https://images-na.ssl-images-amazon.com/images/I/51HeefFi%2B8L.jpg', 1, NULL, NULL),
(141, 'Black Boy ', 'Richard Wright', 3, 'https://images-na.ssl-images-amazon.com/images/I/51dNnHNRvSL.jpg', 1, NULL, NULL),
(142, 'Une vie', 'Guy Maupassant', 3, 'https://images-na.ssl-images-amazon.com/images/I/51YVvx3pNsL.jpg', 1, NULL, NULL),
(143, 'Le tour du monde en 80 jours', 'Jules Vernes', 3, 'assets/img/cover_not_available.png', 1, NULL, NULL),
(144, 'Le dernier jour d\'un condamnÃ© ', 'Victor Hugo', 3, 'https://images-na.ssl-images-amazon.com/images/I/511uHo6aafL.jpg', 1, NULL, NULL),
(145, 'Alcools', 'Guillaume Apollinaire', 3, 'https://images-na.ssl-images-amazon.com/images/I/31P%2BOMT9sAL.jpg', 1, NULL, NULL),
(146, 'Welcome to the jungle : le tourisme', 'Inconnu', 4, 'assets/img/cover_not_available.png', 1, NULL, NULL),
(147, 'Voyage au bout de la nuit ', 'Louis-Ferdinand Celine', 3, 'https://images-na.ssl-images-amazon.com/images/I/51SZVmMqQFL.jpg', 1, NULL, NULL),
(148, 'Un long dimanche de fianÃ§ailles ', 'Sebastien Japrisot', 3, 'https://images-na.ssl-images-amazon.com/images/I/51Re%2BUpiPjL.jpg', 1, NULL, NULL),
(149, 'It\'s Not How Good You Are, It\'s How Good You Want to Be.', 'Paul Arden', 5, 'https://images-na.ssl-images-amazon.com/images/I/51wHdfbS0PL.jpg', 1, NULL, NULL),
(150, 'Les Ã¢mes grises', 'Philippe Claudel', 3, 'https://images-na.ssl-images-amazon.com/images/I/41917Y-YFML.jpg', 1, NULL, NULL),
(151, 'Moi, Malala ', 'Malala Yousafzai', 3, 'https://images-na.ssl-images-amazon.com/images/I/51ttZAh6%2BDL.jpg', 1, NULL, NULL),
(152, 'Soie ', 'Alessan Baricco', 3, 'https://images-na.ssl-images-amazon.com/images/I/41f-9wYyexL.jpg', 1, NULL, NULL),
(153, 'Le Seigneur des Anneaux, tome 1 : La CommunautÃ© de l\'Anneau', 'J.R.R. Tolkien', 3, 'https://images-na.ssl-images-amazon.com/images/I/317JHKHWAHL.jpg', 1, NULL, NULL),
(154, 'Le Seigneur des Anneaux, tome 2 : Les Deux Tours', 'J.R.R. Tolkien', 3, 'https://images-na.ssl-images-amazon.com/images/I/510Y2FYAA3L.jpg', 1, NULL, NULL),
(155, 'Le Seigneur des Anneaux, tome 3 : Le Retour du Roi', 'J.R.R. Tolkien', 3, 'https://images-na.ssl-images-amazon.com/images/I/513SPXXWWZL.jpg', 1, NULL, NULL),
(156, 'L\'Ã©cume des jours ', 'Boris Vian', 3, 'https://images-na.ssl-images-amazon.com/images/I/51kANPqj5%2BL.jpg', 1, NULL, NULL),
(157, 'Mille soleils splendides', 'Khaled Hosseini', 3, 'https://images-na.ssl-images-amazon.com/images/I/51K9gIwWvNL.jpg', 1, NULL, NULL),
(158, 'Au-dessus de tout soupÃ§on', 'Declan Hughes', 3, 'https://pictures.abebooks.com/isbn/9782298095449-fr.jpg', 1, NULL, NULL),
(159, 'Les politiques', 'Aristote', 3, 'https://images-na.ssl-images-amazon.com/images/I/51yzcXakVgL.jpg', 1, NULL, NULL),
(160, 'Trouver le mot juste ', 'Paul Rouaix', 5, 'https://images-na.ssl-images-amazon.com/images/I/5128oCAIGvL.jpg', 1, NULL, NULL),
(161, 'Librio: Apprendre a Apprendre', 'AndrÃ© Giordan et JÃ©rÃ´me Saltet', 1, 'https://images-na.ssl-images-amazon.com/images/I/51VPEE%2B5eeL.jpg', 1, NULL, NULL),
(162, 'Discours de la mÃ©thode ', 'Rene Descartes', 2, 'https://images-na.ssl-images-amazon.com/images/I/416Pp-nXf9L.jpg', 1, NULL, NULL),
(163, 'SociÃ©tÃ© de Consommation', 'Professor Jean Baudrillard', 1, 'https://images-na.ssl-images-amazon.com/images/I/51uZVHu1teL.jpg', 1, NULL, NULL),
(164, 'Sens public, NÂ°15-16 : A-t-on enterrÃ© l\'espace public ?', 'Inconnu', 5, 'https://images-na.ssl-images-amazon.com/images/I/41VrbgTvq6L.jpg', 1, NULL, NULL),
(165, 'Sens public, NÂ°15-16 : A-t-on enterrÃ© l\'espace public ?', 'Inconnu', 5, 'https://images-na.ssl-images-amazon.com/images/I/41VrbgTvq6L.jpg', 1, NULL, NULL),
(166, 'Sens public : un monde en noir et blanc', 'Inconnu', 5, 'https://images-na.ssl-images-amazon.com/images/I/51BvjP3R7ZL.jpg', 1, NULL, NULL),
(167, 'Indignez-vous !', 'StÃ©phane Hessel', 2, 'https://images-na.ssl-images-amazon.com/images/I/51srX6Z2-RL.jpg', 1, NULL, NULL),
(168, 'Les quatre accords toltÃ¨ques : La voie de la libertÃ© personnelle', 'Miguel Ruiz', 5, 'https://images-na.ssl-images-amazon.com/images/I/41c4JNBf2lL.jpg', 1, NULL, NULL),
(169, 'La dissemination', 'Jacques Derrida', 2, 'https://images-na.ssl-images-amazon.com/images/I/61J0T2hHwqL.jpg', 1, NULL, NULL),
(170, 'Thermae romae t.1', 'Mari Yamazaki', 3, 'https://images-na.ssl-images-amazon.com/images/I/41C7t1TWYZL.jpg', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Culture numÃ©rique et technologiques'),
(2, 'Sciences humaines '),
(3, 'LittÃ©rature'),
(4, 'Design'),
(5, '404');

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `date_borrow` datetime NOT NULL,
  `date_return` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `history`
--

INSERT INTO `history` (`id`, `user_id`, `book_id`, `date_borrow`, `date_return`) VALUES
(1, 3, 96, '2017-03-20 14:33:48', '2017-03-20 14:35:18'),
(2, 3, 103, '2017-03-20 14:35:21', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `current_book` int(11) DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `current_book`, `state`) VALUES
(3, 'luc.dandrel@hetic.net', 'Luc', 'DANDREL', 103, 1),
(4, 'demo@demo.demo', 'Demo', 'Demo', NULL, 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `current_book` (`current_book`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `current_book` FOREIGN KEY (`current_book`) REFERENCES `books` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
