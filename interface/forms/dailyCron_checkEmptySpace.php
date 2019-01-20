<?php
global $db;
require_once 'domain/WaterCounter.php';
require_once 'domain/Cesspool.php';

$cessPool = new Cesspool($db);
$subscriptions = $cessPool->getSubscriptionWhenEmptySpaceBelow(1.0);

function sendNotifications($arrayOfRegistration){

    $data = json_encode(["registration_ids"=>$arrayOfRegistration]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://android.googleapis.com/gcm/send");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  //Post Fields
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $headers = [
        'Authorization: key=AAAAdfqUJ1w:APA91bF3XtlCuXcIif0BldV3jIXPGdcS59zTej266GH4mrBdU_QPwYdQA70BJ5DOhB_-HI3GwauhU5pGmC_1U_1wI6lPa1KRpo82YrsoNtugeBzNFkGB1U1bT2hPfGJieZbafdovjPf6',
        'Content-Type: application/json'
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $server_output = curl_exec ($ch);

    curl_close ($ch);
    echo $server_output;
}

for($i =0; $i < count($subscriptions);){
    $partial = [];
    //google has limit 1000 elements at once https://developers.google.com/cloud-messaging/http-server-ref
    for($j =0; $j < 1000 && $i < count($subscriptions); $j++){
        array_push($partial, $subscriptions[$i++]);
    }
    sendNotifications($partial);
}


