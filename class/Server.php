<?php

class Server
{
    public $name = "Local Server";
    public $ip = "127.0.0.1:8001";
    public $gamefiles = "http://localhost/ff";
    public $unityFile = "main.unity3d";

    public function __construct()
    {
    }

    # =================
    # Instance methods
    # =================

    public function setServerInfo($name, $ip, $gameFiles, $unityFile)
    {
        $this->name = $name;
        $this->ip = $ip;
        $this->gamefiles = $gameFiles;
        $this->unityFile = $unityFile;
    }

    public function toJson()
    {
        $array = array(
            "Name" => $this->name,
            "Ip" => $this->ip,
            "GameFiles" => $this->gamefiles,
            "UnityFile" => $this->unityFile
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
            $instance->setServerInfo($decoded["Name"], $decoded["Ip"],
                $decoded["GameFiles"], $decoded["UnityFile"]);
        }
        return $instance;
    }
}