<?php
$listOfCleanings = $cesspool->getListOfCleanings();
if (count($listOfCleanings) >= 2) {
    $forecast = $cesspoolCalculator->getForecast($listOfCleanings, $userConfiguration->getVelocity());
    
}   ?>

<table>
    <tr>
        <td>
            <p style="font-size: large; font-weight: bold">Przewidywanie</p>
            <?php if(isset($forecast)){?>
                <span style="font-size: small">Średni użycie miesięczne: <b><?php echo $forecast["usagePerMonth"];?></b> m3</span>
            <?php } ?>
        </td>
        <td rowspan="2">
            <?php if(isset($forecast)){?>
            <div style="position: relative; height: 80px; width:30px;top:0px;left:0px;">
                <div id="cesspoolimage" 
                     style="position: absolute; top:0px; left:0px;
                     width:100%; height:100%;  
                     border:black 1px solid;   
                     ">
                </div>
                <div id="cesspoolimage" 
                     style="position: absolute; top:<?php echo  81 - 80 * $forecast["percentFillingLevel"] ;?>px; left:1px; 
                     background-color:#3388cc ;
                     width:100%; 
                     height:<?php echo 80*$forecast["percentFillingLevel"];?>px;  
                     border-spacing: 0px;
                     ">
                </div>
            </div> 
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php 
            if (isset($forecast)) { 
                if ($forecast["willBeFullIn"] < 0) { ?>
                    <span style="color:red; font-weight: bolder">Zbiornik zapełnił się <span style="font-size: xx-large"><?php echo abs($forecast["willBeFullIn"]); ?></span> dni temu!</span>

                <?php } else { ?>
                    Zbiornik zapełni się za: <b><?php echo $forecast["willBeFullIn"];?></b> dni<span id="here"></span> </div>
                </td> 
                <?php
            }
        } else {
            ?>
            Za mało danch wejściowych
        <?php } ?>
</table>