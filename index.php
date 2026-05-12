<?php



require_once("includes/constantes.php");
require_once("php/functions-DB.php");
require_once("php/functions_query.php");
require_once("php/functions_structure.php");


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmBox - Cataloguez vos films préférés</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include("static/header.php"); ?>
    <?php include("static/nav.php"); ?>

    <main>

        <section class="hero">
            <div class="hero-content">
                <h1>Cataloguez vos films préférés</h1>
                <p>Notez, critiques et suivez les films que vous regardez</p>
                <a href="php/signup.php" class="btn-primary">Commencer gratuitement</a>
            </div>
            <div class="hero-background">
                <div class="gradient-overlay"></div>
            </div>
        </section>


        <section class="recent-articles" id="films">
            <div class="container">
                <h2>Articles Récents</h2>
                <div class="articles-grid">
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <article class="article-card">
                            <div class="article-image">
                                <img src="https://via.placeholder.com/400x250?text=Article+<?php echo $i; ?>"
                                    alt="Article <?php echo $i; ?>">
                                <span class="article-category">Cinéma</span>
                            </div>
                            <div class="article-content">
                                <h3>Titre de l'article <?php echo $i; ?></h3>
                                <div class="article-meta">
                                    <span class="article-date">
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('d M Y', strtotime("-" . (7 - $i) . " days")); ?>
                                    </span>
                                    <span class="article-author">
                                        <i class="fas fa-user"></i>
                                        Auteur <?php echo $i; ?>
                                    </span>
                                </div>
                                <p class="article-excerpt">Découvrez les dernières nouveautés du cinéma, les critiques des
                                    films à l'affiche et bien d'autres contenus passionnants...</p>
                                <a href="#" class="read-more">Lire l'article <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </article>
                    <?php endfor; ?>
                </div>
            </div>
        </section>


        <section class="popular-films" id="populaires">
            <div class="container">
                <h2>Films Populaires</h2>
                <div class="films-grid">
                    <?php for ($i = 1; $i <= 8; $i++): ?>
                        <div class="film-card">
                            <div class="film-poster">
                                <img src="https://via.placeholder.com/200x300?text=Film+<?php echo $i; ?>"
                                    alt="Film <?php echo $i; ?>">
                                <div class="film-overlay">
                                    <div class="film-rating">
                                        <span class="stars">★★★★★</span>
                                    </div>
                                </div>
                            </div>
                            <div class="film-info">
                                <h3>Titre du Film <?php echo $i; ?></h3>
                                <p class="year">2024</p>
                                <div class="user-ratings">
                                    <span class="rating-stars">⭐ 8.5/10</span>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </section>

    </main>
    <?php include("static/footer.php"); ?>

</body>

</html>