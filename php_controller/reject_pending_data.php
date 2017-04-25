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
  $datetime = array();
  $poi = array();
  $string = '';
  $i = 0;
  foreach ($data->data as $page) {
    if ($i == 0) {
      $string .= "('".$page->Date_time."', '". $page->POI_name . "')";
    } else {
      $string .= ", ('".$page->Date_time."', '". $page->POI_name . "')";
    }
    $i++;
  }
  $query = "UPDATE `data_point` SET `Accept_status`= FALSE WHERE (`Date_time`, `POI_name`) IN (". $string .")";
  $sql = $con->prepare($query);
  if($sql->execute()) {
    $result['message'] = "Successfully Rejected POIs";
  } else {
    http_response_code(401);
    $result['message'] = "Something went wrong while processing your request";
  }
  print json_encode($result);
} catch (PDOException $e) {
  http_response_code(401);
  echo $e->getMessage() . "</br>";
}

?>