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
    foreach ($devices->getAllDevices() as $registeredDevice) { ?>
        <tr>
            <td><?php echo $registeredDevice["custom_device_name"] ?></td>
            <td><?php foreach ($registeredDevice["functions"] as $function) { ?>
                    <button data-inline="true" data-role="button"
                            onclick="saveAction(this, <?php echo $registeredDevice['device_id'] ?>, '<?php echo $function ?>')">
                        <?php echo $function ?>
                    </button> <?php
                } ?>
            </td>
        </tr> <?php
    } ?>
</table>

<script type="text/javascript">


    function saveAction(selector, deviceId, functionName) {
        $.mobile.loading("show");
        $.post("action/saveNewRequest.php", {deviceId: deviceId, functionName: functionName})
        .always(ignored=>{$.mobile.loading("hide");;});

    }
</script>