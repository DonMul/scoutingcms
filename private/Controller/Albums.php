<?php

namespace Controller;
use Lib\Data\AlbumCategory;
use Lib\Exception\PageNotFound;

/**
 * Class Albums
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Albums extends \Lib\Core\BaseController
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

        return [
            'albums' => $this->getAlbumRepository()->findPublicByCategory($category->getId()),
            'categories' => $this->getAlbumCategoryRepository()->getAll(),
        ];
    }
}
