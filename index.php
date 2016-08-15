<?php
/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Main application file
 */
include 'config.php';

if(is_string($_GET['currency'])) {
    require_once 'tmp/inner.php';
} else {
    require_once 'tmp/home.php';
}
