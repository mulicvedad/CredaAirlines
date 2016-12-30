<?php

class Flight
{
    private static $XML_FILE_PATH="data/xml/flights.xml";
    public $from;
    public $to;
    public $dateTime;
    public $duration;
    public $cost;

    public function __construct($tmpFrom="", $tmpTo="", $tmpDate="", $tmpDuration="", $tmpCost="")
    {
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

}