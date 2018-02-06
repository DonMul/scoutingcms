<?php

namespace Controller;

/**
 * Class Page
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Page extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $page = $this->getPageRepository()->getBySlug($this->getVariable('slug', ''));

        if (!$page) {
            header("HTTP/1.1 404 Not Found");
            $controller = new FourOFour();
            $controller->execute();
            exit;
        }

        return [
            'page' => $page,
        ];
    }
}
