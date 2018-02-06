<?php

namespace Controller;

use Lib\Data\Picture;

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
                'agenda' => \Lib\Data\Agenda::getTotalAmount(),
                'album' => \Lib\Data\Album::getTotalAmount(),
                'download' => \Lib\Data\Download::getTotalAmount(),
                'news' => \Lib\Data\News::getTotalAmount(),
                'page' => \Lib\Data\Page::getTotalAmount(),
                'picture' => Picture::getTotalAmount(),
                'speltak' => \Lib\Data\Speltak::getTotalAmount(),
                'user' => \Lib\Data\User::getTotalAmount(),
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
