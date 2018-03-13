<?php

namespace Lib\Core\BaseController;

/**
 * Class Ajax
 * @package Lib\Core\BaseController
 * @author Joost Mul <scoutingcms@jmul.net>
 */
abstract class Ajax extends \Lib\Core\BaseController
{
    /**
     *
     */
    public function execute()
    {
        // Checks whether or not the user needs to be logged in to view this page. If the user requires to be logged in
        // and he/she is not, a Login page will be shown
        if ($this->getRequiresLogin() === true && \Lib\Core\Session::getInstance()->isLoggedIn() === false) {
            $this->output(false, [], []);
        }

        // Validates and executes the page. If anything goes wrong, or the validation did not pass, an error page will
        // be shown
        try {
            $this->validate();

            if (!empty($this->errors)) {
                $this->output(false, [], $this->errors);
            }

            $data = $this->getArray();
            $this->output(true, $data, []);
        } catch (\Exception $ex) {
            $this->output(false, [], [$ex->getMessage()]);
        }
    }

    /**
     * @param bool  $success
     * @param array $data
     * @param array $errors
     */
    private function output($success, $data, $errors)
    {
        echo json_encode([
            'success' => !!$success,
            'faults' => $errors,
            'response' => $data,
        ]);

        exit;
    }

    /**
     * @param string|array $value
     * @return mixed
     */
    protected function getPostValue($value)
    {
        return \Lib\Core\Util::arrayGet($_POST, $value);
    }
}
