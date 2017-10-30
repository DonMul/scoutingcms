<?php

namespace Controller;

/**
 * Class Index
 * @package Controller
 * @author  Joost Mul <jmul@posd.io>
 */
class Location extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $location = \Lib\Factory::getInstance()->getLocationByName($_GET['location']);
        if (!$location) {
            header('Location: ' . \Lib\Core\Translation::getInstance()->translateLink('index'));
        }

        return [
            'restaurants' => $location->getRestaurants(),
            'location' => $location,
            'locations' => \Lib\Factory::getInstance()->getLocations(),
        ];
    }

    /**
     * @return string
     */
    protected function getTitle()
    {
        return \Lib\Core\Translation::getInstance()->translate("title.index");
    }
} 
