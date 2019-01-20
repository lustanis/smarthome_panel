<?php
class Devices{
    public static $tableName = "devices";

    private $db;

    public function __construct(\Medoo\Medoo $db) {
        $this->db= $db;
    }

    public function registerDevice(string $mainServerId, string $deviceId, int ...$services){
        $userId = $this->getUserIdByMainServerId($mainServerId);
        $this->db->insert(Devices::$tableName, ["user_id"=>$userId, "device_id"=>$deviceId, "services"=> json_encode($services)]);
    }

    public function getUserIdByMainServerId(string $mainServerId)
    {
        return $this->db->get(User::$tableName, ["id"], ["main_device_id" => $mainServerId])["id"];
    }

}