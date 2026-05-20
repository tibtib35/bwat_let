<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once("includes/constantes.php");
require_once("includes/auth.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");
require_once("php/functions_structure.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Traitement du formulaire d'avis
$erreurAvis = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_utilisateur'])) {
    $titre_avis = trim($_POST['titre_avis'] ?? '');
    $texte_avis = trim($_POST['texte_avis'] ?? '');
    $note_avis  = (int) ($_POST['note'] ?? 0);

    if ($titre_avis === '') {
        $erreurAvis = 'Le titre est obligatoire.';
    } elseif ($texte_avis === '') {
        $erreurAvis = 'Le texte est obligatoire.';
    } elseif ($note_avis < 1 || $note_avis > 5) {
        $erreurAvis = 'La note doit être entre 1 et 5.';
    } else {
        $conn = connectionDB();
        $ok = creerAvis($conn, $id, $_SESSION['id_utilisateur'], $titre_avis, $texte_avis, $note_avis);
        closeDB($conn);
        if ($ok) {
            header('Location: article.php?id=' . $id);
            exit;
        } else {
            $erreurAvis = 'Une erreur est survenue, veuillez réessayer.';
        }
    }
}

$conn = connectionDB();

$article = getArticle($conn, $id) ?? null;

if ($article === null) {
    closeDB($conn);
    header('Location: index.php');
    exit;
}

$avis         = getAvisByArticle($conn, $id);
$stats        = getMoyenneAvis($conn, $id);
$realisateurs = getRealisateursByFilm($conn, $article['id_film']);
$acteurs      = getActeursByFilm($conn, $article['id_film']);

