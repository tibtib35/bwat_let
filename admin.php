<?php
session_start();
require_once("includes/auth.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");

if (!isset($_SESSION['id_utilisateur']) || !estAdmin()) {
    header('Location: index.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changer_role'])) {
    $id_utilisateur = (int) ($_POST['id_utilisateur'] ?? 0);
    $id_role        = (int) ($_POST['id_role'] ?? 0);

    if ($id_utilisateur > 0 && $id_role > 0) {
        $conn = connectionDB();
        $ok   = changerRole($conn, $id_utilisateur, $id_role);
        closeDB($conn);
        $message = $ok ? 'Rôle mis à jour.' : 'Erreur lors de la mise à jour du rôle.';
    }
}

$conn     = connectionDB();
$users    = getAllUsers($conn);
$articles = getAllArticles($conn);
$avis     = getAllAvis($conn);
$roles    = getRoles($conn);
closeDB($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php include("static/header.php"); ?>

    <main>
        <section class="admin-section">
            <div class="container">

                <h2>Panel Admin</h2>

                <?php if ($message !== ''): ?>
                    <p class="alert alert-success"><?php echo htmlspecialchars($message); ?></p>
                <?php endif; ?>

                <!-- ===== UTILISATEURS ===== -->
                <h3>Utilisateurs (<?php echo count($users); ?>)</h3>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Login</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Inscription</th>
                            <th>Rôle actuel</th>
                            <th>Changer le rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($u['login']); ?></td>
                                <td><?php echo htmlspecialchars($u['prenom'] . ' ' . $u['nom']); ?></td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($u['dateCreation'])); ?></td>
                                <td><?php echo htmlspecialchars($u['nomRole']); ?></td>
                                <td>
                                    <form method="POST" action="admin.php" style="display: flex; gap: 0.4rem; align-items: center;">
                                        <input type="hidden" name="id_utilisateur" value="<?php echo $u['id_utilisateur']; ?>">
                                        <select name="id_role" class="admin-select">
                                            <?php foreach ($roles as $r): ?>
                                                <option value="<?php echo $r['id_role']; ?>"
                                                    <?php if ($r['id_role'] == $u['id_role']) echo 'selected'; ?>>
                                                    <?php echo htmlspecialchars($r['nomRole']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" name="changer_role" class="admin-btn">OK</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- ===== ARTICLES ===== -->
                <h3>Articles (<?php echo count($articles); ?>)</h3>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Film</th>
                            <th>Auteur</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $art): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($art['titreArticle']); ?></td>
                                <td><?php echo htmlspecialchars($art['titreFilm']); ?></td>
                                <td><?php echo htmlspecialchars($art['auteur']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($art['dateCreation'])); ?></td>
                                <td style="display: flex; gap: 0.4rem;">
                                    <a href="article.php?id=<?php echo $art['id_article']; ?>" class="btn-edit">Voir</a>
                                    <a href="modifier_article.php?id=<?php echo $art['id_article']; ?>" class="btn-edit">Modifier</a>
                                    <a href="supprimer_article.php?id=<?php echo $art['id_article']; ?>" class="btn-danger-small">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- ===== AVIS ===== -->
                <h3>Avis (<?php echo count($avis); ?>)</h3>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Article</th>
                            <th>Note</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($avis as $av): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($av['titre']); ?></td>
                                <td><?php echo htmlspecialchars($av['auteur']); ?></td>
                                <td>
                                    <a href="article.php?id=<?php echo $av['id_article']; ?>" style="color: var(--accent);">
                                        <?php echo htmlspecialchars($av['titreArticle']); ?>
                                    </a>
                                </td>
                                <td><?php echo $av['note']; ?>/5</td>
                                <td><?php echo date('d/m/Y', strtotime($av['dateCreation'])); ?></td>
                                <td>
                                    <a href="supprimer_avis.php?id=<?php echo $av['id_avis']; ?>" class="btn-danger-small">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </section>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
