<?php
require "DBInfo.php";
class Account
{
    private static $XML_FILEPATH="data/xml/xml_account";
    private static $XML_NODE_NAME="account";
    private static $tableName="user";
    public $firstName;
    public $lastName;
    public $email;
    public $username;
    public $password;
    public $city;

    public function __construct($tmpFirstName="", $tmpLastName="", $tmpemail="", $tmpUsername="", $pword="", $city="")
    {
        $this->firstName=$tmpFirstName;
        $this->lastName=$tmpLastName;
        $this->email=$tmpemail;
        $this->username=$tmpUsername;
        $this->password=$pword;
        $this->city=$city;
    }

    public function serialize()
    {
        $xml=null;
        if(file_exists($this::$XML_FILEPATH)) {
            $xml=simplexml_load_file($this::$XML_FILEPATH);
        }
        else{
            $xml=new SimpleXMLElement("<accounts></accounts>");
        }

        $acc= $xml->addChild($this::$XML_NODE_NAME);

        $acc->addChild("firstName",$this->firstName);
        $acc->addChild("lastName",$this->lastName);
        $acc->addChild("email",$this->email);
        $acc->addChild("username",$this->username);
        $acc->addChild("password",$this->password);
        $acc->addChild("city",$this->city);

        $xml->asXML($this::$XML_FILEPATH);
    }

    public function saveToDb(){
      try {
        $connection = new PDO(DBInfo::$DB_CONNECTION_STRING, DBInfo::$USERNAME,DBInfo::$PASSWORD);
        $connection->exec("set names utf8");

        $stmt=$connection->prepare("select id from city where name=?");
        $stmt->bindValue(1,$this->city, PDO::PARAM_INT);
        $stmt->execute();
        $city=$stmt->fetchColumn();

        $stmt=$connection->prepare("insert into ". self::$tableName ." set first_name=:fn,
        last_name=:ln, email=:mail, username=:usr, password=:pw,
        city_id=:city ;");
        $stmt->bindValue(":fn",$this->firstName);
        $stmt->bindValue(":ln",$this->lastName);
        $stmt->bindValue(":mail",$this->email);
        $stmt->bindValue(":usr",$this->username);
        $stmt->bindValue(":pw",$this->password);
        $stmt->bindValue(":city",$city, PDO::PARAM_INT);

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

    public function deleteFromDb(){
      try {
        $connection = new PDO(DBInfo::$DB_CONNECTION_STRING, DBInfo::$USERNAME,DBInfo::$PASSWORD);
        $connection->exec("set names utf8");

        $sql="select count(*) from ". self::$tableName ." where username=?";
        $prep=$connection->prepare($sql);
        $prep->bindValue(1, $this->username);
        $prep->execute();

        if($prep->fetchColumn()==0){
          return 2;
        }

        $sql="delete from ". self::$tableName ." where username=?";
        $stmt=$connection->prepare($sql);
        $stmt->bindValue(1, $this->username);
        $stmt->execute();

        return 0;
      } catch (PDOException $e) {
        die($e->errorInfo());
        return 3;
      }
    }
}
