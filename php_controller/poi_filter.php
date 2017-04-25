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
  $location = '';
  $city = '';
  $zipcode = '';
  $state = '';
  $flag = 0;
  $from = '';
  $to = '';

  $query = "Select * from `poi` ";
  if ($data->location) {
    if ($i == 0) {
      $query .= "WHERE";
      $i++;
    }
    $location = safe_input($data->location,"");
    $query .=" `Location_name` = :location";
    $i++;
  }

  if (!empty($data->zipcode)) {
    if ($i == 0) {
      $query .= "WHERE";
      $i++;
    }

    if ($i >= 2) {
      $query .= " AND";
    }

    $zipcode = safe_input($data->zipcode,"");
    $query .=" `Zipcode` = :zipcode";

    $i++;
  }

  if (!empty($data->city)) {
    if ($i == 0) {
      $query .= "WHERE";
      $i++;
    }
    if ($i >= 2) {
      $query .= " AND";
    }
    $city = safe_input($data->city,"");
    $query .=" `POI_city` = :city";
    $i++;
  }

  if (!empty($data->state)) {
    if ($i == 0) {
      $query .= "WHERE";
      $i++;
    }
    if ($i >= 2) {
      $query .= " AND";
    }
    $state = safe_input($data->state,"");
    $query .=" `POI_state` = :state";
    $i++;
  }

  if (!empty($data->flag)) {
    if ($i == 0) {
      $query .= "WHERE";
      $i++;
    }
    if ($i >= 2) {
      $query .= " AND";
    }
    $flag = safe_input($data->flag,"");
    $query .=" `Flag` = :flag";

    $i++;
  }

  if (!empty($data->from)) {
    if ($i == 0) {
      $query .= "WHERE";
      $i++;
    }
    if ($i >= 2) {
      $query .= " AND";
    }
    $from = safe_input($data->from,"");
    $to = safe_input($data->to,"");
    $query .=" `Date_flagged` BETWEEN :from AND :to";

    $i++;
  }
  $sql = $con->prepare($query);
  if (!empty($data->location)) {
    $sql->bindParam(':location', $location, PDO::PARAM_STR);
  }

  if (!empty($data->zipcode)) {
    $sql->bindParam(':zipcode', $zipcode, PDO::PARAM_STR);
  }

  if (!empty($data->city)) {
    $sql->bindParam(':city', $city, PDO::PARAM_STR);
  }

  if (!empty($data->state)) {
    $sql->bindParam(':state', $state, PDO::PARAM_STR);
  }

  if (!empty($data->flag)) {
    $sql->bindParam(':flag', $flag, PDO::PARAM_STR);
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