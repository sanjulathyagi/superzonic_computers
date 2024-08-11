<?php
  session_start();
  include '../../config.php';
  include '../../function.php';
  $db = dbConn();
  $user_id = $_SESSION['USERID'];
  
  extract($_POST);
  
  $sql = "SELECT correct_option FROM questions WHERE id = $question_id";
  $result = $db->query($sql);
  $row = $result->fetch_assoc();
  $is_correct = ($row['correct_option'] == $selected_option) ? 1 : 0;
  
  echo $sql = "INSERT INTO responses (user_id, question_id, selected_option, is_correct) VALUES ('$user_id', '$question_id', '$selected_option', '$is_correct')";
  $db->query($sql);
  
?>