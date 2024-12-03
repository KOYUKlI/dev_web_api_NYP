# TP Vikings

## Modalités

Ce TP est à faire par **groupes de 3**.

Les livrables sont à rendre sur MyGES au plus tard à la date de rendu indiquée dans l'espace de rendu sur MyGes. Ces livrables incluent :
- Le code source de votre projet
- Un export de l'environnement Postman de votre projet
- Un export de la base de données de votre projet
- Le lien du repository GitHub de votre projet s'il y en a un
- Une brève explication (sous forme de fichier texte ou dans le README.md) de votre stratégie de travail en équipe (qui a fait quoi, comment vous avez travaillé ensemble, etc.)

## Objectifs


En partant du code source disponible sur le repository GitHub https://github.com/SarahSch19/VikingsAPI, vous devez ajouter de nouvelles fonctionnalités à l'API des vikings.

### Armes

Ajouter une nouvelle table `Weapon` qui aura les propriétés suivantes :
- `id` : int, clé primaire auto-incrémentée
- `type` : string, type de l'arme (ex: "sword", "axe", "bow", "spear", etc.) (obligatoire)
- `damage` : int, dégâts infligés par l'arme (obligatoire)

Ajouter les fonctionnalités CRUD pour les armes :
- `GET /weapon/findOne.php?id=<id>` : retourne l'arme d'id `<id>`
- `GET /weapon/find.php` : retourne toutes les armes avec un système de limite et d'offset
- `PUT /weapon/create.php` : crée une nouvelle arme
- `PATCH /weapon/update.php?id=<id>` : modifie une arme d'id `<id>`
- `DELETE /weapon/delete.php?id=<id>` : supprime une arme d'id `<id>`

### Vikings

Un viking ne peut avoir qu'une seule arme au maximum, mais peut n'en avoir aucune.
- Modifier la table `viking` pour qu'elle ait une arme (clé étrangère `weaponId` vers la table `Weapon`, peut être null).

Ajouter les fonctionnalités CRUD pour les vikings :
- Mettre à jour les fonctionnalités Read du viking (findOne et findAll) pour qu'elles retournent le détail de l'arme du viking si celui-ci en a une. L'arme doit être retournée au format d'un lien vers le détail de l'arme (HATEOAS) si le viking en a une (sinon renvoyer `"weapon": ""`). Exemple :
```JSON
{
  "id": 1,
  "name": "Ragnar",
  "health": 300,
  "attack": 200,
  "defense": 150,
  "weapon": "/weapon/findOne.php?id=3"
}
```
- Mettre à jour la fonctionnalité Create du viking pour qu'il puisse être créé avec une arme par défaut si elle existe. Retourner une erreur appropriée si elle n'existe pas et ne pas créer le viking.
- Mettre à jour la fonctionnalité Update avec PUT pour mettre à jour le viking dans son intégralité. Faire les vérifications appropriées pour mettre à jour l'arme si elle existe, ou la supprimer si elle n'existe pas.
- Créer une nouvelle fonctionnalité Update dans le fichier `api/viking/addWeapon.php` du viking pour lui ajouter une arme si elle existe. Retourner une erreur appropriée si elle n'existe pas et ne pas mettre à jour le viking. Faire les vérifications appropriées pour correspondre aux contraintes d'appel suivantes :
```JSON
PATCH api/viking/addWeapon.php?id=<vikingId>
Body :
{
  "weaponId": 3
}
```
Attention : la nouvelle fonctionnalité d'Update ne doit mettre à jour **que** le champ WeaponId du viking, et ne doit pas mettre à jour les autres champs du viking.

### Bonus

- Dans le cas où une arme est supprimée, mettre à jour les vikings qui la possèdent pour qu'ils n'aient plus d'arme.
- Ajouter une fonctionnalité `GET /viking/findByWeapon.php?id=<weaponId>` qui retourne tous les vikings possédant l'arme d'id `<weaponId>`. Le corps de réponse doit retourner uniquement le nom des vikings et un lien vers leur détail (HATEOAS). Exemple :
```JSON
[
  {
    "name": "Ragnar",
    "link": "/viking/findOne.php?id=1"
  },
  {
    "name": "Lagertha",
    "link": "/viking/findOne.php?id=2"
  }
]
```

---

