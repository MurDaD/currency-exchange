<?php
$langs = [
    'en' => 'en_US',
    'ru' => 'ru_RU',
    'uk' => 'uk_UA'
];
if(!in_array($_GET['lang'], array_keys($langs))) {
    $language = \includes\Settings::get('lang');
} else {
    $language = is_string($_GET['lang']) ? $langs[$_GET['lang']] : \includes\Settings::get('lang');
}
//$language = 'en_US';
$language.= '.UTF-8';

putenv("LC_ALL=" . $language);
setlocale(LC_ALL, $language);

$domain = "messages"; // which language file to use
bindtextdomain($domain, dirname(__FILE__)."/locale");
//bind_textdomain_codeset($domain, 'UTF-8');

textdomain($domain);
