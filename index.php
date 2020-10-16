<?php

$dbh = new PDO('mysql:host=localhost;dbname=php-quiz', 'root', 'root');

$formSubmitted = isset($_POST['current-question-id']) && isset($_POST['answer']);

if ($formSubmitted) {
  $stmt = $dbh->query('
  SELECT *
  FROM `questions`
  WHERE `id` = ' . $_POST['current-question-id']
  );

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $previousQuestion = $result[0];
}

$stmt = $dbh->query('
SELECT *
FROM `questions`
ORDER BY `rank` ASC
LIMIT 1
');

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$question = $result[0];

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

    <?php if ($formSubmitted): ?>
      <?php if ($_POST['answer'] === $previousQuestion['right_answer']): ?>
        <div id="answer-result" class="alert alert-success">
          <i class="fas fa-thumbs-up"></i> Bravo, c'était la bonne réponse!
        </div>
      <?php else: ?>
        <div id="answer-result" class="alert alert-danger">
          <i class="fas fa-thumbs-down"></i> Hé non! La bonne réponse était <strong>
            <?= $previousQuestion['answer' . $previousQuestion['right_answer']] ?>
          </strong>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <h2 class="mt-4">Question n°<span id="question-id">0</span></h2>
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
      <button type="submit" class="btn btn-primary">Valider</button>
    </form>
  </div>
</body>
</html>