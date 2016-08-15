<?php
include dirname(__FILE__).'/../config.php';

set_time_limit(0);

$parser = new \app\Parser('http://bpteam.net/currency.zip', dirname(__FILE__), 'currency.txt');
$data = $parser->getZipData();
unset($parser);

// Starting transaction
\includes\DB::getInstance()->transaction_start('write');

$added = date(\includes\Settings::get('datetime_format'), time());
foreach ($data as $bank => $currencies) {
    foreach ($currencies as $curr => $type) {
        $currency = new \app\Currency();
        $currency->bank = $bank;
        $currency->currency = $curr;
        $currency->sell = $type['sell'];
        $currency->buy = $type['buy'];
        $currency->added = $added;
        $currency->save();
    }
}

// Commit transaction
\includes\DB::getInstance()->transaction_commit();
