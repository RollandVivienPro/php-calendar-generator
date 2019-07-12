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

    public function getFirstDay() :\DateTimeImmutable
    {
        return new \DateTimeImmutable("{$this->year}-{$this->month}-1");
    }

    public function getFirstDayNum(){
        return $this->getFirstDay()->format('N') ;
    }

    /**
     * Retourne le jour du dernier lundi avant le mois
     *
     * @return \DateTimeImmutable
     */
    public function getLastMonday() :\DateTimeImmutable {
        $start = $this->getFirstDay();
        return $start->format('N') === '1' ? $start : $this->getFirstDay()->modify('last monday');
    }

    /**
     * Retourne le jour courant, incrémenté du jour suivant, au format dateTime
     * il prend en paramètre les index des 2 boucles dans la view : l'index de tous les jours du moids, et l'index du jour de la semaine
     *
     * @param integer $i
     * @param integer $k
     * @return \DateTimeImmutable
     */
    public function getIncrementedDay(int $i, int $k) :\DateTimeImmutable {
        return $this->getLastMonday()->modify("+" . ($k + $i * 7) . " days");
    }

    /**
     * Retourne vrai ou faux si le jour passé en paramètre est un jour du mois
     * Utile pour coller une class css sur les jours du calendrier qui ne sont pas des jours du mois affiché
     *
     * @param \DateTimeImmutable $incDay
     * @return boolean
     */
    public function getwithinMonth(\DateTimeImmutable $incDay) :bool {
        return $this->getFirstDay()->format('Y-m') === $incDay->format('Y-m');
    }

    /**
     * Retourne vrai ou faux si le jour passé en paramètre est aujourd'hui
     *
     * @param \DateTimeImmutable $day
     * @return boolean
     */
    public static function getIsToday(\DateTimeImmutable $day) :bool {
        return $day->format('Y-m-d') === self::$today->format('Y-m-d');
    }

    /**
     * Retourne vrai ou faux si le jour passé en paramètre est un samedi ou un dimanche
     *
     * @param \DateTimeImmutable $day
     * @return boolean
     */
    public static function getIsWeekend(\DateTimeImmutable $day) :bool {
        return $day->format('N') >= 6;
    }

    public function getLastDay()
    {
        return $this->getFirstDay()->modify('+1 month - 1 day');
    }

    public function getLastDayNum(){
        return $this->getLastDay()->format('N') ;
    }

    public function getNumberOfDays() : int 
    {
        return (int) $this->getLastDay()->format('d');
    }

    public function getNumberOfWeeks() : int {
        $lw = (int) $this->getLastDay()->format('W') === 1 ? 53 : (int) $this->getLastDay()->format('W');
        $fw = (int) $this->getFirstDay()->format('W') === 52 ? 0 : (int) $this->getFirstDay()->format('W');
        $result = $lw - $fw + 1;
        return $result;
    }

    /**
     * Get the value of year
     */ 
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set the value of year
     *
     * @return  self
     */ 
    public function setYear($year) : MonthGen
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get the value of month
     */ 
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set the value of month
     *
     * @return  self
     */ 
    public function setMonth($month) : MonthGen
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Retourne le mois précédent
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
     * Retourne le mois suivant
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

}


