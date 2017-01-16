<?php
require "DBInfo.php";
require "DBEntity.php";
class Flight extends DBEntity
{
    private static $XML_FILE_PATH="data/xml/flights.xml";
    public $id;
    public $from;
    public $to;
    public $dateTime;
    public $duration;
    public $cost;
    public static $tableName="flight";

    public function __construct($tmpId,$tmpFrom, $tmpTo, $tmpDate, $tmpDuration, $tmpCost)
    {
        $this->id=$tmpId;
        $this->from=$tmpFrom;
        $this->to=$tmpTo;
        $this->dateTime=$tmpDate;
        $this->duration=$tmpDuration;
        $this->cost=$tmpCost;
    }

    public function serialize(){
        $xml=null;
        if(file_exists(Flight::$XML_FILE_PATH)){
            $xml=simplexml_load_file(Flight::$XML_FILE_PATH);
        }
        else{
            $xml=new SimpleXMLElement("<flights></flights>");
        }

        $newFliight=$xml->addChild("flight");

        $newFliight->addChild("from", $this->from);
        $newFliight->addChild("to", $this->to);
        $newFliight->addChild("date", $this->dateTime);
        $newFliight->addChild("duration", $this->duration);
        $newFliight->addChild("cost", $this->cost);

        $xml->asXML(Flight::$XML_FILE_PATH);
    }
    public function saveToDb(){
      try {
        $connection = new PDO(DBInfo::DB_CONNECTION_STRING(), DBInfo::$USERNAME,DBInfo::$PASSWORD);
        $connection->exec("set names utf8");

        $stmt=$connection->prepare("select id from city where name=?");
        $stmt->bindValue(1,$this->from, PDO::PARAM_INT);
        $stmt->execute();
        $fromId=$stmt->fetchColumn();

        $stmt=$connection->prepare("select id from city where name=?");
        $stmt->bindValue(1,$this->to, PDO::PARAM_INT);
        $stmt->execute();
        $toId=$stmt->fetchColumn();

        $stmt=$connection->prepare("insert into ". self::$tableName ." set from_city=:fc,
        to_city=:tc, date=:dt, duration=:dur, cost=:cost ;");
        $stmt->bindValue(":fc",$fromId,PDO::PARAM_INT);
        $stmt->bindValue(":tc",$toId,PDO::PARAM_INT);
        $stmt->bindValue(":dt",$this->dateTime);
        $stmt->bindValue(":dur",$this->duration, PDO::PARAM_INT);
        $stmt->bindValue(":cost",$this->cost, PDO::PARAM_INT);

        if($stmt->execute()){
          return 0;
        }
        else{
          return 3;
        }
      } catch (PDOException $e) {
        die($e->errorInfo());
        return 2;
      }


    }
    public function updateDb(){
      try {
          echo "lp";
        $connection = new PDO(DBInfo::DB_CONNECTION_STRING(), DBInfo::$USERNAME,DBInfo::$PASSWORD);
        $connection->exec("set names utf8");

        $sql="select count(*) from ". self::$tableName ." where id=?";
        $prep=$connection->prepare($sql);
        $prep->bindValue(1, $this->id, PDO::PARAM_INT);
        $prep->execute();

        if($prep->fetchColumn()==0){

          return 2;
        }

        $stmt=$connection->prepare("select id from city where name=?");
        $stmt->bindValue(1,$this->from, PDO::PARAM_INT);
        $stmt->execute();
        $fromId=$stmt->fetchColumn();

        $stmt=$connection->prepare("select id from city where name=?");
        $stmt->bindValue(1,$this->to, PDO::PARAM_INT);
        $stmt->execute();
        $toId=$stmt->fetchColumn();

        $sql="update ". self::$tableName ."  set from_city=:fc,
        to_city=:tc, date=:dt, duration=:dur, cost=:cost where id=:id ;";
        $stmt=$connection->prepare($sql);
        $stmt->bindValue(":fc",$fromId,PDO::PARAM_INT);
        $stmt->bindValue(":tc",$toId,PDO::PARAM_INT);
        $stmt->bindValue(":dt",$this->dateTime);
        $stmt->bindValue(":dur",$this->duration, PDO::PARAM_INT);
        $stmt->bindValue(":cost",$this->cost, PDO::PARAM_INT);
        $stmt->bindValue(":id",$this->id, PDO::PARAM_INT);

        $stmt->execute();

        return 0;
      } catch (PDOException $e) {
        die($e->errorInfo());
        return 3;
      }
    }
    public function deleteFromDb(){
      try {
        $connection = new PDO(DBInfo::DB_CONNECTION_STRING(), DBInfo::$USERNAME,DBInfo::$PASSWORD);
        $connection->exec("set names utf8");

        $sql="select count(*) from ". self::$tableName ." where id=?";
        $prep=$connection->prepare($sql);
        $prep->bindValue(1, $this->id, PDO::PARAM_INT);
        $prep->execute();

        if($prep->fetchColumn()==0){
          return 2;
        }

        $sql="delete from ". self::$tableName ." where id=?";
        $stmt=$connection->prepare($sql);
        $stmt->bindValue(1, $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return 0;
      } catch (PDOException $e) {
        die($e->errorInfo());
        return 3;
      }
    }

}

/* test
$flight = new Flight(18,"Sarajevo", "Tuzlaa", "date", 1000, 60);
$status = $flight->deleteFromDb();
if($status!=0){
  echo DBInfo::getMesssageForErrorCode($status);
}*/
