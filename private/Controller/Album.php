<?php

namespace Controller;
use Lib\Data\AlbumCategory;
use Lib\Exception\PageNotFound;

/**
 * Class Album
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Album extends \Lib\Core\BaseController
{
    /**
     * @return array
     * @throws PageNotFound
     */
    public function getArray()
    {
        $category = $this->getAlbumCategoryRepository()->getByName($this->getVariable('category', ''));

        if (!($category instanceof AlbumCategory)) {
            throw new PageNotFound();
        }

        $album = $this->getAlbumRepository()->getByCategoryAndSlug($category->getId(), $this->getVariable('album', ''));
        if (!($album instanceof \Lib\Data\Album)) {
            throw new PageNotFound();
        }

        $pictures = $this->getPictureRepository()->findByAlbumId($album->getId());

        return [
            'pictures' => $pictures,
            'album' => $album,
            'albumHash' => md5($album->getId()),
            'category' => $category
        ];
    }
}
