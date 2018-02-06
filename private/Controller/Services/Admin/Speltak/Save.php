<?php

namespace Controller\Services\Admin\Speltak;

use Lib\Core\Imager;
use Lib\Core\Translation;
use Lib\Data\Speltak;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Save extends \Controller\Services\Admin
{
    /**
     * @throws \Exception
     */
    public function getArray()
    {
        $speltakId = $this->getPostValue('speltakId');
        $speltak = Speltak::getById($speltakId);
        if (!($speltak instanceof Speltak)) {
            throw new \Exception(Translation::getInstance()->translate('error.group.notFound'));
        }

        $this->ensurePermission('group.' . $speltak->getName() . '.edit');

        $speltak->setDescription($this->getPostValue('description'));

        if (!empty($_FILES['picture']['name'])) {
            $exploded = explode('.', $_FILES['picture']['name']);
            $type = array_pop($exploded);
            $targetName = $_SERVER["DOCUMENT_ROOT"] . '/public/upload/' . $speltak->getName() . '.' . $type;

            $imager = new Imager();
            $imager->uploadImage($_FILES['picture']['tmp_name'], $targetName);

            $speltak->setPicture($speltak->getName() . '.' . $type);
        }

        $speltak->save();

        return [
            'redirect' => Translation::getInstance()->translateLink("adminGroups")
        ];
    }
}
