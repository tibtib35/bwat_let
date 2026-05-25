<?php
session_start();
require_once("includes/auth.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");

if (!isset($_SESSION['id_utilisateur']) || !estAdmin()) {
    header('Location: index.php');
    exit;
}

$erreur = '';
$conn = connectionDB();
$genres = getGenres($conn);
$plateformes = getPlateformes($conn);
closeDB($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $synopsis = trim($_POST['synopsis'] ?? '');
    $dateSortie = trim($_POST['dateSortie'] ?? '');
    $duree = (int) ($_POST['duree'] ?? 0);
    $paysOrigine = trim($_POST['paysOrigine'] ?? '');
    $langue = trim($_POST['langue'] ?? '');
    $affiche = trim($_POST['affiche'] ?? '');
    $id_genre = (int) ($_POST['id_genre'] ?? 0);
    $id_plateforme = (int) ($_POST['id_plateforme'] ?? 0);

    $realisateurs_noms = $_POST['real_nom'] ?? [];
    $realisateurs_prenoms = $_POST['real_prenom'] ?? [];
    $acteurs_noms = $_POST['acteur_nom'] ?? [];
    $acteurs_prenoms = $_POST['acteur_prenom'] ?? [];

    if ($titre === '') {
        $erreur = 'Le titre est obligatoire.';
    } elseif ($synopsis === '') {
        $erreur = 'Le synopsis est obligatoire.';
    } elseif ($dateSortie === '') {
        $erreur = 'La date de sortie est obligatoire.';
    } elseif ($duree <= 0) {
        $erreur = 'La durée doit être supérieure à 0.';
    } elseif ($paysOrigine === '') {
        $erreur = 'Le pays d\'origine est obligatoire.';
    } elseif ($langue === '') {
        $erreur = 'La langue est obligatoire.';
    } elseif ($affiche === '') {
        $erreur = 'L\'URL de l\'affiche est obligatoire.';
    } elseif ($id_genre <= 0) {
        $erreur = 'Veuillez sélectionner un genre.';
    } elseif ($id_plateforme <= 0) {
        $erreur = 'Veuillez sélectionner une plateforme.';
    } else {
        $conn    = connectionDB();
        $id_film = creerFilm($conn, $titre, $synopsis, $dateSortie, $duree, $paysOrigine, $langue, $affiche, $id_genre, $id_plateforme);

        if ($id_film > 0) {
            foreach ($realisateurs_noms as $i => $nom) {
                $nom    = trim($nom);
                $prenom = trim($realisateurs_prenoms[$i] ?? '');
                if ($nom !== '' && $prenom !== '') {
                    lierRealisateur($conn, $id_film, $nom, $prenom);
                }
            }
            foreach ($acteurs_noms as $i => $nom) {
                $nom    = trim($nom);
                $prenom = trim($acteurs_prenoms[$i] ?? '');
                if ($nom !== '' && $prenom !== '') {
                    lierActeur($conn, $id_film, $nom, $prenom);
                }
            }
            closeDB($conn);
            header('Location: admin.php?film_cree=1');
            exit;
        } else {
            closeDB($conn);
            $erreur = 'Une erreur est survenue lors de la création du film.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un film - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php include("static/header.php"); ?>

    <main>
        <div class="container">
            <div class="form-page">

                <h2>Ajouter un film</h2>

                <?php if ($erreur !== ''): ?>
                    <p class="alert alert-error"><?php echo htmlspecialchars($erreur); ?></p>
                <?php endif; ?>

                <form method="POST" action="creer_film.php">

                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" id="titre" name="titre"
                               value="<?php echo htmlspecialchars($_POST['titre'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="synopsis">Synopsis</label>
                        <textarea id="synopsis" name="synopsis" rows="5" required><?php echo htmlspecialchars($_POST['synopsis'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="dateSortie">Date de sortie</label>
                            <input type="date" id="dateSortie" name="dateSortie"
                                   value="<?php echo htmlspecialchars($_POST['dateSortie'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="duree">Durée (minutes)</label>
                            <input type="number" id="duree" name="duree" min="1"
                                   value="<?php echo htmlspecialchars($_POST['duree'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="paysOrigine">Pays d'origine</label>
                            <input type="text" id="paysOrigine" name="paysOrigine"
                                   value="<?php echo htmlspecialchars($_POST['paysOrigine'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="langue">Langue originale</label>
                            <input type="text" id="langue" name="langue"
                                   value="<?php echo htmlspecialchars($_POST['langue'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="id_genre">Genre</label>
                            <select id="id_genre" name="id_genre" required>
                                <option value="0">-- Choisir --</option>
                                <?php foreach ($genres as $g): ?>
                                    <option value="<?php echo $g['id_genre']; ?>"
                                        <?php if (isset($_POST['id_genre']) && $_POST['id_genre'] == $g['id_genre']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($g['nomGenre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_plateforme">Plateforme</label>
                            <select id="id_plateforme" name="id_plateforme" required>
                                <option value="0">-- Choisir --</option>
                                <?php foreach ($plateformes as $p): ?>
                                    <option value="<?php echo $p['id_plateforme']; ?>"
                                        <?php if (isset($_POST['id_plateforme']) && $_POST['id_plateforme'] == $p['id_plateforme']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($p['nomPlateforme']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="affiche">URL de l'affiche</label>
                        <input type="text" id="affiche" name="affiche"
                               placeholder="ex : img/mon_film.jpg"
                               value="<?php echo htmlspecialchars($_POST['affiche'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Réalisateur(s)</label>
                        <div id="realisateurs-list">
                            <div class="person-row">
                                <input type="text" name="real_prenom[]" placeholder="Prénom">
                                <input type="text" name="real_nom[]" placeholder="Nom">
                            </div>
                        </div>
                        <button type="button" class="btn-add-person" onclick="ajouterLigne('realisateurs-list', 'real_prenom', 'real_nom')">
                            + Ajouter un réalisateur
                        </button>
                    </div>

                    <div class="form-group">
                        <label>Acteur(s)</label>
                        <div id="acteurs-list">
                            <div class="person-row">
                                <input type="text" name="acteur_prenom[]" placeholder="Prénom">
                                <input type="text" name="acteur_nom[]" placeholder="Nom">
                            </div>
                        </div>
                        <button type="button" class="btn-add-person" onclick="ajouterLigne('acteurs-list', 'acteur_prenom', 'acteur_nom')">
                            + Ajouter un acteur
                        </button>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Créer le film</button>
                        <a href="admin.php" class="btn-login">Annuler</a>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <?php include("static/footer.php"); ?>

    <script>
        function ajouterLigne(containerId, champPrenom, champNom) {
            const container = document.getElementById(containerId);
            const row = document.createElement('div');
            row.className = 'person-row';
            row.innerHTML =
                '<input type="text" name="' + champPrenom + '[]" placeholder="Prénom">' +
                '<input type="text" name="' + champNom + '[]" placeholder="Nom">' +
                '<button type="button" class="btn-remove-person" onclick="this.parentElement.remove()">✕</button>';
            container.appendChild(row);
        }
    </script>
</body>
</html>
