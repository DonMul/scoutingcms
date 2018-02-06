<?php

namespace Controller;

/**
 * Class Agenda
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class Agenda extends \Lib\Core\BaseController
{
    public function getArray()
    {
        $items = \Lib\Data\Agenda::findBetweenDates(
            date('Y-m-1 H:i:s'),
            date('Y-m-1 H:i:s', strtotime('+1 year'))
        );

        $dates = [];
        for ($i = 0; $i < 12; $i++) {
            $year = date('Y', strtotime("+{$i} month"));
            $month = date('m', strtotime("+{$i} month"));

            if (!isset($dates[$year])) {
                $dates[$year] = [];
            }

            $dates[$year][$month] = [];

            for ($j = 1; $j <= date('t', strtotime("{$year}-{$month}-1")); $j++) {
                $dates[$year][$month][] = $j;
            }
        }

        return [
            'items' => $items,
            'dates' => $dates,
        ];
    }
}
