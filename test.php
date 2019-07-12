<?php

require('MonthGen.php');

$month = new MonthGen(['year'=>2018,'month'=>12]);

$numberOfWeeks = $month->getNumberOfWeeks();

echo '-----------------------' . PHP_EOL;
echo $month->getMonth() . ' - ' . $month->getYear() . PHP_EOL;
echo '-----------------------' . PHP_EOL;


for($i=0;$i<$numberOfWeeks;$i++){
    if ($i===0) {
        echo 'lun| mar| mer| jeu| ven| sam| dim|' . PHP_EOL;
        echo '---------------------------' . PHP_EOL;
    }
    for($k=0;$k<7;$k++){
        $day = $month->getIncrementedDay($i,$k);
        if($month->getwithinMonth($day)){
            echo $month->getIncrementedDay($i,$k)->format('d') . ' | ';
        }else{
            echo '-- | ';
        }
    }
    echo PHP_EOL;
}