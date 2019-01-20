<?php

class CesspoolCalculator{
    
    public function getForecast($listOfCleanings, $cessPoolCapacity){
        $listOfCleanings = $this->copy10Elements($listOfCleanings);
        assert(count($listOfCleanings) >=2);
        $alreadyConsumed_NotCleanLastTime = 0.0;
        for($i = 0; $i < (count($listOfCleanings) - 1); $i++){
            $alreadyConsumed_NotCleanLastTime += $listOfCleanings[$i]["state"] - $listOfCleanings[$i]["amount"] - $listOfCleanings[$i+1]["state"];
        } 
        $forecast = $this->count($listOfCleanings, $cessPoolCapacity - $alreadyConsumed_NotCleanLastTime);
        return array("willBeFullIn"=> $forecast["forecast"],
                     "usagePerMonth"=> $forecast["usagePerMonth"],
                     "percentFillingLevel"=> min(array(1, ($cessPoolCapacity - $forecast["freeSpaceOnCurrentDay"])/$cessPoolCapacity)));
    } 
    private function count($listOfCleanings, $freeSpaceSinceLastCleaning){
        $totalUsage = (double)$listOfCleanings[0]["state"] - (double)end($listOfCleanings)["state"];
        $lastDayOfCleaning = convertToLocaleDate($listOfCleanings[0]["date"]);
        
        $numberOfDaysFromLastToFirstCleaning = 
                $lastDayOfCleaning->diff(convertToLocaleDate(end($listOfCleanings)["date"]))->format("%a");
        
        $usagePerDay = $totalUsage/$numberOfDaysFromLastToFirstCleaning;
        $now = new DateTime();
        $numberOfDaysSinceLastCleaning = $now->diff($lastDayOfCleaning)->format("%a");
        $freeSpaceInCesspool = $freeSpaceSinceLastCleaning - $usagePerDay * $numberOfDaysSinceLastCleaning;
        return array("forecast"=>(int)($freeSpaceInCesspool / $usagePerDay),
                     "freeSpaceOnCurrentDay"=>$freeSpaceInCesspool,
                     "usagePerMonth" => $usagePerDay * 30); 
        
                    
    }
    
    private function copy10Elements($listOfCleanings){
        $result = [];
        
        foreach($listOfCleanings as $cursor){
            $result[]= $cursor;
            if(count($result) >=10) break;
        }
        return $result;
    }
}
