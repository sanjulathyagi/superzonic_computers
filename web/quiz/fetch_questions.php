<?php
  include '../../function.php';
  $db = dbConn();
  $sql = "SELECT id, question, option1, option2, option3, option4 FROM questions";
  $result = $db->query($sql);
  
  $questions = array();
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $questions[] = $row;
      }
  }
  
  echo json_encode($questions);
?>