<?php

class DeviceRequests
{
    public static $tableName = "device_requests";

    private $db;

    public function __construct(\Medoo\Medoo $db)
    {
        $this->db = $db;
    }

    public function addNewFunctionRequest(int $userId, int $deviceId, string $functionName)
    {
        $newDeviceRequest = [
            "user_id" => $userId,
            "device_id" => $deviceId,
            "function" => $functionName];
        $result = $this->db->insert(DeviceRequests::$tableName, $newDeviceRequest);
        if (!$result || $result->rowCount() != 1) {
            throw new RuntimeException("can not insert new device request");
        }
    }

    public function getLastOneAndRemoveAll(int $userId, string $deviceName)
    {
        $deviceId = $this->extractDeviceIdFromDeviceName($deviceName);
        $result = $this->db->get(
            DeviceRequests::$tableName,
            ["id", "function"],
            ["user_id" => $userId, "device_id" => $deviceId],
            ["ORDER" => ["id" => "ASC"]]);
        if (!$result) {
            throw new RuntimeException("can not obtain device requests");
        }
        if($result->rowCount() > 0){
            $row = $result->fetch();
            $functionToDo = $row["function"];

            $idsToRemove = [$row["id"]];
            while($row = $result->fetch()){
                $idsToRemove[] = $row["id"];
            }

            $this->removeFunctions($idsToRemove);
            return $functionToDo;
        }
        return "";
    }

    private function extractDeviceIdFromDeviceName(string $deviceName)
    {
        return substr($deviceName, strrpos($deviceName, "_"));
    }

    private function removeFunctions(array $idsToRemove)
    {
        $result = $this->db->delete(DeviceRequests::$tableName, ["id"=>$idsToRemove]);
        if (!$result || $result->rowCount() != count($idsToRemove)) {
            throw new RuntimeException("can not remove device requests");
        }
    }
}
