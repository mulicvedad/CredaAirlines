<?php
require "validation.php";
require "DBInfo.php";
function zag() {
    header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
}
function rest_get($request, $data) {

  if(isset($data["city"])){
    $city=preventXSS($data["city"]);
    if(strlen($city)==0){
      print "{ \"message\" :\"No parameter specified\"}";
      exit();
    }
    try {
      $connection = new PDO(DBInfo::DB_CONNECTION_STRING(), DBInfo::$USERNAME,DBInfo::$PASSWORD);
      $connection->exec("set names utf8");

      $tmp=$connection->prepare("select id from city where lower(name)=lower(?) ; ");
      $tmp->bindValue(1, $city);
      $tmp->execute();
      $cityId=$tmp->fetchColumn();

      $sql="select * from flight where from_city=? or to_city=?";
      $stmt=$connection->prepare($sql);
      $stmt->bindValue(1, $cityId);
      $stmt->bindValue(2, $cityId);
      $stmt->execute();
      $data=array();
      $results=$stmt->fetchAll();


      foreach ($results as $flight) {

        $sql="select name from city where id=? or id=?";
        $stmt=$connection->prepare($sql);
        $stmt->bindValue(1, $flight["from_city"], PDO::PARAM_INT);
        $stmt->bindValue(2, $flight["to_city"], PDO::PARAM_INT);
        $stmt->execute();
        $from=$stmt->fetchColumn();
        $to=$stmt->fetchColumn();
         $data[] = array("fromCity" => (string)$from, "toCity" => (string)$to,
         "duration" => $flight["duration"],"cost" => $flight["cost"]);
      }
      print "{ \"flights\": " . json_encode($data) . "}";

    }
    catch(PDOException $e){

    }
  }
 }
function rest_post($request, $data) { }
function rest_delete($request) { }
function rest_put($request, $data) { }
function rest_error($request) { }

$method  = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

switch($method) {
    case 'PUT':
      //  parse_str(file_get_contents('php://input'), $put_vars);
      //  zag(); $data = $put_vars; rest_put($request, $data); break;
    case 'POST':
      //  zag(); $data = $_POST; rest_post($request, $data); break;
    case 'GET':
        zag(); $data = $_GET; rest_get($request, $data); break;
    case 'DELETE':
      //  zag(); rest_delete($request); break;
    default:
        header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
        rest_error($request); break;
}
?>
