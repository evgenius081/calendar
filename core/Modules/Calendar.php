<?php


namespace Modules;


class Calendar
{
    private $days = [];
    private $all_days = [];
    private $months = ['Январь', 'Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь', ""];
    private $current_year;
    private $current_month;
    public function __construct($year=null,$month = null)
    {
            $this->current_month = isset($month) ? $month : date('n');
            $this->current_year = $year ?? date('Y');
            $first_day = date('w', mktime('0', '0', '0', $this->current_month, '1', $this->current_year)) - 1;
            if($first_day == -1){
                $first_day = 6;
            }
            $days_num = date('t', mktime('0', '0', '0', $this->current_month, '1', $this->current_year));
            $days = [];
            $day = 1;
            for($i = 0; $i < 6; $i++){
                for($j = 0; $j < 7; $j++){
                    if($i === 0 && $j < $first_day){
                        $days[$i][$j] = '';
                    }else if($i === 5 && $day > $days_num){
                        $days[$i][$j] = '';
                        $day++;
                    }else if($i === 4 && $day > $days_num){
                        $days[$i][$j] = '';
                        $day++;
                    }
                    else{
                        $days[$i][$j] = $day;
                        $day++;
                    }
                }
            }
            $this->days = $days;

            $all_days = [];
            foreach ($this->months as $number=>$month){
            $all_days[$number][0]=date('w', mktime('0', '0', '0', $number, '1', $this->current_year))-1;

            if($all_days[$number][0] === -1){
                $all_days[$number][0] = 6;
            }
            $all_days[$number][1]=date('t', mktime('0','0','0', $number, '1', $this->current_year));
        }

        array_shift($all_days);
        foreach ($this->months as $number=>$month){

            $days = [];
            $day = 1;
            for($i = 0; $i < 6; $i++){
                for($j = 0; $j < 7; $j++){
                    if($i === 0 && $j < $all_days[$number][0]){
                        $days[$i][$j] = '';
                    }else if($i === 4 && $day > $all_days[$number][1]){
                        $days[$i][$j] = '';
                        $day++;
                    }else if($i === 5 && $day > $all_days[$number][1]){
                        $days[$i][$j] = '';
                        $day++;
                    }else{
                        $days[$i][$j] = $day;
                        $day++;
                    }
                }
            }
            $all_days[$number][2] = $days;
        }
        $this->all_days = $all_days;
    }

    public function getDays(): array
    {
        return $this->days;
    }

    /**
     * @return array
     */
    public function getMonths(): array
    {
        return $this->months;
    }

    /**
     * @return mixed
     */
    public function getCurrentYear()
    {
        return $this->current_year;
    }

    /**
     * @return false|string
     */
    public function getCurrentMonth()
    {
        return $this->current_month;
    }

    /**
     * @return array
     */
    public function getAllDays(): array
    {
        return $this->all_days;
    }

    
}