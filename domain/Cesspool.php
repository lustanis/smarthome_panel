<?php

class Cesspool
{
    private $db;
    private $userId;

    public static $dbName = "cesspool";

    public function __construct(\Medoo\Medoo $db, int $userId = null)
    {
        $this->db = $db;
        $this->userId = $userId;
    }

    public function empty(string $date)
    {
        $result = $this->db->insert("cleanings", ["timestamp" => $date, "user" => $this->userId]);
        if ($result === NULL || $result->rowCount() !== 1) {
            throw new Exception("cleaning failed: " . print_r($result->errorInfo(), true));
        }
    }

    public function savePushRegistrationId(string $id)
    {
        $this->db->action(function ($database) use ($id) {
            $database->delete(Cesspool::$dbName, ["user_id" => $this->userId]);
            $database->insert(Cesspool::$dbName, ["user_id" => $this->userId, "push_id" => $id]);
        });
    }
    public function getSubscriptionWhenEmptySpaceBelow(float $threshold){
        $subscriptions = [];
        $result = $this->db->select(Cesspool::$dbName, "*");
        foreach ($result as $entry){
            $userId = $entry["user_id"];
            $waterCounter = new WaterCounter($this->db, $userId);
            if($waterCounter->getFreeSpace($userId) < $threshold){
                array_push($subscriptions, $entry["push_id"]);
            }
        }
        return $subscriptions;
    }
}