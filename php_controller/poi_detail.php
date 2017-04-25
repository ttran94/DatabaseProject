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
  $i = 0;
  $type = '';
  $poi = '';
  $one = '';
  $two = '';
  $from = '';
  $to = '';

  if (!empty($data->poi)) {
    $poi = safe_input($data->poi,"");
  }

  $query = "Select * from `data_point` WHERE `data_point`.POI_name = :poi AND `Accept_status` = '1'";

  if (!empty($data->type)) {
    $type = safe_input($data->type,"");
    $query .="AND `Data_type` = :type ";
  }

  if (!empty($data->one) || $data->one == "0") {
    $one = safe_input($data->one,"");
    $two = safe_input($data->two,"");
    $query .="AND `Value` BETWEEN :one AND :two ";
  }

  if (!empty($data->from)) {
    $from = safe_input($data->from,"");
    $to = safe_input($data->to,"");
    $query .="AND `Date_time` BETWEEN :from AND :to ";
    $i++;
  }
  $sql = $con->prepare($query);
  $sql->bindParam(':poi', $poi, PDO::PARAM_STR);
  if (!empty($data->type)) {
    $sql->bindParam(':type', $type, PDO::PARAM_STR);
  }

  if (!empty($data->one) || $data->one == "0") {
    $sql->bindParam(':one', $one, PDO::PARAM_STR);
    $sql->bindParam(':two', $two, PDO::PARAM_STR);
  }

  if (!empty($data->from)) {
    $sql->bindParam(':from', $from, PDO::PARAM_STR);
    $sql->bindParam(':to', $to, PDO::PARAM_STR);
  }


  if($sql->execute()) {
    $result['data'] = $sql->fetchALL(PDO::FETCH_ASSOC);
    $result['message'] = "Successfully retrieve POI Data";
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