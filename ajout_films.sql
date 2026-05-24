-- Ajout de nouveaux films avec vrais synopsis et informations
-- Ces films ne sont liés à aucun article

-- Ajout d'images pour les nouveaux films
INSERT INTO `image` (`id_image`, `chemin`) VALUES
(9, 'img/forrest_gump.jpg'),
(10, 'img/shawshank.jpg'),
(11, 'img/titanic.jpg'),
(12, 'img/la_vita_bella.jpg'),
(13, 'img/matrix.jpg'),
(14, 'img/gladiator.jpg'),
(15, 'img/prestige.jpg'),
(16, 'img/toy_story.jpg'),
(17, 'img/fight_club.jpg'),
(18, 'img/oppenheimer.jpg');

-- Ajout de réalisateurs
INSERT INTO `realisateurs` (`id_real`, `nom`, `prenom`) VALUES
(8, 'Zemeckis', 'Robert'),
(9, 'Darabont', 'Frank'),
(10, 'Cameron', 'James'),
(11, 'Benigni', 'Roberto'),
(12, 'Wachowski', 'Lana'),
(13, 'Scott', 'Ridley'),
(14, 'Nolan', 'Christopher'),
(15, 'Lasseter', 'John'),
(16, 'Fincher', 'David'),
(17, 'Aronofsky', 'Darren'),
(18, 'Nolan', 'Christopher');

-- Ajout d'acteurs
INSERT INTO `acteurs` (`id_acteur`, `nom`, `prenom`) VALUES
(17, 'Hanks', 'Tom'),
(18, 'Freeman', 'Morgan'),
(19, 'Winslet', 'Kate'),
(20, 'Benigni', 'Roberto'),
(21, 'Reeves', 'Keanu'),
(22, 'Fishburne', 'Laurence'),
(23, 'Crowe', 'Russell'),
(24, 'Bardem', 'Javier'),
(25, 'Jackman', 'Hugh'),
(26, 'Pitt', 'Brad'),
(27, 'Norton', 'Edward'),
(28, 'Leto', 'Jared'),
(29, 'Murphy', 'Cillian'),
(30, 'Chalamet', 'Timothée'),
(31, 'Oscar', 'Isaac');

-- Ajout des nouveaux films
INSERT INTO `film` (`id_film`, `titre`, `synopsis`, `dateSortie`, `duree`, `paysOrigine`, `langue`, `affiche`, `id_genre`, `id_plateforme`, `id_image`) VALUES

(9, 'Forrest Gump', 'Forrest Gump, un homme atteint d\'une légère déficience intellectuelle, traverse les décennies de l\'histoire américaine du milieu du XXe siècle en assistant à des événements majeurs et en réussissant dans différents domaines, tout en poursuivant un amour de jeunesse impossible.', '1994-07-06', 142, 'États-Unis', 'Anglais', 'img/affiche_forrest_gump.jpg', 3, 2, 9),

(10, 'The Shawshank Redemption', 'Deux hommes condamnés à perpétuité nouent une amitié indéfectible en prison pendant qu\'ils construisent progressivement une entreprise souterraine. Un récit profond sur l\'espoir, la liberté et la rédemption humaine.', '1994-10-14', 142, 'États-Unis', 'Anglais', 'img/affiche_shawshank.jpg', 3, 3, 10),

(11, 'Titanic', 'Le Titanic sombre dans l\'Atlantique Nord lors de son voyage inaugural en 1912. Au cœur du drame : une histoire d\'amour entre deux passagers de classes sociales différentes qui transcende les conventions de l\'époque.', '1997-12-19', 194, 'États-Unis', 'Anglais', 'img/affiche_titanic.jpg', 8, 2, 11),

(12, 'La Vita è Bella', 'Un père juif utilise l\'humour et l\'imagination pour protéger son fils des horreurs d\'un camp de concentration pendant la Seconde Guerre mondiale. Un film sur le pouvoir de l\'amour et de l\'espoir face à l\'obscurité.', '1997-12-20', 116, 'Italie', 'Italien', 'img/affiche_la_vita_bella.jpg', 2, 4, 12),

(13, 'The Matrix', 'Un hacker découvre que la réalité dans laquelle il vit est une simulation informatique créée par des machines intelligentes. Il rejoint une rébellion pour se libérer et affronter les architectes de ce monde virtuel.', '1999-03-31', 136, 'États-Unis', 'Anglais', 'img/affiche_matrix.jpg', 5, 1, 13),

(14, 'Gladiator', 'Un général romain devient esclave gladiateur après avoir été trahi par le fils tyrannique de l\'empereur. Il doit combattre pour sa survie dans l\'arène et se venger de celui qui a détruit sa vie.', '2000-05-05', 155, 'États-Unis', 'Anglais', 'img/affiche_gladiator.jpg', 1, 1, 14),

(15, 'Le Prestige', 'Deux magiciens rivaux à Londres au XIXe siècle s\'engagent dans une compétition obsessionnelle pour créer le tour de magie parfait. Leurs vies s\'entrelacent dans un jeu de duplicité, de secrets et de trahisons.', '2006-10-20', 130, 'États-Unis', 'Anglais', 'img/affiche_prestige.jpg', 6, 2, 15),

(16, 'Toy Story', 'Woody, un cow-boy jouet, doit s\'adapter à l\'arrivée d\'un nouvel astronaute jouet et ensemble ils doivent échapper à un propriétaire sadique pour revenir auprès de leur enfant adoré.', '1995-11-22', 81, 'États-Unis', 'Anglais', 'img/affiche_toy_story.jpg', 7, 4, 16),

(17, 'Fight Club', 'Un homme insomnique rencontre un vendeur savon charismatique et commence un club de combat souterrain secrets qui évolue en quelque chose de bien plus grand et plus sinistre. Un drame sur l\'identité et la rébellion.', '1999-10-15', 139, 'États-Unis', 'Anglais', 'img/affiche_fight_club.jpg', 6, 3, 17),

(18, 'Oppenheimer', 'Le film raconte la vie du physicien J. Robert Oppenheimer et son rôle dans la création de la bombe atomique lors du Projet Manhattan, explorant les dilemmes moraux et les conséquences de cette découverte scientifique.', '2023-07-21', 180, 'États-Unis', 'Anglais', 'img/affiche_oppenheimer.jpg', 3, 1, 18);

-- Liaison des réalisateurs aux films
INSERT INTO `realise` (`id_film`, `id_real`) VALUES
(9, 8),
(10, 9),
(11, 10),
(12, 11),
(13, 12),
(14, 13),
(15, 14),
(16, 15),
(17, 16),
(18, 18);

-- Liaison des acteurs aux films
INSERT INTO `jouedans` (`id_acteur`, `id_film`) VALUES
(17, 9),
(18, 10),
(19, 11),
(20, 12),
(21, 13),
(22, 13),
(23, 14),
(24, 14),
(25, 15),
(26, 15),
(29, 18),
(27, 17),
(26, 17);
