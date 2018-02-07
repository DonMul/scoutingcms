<?php

namespace Unit\Data;

/**
 * Class AgendaCategoryTest
 */
class AgendaCategoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreateAgendaCategory()
    {
        $id = rand(0, 1000);
        $name = 'Test Agenda Category';
        $color = '000000';
        $agendaCategory = new \Lib\Data\AgendaCategory($id, $name, $color);

        $this->assertEquals($agendaCategory->getId(), $id);
        $this->assertEquals($agendaCategory->getName(), $name);
        $this->assertEquals($agendaCategory->getColor(), $color);
    }
}
