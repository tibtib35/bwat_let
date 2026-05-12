# Roadmap — Bwat Let

## V1 — Fondations *(débloquer le reste)*

| Dev A | Dev B |
|-------|-------|
| Nettoyer le code Pokédex, fusionner les deux `functions-DB.php` en un seul | Créer la structure HTML/CSS de base : header, nav, footer, `style.css` |
| Adapter `config-bdd.php` et tester la connexion à la BDD | Importer le SQL et peupler la BDD avec des données de test |

> **Point de sync :** les deux ont la même base avant de passer à V2.

---

## V2 — Authentification

| Dev A | Dev B |
|-------|-------|
| `inscription.php` + `login.php` / `logout.php` adaptés aux utilisateurs (plus de dresseurs) | Page d'accueil `index.php` : liste des articles avec pagination |
| Gestion des sessions (`id_utilisateur`, `role`) | Recherche par nom de film et par genre |

---

## V3 — Articles & Films

| Dev A | Dev B |
|-------|-------|
| CRUD articles : créer, modifier, supprimer (rédacteur uniquement) | Page détail d'un article (`article.php`) avec infos film, affiche, moyenne des notes |
| Vérification des droits par rôle | Affichage des réalisateurs et acteurs liés au film |

---

## V4 — Avis & Profils

| Dev A | Dev B |
|-------|-------|
| CRUD avis : poster, modifier, supprimer (un seul avis par membre par article) | Page profil (`profil.php`) : infos personnelles, liste de ses avis et articles |
| Calcul et affichage de la moyenne des notes | Modification des infos personnelles depuis le profil |

---

## V5 — Admin & Finitions

| Dev A | Dev B |
|-------|-------|
| Panel admin : gérer tous les articles, avis et utilisateurs | Validation HTML/CSS, cohérence du design sur toutes les pages |
| Gestion des rôles (promouvoir un membre en rédacteur, etc.) | Tests de tous les scénarios (navigation, inscription, ajout article...) |

---

> **Règle d'or pour éviter les conflits git :** chaque dev travaille sur ses propres fichiers PHP — Dev A sur la logique backend, Dev B sur les pages d'affichage — et on fusionne à chaque fin de version.
