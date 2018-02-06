<?php

namespace Controller;

/**
 * Class Admin
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class Admin extends \Lib\Core\BaseController
{
    /**
     * Admin constructor.
     */
    public function __construct()
    {
        $this->setRequiresLogin(true);
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'totals' => [
                'agenda' => $this->getAgendaRepository()->getTotalAmount(),
                'album' => $this->getAlbumRepository()->getTotalAmount(),
                'download' => $this->getDownloadRepository()->getTotalAmount(),
                'news' => $this->getNewsRepository()->getTotalAmount(),
                'page' => $this->getPageRepository()->getTotalAmount(),
                'picture' => $this->getPictureRepository()->getTotalAmount(),
                'speltak' => $this->getSpeltakRepository()->getTotalAmount(),
                'user' => $this->getUserRepository()->getTotalAmount(),
            ],
        ];
    }

    /**
     * @param string $permissionName
     */
    protected function ensurePermission($permissionName)
    {
        if (!$this->hasPermission($permissionName)) {
            header("HTTP/1.1 404 Not Found");
            $controller = new FourOFour();
            $controller->execute();
            exit;
        }
    }
}
