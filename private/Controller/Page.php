<?php

namespace Controller;

/**
 * Class Page
 * @package Controller
 */
class Page extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $page = \Lib\Data\Page::getBySlug($_GET['slug']);

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