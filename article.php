<?php

require_once("includes/constantes.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");
require_once("php/functions_structure.php");

// Récupérer l'ID du film depuis l'URL
$film_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// TODO: Récupérer les informations du film depuis la base de données
// Pour la démo, on utilise des données statiques
$film = [
    'id' => 1,
    'title' => 'Inception',
    'year' => 2010,
    'duration' => '148 minutes',
    'release_date' => '16 juillet 2010',
    'synopsis' => 'Un voleur spécialisé dans l\'extraction d\'informations à partir des rêves est engagé pour accomplir l\'une des plus difficiles tâches : l\'inception, insérer une idée dans l\'esprit d\'une personne. Armé d\'une technologie sophistiquée, Cobb et son équipe pénètrent les différentes couches de rêves des cibles pour accomplir cette mission périlleuse.',
    'rating_average' => 8.5,
    'rating_count' => 245,
    'director' => 'Christopher Nolan',
    'cast' => 'Leonardo DiCaprio, Marion Cotillard, Ellen Page, Joseph Gordon-Levitt',
    'genres' => 'Science-fiction, Thriller, Action',
    'images' => [
        'https://via.placeholder.com/800x400?text=Inception+Scene+1',
        'https://via.placeholder.com/800x400?text=Inception+Scene+2',
        'https://via.placeholder.com/800x400?text=Inception+Scene+3'
    ]
];

