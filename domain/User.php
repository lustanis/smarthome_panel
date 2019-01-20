<?php

use Medoo\Medoo;

class User  {
    public function __construct(Medoo $db = null) {
        $this->db = $db;
    }

    public function login($login, $passwordMd5) {
        $user = $this->db->select(User::$tableName, "*", ["AND"=>["login"=>$login, "password"=>$passwordMd5]]);
        if ($user != NULL && count($user) === 1) {
            $_SESSION["User_user"] = serialize($user[0]);
        }
        else{
            throw new Exception ("user does not exists");
        }
    }


    public function register($login, $password){
        $result = $this->db->insert(User::$tableName, ["login"=>$login, "password"=>md5($password)]);
        if($result == NULL || $result->rowCount() !== 1){
            throw new Exception("registration failed: ". print_r($result->errorInfo(), true));
        }
    }
    public function isLogged(){
        return isset($_SESSION["User_user"]);
    }

    public function logout() {
        unset($_SESSION["User_user"]);
    }
    
    public function getUserName(){
        return $this->getUserFromSession()["login"];
    }
    public function getVelocity(): int{
        return $this->getUserFromSession()["velocity"];
    }

    public function getId(){
        return $this->getUserFromSession()["id"];
    }
    private $db;
    public static $tableName = "users";

    public function changeVelocity($velocity)
    {
        $result = $this->db->update(User::$tableName, ["velocity"=>$velocity], ["id"=> $this->getUserFromSession()["id"]]);
        if($result === NULL){
            throw new Exception("change velocity failed");
        }
        if($result->rowCount() !== 1){
            throw new Exception("nothing is updated: ". $result->errorInfo());
        }
        $this->updateUser();
    }

    private function updateUser()
    {
        $user = $this->db->select(User::$tableName, "*",  ["id"=> $this->getUserFromSession()["id"]]);
        if ($user != NULL && count($user) === 1) {
            $_SESSION["User_user"] = serialize($user[0]);
        }
    }

    public function getUserFromSession(): array
    {
        return unserialize($_SESSION["User_user"]);
    }

}