<?php

namespace Unit\Controller;

use Lib\Data\Agenda;
use Lib\Data\AgendaCategory;


/**
 * Class ItemTest
 * @package Unit\Controller
 */
class ItemTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testGetArray()
    {
        $mockAgendaCategory = new AgendaCategory(1, 'name', 'color');
        $mockAgenda = new Agenda(5, 'name', '2017-01-01', '2018-01-01', 'description', 'slug', $mockAgendaCategory->getId());

        $_GET['slug'] = $mockAgenda->getSlug();

        $agendaRepo = new \Lib\Repository\Agenda();
        $agendaDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $agendaDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Agenda::TABLENAME))->will($this->returnValue(\Lib\Repository\Agenda::TABLENAME));
        $agendaDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Agenda::TABLENAME . '` WHERE slug = ?'), $this->equalTo([$mockAgenda->getSlug()]), $this->equalTo('s'))->will($this->returnValue([
            'id' => $mockAgenda->getId(),
            'name' => $mockAgenda->getName(),
            'startDate' => $mockAgenda->getStartDate(),
            'endDate' => $mockAgenda->getEndDate(),
            'description' => $mockAgenda->getDescription(),
            'slug' => $mockAgenda->getSlug(),
            'category' => $mockAgenda->getCategory()
        ]));
        $agendaRepo->setDatabase($agendaDatabase);

        $agendaCategoryRepo = new \Lib\Repository\AgendaCategory();
        $agendaCategoryDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $agendaCategoryDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\AgendaCategory::TABLENAME))->will($this->returnValue(\Lib\Repository\AgendaCategory::TABLENAME));
        $agendaCategoryDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\AgendaCategory::TABLENAME . '` WHERE id = ?'), $this->equalTo([$mockAgenda->getCategory()]), $this->equalTo('i'))->will($this->returnValue([
            'id' => $mockAgendaCategory->getId(),
            'name' => $mockAgendaCategory->getName(),
            'color' => $mockAgendaCategory->getColor(),
        ]));
        $agendaCategoryRepo->setDatabase($agendaCategoryDatabase);

        $controller = new \Controller\Agenda\Item;
        $controller->setAgendaRepository($agendaRepo);
        $controller->setAgendaCategoryRepository($agendaCategoryRepo);

        $this->assertEquals($controller->getArray(), [
            'item' => $mockAgenda,
            'category' => $mockAgendaCategory,
        ]);
    }
}
