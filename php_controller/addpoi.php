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
  $zipcode = safe_input($data->zipcode,"");
  $city = safe_input($data->city,"");
  $state = safe_input($data->state,"");
  $query = "INSERT INTO `poi` (`Location_name`, `Zipcode`,`POI_city`, `POI_state`) VALUES (:location, :zipcode, :city, :state)";
  $sql = $con->prepare($query);
  $sql->bindParam(':location', $location, PDO::PARAM_STR);
  $sql->bindParam(':zipcode', $zipcode, PDO::PARAM_STR);
  $sql->bindParam(':city', $city, PDO::PARAM_STR);
  $sql->bindParam(':state', $state, PDO::PARAM_STR);
  if($sql->execute()) {
    $result['message'] = "Your POI has been successfully submit.";
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