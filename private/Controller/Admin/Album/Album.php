<?php

namespace Controller\Admin\Album;

use Controller\Admin;

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
        $album = $this->getAlbumRepository()->getById($this->getVariable('id', 0));
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
            $this->ensurePermission(
                'album.' . $this->getAlbumCategoryRepository()->getById($album->getCategory())->getName() . '.view'
            );
        }

        return [
            'album' => $album,
            'pictures' => $this->getPictureRepository()->findByAlbumId($this->getVariable('id', 0)),
            'categories' => $this->getAlbumCategoryRepository()->getAll(),
            'albumHash' => md5($album->getId()),
            'active' => 'album'
        ];
    }
}
