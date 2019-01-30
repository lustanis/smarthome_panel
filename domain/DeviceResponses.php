<?php

class DeviceResponses {
    public static $tableName = "device_responses";
    private $db;

    public function __construct(\Medoo\Medoo $db)
    {
        $this->db = $db;
    }

    public function getDeviceResponses($userId, $deviceId){
        $result = $this->db->select(DeviceResponses::$tableName, ["id", "status"],
            ["user_id" => $userId, "device_id" => $this->getDeviceIdByCustomDeviceId($userId, $deviceId),
            "ORDER" => ["id" => "DESC"]]);
        if ($result === null) {
            throw new RuntimeException("can not obtain device responses");
        }
        if(count($result) > 0){
            $idsToRemove = array_map(function($e){return $e["id"];}, $result);
            $this->remove($idsToRemove);
        }
        return array_map( function($e) { return $e["status"];}, $result);
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

    private function getDeviceIdByCustomDeviceId($userId, $deviceId)
    {
        require_once "domain/Devices.php";
        $devices = new Devices($this->db);
        foreach($devices->getAllDevices($userId) as $d){
            if($d["device_id"] == $deviceId){
                return $d["id"];
            }
        }
        throw new RuntimeException("can not find device id using device custom id: ". $deviceId);
    }

    private function remove(array $idsToRemove)
    {
        $result = $this->db->delete(DeviceResponses::$tableName, ["id"=>$idsToRemove]);
        if (!$result || $result->rowCount() != count($idsToRemove)) {
            throw new RuntimeException("can not remove device responses");
        }
    }
}
