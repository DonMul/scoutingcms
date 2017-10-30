<?php

namespace Controller;

use Lib\Data\AlbumCategory;
use Lib\Data\Picture;

class Album extends \Lib\Core\BaseController
{
    public function getArray()
    {
        $category = AlbumCategory::getByName($_GET['category']);
        $album = \Lib\Data\Album::getByCategoryAndSlug($category->getId(), $_GET['album']);
        $pictures = Picture::findByAlbumId($album->getId());

        return [
            'pictures' => $pictures,
            'album' => $album,
            'albumHash' => md5($album->getName()),
            'category' => AlbumCategory::getById($album->getCategory())
        ];
    }
}