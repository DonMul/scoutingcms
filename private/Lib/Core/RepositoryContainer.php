<?php

namespace Lib\Core;

use Lib\Repository\Picture;
use Lib\Repository\Agenda;
use Lib\Repository\AgendaCategory;
use Lib\Repository\Album;
use Lib\Repository\AlbumCategory;
use Lib\Repository\Download;
use Lib\Repository\Menu;
use Lib\Repository\News;
use Lib\Repository\Page;
use Lib\Repository\Permission;
use Lib\Repository\Role;
use Lib\Repository\Speltak;
use Lib\Repository\User;

class RepositoryContainer
{
    /**
     * @var Agenda
     */
    private $agendaRepository;

    /**
     * @var AgendaCategory
     */
    private $agendaCategoryRepository;

    /**
     * @var Album
     */
    private $albumRepository;

    /**
     * @var AlbumCategory
     */
    private $albumCategoryRepository;

    /**
     * @var Download
     */
    private $downloadRepository;

    /**
     * @var Menu
     */
    private $menuRepository;

    /**
     * @var News
     */
    private $newsRepository;

    /**
     * @var Page
     */
    private $pageRepository;

    /**
     * @var Permission
     */
    private $permissionRepository;

    /**
     * @var Picture
     */
    private $pictureRepository;

    /**
     * @var Role
     */
    private $roleRepository;

    /**
     * @var Speltak
     */
    private $speltakRepository;

    /**
     * @var User
     */
    private $userRepository;

    /**
     * @param Agenda $repo
     */
    public function setAgendaRepository(Agenda $repo)
    {
        $this->agendaRepository = $repo;
    }

    /**
     * @return Agenda
     */
    public function getAgendaRepository(): Agenda
    {
        if (!($this->agendaRepository instanceof Agenda)) {
            $this->setAgendaRepository(new Agenda());
        }

        return $this->agendaRepository;
    }

    /**
     * @param AgendaCategory $repo
     */
    public function setAgendaCategoryRepository(AgendaCategory $repo)
    {
        $this->agendaCategoryRepository = $repo;
    }

    /**
     * @return AgendaCategory
     */
    public function getAgendaCategoryRepository(): AgendaCategory
    {
        if (!($this->agendaCategoryRepository instanceof AgendaCategory)) {
            $this->setAgendaCategoryRepository(new AgendaCategory());
        }

        return $this->agendaCategoryRepository;
    }

    /**
     * @param Album $repo
     */
    public function setAlbumRepository(Album $repo)
    {
        $this->albumRepository = $repo;
    }

    /**
     * @return Album
     */
    public function getAlbumRepository(): Album
    {
        if (!($this->albumRepository instanceof Album)) {
            $this->setAlbumRepository(new Album());
        }

        return $this->albumRepository;
    }

    /**
     * @param AlbumCategory $repo
     */
    public function setAlbumCategoryRepository(AlbumCategory $repo)
    {
        $this->albumCategoryRepository = $repo;
    }

    /**
     * @return AlbumCategory
     */
    public function getAlbumCategoryRepository(): AlbumCategory
    {
        if (!($this->albumCategoryRepository instanceof AlbumCategory)) {
            $this->setAlbumCategoryRepository(new AlbumCategory());
        }

        return $this->albumCategoryRepository;
    }

    /**
     * @param Download $repo
     */
    public function setDownloadRepository(Download $repo)
    {
        $this->downloadRepository = $repo;
    }

    /**
     * @return Download
     */
    public function getDownloadRepository(): Download
    {
        if (!($this->downloadRepository instanceof Download)) {
            $this->setDownloadRepository(new Download());
        }

        return $this->downloadRepository;
    }

    /**
     * @param Menu $repo
     */
    public function setMenuRepository(Menu $repo)
    {
        $this->menuRepository = $repo;
    }

    /**
     * @return Menu
     */
    public function getMenuRepository(): Menu
    {
        if (!($this->menuRepository instanceof Menu)) {
            $this->setMenuRepository(new Menu());
        }

        return $this->menuRepository;
    }

    /**
     * @param News $repo
     */
    public function setNewsRepository(News $repo)
    {
        $this->newsRepository = $repo;
    }

    /**
     * @return News
     */
    public function getNewsRepository(): News
    {
        if (!($this->newsRepository instanceof News)) {
            $this->setNewsRepository(new News());
        }

        return $this->newsRepository;
    }

    /**
     * @param Page $repo
     */
    public function setPageRepository(Page $repo)
    {
        $this->pageRepository = $repo;
    }

    /**
     * @return Page
     */
    public function getPageRepository(): Page
    {
        if (!($this->pageRepository instanceof Page)) {
            $this->setPageRepository(new Page());
        }

        return $this->pageRepository;
    }

    /**
     * @param Permission $repo
     */
    public function setPermissionRepository(Permission $repo)
    {
        $this->permissionRepository = $repo;
    }

    /**
     * @return Permission
     */
    public function getPermissionRepository(): Permission
    {
        if (!($this->permissionRepository instanceof Permission)) {
            $this->setPermissionRepository(new Permission());
        }

        return $this->permissionRepository;
    }

    /**
     * @param Picture $repo
     */
    public function setPictureRepository(Picture $repo)
    {
        $this->pictureRepository = $repo;
    }

    /**
     * @return Picture
     */
    public function getPictureRepository(): Picture
    {
        if (!($this->pictureRepository instanceof Picture)) {
            $this->setPictureRepository(new Picture());
        }

        return $this->pictureRepository;
    }

    /**
     * @param Role $repo
     */
    public function setRoleRepository(Role $repo)
    {
        $this->roleRepository = $repo;
    }

    /**
     * @return Role
     */
    public function getRoleRepository(): Role
    {
        if (!($this->roleRepository instanceof Role)) {
            $this->setRoleRepository(new Role());
        }

        return $this->roleRepository;
    }

    /**
     * @param Speltak $repo
     */
    public function setSpeltakRepository(Speltak $repo)
    {
        $this->speltakRepository = $repo;
    }

    /**
     * @return Speltak
     */
    public function getSpeltakRepository(): Speltak
    {
        if (!($this->speltakRepository instanceof Speltak)) {
            $this->setSpeltakRepository(new Speltak());
        }

        return $this->speltakRepository;
    }

    /**
     * @param User $repo
     */
    public function setUserRepository(User $repo)
    {
        $this->userRepository = $repo;
    }

    /**
     * @return User
     */
    public function getUserRepository(): User
    {
        if (!($this->userRepository instanceof User)) {
            $this->setUserRepository(new User());
        }

        return $this->userRepository;
    }
}
