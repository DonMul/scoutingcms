<?php

namespace Controller;

/**
 * Class Albums
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Albums extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $category = $this->getAlbumCategoryRepository()->getByName($this->getVariable('category', 0));

        return [
            'albums' => $this->getAlbumRepository()->findPublicByCategory($category->getId()),
            'categories' => $this->getAlbumCategoryRepository()->getAll(),
        ];
    }
}
