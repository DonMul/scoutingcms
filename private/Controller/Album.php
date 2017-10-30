<?php

namespace Controller;

use Lib\Data\Picture;

class Album extends \Lib\Core\BaseController
{
    public function getArray()
    {
        $album = \Lib\Data\Album::getByCategoryAndSlug($_GET['category'], $_GET['album']);
        $pictures = Picture::findByAlbumId($album->getId());

        return [
            'pictures' => $pictures,
            'album' => $album,
            'albumHash' => md5($album->getName()),
        ];
    }
}