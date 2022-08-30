<?php

require_once 'GenerateCalendar.php';

//precisa do ano, do mês e do filtro(mensal ou semanal)

$year = date('Y');
$month = date('m');

//monthly ou weekly
$filter = "monthly";

//instância o helper de calendário com o mês e ano
$generateCalendar = new GenerateCalendar($year, $month);

//verifica qual filtro foi passado para construir os dias
if ($filter == "weekly") {
    $generateCalendar->buildCalendar("weekly");
} else {
    $generateCalendar->buildCalendar("monthly");            
}

//pega o calendário construído
$calendar = $generateCalendar->getCalendar();

var_dump($calendar);

