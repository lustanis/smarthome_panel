<?php
global $db;

require_once 'domain/Devices.php';
$devices = new Devices($db);

?>
<table border="1" style="width:100%">
    <tr style="font-weight: bold">
        <td>Device name</td>
        <td style="min-width: 200px">Functions</td>
    </tr> <?php
    foreach ($devices->getAllDevices($user->getId()) as $registeredDevice) { ?>
        <tr>
            <td><?php echo $registeredDevice["custom_device_name"] ?></td>
            <td><?php foreach ($registeredDevice["functions"] as $function) { ?>
                    <button data-inline="true" data-role="button"
                            onclick="saveAction(<?php echo $registeredDevice['device_id'] ?>, '<?php echo $function ?>')">
                        <?php echo $function ?>
                    </button> <?php
                } ?>
            </td>
        </tr> <?php
} ?>
</table>

<script type="text/javascript">
    var numberOfAttemptToGetResponses = 0;
    function getResponseFromDevice(deviceId){
        $.post("laction/getDeviceResponses.php", {deviceId: deviceId})
            .always(responses=>{
                const jsonAnswer = JSON.parse(responses);
                if(jsonAnswer.length == 0){
                    if(numberOfAttemptToGetResponses++ < 66){
                        setTimeout(function(){ getResponseFromDevice(deviceId);}, 3000);
                    }
                    else{
                        numberOfAttemptToGetResponses = 0;
                        $.mobile.loading("hide");
                    }
                    return;
                }
                $.mobile.loading("hide");
                alert(jsonAnswer);
            })
    }

    function saveAction(deviceId, functionName) {
        $.mobile.loading("show");
        $.post("laction/saveNewRequest.php", {deviceId: deviceId, functionName: functionName})
            .fail(message=>{alert(message);})
            .done(data=>{if(data.trim().length > 0) alert(data);})
            .always(ignored=>{
                if(functionName == "check"){
                    getResponseFromDevice(deviceId);
                }
                else{
                    $.mobile.loading("hide");
                }
            });
    }
</script>