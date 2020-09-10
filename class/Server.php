<?php

class Server
{
    public $Name = "Local Server";
    public $Ip = "127.0.0.1:8001";
    public $GameFiles = "http://localhost/ff";

    public function __construct()
    {
    }

    # =================
    # Instance methods
    # =================

    public function setServerInfo($name, $ip, $gameFiles)
    {
        $this->Name = $name;
        $this->Ip = $ip;
        $this->GameFiles = $gameFiles;
    }

    public function toJson()
    {
        $array = array(
            "Name" => $this->Name,
            "Ip" => $this->Ip,
            "GameFiles" => $this->GameFiles
        );
        return json_encode($array);
    }

    # ===============
    # Static methods
    # ===============

    public static function fromJson($json)
    {
        $instance = new Server();
        if (!empty($json)) {
            $decoded = json_decode($json);
            $instance->setServerInfo($decoded["Name"], $decoded["Ip"], $decoded["GameFiles"]);
        }
        return $instance;
    }
}