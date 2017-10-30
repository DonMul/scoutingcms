<?php

namespace Lib\Core;


class SessionMessage
{
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';

    /**
     * @param string $type
     * @param string $message
     */
    public static function addMessage($type, $message)
    {
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }

        if (!isset($_SESSION['messages'][$type])) {
            $_SESSION['messages'][$type] = [];
        }

        $_SESSION['messages'][$type][] = $message;
    }

    /**
     * @return array
     */
    public static function getAllMessages()
    {
        $messages = Util::arrayGet($_SESSION, 'messages');
        $_SESSION['messages'] = [];

        return $messages;
    }
}