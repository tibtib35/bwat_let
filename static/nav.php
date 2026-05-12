<nav>
    <div class="nav-gauche">
        <a href="index.php">Accueil</a>
    </div>

    <div class="nav-droite">
        <?php if (isset($_SESSION['username'])): ?>
            <span class="nav-nom"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="php/logout.php" class="nav-deconnexion">Déconnexion</a>
        <?php else: ?>
            <a href="connection.php">Connexion</a>
        <?php endif; ?>
    </div>
</nav>
