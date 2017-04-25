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
  $query = "SELECT `poi`.Location_name AS 'POI Location',
  `poi`.`POI_city` AS 'City' ,
  `poi`.`POI_state` AS 'State' ,
  `data_point`.`Data_type`,
  AVG(CASE WHEN `data_point`.`Data_type` = 'Mold' THEN `data_point`.`Value` END) AS 'Mold AVG',
  MAX(CASE WHEN `data_point`.`Data_type` = 'Mold' THEN `data_point`.`Value` END) AS 'Mold MAX',
  MIN(CASE WHEN `data_point`.`Data_type` = 'Mold' THEN `data_point`.`Value` END) AS 'Mold MIN',
  AVG(CASE WHEN `data_point`.`Data_type` = 'Air Quality' THEN `data_point`.`Value` END) AS 'AQ AVG',
  MAX(CASE WHEN `data_point`.`Data_type` = 'Air Quality' THEN `data_point`.`Value` END) AS 'AQ MAX',
  MIN(CASE WHEN `data_point`.`Data_type` = 'Air Quality' THEN `data_point`.`Value` END) AS 'AQ MIN',
  COUNT(`data_point`.`POI_name`) AS '#of data points', `poi`.`Flag` AS 'Flagged' FROM `poi` INNER JOIN `data_point` ON `data_point`.`POI_name` = `poi`.`Location_name` GROUP BY `data_point`.`POI_name`";
  $sql = $con->prepare($query);
  $sql->execute();
  $result = $sql->fetchALL(PDO::FETCH_ASSOC);
  $count = $sql->rowCount();
  print json_encode($result);
} catch(PDOException $e) {
  http_response_code(401);
  echo $e->getMessage() . "</br>";
}

?>