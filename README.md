# Exercice 4

__Vous devez réaliser un Blog.__

L’internaute doit pouvoir :
- Afficher les articles par catégorie
- Afficher un article
- Créer un compte
- Commenter un article s’il est connecté

L’administrateur doit pouvoir :
- Créer des catégories et articles
- Modifier des catégories et articles
- Supprimer des catégories et articles
- Désactiver / réactiver des commentaires.

## Entités

Vous aurez besoin des entités suivantes :

### Categorie :
- Titre

### Utilisateur :
- Nom,
- Prénom,
- Email,
- Mot de passe,
- Roles

### Article :
- titre,
- contenu,
- date de création (automatiquement renseigné, ne doit pas apparaitre dans le formulaire),
- état (brouillon, publié)
- date de parution (automatiquement renseigné lorsqu’on publie l’article),
- auteur (relation ManyToOne vers Utilisateur)
- categorie (relation ManyToOne vers Categorie)

### Commentaire :
- Commentaire,
- Date de publication (automatiquement renseigné, ne doit pas apparaitre dans le formulaire),
- Etat (activé par défaut ou désactivé),
- Auteur (relation ManyToOne vers Utilisateur).
- Article (relation ManyToOne vers Article)

## Pages

### Page Accueil :
Affiche les 3 dernières catégories.
Au clic d’une catégorie, on arrive sur sa page.

Si on est connecté comme administrateur, on doit pouvoir :
- Accéder à une page permettant de créer une catégorie,
- Accéder à une page permettant de créer un article.

### Page Catégorie :
Cette page doit afficher :
- Le nom de la catégorie,
- La liste des articles présents dans cette catégorie. Au clic d’un article on arrive sur l’article.

Si on est connecté comme administrateur, on doit pouvoir : - Modifier la catégorie,
- Supprimer la catégorie.

### Page Articles :
Affiche les articles. Au clic d’un article, on arrive sur sa page

### Page Article :
Cette page doit afficher :
- L’article
- La liste des commentaires de l’article.

Si on est connecté comme administrateur, on doit pouvoir :
- Modifier l’article,
- Supprimer l’article,
- Modérer les commentaires.

### Page Commentaires :
Cette page doit afficher :
- Un formulaire permettant d’ajouter un commentaire