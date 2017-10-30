<?php

namespace Controller;

/**
 * Class Restaurant
 * @package Controller
 */
class Restaurant extends \Lib\Core\BaseController
{
    public function getArray()
    {
        $restaurant = $_GET['restaurant'];
        $restaurant = \Lib\Factory::getInstance()->getRestaurantByName($restaurant);
        $food = $restaurant->getFood();

        return [
            'restaurant' => $restaurant,
        ];
    }
}