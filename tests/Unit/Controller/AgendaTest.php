<?php

namespace Unit\Controller;

use Controller\Agenda;
use Controller\Albums;
use Lib\Data\Album;
use Lib\Data\AlbumCategory;

/**
 * Class AgendaTest
 * @package Unit\Controller
 */
class AgendaTest extends \PHPUnit\Framework\TestCase
{
    public function testGetArray()
    {
        $mockAgenda = new \Lib\Data\Agenda(5, 'name', '2017-01-01', '2018-01-01', 'description', 'slug', 0);
        $controller = new Agenda();

        $agendaRepo = new \Lib\Repository\Agenda();
        $agendaDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $agendaDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Agenda::TABLENAME))->will($this->returnValue(\Lib\Repository\Agenda::TABLENAME));
        $agendaDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Agenda::TABLENAME . '` WHERE startDate > ? AND endDate < ?'), $this->equalTo([date('Y-m-1 H:i:s'), date('Y-m-1 H:i:s', strtotime('+1 year'))]), $this->equalTo('ss'))->will($this->returnValue([
            [
                'id' => $mockAgenda->getId(),
                'name' => $mockAgenda->getName(),
                'startDate' => $mockAgenda->getStartDate(),
                'endDate' => $mockAgenda->getEndDate(),
                'description' => $mockAgenda->getDescription(),
                'slug' => $mockAgenda->getSlug(),
                'category' => $mockAgenda->getCategory()
            ]
        ]));
        $agendaRepo->setDatabase($agendaDatabase);
        $controller->setAgendaRepository($agendaRepo);

        $result = $controller->getArray();
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
        $this->assertEquals($result, [
            'items' => [$mockAgenda],
            'dates' => $dates,
        ]);
    }
}
