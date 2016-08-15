<?php
/**
* Author: MurDaD
* Author URL: https://github.com/MurDaD
*
* Description: Config file, must be included in every script
*/

use includes\Settings;

date_default_timezone_set('Europe/Kiev');
define('DEBUG', true);

if(DEBUG) {
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set("display_errors", 1);
}

// Check if vendor folder exists
if(!file_exists(dirname(__FILE__).'/vendor/autoload.php')) die ('Please, run \'composer install\' from root dir');
include dirname(__FILE__).'/vendor/autoload.php';

/**
 * Lazy load of app classes
 */
spl_autoload_register(function($class) {
    $map = [
        'includes\DB' => dirname(__FILE__).'/includes/DB.php',
        'includes\Exception' => dirname(__FILE__).'/includes/Exception.php',
        'includes\Settings' => dirname(__FILE__).'/includes/Settings.php',
        'app\Currency' => dirname(__FILE__).'/app/Currency.php',
        'app\CurrencyController' => dirname(__FILE__).'/app/CurrencyController.php',
        'app\Model' => dirname(__FILE__).'/app/Model.php',
        'app\Parser' => dirname(__FILE__).'/app/Parser.php',
    ];
    try {
        include $map[$class];
    } catch (Exception $e) {
        echo $e->getMessage().'. Including '.$class.' from '.$map[$class];
    }
});

// Config DB here
// Default settings
Settings::set('db_host',        'localhost');
Settings::set('db_database',    'currency-ex');
Settings::set('db_user',        'currency-ex');
Settings::set('db_password',    'qwert123');
Settings::set('db_port',        '3306');
Settings::set('lang',           'en_EN');
Settings::set('datetime_format','Y-m-d H:i:s');

include dirname(__FILE__).'/i18n.php';
