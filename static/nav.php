<nav>
    <div class="nav-gauche">
        <a href="index.php">Accueil</a>
        <?php if (isset($_SESSION['nom_dresseur'])): ?>
            <a href="dresseur.php">Mon Pokédex</a>
        <?php endif; ?>
    </div>

    <div class="nav-droite">
        <?php if (isset($_SESSION['nom_dresseur'])): ?>
            <span class="nav-nom"><?php echo htmlspecialchars($_SESSION['nom_dresseur']); ?></span>
            <a href="php/logout.php" class="nav-deconnexion">Déconnexion</a>
        <?php else: ?>
            <a href="connection.php">Connexion</a>
        <?php endif; ?>
    </div>
</nav>
