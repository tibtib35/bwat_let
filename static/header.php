<header>
    <div class="container">
        <div class="logo">
            <a href="index.php"><i class="fas fa-film"></i>
                <span>Bwat Let</span></a>

        </div>
        <nav class="nav">
            <ul>
                <?php 
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                if (isset($_SESSION['id_utilisateur']) && isset($_SESSION['id_role']) && $_SESSION['id_role'] >= 2): ?>
                    <li><a href="creer_article.php">Rédiger un article</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="nav-buttons">
            <?php 
            if (isset($_SESSION['id_utilisateur'])): ?>
                <span class="user-welcome">
                    Bienvenue, <strong><?php echo htmlspecialchars($_SESSION['prenom'] ?? 'Utilisateur'); ?></strong>
                </span>
                <a href="profil.php" class="btn-profile">
                    <i class="fas fa-user-circle"></i> Mon profil
                </a>
                <a href="php/logout.php" class="btn-logout">Se déconnecter</a>
            <?php else: ?>
                <a href="connection.php" class="btn-login">Se connecter</a>
                <a href="inscription.php" class="btn-signup">S'inscrire</a>
            <?php endif; ?>
        </div>
    </div>
</header>