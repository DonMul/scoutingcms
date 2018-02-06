<?php

namespace Controller;

use Lib\Core\Util;

/**
 * Class News
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class News extends \Lib\Core\BaseController
{
    public function getArray()
    {
        $offset = Util::arrayGet($_GET, 'offset', 0);
        $amount = Util::arrayGet($_GET, 'amount', 10);

        $newsArticles = \Lib\Data\News::getLimitedDescending($offset, $amount);
        $total = \Lib\Data\News::getTotalAmount();

        return [
            'articles' => $newsArticles,
            'total' => $total,
        ];
    }
}
