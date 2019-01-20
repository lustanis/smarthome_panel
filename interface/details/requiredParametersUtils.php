<?php
function assertAndObtainRequiredParameters($array, ...$requiredParameters){
    $result = array();
    foreach($requiredParameters as $required ){
        $value = $array[$required];
        if(!isset($value)){
            throw new RuntimeException("missing required parameter: ". $required);
        }
        array_push($result, $value);
    }
    return $result;
}