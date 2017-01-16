<?php
require "DBEntity.php";
require "DBInfo.php";
class City extends DBEntity
{
    public $id;
    public $name;
    public $numberOfCitizens;

    public function __construct($tmpId=-1,$tmpName, $tmpNumCitizens)
    {
        $this->id=$tmpId;
        $this->name=$tmpName;
        $this->numberOfCitizens=$tmpNumCitizens;
    }

    public function saveToDb(){
      try {
        $connection = new PDO(DBInfo::DB_CONNECTION_STRING(), DBInfo::$USERNAME,DBInfo::$PASSWORD);
        $connection->exec("set names utf8");

        //we will not allow cities with same name
        $sql="select count(*) from city where name=?";
        $prep=$connection->prepare($sql);
        $prep->bindValue(1, $this->name);
        $prep->execute();

        //if this city already exists return false
        if($prep->fetchColumn()!=0){
          return 1;
        }
        /*
        foreach($cities->fetchAll() as $city){
          if($city["name"]==$this->name){
            return false;
          }
        }*/
        $stmt=$connection->prepare("insert into city set name=?, number_of_citizens=? ;");
        $stmt->bindValue(1,$this->name);
        $stmt->bindValue(2,$this->numberOfCitizens,PDO::PARAM_INT);
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
        $connection = new PDO(DBInfo::DB_CONNECTION_STRING(), DBInfo::$USERNAME,DBInfo::$PASSWORD);
        $connection->exec("set names utf8");

        //check if city exists
        $sql="select count(*) from city where id=?";
        $prep=$connection->prepare($sql);
        $prep->bindValue(1, $this->id, PDO::PARAM_INT);
        $prep->execute();

        //if this city doesnt exist return false
        if($prep->fetchColumn()==0){
          return 2;
        }

        $sql="update city set name=?, number_of_citizens=? where id=? ;";
        $stmt=$connection->prepare($sql);

        $stmt->bindValue(1,$this->name);
        $stmt->bindValue(2,$this->numberOfCitizens, PDO::PARAM_INT);
        $stmt->bindValue(3,$this->id, PDO::PARAM_INT);
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
        //check if city exists
        $sql="select count(*) from city where id=?";
        $prep=$connection->prepare($sql);
        $prep->bindValue(1, $this->id, PDO::PARAM_INT);
        $prep->execute();

        //if this city doesnt exist return false
        if($prep->fetchColumn()==0){
          return 2;
        }
        $sql="delete from city where id=?";
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

?>
