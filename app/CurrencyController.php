<?php namespace app;
use includes\DB;
use includes\Settings;

/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Currency Controller Class
 */

class CurrencyController
{

    /**
     * Returns actual latest list of all currencies
     *
     * @return array|bool
     */
    public static function getLatest()
    {
        $res = DB::getInstance()->select(
            'currencies',
            'added IN (SELECT MAX(added) FROM currencies)',
            '*',
            'id ASC');
        return $res;
    }

    /**
     * Returns the latest update date
     *
     * @return mixed
     */
    public static function getLatestDate() {
        $res = DB::getInstance()->query('SELECT MAX(added) FROM currencies')->fetch_row();
        return $res[0];
    }

    public static function getIntervalList($from = '1970-01-01 00:00:00', $to = 0) {
        if($to == 0)
            $to = date(Settings::get('datetime_format'), time());
        $res = DB::getInstance()->select(
            'currencies',
            'added BETWEEN \''.$from.'\' AND \''.$to.'\'',
            '*',
            'id DESC');
        return $res;
    }

    /**
     * Returns detailed list for the current currency
     *
     * @param $bank
     * @param $currency
     * @return array|bool
     */
    public static function getCurrencyDetails($bank, $currency) {
        $bank = addslashes(htmlspecialchars($bank));
        $currency = addslashes(htmlspecialchars($currency));
        $res = DB::getInstance()->select(
            'currencies',
            'bank = \''.$bank.'\' AND currency = \''.$currency.'\'',
            'id, buy, sell, added',
            'added DESC');
        return $res;
    }
}