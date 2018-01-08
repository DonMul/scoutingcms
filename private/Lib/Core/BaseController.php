<?php

namespace Lib\Core;

use Lib\Data\AlbumCategory;
use Lib\Data\Menu;
use Lib\Data\Page;
use Lib\Data\Permission;
use Lib\Data\Speltak;

/**
 * Class BaseController
 * @package Lib\Core
 * @author  Joost Mul <jmul@posd.io>
 */
abstract class BaseController
{
    /**
     * @var bool
     */
    private $requiresLogin = false;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @param boolean $requiresLogin
     */
    protected function setRequiresLogin($requiresLogin)
    {
        $this->requiresLogin = $requiresLogin;
    }

    /**
     * @return boolean
     */
    protected function getRequiresLogin()
    {
        return $this->requiresLogin;
    }

    /**
     *
     */
    protected function validate()
    {

    }

    /**
     * Adds an validation error to the error list. If an empty $message is given, it will be ignored
     *
     * @param string $message
     * @param array  $params
     * @return bool
     */
    protected final function addError($message, $params = [])
    {
        if (empty($message)) {
            return false;
        }

        $this->errors[] = \Lib\Core\Translation::getInstance()->translate($message, $params);
        return true;
    }

    /**
     *
     */
    public function execute()
    {
        // Checks whether or not the user needs to be logged in to view this page. If the user requires to be logged in
        // and he/she is not, a Login page will be shown
        if ($this->getRequiresLogin() === true && \Lib\Core\Session::getInstance()->isLoggedIn() === false) {
            $this->serveTemplate('User/Login.html.twig', []);
            return;
        }

        // Validates and executes the page. If anything goes wrong, or the validation did not pass, an error page will
        // be shown
        try {
            $this->validate();

            if (!empty($this->errors)) {
                $this->showErrorPage($this->errors);
                return;
            }

            $data = $this->getArray();
            $this->serveTemplate(str_replace('Controller\\', '', get_called_class()) . '.html.twig', $data);
        } catch (\Exception $ex) {
            $this->showErrorPage([$ex->getMessage()]);
        }
    }

    /**
     * Shows an error page
     */
    protected function showErrorPage($errors)
    {
        http_response_code(500);
        $this->serveTemplate('error.html.twig', ['errors' => $errors]);
    }

    /**
     * Serves the given template with the given context added to it. The context must consits out of data you want to
     * be available in the FrontEnd
     *
     * @param string $templateLocation
     * @param array  $context
     */
    protected function serveTemplate($templateLocation, $context)
    {
        // Initiates the Twig environment
        require_once LIBROOT . 'Twig/Autoloader.php';
        \Twig_Autoloader::register();

        $loader = new \Twig_Loader_Filesystem(TEMPLATEROOT);
        $twig = new \Twig_Environment($loader, [
            'cache' => false
        ]);

        // Add custom twig functions to this page
        $this->addTwigFunctions($twig);

        // Load Template
        $template = $twig->loadTemplate($templateLocation);

        $array = [
            'context' => $context,
            'languages' => \Lib\Core\Translation::getInstance()->getAllLanguages(),
            'request' => $_GET,
            'loggedIn' => \Lib\Core\Session::getInstance()->isLoggedIn(),
            'language' => \Lib\Core\Translation::getInstance()->getLanguage(),
            'menu' => Menu::getNestedStructure(),
            'pages' => Page::getAll(),
            'groups' => Speltak::getAll(),
            'albumCategories' => AlbumCategory::getAll(),
        ];

        if ($this->getTitle() !== null) {
            $array['title'] = $this->getTitle();
        }

        if ($this->getDescription() !== null) {
            $array['description'] = $this->getDescription();
        }

        if (\Lib\Core\Session::getInstance()->isLoggedIn()) {
            $array['user'] = \Lib\Data\User::getById(\Lib\Core\Session::getInstance()->getKey());
            $array['permissions'] = $this->getPermissions();
        }

        $array = $this->sanitizeContext($array);

        // If the context GET variable is set and the logged in user is an administrator, the context is printed and the
        // template is not executed.
        if (isset($_GET['context'])) {
            echo '<pre>';
            print_r($array);
            echo '</pre>';
            exit;
        }

        // Render the template
        echo $template->render($array);
    }

