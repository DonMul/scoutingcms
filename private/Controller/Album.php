<?php

namespace Controller;

/**
 * Class Album
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Album extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $category = $this->getAlbumCategoryRepository()->getByName($this->getVariable('category', ''));
        $album = $this->getAlbumRepository()->getByCategoryAndSlug($category->getId(), $this->getVariable('album', ''));
        $pictures = $this->getPictureRepository()->findByAlbumId($album->getId());

        return [
            'pictures' => $pictures,
            'album' => $album,
            'albumHash' => md5($album->getId()),
            'category' => $this->getAlbumCategoryRepository()->getById($album->getCategory())
        ];
    }
}