// Traiter l'ajout d'un avis
$error = '';
$success = '';
$reviews = [
    [
        'author' => 'Jean Dupont',
        'rating' => 5,
        'date' => '2026-05-15',
        'comment' => 'Un chef-d\'oeuvre du cinéma ! L\'histoire est captivante et les effets spéciaux sont impressionnants.'
    ],
    [
        'author' => 'Marie Bernard',
        'rating' => 4,
        'date' => '2026-05-10',
        'comment' => 'Très bon film, bien que certains passages soient un peu confus.'
    ],
    [
        'author' => 'Pierre Martin',
        'rating' => 5,
        'date' => '2026-05-05',
        'comment' => 'Excellent ! À regarder absolument pour les fans de science-fiction.'
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_review'])) {
    $reviewer_name = trim($_POST['reviewer_name'] ?? '');
    $reviewer_rating = (int)($_POST['reviewer_rating'] ?? 0);
    $reviewer_comment = trim($_POST['reviewer_comment'] ?? '');

    if (empty($reviewer_name)) {
        $error = 'Le nom est requis.';
    } elseif ($reviewer_rating < 1 || $reviewer_rating > 5) {
        $error = 'La note doit être entre 1 et 5.';
    } elseif (empty($reviewer_comment)) {
        $error = 'Le commentaire est requis.';
    } else {
        // TODO: Ajouter l'avis à la base de données
        $success = 'Votre avis a été ajouté avec succès !';
        // Ajouter l'avis à la liste locale pour la démo
        array_unshift($reviews, [
            'author' => htmlspecialchars($reviewer_name),
            'rating' => $reviewer_rating,
            'date' => date('Y-m-d'),
            'comment' => htmlspecialchars($reviewer_comment)
        ]);
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($film['title']); ?> - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include("static/header.php"); ?>
    <?php include("static/nav.php"); ?>

    <main>
        <!-- Film Header Section -->
        <section class="film-header">
            <div class="container">
                <div class="film-header-content">
                    <div class="film-poster-section">
                        <div class="film-poster-large">
                            <img src="https://via.placeholder.com/300x450?text=<?php echo urlencode($film['title']); ?>"
                                alt="<?php echo htmlspecialchars($film['title']); ?>">
                        </div>
                    </div>

                    <div class="film-info-section">
                        <h1><?php echo htmlspecialchars($film['title']); ?></h1>
                        <p class="film-year"><?php echo htmlspecialchars($film['year']); ?></p>

                        <div class="film-rating-section">
                            <div class="rating-display">
                                <span class="rating-value"><?php echo number_format($film['rating_average'], 1); ?></span>
                                <span class="rating-stars">
                                    <?php
                                    $full_stars = floor($film['rating_average']);
                                    $half_star = ($film['rating_average'] - $full_stars) >= 0.5 ? 1 : 0;
                                    for ($i = 0; $i < $full_stars; $i++) echo '★';
                                    if ($half_star) echo '⭐';
                                    ?>
                                </span>
                                <span class="rating-count">(<?php echo $film['rating_count']; ?> avis)</span>
                            </div>
                        </div>

                        <div class="film-meta">
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-calendar"></i> Date de sortie</span>
                                <span class="meta-value"><?php echo htmlspecialchars($film['release_date']); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-clock"></i> Durée</span>
                                <span class="meta-value"><?php echo htmlspecialchars($film['duration']); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-video"></i> Réalisateur</span>
                                <span class="meta-value"><?php echo htmlspecialchars($film['director']); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-masks-theater"></i> Genres</span>
                                <span class="meta-value"><?php echo htmlspecialchars($film['genres']); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-users"></i> Acteurs</span>
                                <span class="meta-value"><?php echo htmlspecialchars($film['cast']); ?></span>
                            </div>
                        </div>

                        <div class="film-actions">
                            <button class="btn-primary"><i class="fas fa-plus"></i> Favoris</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Film Gallery Section -->
        <section class="film-gallery">
            <div class="container">
                <h2>Galerie photos</h2>
                <div class="gallery-grid">
                    <?php foreach ($film['images'] as $index => $image): ?>
                        <div class="gallery-item" onclick="openGalleryModal(<?php echo $index; ?>)">
                            <img src="<?php echo htmlspecialchars($image); ?>"
                                alt="<?php echo htmlspecialchars($film['title']); ?> - Photo <?php echo $index + 1; ?>">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Synopsis Section -->
        <section class="film-synopsis">
            <div class="container">
                <h2>Synopsis</h2>
                <p><?php echo htmlspecialchars($film['synopsis']); ?></p>
            </div>
        </section>

        <!-- Reviews Section -->
        <section class="film-reviews">
            <div class="container">
                <h2>Avis des utilisateurs</h2>

                <!-- Add Review Form -->
                <div class="add-review-card">
                    <h3>Laisser un avis</h3>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="review-form">
                        <div class="form-group">
                            <label for="reviewer_name">Votre nom</label>
                            <input type="text" id="reviewer_name" name="reviewer_name"
                                placeholder="Entrez votre nom"
                                value="<?php echo htmlspecialchars($_POST['reviewer_name'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="reviewer_rating">Note (1-5 étoiles)</label>
                            <div class="rating-input">
                                <input type="radio" id="star5" name="reviewer_rating" value="5" required>
                                <label for="star5" class="star-label">★</label>

                                <input type="radio" id="star4" name="reviewer_rating" value="4">
                                <label for="star4" class="star-label">★</label>

                                <input type="radio" id="star3" name="reviewer_rating" value="3">
                                <label for="star3" class="star-label">★</label>

                                <input type="radio" id="star2" name="reviewer_rating" value="2">
                                <label for="star2" class="star-label">★</label>

                                <input type="radio" id="star1" name="reviewer_rating" value="1">
                                <label for="star1" class="star-label">★</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reviewer_comment">Votre avis</label>
                            <textarea id="reviewer_comment" name="reviewer_comment"
                                placeholder="Partagez votre avis sur ce film..."
                                rows="4" required></textarea>
                        </div>

                        <button type="submit" name="add_review" class="btn-primary">Publier l'avis</button>
                    </form>
                </div>

                <!-- Reviews List -->
                <div class="reviews-list">
                    <h3><?php echo count($reviews); ?> avis</h3>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-author">
                                    <h4><?php echo htmlspecialchars($review['author']); ?></h4>
                                    <span class="review-date">
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('d/m/Y', strtotime($review['date'])); ?>
                                    </span>
                                </div>
                                <div class="review-rating">
                                    <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                        <span class="review-star">★</span>
                                    <?php endfor; ?>
                                    <?php for ($i = $review['rating']; $i < 5; $i++): ?>
                                        <span class="review-star empty">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="review-comment"><?php echo htmlspecialchars($review['comment']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <?php include("static/footer.php"); ?>

    <script>
        function openGalleryModal(index) {
            // TODO: Implémenter un modal de galerie
            console.log('Image ' + index);
        }
    </script>
</body>

</html>
