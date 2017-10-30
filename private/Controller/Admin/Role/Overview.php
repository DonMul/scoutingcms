<?php
namespace Controller\Admin\Role;

use Controller\Admin;
use Lib\Data\Role;

class Overview extends Admin
{
    public function getArray()
    {
        return [
            'roles' => Role::getAll(),
        ];
    }
}