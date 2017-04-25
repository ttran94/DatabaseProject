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
  $email = safe_input($data->email, "");
  $userType = safe_input($data->userType, "");
  $city = safe_input($data->city, "");
  $state = safe_input($data->state, "");
  $title = safe_input($data->title, "");

  $query = "SELECT * from `user` WHERE `Username` = :username";
  $sql = $con->prepare($query);
  $sql->bindParam(':username', $username, PDO::PARAM_STR);
  $sql->execute();
  $result = $sql->fetchALL(PDO::FETCH_ASSOC);
  if ($sql->rowCount() >= 1) {
    $result['message'] = "The username you entered is not available";
    http_response_code(409);
    print json_encode($result);
    exit();
  }
  $query = "SELECT * from `user` WHERE `Email` = :email";
  $sql = $con->prepare($query);
  $sql->bindParam(':email', $email, PDO::PARAM_STR);
  $sql->execute();
  $result = $sql->fetchALL(PDO::FETCH_ASSOC);
  if ($sql->rowCount() >= 1) {
    $result['message'] = "The email you entered is not available";
    http_response_code(409);
    print json_encode($result);
    exit();
  }


  $query = "INSERT INTO `user` (`Username`, `Password`, `Email`, `User_type`) VALUES (:username,:password,:email,:userType)";
  $sql = $con->prepare($query);
  $sql->bindParam(':username', $username, PDO::PARAM_STR);
  $sql->bindParam(':password', $password, PDO::PARAM_STR);
  $sql->bindParam(':email', $email, PDO::PARAM_STR);
  $sql->bindParam(':userType', $userType, PDO::PARAM_STR);

  if ($sql->execute()) {
    if ($userType == "city_official") {
      $query = "INSERT INTO `city_official` (`Username`, `Title`, `Official_city`, `Official_state`) VALUES (:username,:title, (SELECT City from `city_state` WHERE `City` = :city),(SELECT State from `city_state` WHERE `State` = :state))";
      $sql = $con->prepare($query);
      $sql->bindParam(':username', $username, PDO::PARAM_STR);
      $sql->bindParam(':title', $title, PDO::PARAM_STR);
      $sql->bindParam(':city', $city, PDO::PARAM_STR);
      $sql->bindParam(':state', $state, PDO::PARAM_STR);
      if ($sql->execute()) {
        $result['city'] = $city;
        $result['state'] = $state;
        $result['message'] = "Your account has been successfully created.";
      } else {
        http_response_code(403);
        $result['error'] = $sql->errorCode();
        $result['message'] = "Something went wrong in the server.";
        exit();
      }
    }
    $result['message'] = "Your account has been successfully created.";
  } else {
    http_response_code(403);
    $result['error'] = $sql->errorCode();
    $result['message'] = "Something went wrong in the server.";
    exit();
  }
  print json_encode($result);

} catch (PDOException $e) {
  echo $e->getMessage() . "</br>";
}

?>