# Travaux pratiques - PHP / bases de données

## Travail à réaliser

### 1. Mettre en place la base de données

Créer une base de données avec une table **questions**, et y insérer les questions données en annexe. La table **questions** doit posséder une colonne permettant de déterminer dans quel ordre les questions vont être présentées à l'utilisateur.

<details> 
  <summary>Indice</summary>
  `rank` INT UNSIGNED
</details>

### 2. Récupérer la première question

Ecrire la requête SQL permettant de récupérer la première question, en respectant l'ordre de présentation défini par la propriété évoquée ci-dessus.

<details> 
  <summary>Indice</summary>
  LIMIT 1
</details>

<details> 
  <summary>Indice</summary>
  ORDER BY `rank`
</details>

### 3. Afficher la première question

Etablir la connexion à la base de données dans le fichier **index.php** et exécuter la requête écrite à l'étape précédente. Dynamiser le contenu de la page de quiz afin que celle-ci affiche l'énoncé de la première question, ainsi que les réponses possibles, aux endroits adéquats.

### 4. Traiter la réponse de l'utilisateur

Lorsque le formulaire est validé, une alerte doit s'afficher dans la page indiquant à l'utilisateur si sa réponse était bonne ou non. La première fois que la page est chargée, aucune alerte ne doit s'afficher.

#### Bonus (facultatif)

En cas de mauvaise réponse, l'alerte doit afficher quelle était la réponse attendue.

### 5. Charger la question suivante

A chaque fois que l'utilisateur répond à une question, lorsque la page est rechargée, elle doit afficher la question suivante (toujours en respectant l'ordre de présentation défini dans la base de données).

<details>
  <summary>Indice</summary>
  Utiliser l'**input type="hidden"** ligne 44 pour garder le compte de la question actuelle
</details>

<details>
  <summary>Indice</summary>
  OFFSET 1
</details>

### Bonus (facultatif)

Créer une table **answers** pour contenir les réponses aux questions. Adapter le schéma de la base de données et les requêtes SQL afin que chaque information ne soit stockée qu'une seule fois, à l'endroit adéquat.

## Questions

### Combien de joueurs y a-t-il dans une équipe de football?

1. 5
2. 7
3. **11**
4. 235

### Combien de temps la lumière du soleil met-elle pour nous parvenir?

1. 15 secondes
2. **8 minutes**
3. 2 heures
4. 3 mois

### En 1582, le pape Grégoire XIII a décidé de réformer le calendrier instauré par Jules César. Mais quel était le premier mois du calendrier julien?

1. Janvier
2. Février
3. **Mars**
4. Avril

### Lequel de ces signes du zodiaque n'est pas un signe d'Eau?

1. **Le Verseau**
2. Le Cancer
3. Le Scorpion
4. Les Poissons

### Combien de doigts ai-je dans mon dos?

1. 2
2. 3
3. 4
4. **5, comme tout le monde**
