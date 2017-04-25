<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
//echo json_encode($sessions);
include 'global.php';
include 'Info.php';

try {
  $con = new PDO($dsn, $user, $pass);
  $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  $post =  file_get_contents('php://input');
  $data = json_decode($post);
  $location = safe_input($data->location,"");
  $date = safe_input($data->date,"");
  $type = safe_input($data->type,"");
  $value = safe_input($data->value,"");
  $query = "INSERT INTO `data_point` (`Date_time`, `POI_name`,`Data_type`, `value`) VALUES (:datetime, (SELECT Location_name from poi WHERE `Location_name` = :location), :datatype, :datavalue)";
  $sql = $con->prepare($query);
  $sql->bindParam(':datetime', $date, PDO::PARAM_STR);
  $sql->bindParam(':location', $location, PDO::PARAM_STR);
  $sql->bindParam(':datatype', $type, PDO::PARAM_STR);
  $sql->bindParam(':datavalue', $value, PDO::PARAM_STR);
  if($sql->execute()) {
    $result['message'] = "Your data point has been successfully submit.";
  } else {
    http_response_code(401);
    $result[0]['status'] = "failed";
  }
  print json_encode($result);
} catch(PDOException $e) {
  http_response_code(401);
  echo $e->getMessage() . "</br>";
}

?>