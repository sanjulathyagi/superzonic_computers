<?php
session_start();
include '../../function.php';
include '../header.php';
include '../../config.php';
  $db = dbConn();
  $user_id = $_SESSION['USERID'];
  
  //display questions with answers
  $sql = "SELECT q.question, q.option1, q.option2, q.option3, q.option4, q.correct_option, r.selected_option, r.is_correct
          FROM questions q
          INNER JOIN responses r ON q.id = r.question_id  
          WHERE r.user_id = $user_id";
  $result = $db->query($sql);
  
  //store how many correct answers 
  $results = array();
  $correct_answers = 0;
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        //get total correct answer count
          if ($row['is_correct']) {
              $correct_answers++;
          }
          $results[] = $row;
      }
  }
  
  $total_questions = count($results);
  $total_marks = ($total_questions > 0) ? ($correct_answers / $total_questions) * 100 : 0;
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Quiz Results</title>
      <style>
          .correct {
              color: green;
          }
          .selected-correct {
              font-weight: bold;
              color: green;
          }
          .selected-wrong {
              font-weight: bold;
              color: red;
          }
      </style>
  </head>
  <body>
      <h1>Quiz Results</h1>
      <h2>Your Score: <?php echo number_format($total_marks, 2); ?> / 100</h2>
      <div id="results">
          <?php foreach ($results as $result) : ?>
              <div class="question">
                  <p><?php echo $result['question']; ?></p>
                  <ul>
                      <li class="<?php echo ($result['correct_option'] == 1 ? 'correct' : '') . ($result['selected_option'] == 1 ? ($result['is_correct'] ? ' selected-correct' : ' selected-wrong') : ''); ?>">
                          <?php echo $result['option1']; ?>
                      </li>
                      <li class="<?php echo ($result['correct_option'] == 2 ? 'correct' : '') . ($result['selected_option'] == 2 ? ($result['is_correct'] ? ' selected-correct' : ' selected-wrong') : ''); ?>">
                          <?php echo $result['option2']; ?>
                      </li>
                      <li class="<?php echo ($result['correct_option'] == 3 ? 'correct' : '') . ($result['selected_option'] == 3 ? ($result['is_correct'] ? ' selected-correct' : ' selected-wrong') : ''); ?>">
                          <?php echo $result['option3']; ?>
                      </li>
                      <li class="<?php echo ($result['correct_option'] == 4 ? 'correct' : '') . ($result['selected_option'] == 4 ? ($result['is_correct'] ? ' selected-correct' : ' selected-wrong') : ''); ?>">
                          <?php echo $result['option4']; ?>
                      </li>
                  </ul>
              </div>
          <?php endforeach; ?>
      </div>
  </body>
  </html>


  <?php
include '../footer.php';
?>