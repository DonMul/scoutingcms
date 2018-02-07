<?php

namespace Controller;

use Lib\Exception\PageNotFound;

/**
 * Class NewsItem
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class NewsItem extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $newsItem = $this->getNewsRepository()->getById($this->getVariable('id', 0));

        if (!($newsItem instanceof \Lib\Data\News)) {
            throw new PageNotFound();
        }

        return [
            'article' => $newsItem,
        ];
    }
}
