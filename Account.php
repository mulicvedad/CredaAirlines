<?php

class Account
{
    private static $XML_FILEPATH="data/xaml/xml_account";
    private static $XML_NODE_NAME="account";
    public $firstName;
    public $lastName;
    public $email;
    public $username;

    public function __construct($tmpFirstName="", $tmpLastName="", $tmpemail="", $tmpUsername="")
    {
        $this->firstName=$tmpFirstName;
        $this->lastName=$tmpLastName;
        $this->email=$tmpemail;
        $this->username=$tmpUsername;
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

        $xml->asXML($this::$XML_FILEPATH);
    }
}