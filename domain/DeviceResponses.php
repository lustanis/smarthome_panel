<?php

class DeviceResponses {
    public static $tableName = "device_responses";
    private $db;

    public function __construct(\Medoo\Medoo $db)
    {
        $this->db = $db;
    }

    public function getDeviceResponses(){

    }

    public function addResponse($userId, $deviceName, $status)
    {
        $newDeviceResponse = [
            "user_id" => $userId,
            "device_id" => $this->getDeviceId($userId, $deviceName),
            "status" => $status];
        $result = $this->db->insert(DeviceResponses::$tableName, $newDeviceResponse);
        if (!$result || $result->rowCount() != 1) {
            throw new RuntimeException("can not insert new device response");
        }
    }

    private function getDeviceId($userId, $deviceName)
    {
        require_once "domain/Devices.php";
        $devices = new Devices($this->db);
        foreach($devices->getAllDevices($userId) as $d){
            if($d["device_name"] == $deviceName){
                return $d["id"];
            }
        }
        throw new RuntimeException("can not find device id using device name: ". $deviceName);
    }
}
