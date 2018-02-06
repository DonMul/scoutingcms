<?php

namespace Controller;

/**
 * Class News
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class News extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $newsArticles = $this->getNewsRepository()->getLimitedDescending(
            $this->getVariable('offset', 0),
            $this->getVariable('amount', 10)
        );
        $total = $this->getNewsRepository()->getTotalAmount();

        return [
            'articles' => $newsArticles,
            'total' => $total,
        ];
    }
}