# Grille de notation

### 1. Respect des livrables (3 points)
| Critère                                           | Détails                                                                                 | Points |
|---------------------------------------------------|-----------------------------------------------------------------------------------------|--------|
| **Code source**                                   | Le code source est complet, correctement structuré, et respectant les consignes.        | 1      |
| **Export Postman**                                | L'environnement Postman est fourni et contient toutes les requêtes nécessaires.         | 0.5    |
| **Export de la base de données**                  | Le fichier SQL d'export est présent et correctement utilisable.                         | 0.5    |
| **README/Explication de la stratégie de travail** | La stratégie de collaboration est expliquée clairement dans un README ou fichier texte. | 1      |


### 2. Table `Weapon` et ses fonctionnalités CRUD (6 points)
| Critère                           | Détails                                                                                 | Points |
|-----------------------------------|-----------------------------------------------------------------------------------------|--------|
| **Création de la table `Weapon`** | La table est correctement ajoutée avec les colonnes demandées (`id`, `type`, `damage`). | 1      |
| **GET /weapon/findOne.php**       | Fonctionnalité correcte pour retourner une arme par ID.                                 | 1      |
| **GET /weapon/find.php**          | Fonctionnalité correcte pour retourner toutes les armes avec limite et offset.          | 1      |
| **PUT /weapon/create.php**        | Création d'une nouvelle arme fonctionnelle avec validation des entrées.                 | 1      |
| **PATCH /weapon/update.php**      | Mise à jour d'une arme fonctionnelle avec validation des entrées.                       | 1      |
| **DELETE /weapon/delete.php**     | Suppression d'une arme fonctionnelle.                                                   | 1      |


### 3. Mise à jour de la table `Viking` et ses fonctionnalités (10 points)
| Critère                                           | Détails                                                                                                          | Points |
|---------------------------------------------------|------------------------------------------------------------------------------------------------------------------|--------|
| **Modification de la table `viking`**             | Ajout d'une clé étrangère `weaponId` (nullable) dans la table.                                                   | 1      |
| **GET /viking/findOne**                           | Retourne les détails d’un viking avec lien HATEOAS vers son arme.                                                | 1      |
| **GET /viking/findAll**                           | Retourne tous les vikings avec leurs armes sous forme de lien HATEOAS.                                           | 1      |
| **PUT /viking/create.php**                        | Création d’un viking avec une arme par défaut si elle existe. Gère les erreurs si l’arme n'existe pas.           | 2      |
| **PUT /viking/update.php**                        | Mise à jour d’un viking avec une arme par défaut si elle existe. Gère les erreurs si l’arme n'existe pas.        | 2      |
| **PATCH /viking/addWeapon.php**                   | Ajout d'une arme à un viking avec validation des contraintes (arme existante, mise à jour de l'arme uniquement). | 2      |
| **Validation des entrées et gestion des erreurs** | Erreurs appropriées (ex : arme non existante, contraintes non respectées).                                       | 1      |


### 5. Qualité du code (1 point)
| Critère             | Détails                                                                                                                                | Points |
|---------------------|----------------------------------------------------------------------------------------------------------------------------------------|--------|
| **Qualité du code** | Code bien structuré, respect des standards (noms de fichiers, conventions de code, répartition des fonctionnalités dans les fichiers). | 1      |


### Récapitulatif des points
| Section                                             | Points       |
|-----------------------------------------------------|--------------|
| Respect des livable                                 | 3            |
| Table `Weapon` et fonctionnalités CRUD              | 6            |
| Mise à jour de la table `Viking` et fonctionnalités | 10           |
| Qualité du code                                     | 1            |
| **Total**                                           | **20 (max)** |


---

### Fonctionnalités bonus (3 points)
| Critère                                         | Détails                                                                         | Points |
|-------------------------------------------------|---------------------------------------------------------------------------------|--------|
| **Suppression des armes associées aux vikings** | Lorsqu'une arme est supprimée, tous les vikings associés perdent cette arme.    | 1.5    |
| **GET /viking/findByWeapon.php**                | Retourne tous les vikings avec l'arme demandée sous forme HATEOAS (nom + lien). | 1.5    |


Les points des fonctionnalités bonus seront ajoutés à votre note d'examen finale ou à votre note de QCM.
