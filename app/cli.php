<?php

use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Logger as Logger;
use Phalcon\Logger\Adapter\File as LoggerFileAdapter;
use Phalcon\Cli\Console as ConsoleApp;
use Phalcon\Loader;

// paths
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Using the CLI factory default services container
$di = new CliDI();

// Shared configuration service
$di->setShared('config', function () {
    $config = include APP_PATH . "/config/config.php";
    $config->merge(include APP_PATH . "/config/permissionbase.php");
    $config->merge(include BASE_PATH . "/vendor/rnt-forest/core/config/permissionbase.php");
    $config->merge(include BASE_PATH . "/vendor/rnt-forest/dns/config/permissionbase.php");
    
    if (is_readable(APP_PATH . '/config/config.ini')) {
        $override = new ConfigIni(APP_PATH . '/config/config.ini');
        $config->merge($override);
    }

    return $config;
});


// Database connection is created based in the parameters defined in the configuration file
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);
    
    // DB logs
    $eventsManager = new Phalcon\Events\Manager();
    $logger = new \Phalcon\Logger\Adapter\File($config->application->logsDir."cli_db.log");
    
    //Listen all the database events
    if($config->application->mode == 'debug'){
        $eventsManager->attach('db', function($event, $connection) use ($logger) {
            if ($event->getType() == 'beforeQuery') {
                $sqlVariables = $connection->getSQLVariables();
                if (count($sqlVariables)) {
                    $logger->log($connection->getSQLStatement() . ' ' . join(', ', $sqlVariables), Logger::INFO);
                } else {
                    $logger->log($connection->getSQLStatement(), Logger::INFO);
                }
            }
        });
    }

    //Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);    
    
    return $connection;
});

// Session
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

// Translation
$di->setShared('translate', function() use($di) {
    $config = $this->getConfig();
    require $config->application['messagesDir']."en.php";
    return new \Phalcon\Translate\Adapter\NativeArray(array(
        "content" => $messages
    ));
});

// Logger
$di->setShared('logger', function() {
    $config = $this->getConfig();
    $logger = new LoggerFileAdapter($config->application->logsDir."cli.log");
    $loglevel = $config->application->logLevel;
    if($config->application->mode == 'debug') $loglevel = Logger::DEBUG;
    $logger->setLogLevel($loglevel);
    return $logger;
});


// Push
$di->setShared('push', function() use ($di) {
    $push = new \RNTForest\core\services\Push($di);
    return $push;
});

// Permissions
$di->setShared('permissions', function() {
    $permissions = new \RNTForest\core\libraries\Permissions();
    return $permissions;
});

// Models Manager (used for PHQL)
$di->set('modelsManager', function() {
    return new \Phalcon\Mvc\Model\Manager();
});

/**
* Register the autoloader
*/
$loader = new Loader();

$loader->registerDirs([
    __DIR__ . "/tasks",
    __DIR__ . "/../vendor/rnt-forest/core/tasks",
]);

$loader->registerNamespaces(array(
    "RNTForest\\core\\models" => APP_PATH . "/models/core/",
    "RNTForest\\dns\\models" => APP_PATH . "/models/dns/",
));

$loader->registerNamespaces([
    // DNSCP
    "RNTForest\\DNSCP\\controllers" => APP_PATH . "/controllers/",
    "RNTForest\\DNSCP\\models" => APP_PATH . "/models/",
    "RNTForest\\DNSCP\\forms" => APP_PATH . "/forms/",
    "RNTForest\\DNSCP\\libraries" => APP_PATH . "/libraries/",

    // core
    "RNTForest\\core\\controllers" => BASE_PATH . "/vendor/rnt-forest/core/controllers/",
    "RNTForest\\core\\models" => BASE_PATH . "/vendor/rnt-forest/core/models/",
    "RNTForest\\core\\forms" => BASE_PATH . "/vendor/rnt-forest/core/forms/",
    "RNTForest\\core\\services" => BASE_PATH . "/vendor/rnt-forest/core/services/",
    "RNTForest\\core\\libraries" => BASE_PATH . "/vendor/rnt-forest/core/libraries/",
    "RNTForest\\core\\interfaces" => BASE_PATH . "/vendor/rnt-forest/core/interfaces/",
    "RNTForest\\core\\plugins" => BASE_PATH . "/vendor/rnt-forest/core/plugins/",

    // dns
    "RNTForest\\dns\\controllers" => BASE_PATH . "/vendor/rnt-forest/dns/controllers/",
    "RNTForest\\dns\\models" => BASE_PATH . "/vendor/rnt-forest/dns/models/",
    "RNTForest\\dns\\forms" => BASE_PATH . "/vendor/rnt-forest/dns/forms/",
    "RNTForest\\dns\\services" => BASE_PATH . "/vendor/rnt-forest/dns/services/",
],true);
$loader->register();


// Create a console application
$console = new ConsoleApp();
$console->setDI($di);

/**
* Process the console arguments
*/
$arguments = [];
foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments["task"] = $arg;
    } elseif ($k === 2) {
        $arguments["action"] = $arg;
    } elseif ($k >= 3) {
        $arguments["params"][] = $arg;
    }
}

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();
    exit(255);
}

