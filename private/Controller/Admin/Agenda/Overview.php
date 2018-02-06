<?php

namespace Controller\Admin\Agenda;


/**
 * Class Overview
 * @package Controller\Admin\Agenda
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Overview extends \Controller\Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('calender.edit');

        $items = $this->getAgendaRepository()->findBetweenDates(
            date('Y-m-d H:i:s', strtotime('-1 year')),
            date('Y-m-d H:i:s', strtotime('+1 year')),
            true
        );

        return [
            'items' => $items,
            'active' => 'calender'
        ];
    }
}
