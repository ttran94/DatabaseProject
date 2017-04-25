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
  $username = safe_input($data->username, "");
  $password = safe_input($data->password, "");
  $query = "Select * from user WHERE `Username` = :user AND `Password` = :pass";
  $sql = $con->prepare($query);
  $sql->bindParam(':user', $username, PDO::PARAM_STR);
  $sql->bindParam(':pass', $password, PDO::PARAM_STR);
  $sql->execute();
  $result = $sql->fetchALL(PDO::FETCH_ASSOC);
  $count = $sql->rowCount();
  if ($count != 1) {
    $result['message'] = "Your username/password is incorrect";
    http_response_code(401);
  } else {
    if ($result[0]['User_type'] == "city_official") {
      $query = "Select * from `city_official` WHERE `Username` = :user";
      $sql = $con->prepare($query);
      $sql->bindParam(':user', $username, PDO::PARAM_STR);
      $sql->execute();
      $official = $sql->fetchALL(PDO::FETCH_ASSOC);
      $count = $sql->rowCount();
      if ($count >= 1) {
        if ($official[0]["Approved_status"] == NULL) {
          $result['message'] = "This account is still in pending status.";
          http_response_code(401);
        } elseif ($official[0]["Approved_status"] == FALSE) {
          $result['message'] = "This account has been rejected.";
          http_response_code(401);
        }
      } else {
        $result['message'] = "Your username/password is incorrect";
        http_response_code(401);
      }
    }
  }
  print json_encode($result);
} catch (PDOException $e) {
  echo $e->getMessage() . "</br>";
}

?>