    /**
     * @return string[]
     */
    private function getPermissions()
    {
        if (\Lib\Core\Session::getInstance()->isLoggedIn() == false) {
            return [];
        }

        if (!isset($_SESSION['permissions'])) {
            $user = \Lib\Data\User::getById(\Lib\Core\Session::getInstance()->getKey());
            $_SESSION['permissions'] = $user->getPermissions();
        }

        return $_SESSION['permissions'];
    }

    /**
     * @param string $permissionName
     * @return bool
     */
    protected function hasPermission($permissionName)
    {
        return in_array($permissionName, $this->getPermissions());
    }

    /**
     * Add custom functions to the twig environment
     *
     * @param \Twig_Environment $twig
     */
    private function addTwigFunctions(\Twig_Environment $twig)
    {
        $translate = new \Twig_SimpleFunction('t', [\Lib\Core\Translation::getInstance(), 'translate']);
        $settings = new \Twig_SimpleFunction('s', [\Lib\Core\Settings::getInstance(), 'get']);
        $translateUrl = new \Twig_SimpleFunction('tl', [\Lib\Core\Translation::getInstance(), 'translateLink']);
        $uploadPath = new \Twig_SimpleFunction('up', [$this, 'uploadPath']);

        $twig->addFunction($translate);
        $twig->addFunction($settings);
        $twig->addFunction($translateUrl);
        $twig->addFunction(new \Twig_SimpleFunction('md5', [$this, 'md5']));
        $twig->addFunction($uploadPath);
    }

    /**
     * @param int $id
     * @param string $type
     * @return string
     */
    public function uploadPath($id, $type)
    {
        $path = '';
        $cdn = Settings::getInstance()->get('cdn');
        switch($type) {
            case 'image':
                $image = \Lib\Data\Picture::getById($id);
                $album = \Lib\Data\Album::getById($image->getAlbumId());
                $category = $album->getCategoryObject();
                $path = $category->getName() . '/' . md5($album->getId()) . '/' . $image->getLocation();
                if (Util::arrayGet($cdn, 'enabled', false) === true) {
                    $path = 'http://' . $cdn['host'] . '/' . $path;
                } else {
                    $path = '/upload/' . $path;
                }
                break;
            case 'albumThumb':
                $album = \Lib\Data\Album::getById($id);
                $path = $album->getCategoryObject()->getName() . '/' . $album->getThumbnail();
                if (Util::arrayGet($cdn, 'enabled', false) === true) {
                    $path = 'http://' . $cdn['host'] . '/' . $path;
                } else {
                    $path = '/upload/' . $path;
                }
                break;
            case 'download':
                $download = \Lib\Data\Download::getById($id);
                $path = $download->getType() . '/' . $download->getFilename();
                if (Util::arrayGet($cdn, 'enabled', false) === true) {
                    $path = 'http://' . $cdn['host'] . '/' . $path;
                } else {
                    $path = '/downloads/' . $path;
                }
        }

        return $path;
    }

    /**
     * @param string $a
     * @return string
     */
    public function md5($a)
    {
        return md5($a);
    }

    /**
     * @return array
     */
    public abstract function getArray();

    /**
     * Sanitizes the content recursively
     *
     * @param array $context
     * @return array
     */
    private function sanitizeContext($context)
    {
        foreach ($context as &$data) {
            if (is_array($data)) {
                $data = $this->sanitizeContext($data);
            } else if (is_object($data)) {
                if (method_exists($data, 'toArray')) {
                    $data = $data->toArray();
                }
            }
        }

        return $context;
    }

    /**
     * @return string
     */
    protected function getTitle()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function getDescription()
    {
        return '';
    }
} 
