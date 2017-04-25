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
  $query = "Select City from `city_state`";
  $sql = $con->prepare($query);
  $sql->execute();
  $result = $sql->fetchALL(PDO::FETCH_ASSOC);
  $count = $sql->rowCount();
  print json_encode($result);
} catch(PDOException $e) {
  echo $e->getMessage() . "</br>";
}

?>