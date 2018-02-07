<?php

namespace Controller;

use Lib\Exception\PageNotFound;

/**
 * Class Page
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Page extends \Lib\Core\BaseController
{
    /**
     * @return array
     * @throws PageNotFound
     */
    public function getArray()
    {
        $page = $this->getPageRepository()->getBySlug($this->getVariable('slug', ''));

        if (!($page instanceof \Lib\Data\Page)) {
            throw new PageNotFound();
        }

        return [
            'page' => $page,
        ];
    }
}
