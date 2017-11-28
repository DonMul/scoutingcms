<?php
require_once realpath(__DIR__ . '/../private/bootstrap.php');

$s = \Lib\Core\Settings::getInstance();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $settings = [
        'database' => [
            'username'  => \Lib\Core\Util::arrayGet($_POST, 'dbUsername'),
            'password'  => \Lib\Core\Util::arrayGet($_POST, 'dbPassword'),
            'host'      => \Lib\Core\Util::arrayGet($_POST, 'dbHost'),
            'database'  => \Lib\Core\Util::arrayGet($_POST, 'dbDatabase'),
            'prefix'    => \Lib\Core\Util::arrayGet($_POST, 'dbPrefix'),
        ],
        'ssl' => isset($_POST['sslEnabled']),
        'google-analytics' => strtoupper(\Lib\Core\Util::arrayGet($_POST, 'gaCode')),
        'google-tagmanager' => strtoupper(\Lib\Core\Util::arrayGet($_POST, 'gtmCode')),
    ];

    $mysqli = mysqli_init();
    $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
    $canConnect = $mysqli->real_connect(
        $settings['database']['host'],
        $settings['database']['username'],
        $settings['database']['password'],
        $settings['database']['database']
    );

    if (!$canConnect) {
        $errors[] = "Invalid Database Credentials";
    }

    if (!empty($settings['google-analytics']) && !preg_match('/^UA-[A-Z0-9]{5}-[A-Z0-9]$/', $settings['google-analytics'])) {
        $errors[] = "Invalid Google Analytics code. It should be formatted as follows: UA-XXXXX-Y";
    }

    if (!empty($settings['google-tagmanager']) && !preg_match('/^GTM-[A-Z0-9]{6}$/', $settings['google-tagmanager'])) {
        $errors[] = "Invalid Google TagManager code. It should be formatted as follows: GTM-XXXXXX";
    }

    if ((!isset($_POST['adminUser']) || empty($_POST['adminUser'])) || (!isset($_POST['adminPassword']) || empty($_POST['adminPassword']))) {
        $errors[] = "Invalid Admin Username and password given";
    }

    if (empty($errors)) {
        $settingsString = \Symfony\Component\Yaml\Yaml::dump($settings);
        if (file_exists(CONFROOT . 'settings.yaml')) {
            unlink(CONFROOT . 'settings.yaml');
        }

        file_put_contents(CONFROOT . 'settings.yaml', $settingsString);

        $s->overrideSettings($settings);
        $sql = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'db.sql');
        $seperated = preg_split("#\n\s*\n#Uis", $sql);
        foreach ($seperated as $table) {
            if (preg_match('/^--/', $table)) {
                continue;
            }

            $part = preg_replace(
                '/CREATE TABLE IF NOT EXISTS `/',
                'CREATE TABLE IF NOT EXISTS `' . $settings['database']['prefix'],
                $table
            );

            $part = preg_replace(
                '/ALTER TABLE `/',
                'ALTER TABLE `' . $settings['database']['prefix'],
                $table
            );

            \Lib\Core\Database::getInstance()->query($part);
        }

        $user = new \Lib\Data\User(
            null,
            \Lib\Core\Util::arrayGet($_POST, 'adminUser'),
            \Lib\Core\Util::arrayGet($_POST, 'adminPassword'),
            \Lib\Core\Util::arrayGet($_POST, 'adminUser'),
            ''
        );

        $user->save();
        header('Location: /');
    }
}
?>

    <html>
    <head>
        <title>Install ScoutingCMS</title>
        <link rel="stylesheet" type="text/css" href="/css/compiled.php"/>
    </head>
    </html>

    <div class="container">
        <h1 class="text-center">Install ScoutingCMS</h1>
        <?php if (count($errors) > 0): ?>
            <h3 class="text-center">The install script has encountered some errors</h3>
            <?php foreach ($errors as $error): ?>
                <div class="install__error">
                    <?= $error ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div>
            * required fields
        </div>
        <form method="post">
            <div class="install-section">
                <h2 class="install-section__header">Database</h2>
                <div class="install-section__form">
                    <div class="install-section__field <?= requiredIsset('dbUsername') ?>">
                        <label for="dbUsername" class="install-section__label">
                            Username *
                        </label>
                        <input type="text" class="install-section__input" name="dbUsername" id="dbUsername"
                               value="<?= $s->get(['database', 'username']) ?>"/>
                    </div>
                    <div class="install-section__field">
                        <label for="dbPassword" class="install-section__label">
                            Password
                        </label>
                        <input type="password" class="install-section__input" name="dbPassword" id="dbPassword"/>
                    </div>
                    <div class="install-section__field <?= requiredIsset('dbHost') ?>">
                        <label for="dbHost" class="install-section__label">
                            Host *
                        </label>
                        <input type="text" class="install-section__input" name="dbHost" id="dbHost"
                               value="<?= $s->get(['database', 'host'], 'localhost') ?>"/>
                    </div>
                    <div class="install-section__field <?= requiredIsset('dbDatabase') ?>">
                        <label for="dbDatabase" class="install-section__label">
                            Database *
                        </label>
                        <input type="text" class="install-section__input" name="dbDatabase" id="dbDatabase"
                               value="<?= $s->get(['database', 'database']) ?>"/>
                    </div>
                    <div class="install-section__field">
                        <label for="dbPrefix" class="install-section__label">
                            Table Prefix
                        </label>
                        <input type="text" class="install-section__input" name="dbPrefix" id="dbPrefix"
                               value="<?= $s->get(['database', 'prefix']) ?>"/>
                    </div>
                </div>
            </div>

            <div class="install-section">
                <h2 class="install-section__header">Admin User</h2>
                <div class="install-section__form">
                    <div class="install-section__field <?= requiredIsset('adminUser') ?>">
                        <label for="adminUser" class="install-section__label">
                            Admin Username *
                        </label>
                        <input type="text" class="install-section__input" name="adminUser" id="adminUser"/>
                    </div>
                    <div class="install-section__field <?= requiredIsset('adminPassword') ?>">
                        <label for="adminPassword" class="install-section__label">
                            Admin Password *
                        </label>
                        <input type="password" class="install-section__input" name="adminPassword" id="adminPassword"/>
                    </div>
                </div>
            </div>

            <div class="install-section">
                <h2 class="install-section__header">Site settings</h2>
                <div class="install-section__form">
                    <div class="install-section__field">
                        <label for="sslEnabled" class="install-section__label">
                            SSL Enabled / forced
                        </label>
                        <input type="checkbox" class="install-section__input" name="sslEnabled" id="sslEnabled"
                               <?= $s->get(['ssl'], false) == true ? 'checked="checked"' : '' ?>"/>
                    </div>
                </div>
            </div>

            <div class="install-section">
                <h2 class="install-section__header">Tracking</h2>
                <div class="install-section__form">
                    <div class="install-section__field">
                        <label for="gaCode" class="install-section__label">
                            Google Analytics UA-Code
                        </label>
                        <input type="text" class="install-section__input" name="gaCode" id="gaCode"
                               value="<?= $s->get(['google-analytics']) ?>"/>
                    </div>
                    <div class="install-section__field">
                        <label for="gtmCode" class="install-section__label">
                            Google TagManager GTM-Code
                        </label>
                        <input type="text" class="install-section__input" name="gtmCode" id="gtmCode"
                               value="<?= $s->get(['google-tagmanager']) ?>"/>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary install__button" type="submit">
                Install
            </button>
        </form>
    </div>

<?php
function requiredIsset($name)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return '';
    }

    if (!isset($_POST[$name]) || empty($_POST[$name])) {
        return 'install-section__field--required';
    }
}

?>