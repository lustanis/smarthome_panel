<?php

class Devices
{
    public static $tableName = "devices";

    private $db;

    public function __construct(\Medoo\Medoo $db)
    {
        $this->db = $db;
    }

    public function registerDevice(string $mainServerId, string $deviceId, int ...$services)
    {
//        $userId = $this->getUserIdByMainServerId($mainServerId, $deviceId);
//        $servicesName = array_map(function ($e) {
//            return $this->replaceEnumWithName($e);
//        }, $services);
//        $this->db->insert(Devices::$tableName, ["user_id" => $userId, "device_id" => $deviceId, "services" => json_encode($servicesName)]);
    }

    private function replaceEnumWithName($intValue)
    {
        switch ($intValue) {
            case 101:
                return "water_counter";
            default:
                return "$intValue";
        }
    }

    public function registerStandaloneDevice(int $userId, string $deviceType, string $functions)
    {
        $deviceId = $this->generateDeviceId($userId);
        $newDeviceName = "${deviceType}_${deviceId}";
        $datas = [
            "user_id" => $userId,
            "device_id" => $deviceId,
            "services" => json_encode([$deviceType]),
            "device_name" => $newDeviceName,
            "custom_device_name" => $newDeviceName,
            "functions" => json_encode(preg_split("/\|/", $functions))];
        $result = $this->db->insert(Devices::$tableName, $datas);
        if (!$result || $result->rowCount() != 1) {
            throw new RuntimeException("can not insert new device");
        }
        return $newDeviceName;

    }

    public function getUserIdByMainServerId(string $mainServerId, $deviceId)
    {
        $users = array_map(
            function($e){ return $e["user_id"];},
            $this->db->select(Devices::$tableName, ["user_id"], ["device_id"=>$deviceId]));
        return $this->db->get(User::$tableName, ["id"], ["main_device_id" => $mainServerId, "id"=>$users])["id"];
    }

    private function generateDeviceId(int $userId)
    {
        $result = $this->db->update(User::$tableName, ["standalone_device_id[+]" => 1], ["id" => $userId]);
        if (!$result || $result->rowCount() != 1) {
            throw new RuntimeException("can not update standalone_device_id");
        }
        $result = $this->db->get(User::$tableName, ["standalone_device_id [Int]"], ["id" => $userId]);
        if (!$result) {
            throw new RuntimeException("can not get standalone_device_id");
        }
        $deviceId = $result["standalone_device_id"];
        if (!isset($deviceId)) {
            throw new RuntimeException("can not obtain standalone_device_id");
        }
        return $deviceId;
    }

    public function getAllDevices($userId)
    {
        $result = $this->db->select(Devices::$tableName, "*", ["user_id"=>$userId]);
        if (!$result) {
            throw new RuntimeException("can not obtain devices list");
        }
        foreach ($result as $row) {
            $functions = $row["functions"];
            if(isset($functions) && $functions != "") {
                $row["functions"] = json_decode($row["functions"]);
            }
            else{
                $row["functions"] = [];
            }
            yield $row;
        }
    }
}