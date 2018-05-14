<?php
/**
* @copyright Copyright (c) ARONET GmbH (https://aronet.swiss)
* @license AGPL-3.0
*
* This code is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License, version 3,
* as published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License, version 3,
* along with this program.  If not, see <http://www.gnu.org/licenses/>
*
*/

//debug
ini_set('display_errors', "On");
error_reporting(E_ALL);
$debug = new \Phalcon\Debug();
$debug->listen();

// paths
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// try {
    // check the environment
    if(!file_exists(BASE_PATH."/cache/volt")) mkdir(BASE_PATH."/cache/volt",0770,true);
    if(!file_exists(BASE_PATH."/cache/pdf")) mkdir(BASE_PATH."/cache/pdf",0770,true);
    if(!file_exists(BASE_PATH."/logs")) mkdir(BASE_PATH."/logs",0770,true);
    if(!file_exists(APP_PATH."/config/keys")) mkdir(APP_PATH."/config/keys",0770,true);
    if(!file_exists(APP_PATH."/mail")) mkdir(APP_PATH."/mail",0770,true);
    if(!file_exists(APP_PATH."/views/templates")) mkdir(APP_PATH."/views/templates",0770,true);
    if(!file_exists(APP_PATH."/views/partials")) mkdir(APP_PATH."/views/partials",0770,true);
    if(!file_exists(APP_PATH."/views/templates/core")) symlink("../../../vendor/rnt-forest/core/views/templates",APP_PATH."/views/templates/core");
    if(!file_exists(APP_PATH."/views/partials/core")) symlink("../../../vendor/rnt-forest/core/views",APP_PATH."/views/partials/core");
    if(!file_exists(APP_PATH."/views/partials/dns")) symlink("../../../vendor/rnt-forest/dns/views",APP_PATH."/views/partials/dns");
    
    // Bootstrap
    include APP_PATH . "/config/bootstrap.php";
    
    // Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    // NGINX - PHP-FPM already set PATH_INFO variable to handle route
    echo $application->handle(!empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : null)->getContent();
   
/*   
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
*/