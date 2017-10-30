<?php

namespace Controller\Admin\Agenda;

/**
 * Class Overview
 * @package Controller\Admin\Agenda
 */
class Overview extends \Controller\Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('calender.edit');

        $items = \Lib\Data\Agenda::findBetweenDates(
            date('Y-m-d H:i:s', strtotime('-1 year')),
            date('Y-m-d H:i:s', strtotime('+1 year')),
            true
        );

        return [
            'items' => $items
        ];
    }
}