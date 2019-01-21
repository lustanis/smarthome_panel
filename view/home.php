<?php
global $db;

require_once 'domain/Devices.php';
$devices = new Devices($db);

?>
<table border="1" style="width:100%">
    <thead style="font-weight: bold">
        <td style="min-width: 200px">Device name</td>
        <td>Functions</td>
    </thead> <?php
    foreach ($devices->getAllDevices() as $registeredDevice) { ?>
        <tr>
            <td><?php echo $registeredDevice["custom_device_name"] ?></td>
            <td><?php foreach ($registeredDevice["functions"] as $function) { ?>
                    <button value="<?php echo $function ?>"></button> <?php
                } ?>
            </td>
        </tr> <?php
    } ?>
</table>
