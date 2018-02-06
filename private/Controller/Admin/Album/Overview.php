<?php

namespace Controller\Admin\Album;

use Controller\FourOFour;
use Lib\Core\BaseController;

/**
 * Class Overview
 * @package Controller\Admin\Album
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Overview extends BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $albums = $this->getAlbumRepository()->getAll();
        $allowed = false;

        foreach ($albums as $key => $album) {
            if ($this->hasPermission('album.' . $this->getAlbumCategoryRepository()->getById($album->getCategory())->getName() . '.view')) {
                $allowed = true;
            } else {
                unset($albums[$key]);
            }
        }

        if (!$allowed) {
            header("HTTP/1.1 404 Not Found");
            $controller = new FourOFour();
            $controller->execute();
            exit;
        }

        return [
            'albums' => $albums,
            'categories' => $this->getAlbumCategoryRepository()->getAll(),
            'active' => 'album'
        ];
    }
}
