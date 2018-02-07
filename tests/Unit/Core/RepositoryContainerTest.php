<?php

/**
 * Class RepositoryContainerTest
 * @package Unit\Core
 */
class RepositoryContainerTest extends \PHPUnit\Framework\TestCase
{
    public function testRepositoryContainerTest()
    {
        $repositoryContainer = new \Lib\Core\RepositoryContainer();

        $this->assertInstanceOf(\Lib\Repository\User::CLASS, $repositoryContainer->getUserRepository());
        $this->assertInstanceOf(\Lib\Repository\Speltak::CLASS, $repositoryContainer->getSpeltakRepository());
        $this->assertInstanceOf(\Lib\Repository\Page::CLASS, $repositoryContainer->getPageRepository());
        $this->assertInstanceOf(\Lib\Repository\Menu::CLASS, $repositoryContainer->getMenuRepository());
        $this->assertInstanceOf(\Lib\Repository\Download::CLASS, $repositoryContainer->getDownloadRepository());
        $this->assertInstanceOf(\Lib\Repository\Album::CLASS, $repositoryContainer->getAlbumRepository());
        $this->assertInstanceOf(\Lib\Repository\Picture::CLASS, $repositoryContainer->getPictureRepository());
        $this->assertInstanceOf(\Lib\Repository\Role::CLASS, $repositoryContainer->getRoleRepository());
        $this->assertInstanceOf(\Lib\Repository\News::CLASS, $repositoryContainer->getNewsRepository());
        $this->assertInstanceOf(\Lib\Repository\AgendaCategory::CLASS, $repositoryContainer->getAgendaCategoryRepository());
        $this->assertInstanceOf(\Lib\Repository\AlbumCategory::CLASS, $repositoryContainer->getAlbumCategoryRepository());
        $this->assertInstanceOf(\Lib\Repository\Agenda::CLASS, $repositoryContainer->getAgendaRepository());
    }
}
