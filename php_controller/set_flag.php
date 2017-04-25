<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
//echo json_encode($sessions);
include 'global.php';
include 'Info.php';

try {
  $con = new PDO($dsn, $user, $pass);
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $post = file_get_contents('php://input');
  $data = json_decode($post);
  $poi = $data->poi;
  $flag = $data->flag;
  $date = $data->date;
  $query = "UPDATE `poi` SET `Flag`= :flag WHERE `Location_name` = :poi ";
  $sql = $con->prepare($query);
  $sql->bindParam(':poi', $poi, PDO::PARAM_STR);
  $sql->bindParam(':flag', $flag, PDO::PARAM_STR);
  if($sql->execute()) {
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
    if ($flag == '1') {
      $query = "UPDATE `poi` SET `Date_flagged`= :date WHERE `Location_name` = :poi ";
      $sql = $con->prepare($query);
      $sql->bindParam(':poi', $poi, PDO::PARAM_STR);
      $sql->bindParam(':date', $date, PDO::PARAM_STR);
      if($sql->execute()) {
        $result['message'] = "Successfully Updated Flag";
        exit();
      } else {
        http_response_code(401);
        $result['message'] = "Something went wrong while processing your request";
        exit();
      }
    } else if ($flag == '0') {
      $query = "UPDATE `poi` SET `Date_flagged` = NULL WHERE `Location_name` = :poi ";
      $sql = $con->prepare($query);
      $sql->bindParam(':poi', $poi, PDO::PARAM_STR);
      if($sql->execute()) {
        $result['message'] = "Successfully Updated Flag";
        exit();
      } else {
        http_response_code(401);
        $result['message'] = "Something went wrong while processing your request";
        exit();
      }
    }
    $result['message'] = "Successfully Updated Flag";
  } else {
    http_response_code(401);
    $result['message'] = "Something went wrong while processing your request";
  }
  print json_encode($result);
} catch(PDOException $e) {
  echo $e->getMessage() . "</br>";
}

?>