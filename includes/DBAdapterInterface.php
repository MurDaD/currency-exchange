<?php namespace includes;
/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Database Interface
 */

interface DBAdapterInterface
{
    function connect();

    function close();

    function query($query);

    function fetch();

    function select($table, $conditions = '', $fields = '*', $order = '', $limit = null, $offset = null);

    function insert($table, array $data);

    function update($table, array $data, $conditions);

    function delete($table, $conditions);

    function countRows();

    function getAffectedRows();
}