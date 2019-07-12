<?php

// run php test.php to the result in the console

require('MonthGen.php');

$year =  (new DateTime('NOW'))->format('Y');

for($m=1;$m<=12;$m++){

    $month = new MonthGen(['year'=>$year,'month'=>$m]);

    $numberOfWeeks = $month->getNumberOfWeeks();

    echo '***' . PHP_EOL;
    echo '-----------------------' . PHP_EOL;
    echo $month->getMonth() . ' - ' . $month->getYear() . PHP_EOL;
    echo '-----------------------' . PHP_EOL;

    for ($i=0;$i<$numberOfWeeks;$i++) {
        if ($i===0) {
            echo 'mon| tue| wed| thu| fri| sat| sun|' . PHP_EOL;
            echo '----------------------------------' . PHP_EOL;
        }
        for ($k=0;$k<7;$k++) {
            $day = $month->getIncrementedDay($i, $k);
            if ($month->getwithinMonth($day)) {
                echo $month->getIncrementedDay($i, $k)->format('d') . ' | ';
            } else {
                echo '-- | ';
            }
        }
        echo PHP_EOL;
    }

    echo '----------------------------------' . PHP_EOL;
    echo '***' . PHP_EOL;

}

