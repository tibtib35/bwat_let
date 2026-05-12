# Projet BDD & IHM — CUPGE S4 / ESIR

> **Encadrante :** H. Feuillatre  
> **Rendu :** mai 2025/2026  
> **Technologies :** PHP · MySQL · HTML · CSS (vanilla)

---

## Présentation

Site web de **critique de films**, développé en local avec un serveur Apache + MySQL + PHP (MAMP/WAMP). Le projet combine une partie **base de données** (conception et requêtes SQL) et une partie **interface web** (pages PHP dynamiques).

---

## Fonctionnalités principales

### Articles & Films
- Chaque article est dédié à **un seul film** (et un film peut faire l'objet d'au plus un article).
- Un article contient : titre accrocheur, contenu critique, image(s) ou affiche, date de création, date de dernière modification.
- Un film est représenté par : réalisateur, date de sortie, durée, catégorie(s) (*Action, Comédie, Drame, Horreur, Science-Fiction, etc.*), support(s) (*Cinéma, Netflix, Amazon Prime, etc.*).

### Avis
- Les membres peuvent poster **un seul avis par film** sur chaque article disponible.
- Un avis comprend : titre, texte explicatif, note, date de création.
- Chaque article affiche la **moyenne des notes** données par les utilisateurs.
- Un membre peut **modifier ou supprimer** ses propres avis uniquement.

### Page principale
- Articles triés par **date de création croissante**.
- **Pagination** des articles.
- Recherche par **nom de film** et par **catégorie**.

### Gestion des utilisateurs
| Rôle | Droits |
|------|--------|
| Visiteur | Consulter articles et avis |
| Membre | Visiteur + créer un compte, poster/modifier/supprimer ses avis |
| Rédacteur | Membre + créer et modifier ses propres articles |
| Administrateur | Rédacteur + gérer tous les articles, avis et utilisateurs |

### Profil utilisateur
- Inscription avec : login, mot de passe, adresse, e-mail, date de naissance.
- Page de profil **privée** : modification des informations personnelles, liste de ses avis postés, articles rédigés.
- La date de création du compte et la date de dernière connexion sont visibles sur la page profil.

---

## Structure des pages PHP

Chaque page PHP qui génère du HTML doit respecter la structure suivante :

```
┌─────────────────────────────┐
│ ENTÊTE (header commun)      │  ← index.php
│  Navigation vers les pages  │  ← liens vers toutes les pages du site
├─────────────────────────────┤
│ CONTENU                     │  ← spécifique à chaque page
│ (rendu dans le navigateur)  │
├─────────────────────────────┤
│ PIED DE PAGE (footer)       │  ← prénom, nom, groupe + infos légales
│  sur plusieurs fichiers     │
└─────────────────────────────┘
```

---

## Base de données

- Conception des **schémas conceptuels** avant implémentation.
- Création des tables via **PHPMyAdmin** (`http://localhost/phpmyadmin`).
- Les tables doivent être cohérentes avec le sujet et contenir suffisamment de données pour tester les affichages.
- Des exemples de requêtes SQL doivent figurer dans le rapport.

---

## Design CSS

- Design **cohérent** sur toutes les pages, sobre et non agressif.
- **Aucun framework CSS** (pas de Bootstrap, etc.).
- Chaque règle CSS dans un **fichier externe**.
- Les fichiers CSS sont à définir librement dans le projet.

---

## Lancement en local

1. Démarrer le serveur Apache et MySQL (MAMP/WAMP).
2. Placer le projet dans le répertoire web du serveur (`htdocs`, `C:/wamp/www`, etc.).
3. Accéder au site : `http://localhost/<nom_dossier>/`
4. Accéder à PHPMyAdmin : `http://localhost/phpmyadmin/`
5. Importer ou créer la base de données via PHPMyAdmin.

---

## Ressources

| Ressource | Lien |
|-----------|------|
| MySQL 8.0 | https://dev.mysql.com/doc/refman/8.0/en/ |
| HTML (MDN) | https://developer.mozilla.org/en-US/docs/Web/HTML/Element |
| CSS (MDN) | https://developer.mozilla.org/en-US/docs/Web/CSS/Reference |
| W3Schools | https://www.w3schools.com/ |
| PHP | https://www.php.net/manual/en/ |
| Validateur HTML | https://validator.w3.org/ |
| Validateur CSS | http://www.css-validator.org/validator.html.fr |

---

## Rendu & Soutenance

- **Rendu individuel** : un seul dossier compressé par personne, déposé sur l'ENT (ou via [FileSender Renater](https://filesender.renater.fr) si trop volumineux — déposer un fichier `.txt` contenant le lien de téléchargement).
- Le dossier doit inclure la base de données (export SQL) et le site.
- **Soutenance** : lors de la dernière séance de TP en mai — présentation succincte de la base de données et démonstration du site selon différents scénarios (navigation, création de compte, ajout d'article, etc.).
- Indiquer **nom et prénom** sur le rapport et dans le nom du dossier compressé.

> **Attention :** Toute soumission en retard ou incomplète sera pénalisée (jusqu'à 0). L'entraide est autorisée mais le travail doit être individuel. L'utilisation d'IA doit être mentionnée (CC sur le tableau récapitulatif).
