<?php

namespace Controller\Admin\Album;

use Lib\Core\BaseController;
use Lib\Core\Settings;
use Lib\Data\Picture;

/**
 * Class Pictures
 * @package Controller\Admin
 */
class Album extends BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $album = \Lib\Data\Album::getById($_GET['id']);
        if (!$album) {
            $album = new \Lib\Data\Album(null, "New Album", '', '', '', '');
        }

        return [
            'album' => $album,
            'pictures' => Picture::findByAlbumId($_GET['id']),
            'categories' => Settings::getInstance()->get(['album', 'categories'])
        ];
    }
}