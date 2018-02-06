<?php

namespace Controller\Admin\Album;

use Controller\Admin;
use Lib\Data\AlbumCategory;
use Lib\Data\Picture;

/**
 * Class Album
 * @package Controller\Admin
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Album extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $album = \Lib\Data\Album::getById($_GET['id']);
        if (!$album) {
            $album = new \Lib\Data\Album(
                null,
                "",
                '',
                '',
                '',
                '',
                0
            );
        } else {
            $this->ensurePermission('album.' . $album->getCategoryObject()->getName() . '.view');
        }

        return [
            'album' => $album,
            'pictures' => Picture::findByAlbumId($_GET['id']),
            'categories' => AlbumCategory::getAll(),
            'albumHash' => md5($album->getId()),
            'active' => 'album'
        ];
    }
}
