<?php
function convertToLocaleDate($date)
{
    $dt = $date->toDateTime();
    $dt->setTimezone(new DateTimeZone('Europe/Warsaw'));
    return $dt;
}


require_once 'infrastructure/CesspoolCalculator.php';
require_once 'domain/User.php';
require_once 'domain/WaterCounter.php';

$user = new User($db);
$waterCounter = new WaterCounter($db, $user->getId());
?>
<hr>
<form method="post" data-ajax="false" action="action/changeVelocity.php">
    <div style="font-size: large; font-weight: bold">Konfiguracja</div>
    <table style='width:100%'>
        <tr>
            <td>Pojemność</td>
            <td style="width: 100%">
                <input required="required" style=" font-size: medium" type="number" step="1" name="velocity"
                       placeholder="pojemność" id="velocity_id" value="<?php echo $user->getVelocity(); ?>">
            </td>
            <td><input type="submit" value="zmień" data-mini="true"></td>
        </tr>
    </table>
</form>
<hr>
<?php
$currentState = $waterCounter->getAmountSinceLastCleaning($user->getId());
$isFull = ($user->getVelocity() - $currentState) < 0.5;
?>
<div style="font-size: large; font-weight: bold; <?php echo $isFull === true ? "color:red" : ""; ?>">
    Bieżący stan:<?php echo " " . $currentState . " m3"; ?>
</div>


<form method="post" data-ajax="false" action="action/cleaning.php"
      onsubmit="return confirm('Czy napewno chcesz odnotować wywóz szamba?')">
    <table style="margin:2px;">
        <tr>
            <td style="font-size: large; font-weight: bold">Wyzeruj licznik</td>
            <td>
                <input type="date" name="current_date" value="<?php echo date('Y-m-d'); ?>" required="required"
                       style=" font-size: small">
            </td>
            <td>
                <input type="submit" value="zeruj" data-mini="true">
            </td>
        </tr>
    </table>
</form>

<?php
$waterConsumptionEntries = $waterCounter->getConsumptionEntries();
?>
<hr>
<h3>Wykres</h3>
<div id="waterConsumptionChart"></div>
<script>
    $(document).ready(function () {
        var chart = c3.generate({
            bindto: "#waterConsumptionChart",
            data: {
                x: "x",
                xFormat: '%Y-%m-%d %H',
                columns: [
                    ["x", <?php echo implode(",", array_map(function ($entry) {
                        return "'" . $entry . "'";
                    }, array_keys($waterConsumptionEntries))); ?>],
                    ['consumption[L]', <?php echo implode(",", array_values($waterConsumptionEntries)) ?>],
                    //['consumption', <?php $current_value_consumer = 0;  echo implode(",", array_map(function ($e) use (&$current_value_consumer) {
                    return $current_value_consumer += $e;
                }, array_values($waterConsumptionEntries)))   ?>],

                ]
            },
            axis: {
                x: {
                    label: 'Date',
                    type: 'timeseries',
                    tick: {
                        format: '%Y-%m-%d %H'
                    }
                },
                y: {
                    label: {
                        text: 'water consumption',
                        position: 'outer-middle'
                    }
                }
            },
            tooltip: {
//          enabled: false
            },
            zoom: {
                enabled: true
            },
            subchart: {
                show: true
            }
        });
    });
</script>

