<?php namespace app;
use includes\DB;

/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Users Class. All the logic goes here
 * Type:
 */

class Currency extends Model
{
    protected $_table = 'currencies';                       // Table name

    /**
     * Currency constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        parent::__construct();
        if($id && is_numeric($id)) {
            return parent::find($id);
        } else {
            return $this;
        }
    }
}