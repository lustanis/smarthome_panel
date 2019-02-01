<?php

use Medoo\Medoo;

class WaterCounter
{
    private $userId;

    public function __construct(Medoo $db, $userId)
    {
        $this->db = $db;
        $this->userId = $userId;
    }

    public function addCounting($devicesId, $value, $report_id)
    {
        $result = $this->db->insert(WaterCounter::$dbName,
            ["value" => $value, "user" => $this->userId, "report_id" => $report_id, "device_id"=>$devicesId]);
        if ($result == NULL || $result->rowCount() !== 1)
            throw new RuntimeException("no insert: " . $result->errorInfo());
    }

    public function getAmountSinceLastCleaning(int $userId): float
    {
        $lastCleaningTimestamp = $this->getLastCleaningTimestamp($userId);
        $result = (string)$this->db->sum(WaterCounter::$dbName, "value", ["AND" => ["user" => $userId, "timestamp[>=]" => $lastCleaningTimestamp]]);
        return $result / 1000;
    }

    public function getConsumptionEntries($month)
    {
        $res = $this->db->select(WaterCounter::$dbName, ["value", "timestamp"],
            ["user" => $this->userId,
                "timestamp[>=]" => $month,
                "timestamp[<]" => date("Y-m-d", strtotime('+1 month', strtotime($month."-01")))]);
        if ($res === NULL) {
            throw new Exception("can not get entries");
        }
        $accumulatedResult = array();
        foreach ($res as $entry) {
            $date = substr($entry["timestamp"], 0, 10);
            if (isset($accumulatedResult[$date])) {
                $accumulatedResult[$date] += $entry['value'];
            } else {
                $accumulatedResult[$date] = $entry['value'];
            }
        }
        return $accumulatedResult;
    }


    private function getLastCleaningTimestamp(int $userId): string
    {
        return $this->db->max("cleanings", "timestamp", ["user" => $userId]) ?? "";

    }

    private $db;
    private static $dbName = "counter";

    public function getVelocity($userId)
    {
        return $this->db->get(User::$tableName, ["velocity"], ["id" => $userId])["velocity"];
    }

    public function getFreeSpace($userId){
        return $this->getVelocity($userId) - $this->getAmountSinceLastCleaning($userId);
    }
}