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

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => '',
        'password'    => '',
        'dbname'      => '',
        'charset'     => 'utf8',
    ],
    'application' => [
        'mode'                  => 'production', // or debug
        'appDir'                => APP_PATH . '/',
        'viewsDir'              => APP_PATH . '/views/',
        'messagesDir'           => APP_PATH . '/messages/',
        'cacheDir'              => BASE_PATH . '/cache/volt/',
        'pdfDir'                => BASE_PATH . '/cache/pdf/',
        'mailTemplateDir'       => APP_PATH . '/mail/',
        'logsDir'               => BASE_PATH . '/logs/',
        'vendorDir'             => BASE_PATH . '/vendor/',
        'baseUrl'               => 'baseUrl: to define in config.ini',  
        'baseUri'               => '/',
        'appBaseNamespaceName'  => "\\RNTForest\\DNSCP\\",
        'appTitle'              => 'DNS Control Panel',
        'appName'               => 'dns-control-panel',
        'securitySalt'          => '',
        'hashTokenExpiryHours'  => 4,
        'logLevel'              => \Phalcon\Logger::DEBUG,
    ],
    'push' => [
        'adminpublickeyfile'    => APP_PATH."/config/keys/public.pem",
        'adminprivatekeyfile'   => APP_PATH."/config/keys/private.key",
    ],
    'jobsystem' => [
        'prefix'                => 'rnt', // used for service name in the jobsystem
        'poolserver'            => 'pool.domain.org',
    ],
    'jobs' => [
        'invisible' => [  // used to set some jobtypes with certain state to invisible in view, e.g. general_test_sendmail => [1,-1]
        ],
    ],
    'pdf' => [
        'author' => "RNT Forest",
        'logo' => "/public/img/OpenVZ.png",
        'footer' => "My PDF Footer",
    ],
    'mail' => [
        'from' => "dnscp@domain.org",
    ],
]);
