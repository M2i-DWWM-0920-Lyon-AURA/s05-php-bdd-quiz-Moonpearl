<?php

// Initialise l'interface permettant de se connecter à la base de données
$dbh = new PDO('mysql:host=localhost;dbname=php-quiz', 'root', 'root');

// Retient si l'utilisateur vient de valider le formulaire (true)
// ou s'il se connecte sur la page pour la première fois (false)
$formSubmitted = isset($_POST['current-question-id']) && isset($_POST['answer']) && isset($_POST['score']);

// Si l'utilisateur vient de valider le formulaire
if ($formSubmitted) {
  // Récupère les données de la question précédente dans la base de données
  $stmt = $dbh->query('
  SELECT *
  FROM `questions`
  WHERE `id` = ' . $_POST['current-question-id']
  );

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $previousQuestion = $result[0];

  // Retient si la réponse donnée par l'utilisateur est la même que la bonne réponse à la question précédente
  $answeredCorrectly = $_POST['answer'] === $previousQuestion['right_answer'];

  // Récupère le score de la page précédente
  $score = $_POST['score'];

  // Si la réponse donnée par l'utilisateur était correcte
  if ($answeredCorrectly) {
    // Augmente le score de 1
    $score += 1;
  }
// Sinon, si l'utilisateur arrive sur la page de quiz pour la première fois
} else {
  // Initialise le score à zéro
  $score = 0;
}

// Retient la requête permettant d'aller chercher la prochaine question dans la base de données
$sqlQuery = '
SELECT *
FROM `questions`
ORDER BY `rank` ASC
LIMIT 1
';

// Si l'utilisateur vient de valider le formulaire
if ($formSubmitted) {
  // Rajoute une clause à la requête permettant de décaler les résultats
  // afin d'avoir la question suivante
  $sqlQuery .= ' OFFSET ' . $previousQuestion['rank'];
}

$stmt = $dbh->query($sqlQuery);

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si le résultat de la requête est vide, retient que le quiz est terminé
$finished = empty($result);

// Si le quiz est terminé
if ($finished) {
  // Récupère le nombre de questions total dans le quiz
  $stmt = $dbh->query('SELECT COUNT(`id`) FROM `questions`');

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $questionCount = $result[0]['COUNT(`id`)'];
// Sinon
} else {
  // Retient la nouvelle question
  $question = $result[0];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->   
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
  <div class="container">
    <h1>Quizz</h1>

    <!-- Si l'utilisateur vient de valider le formulaire -->
    <?php if ($formSubmitted): ?>
      <!-- Si la réponse donnée par l'utilisateur était correcte -->
      <?php if ($answeredCorrectly): ?>
        <!-- Affiche une alerte de succès -->
        <div id="answer-result" class="alert alert-success">
          <i class="fas fa-thumbs-up"></i> Bravo, c'était la bonne réponse!
        </div>
      <?php else: ?>
        <!-- Affiche une alerte d'erreur -->
        <div id="answer-result" class="alert alert-danger">
          <i class="fas fa-thumbs-down"></i> Hé non! La bonne réponse était <strong>
            <!-- Affiche le texte de la bonne réponse à la question précédente -->
            <?= $previousQuestion['answer' . $previousQuestion['right_answer']] ?>
          </strong>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Si le quiz est terminé -->
    <?php if ($finished): ?>
      <!-- Affiche un message -->
      <p>C'est fini!</p>
      <p>Vous avez atteint le score extraordinaire de <?= $score ?> bonnes réponses sur <?= $questionCount ?>!</p>
    <!-- Sinon -->
    <?php else: ?>
      <!-- Affiche le formulaire contenant la prochaine question -->
      <h2 class="mt-4">Question n°<span id="question-id"><?= $question['rank'] ?></span></h2>
      <form id="question-form" method="post">
        <p id="current-question-text" class="question-text">
          <?= $question['description'] ?>
        </p>
        <div id="answers" class="d-flex flex-column">
          <div class="custom-control custom-radio mb-2">
            <input class="custom-control-input" type="radio" name="answer" id="answer1" value="1">
            <label class="custom-control-label" for="answer1" id="answer1-caption">
              <?= $question['answer1'] ?>
            </label>
          </div>
          <div class="custom-control custom-radio mb-2">
            <input class="custom-control-input" type="radio" name="answer" id="answer2" value="2">
            <label class="custom-control-label" for="answer2" id="answer2-caption">
              <?= $question['answer2'] ?>
            </label>
          </div>
          <div class="custom-control custom-radio mb-2">
            <input class="custom-control-input" type="radio" name="answer" id="answer3" value="3">
            <label class="custom-control-label" for="answer3" id="answer3-caption">
              <?= $question['answer3'] ?>
            </label>
          </div>
          <div class="custom-control custom-radio mb-2">
            <input class="custom-control-input" type="radio" name="answer" id="answer4" value="4">
            <label class="custom-control-label" for="answer4" id="answer4-caption">
              <?= $question['answer4'] ?>
            </label>
          </div>
        </div>
        <input type="hidden" name="current-question-id" value="<?= $question['id'] ?>" />
        <input type="hidden" name="score" value="<?= $score ?>" />
        <button type="submit" class="btn btn-primary">Valider</button>
      </form>
    <?php endif; ?>

  </div>
</body>
</html>