closeDB($conn);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['titreFilm']); ?> - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include("static/header.php"); ?>

    <main>

        <!-- En-tête de l'article : affiche + infos film -->
        <section class="film-header">
            <div class="container">
                <div class="film-header-content">

                    <div class="film-poster-section">
                        <div class="film-poster-large">
                            <img src="<?php echo htmlspecialchars($article['affiche']); ?>"
                                 alt="<?php echo htmlspecialchars($article['titreFilm']); ?>">
                        </div>
                    </div>

                    <div class="film-info-section">
                        <h1><?php echo htmlspecialchars($article['titreFilm']); ?></h1>
                        <p class="film-year">
                            <?php echo date('Y', strtotime($article['dateSortie'])); ?>
                        </p>

                        
                        <div class="film-rating-section">
                            <div class="rating-display">
                                <span class="rating-value">
                                    <?php echo number_format($stats['moyenne'], 1); ?> / 5
                                </span>
                                <span class="rating-count">
                                    (<?php echo $stats['nbAvis']; ?> avis)
                                </span>
                            </div>
                        </div>

                        
                        <div class="film-meta">
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-calendar"></i> Date de sortie</span>
                                <span class="meta-value">
                                    <?php echo date('d/m/Y', strtotime($article['dateSortie'])); ?>
                                </span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-clock"></i> Durée</span>
                                <span class="meta-value">
                                    <?php echo $article['duree']; ?> min
                                </span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-globe"></i> Pays</span>
                                <span class="meta-value">
                                    <?php echo htmlspecialchars($article['paysOrigine']); ?>
                                </span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-masks-theater"></i> Genre</span>
                                <span class="meta-value">
                                    <?php echo htmlspecialchars($article['nomGenre']); ?>
                                </span>
                            </div>

                            <!-- Réalisateurs -->
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-video"></i> Réalisateur(s)</span>
                                <span class="meta-value">
                                    <?php foreach ($realisateurs as $r): ?>
                                        <?php echo htmlspecialchars($r['prenom'] . ' ' . $r['nom']); ?>
                                    <?php endforeach; ?>
                                </span>
                            </div>

                            <!-- Acteurs -->
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-users"></i> Acteurs</span>
                                <span class="meta-value">
                                    <?php foreach ($acteurs as $a): ?>
                                        <?php echo htmlspecialchars($a['prenom'] . ' ' . $a['nom']); ?>
                                    <?php endforeach; ?>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>


        <!-- Contenu de l'article -->
        <section class="film-synopsis">
            <div class="container">
                <h2><?php echo htmlspecialchars($article['titreArticle']); ?></h2>
                <p class="article-meta-info">
                    Par <?php echo htmlspecialchars($article['auteur']); ?>
                    — <?php echo date('d/m/Y', strtotime($article['dateCreation'])); ?>
                </p>
                <p><?php echo nl2br(htmlspecialchars($article['contenu'])); ?></p>
            </div>
        </section>


        <!-- Synopsis du film -->
        <section class="film-synopsis">
            <div class="container">
                <h2>Synopsis</h2>
                <p><?php echo htmlspecialchars($article['synopsis']); ?></p>
            </div>
        </section>


        <!-- Avis des utilisateurs -->
        <section class="film-reviews">
            <div class="container">
                <h2>Avis des utilisateurs</h2>

                <!-- Liste des avis -->
                <div class="reviews-list">
                    <h3><?php echo $stats['nbAvis']; ?> avis</h3>

                    <?php if (empty($avis)): ?>
                        <p>Aucun avis pour le moment.</p>
                    <?php else: ?>
                        <?php foreach ($avis as $a): ?>
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="review-author">
                                        <h4><?php echo htmlspecialchars($a['auteur']); ?></h4>
                                        <span class="review-date">
                                            <i class="fas fa-calendar"></i>
                                            <?php echo date('d/m/Y', strtotime($a['dateCreation'])); ?>
                                        </span>
                                    </div>
                                    <div class="review-rating">
                                        <?php echo $a['note']; ?> étoiles
                                    </div>
                                </div>
                                <h4><?php echo htmlspecialchars($a['titre']); ?></h4>
                                <p class="review-comment"><?php echo htmlspecialchars($a['texte']); ?></p>
                                <?php if (isset($_SESSION['id_utilisateur']) && ($a['id_utilisateur'] == $_SESSION['id_utilisateur'] || estAdmin())): ?>
                                    <div class="review-actions">
                                        <a href="modifier_avis.php?id=<?php echo $a['id_avis']; ?>" class="btn-edit">
                                            <i class="fas fa-pencil-alt"></i> Modifier
                                        </a>
                                        <a href="supprimer_avis.php?id=<?php echo $a['id_avis']; ?>" class="btn-danger-small">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Formulaire pour ajouter un avis -->
                <?php if (isset($_SESSION['id_utilisateur'])): ?>
                    <div class="add-review-card">
                        <h3>Laisser un avis</h3>

                        <?php if ($erreurAvis !== ''): ?>
                            <p class="alert alert-error"><?php echo htmlspecialchars($erreurAvis); ?></p>
                        <?php endif; ?>

                        <form method="POST" action="article.php?id=<?php echo $id; ?>" class="review-form">

                            <div class="form-group">
                                <label for="titre_avis">Titre</label>
                                <input type="text" id="titre_avis" name="titre_avis"
                                       value="<?php echo htmlspecialchars($_POST['titre_avis'] ?? ''); ?>"
                                       placeholder="Résumez votre avis..." required>
                            </div>

                            <div class="form-group">
                                <label for="note">Note</label>
                                <select id="note" name="note" required>
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <option value="<?php echo $i; ?>"
                                            <?php if (isset($_POST['note']) && (int)$_POST['note'] === $i) echo 'selected'; ?>>
                                            <?php echo $i; ?> / 5
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="texte_avis">Votre avis</label>
                                <textarea id="texte_avis" name="texte_avis"
                                          rows="5"
                                          placeholder="Partagez votre opinion..." required></textarea>
                            </div>

                            <button type="submit" class="btn-primary">Publier l'avis</button>

                        </form>
                    </div>
                <?php else: ?>
                    <p style="margin-top: 2rem; color: var(--light-text);">
                        <a href="connection.php" style="color: var(--accent-color);">Connectez-vous</a> pour laisser un avis.
                    </p>
                <?php endif; ?>

            </div>
        </section>

    </main>

    <?php include("static/footer.php"); ?>

</body>

</html>
