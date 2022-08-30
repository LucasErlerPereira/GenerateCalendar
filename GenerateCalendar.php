<?php

class GenerateCalendar
{
    private $year;
    private $month;
    private $date;
    private $calendar = [];

    private $weekDay1 = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
    
    private $weekDay2 = [
        'Domingo' => NULL,
        'Segunda' => NULL,
        'Terça' => NULL,
        'Quarta' => NULL,
        'Quinta' => NULL,
        'Sexta' => NULL,
        'Sábado' => NULL,
    ];

    public function __construct($year, $month)
    {
        $this->year =  $year;
        $this->month = $month;
    }

    private function positionWeekDay($date)
    {
        return date('w', strtotime($date));
    }

    private function startDate()
    {
        $weekDay = $this->weekDay1[$this->positionWeekDay($this->date)];

        switch ($weekDay) {
            case 'Segunda':
                $this->date = date('Y-m-d', strtotime('-1 days', strtotime($this->date)));
                break;
            case 'Terça':
                $this->date = date('Y-m-d', strtotime('-2 days', strtotime($this->date)));
                break;                
            case 'Quarta':
                $this->date = date('Y-m-d', strtotime('-3 days', strtotime($this->date)));
                break;                
            case 'Quinta':
                $this->date = date('Y-m-d', strtotime('-4 days', strtotime($this->date)));
                break; 
            case 'Sexta':
                $this->date = date('Y-m-d', strtotime('-5 days', strtotime($this->date)));
                break;             
            case 'Sábado':
                $this->date = date('Y-m-d', strtotime('-6 days', strtotime($this->date)));
                break; 
            default:
                //domingo
                break;
        }        
    }

    private function builddHours()
    {
        $hours = [];

        for ($i=8; $i <= 22; $i++) {
            $hour = $i;

            if (strlen($hour) == 1) {
                $hour = "0$hour:00";
            } else {
                $hour = "$hour:00";
            }

            $hours[$hour] = $this->calendar[0];
        }

        $this->calendar = $hours;
    }

    private function buildDay($valueDay, $keyDay, $keyWeek)
    {
        $this->calendar[$keyWeek][$keyDay] = $this->date;
        $this->date = date('Y-m-d', strtotime('+1 days', strtotime($this->date)));
    }

    private function buildWeek($valueWeek, $keyWeek)
    {
        array_walk($valueWeek, [$this, 'buildDay'], $keyWeek);
    }

    public function buildCalendar($type)
    {
        if ($type == "monthly") {
            $this->date = $this->year. '-' .$this->month .'-1';

            for ($i=0; $i <= 4; $i++) { 
                $this->calendar[] = $this->weekDay2;
            }

            $this->startDate();

            array_walk($this->calendar, [$this, 'buildWeek']);            
        }
        
        if ($type == "weekly") {
            $this->date = $this->year. '-' .$this->month . '-' . date("d");

            $this->calendar[] = $this->weekDay2;

            $this->startDate();

            array_walk($this->calendar, [$this, 'buildWeek']);

            $this->builddHours();
        }
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getCalendar()
    {
        return $this->calendar;
    }    
}
