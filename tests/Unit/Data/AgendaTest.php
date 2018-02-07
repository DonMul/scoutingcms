<?php

namespace Unit\Data;

/**
 * Class AgendaTest
 */
class AgendaTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreateAgenda()
    {
        $id = rand(0, 1000);
        $name = 'Test agenda name';
        $startDate = '2017-01-01';
        $endDate = '2018-01-02';
        $description = 'Test agenda description';
        $slug = 'test-agenda-slug';
        $category = rand(0, 1000);
        $agenda = new \Lib\Data\Agenda($id, $name, $startDate, $endDate, $description, $slug, $category);

        $this->assertEquals($agenda->getId(), $id);
        $this->assertEquals($agenda->getName(), $name);
        $this->assertEquals($agenda->getEndDate(), $endDate);
        $this->assertEquals($agenda->getDescription(), $description);
        $this->assertEquals($agenda->getSlug(), $slug);
        $this->assertEquals($agenda->getCategory(), $category);
    }
}
