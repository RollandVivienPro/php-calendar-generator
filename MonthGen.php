<?php

class MonthGen {

    private static $today;
    private $year;
    private $month;

    public function __construct(array $args){

        if (isset($args['year'])) {
            $y = (int) $args['year'];
        } else {
            throw new \Exception('You have to define a year.');
        };
        if ($y>1969 && $y<2038) {
            $this->year = $y;
        } else {
            throw new \Exception('You have to define a year between 1970 and 2037.');
        }

        if (isset($args['month'])) {
            $m = (int) $args['month'];
        }else{
            throw new \Exception('You have to define a month.');
        };
        if($m>0 && $m<13){
            $this->month = $m;
        }else{
            throw new \Exception('You have to define a valid month between 1 and 12.');
        }

        self::$today = new \DateTime('NOW');

    }

    /**
     * Return the first day month
     *
     * @return \DateTimeImmutable
     */
    public function getFirstDay() :\DateTimeImmutable
    {
        return new \DateTimeImmutable("{$this->year}-{$this->month}-1");
    }

    /**
     * Return the first day num (1 to 7)
     *
     * @return integer
     */
    public function getFirstDayNum() :int{
        return $this->getFirstDay()->format('N') ;
    }

    /**
     * Return the day of the first monday of the month
     * Used in the next function to start the calcul at the very first day of month;
     *
     * @return \DateTimeImmutable
     */
    public function getLastMonday() :\DateTimeImmutable {
        $start = $this->getFirstDay();
        return $start->format('N') === '1' ? $start : $this->getFirstDay()->modify('last monday');
    }

    /**
     * Return the first day of the month with an addition : $k day of week (1 ..7) + $i (num of the week) * 7
     * Used in the iterator algorithm to generate the month, check the test.php exemple
     *
     * @param integer $i
     * @param integer $k
     * @return \DateTimeImmutable
     */
    public function getIncrementedDay(int $i, int $k) :\DateTimeImmutable {
        return $this->getLastMonday()->modify("+" . ($k + $i * 7) . " days");
    }

    /**
     * Return false if the day in parameter is not a day of the month
     *
     * @param \DateTimeImmutable $incDay
     * @return boolean
     */
    public function getwithinMonth(\DateTimeImmutable $incDay) :bool {
        return $this->getFirstDay()->format('Y-m') === $incDay->format('Y-m');
    }

    /**
     * Return true if the day is today;
     *
     * @param \DateTimeImmutable $day
     * @return boolean
     */
    public static function getIsToday(\DateTimeImmutable $day) :bool {
        return $day->format('Y-m-d') === self::$today->format('Y-m-d');
    }

    /**
     * Return true if the day is saturday or sunday
     *
     * @param \DateTimeImmutable $day
     * @return boolean
     */
    public static function getIsWeekend(\DateTimeImmutable $day) :bool {
        return $day->format('N') >= 6;
    }

    /**
     * Return the last day of the month
     *
     * @return \DateTimeImmutable
     */
    public function getLastDay() :\DateTimeImmutable
    {
        return $this->getFirstDay()->modify('+1 month - 1 day');
    }

    /**
     * Return the last day num (1 to 7)
     *
     * @return integer
     */

    public function getLastDayNum() : int {
        return $this->getLastDay()->format('N') ;
    }

    /**
     * Total days in the month
     *
     * @return integer
     */
    public function getNumberOfDays() : int 
    {
        return (int) $this->getLastDay()->format('d');
    }

    /**
     * Calcul the number of weeks in the month, Use to iterate in the view, check the test.php exemple
     *
     * @return integer
     */
    public function getNumberOfWeeks() : int {
        $lw = (int) $this->getLastDay()->format('W') === 1 ? 53 : (int) $this->getLastDay()->format('W');
        $fw = (int) $this->getFirstDay()->format('W') === 52 ? 0 : (int) $this->getFirstDay()->format('W');
        $result = $lw - $fw + 1;
        return $result;
    }

    /**
     * Get the prev month
     *
     * @return MonthGen
     */
    public function prevMonth() : MonthGen {
        $month = $this->month - 1;
        $year = $this->year;
        if($month<1){
            $month=12; 
            $year -=1;
        }
        return new MonthGen(['year'=>$year,'month'=>$month]);
    }

    /**
     * Get the next month
     *
     * @return MonthGen
     */
    public function nextMonth() : MonthGen {
        $month = $this->month + 1;
        $year = $this->year;
        if ($month>12) {
            $month=1;
            $year +=1;
        }
        return new MonthGen(['year'=>$year,'month'=>$month]);
    }

    /**
     * Get the value of year
     * 
     * @return int
     */ 
    public function getYear() : int
    {
        return $this->year;
    }

    /**
     * Set the value of year
     *
     * @return  self
     */ 
    public function setYear(int $year) : MonthGen
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get the value of month
     * 
     * @return int
     */ 
    public function getMonth() :int
    {
        return $this->month;
    }

    /**
     * Set the value of month
     *
     * @return  self
     */ 
    public function setMonth(int $month) : MonthGen
    {
        $this->month = $month;

        return $this;
    }

}


