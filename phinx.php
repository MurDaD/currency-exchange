<?php
include 'config.php';
use includes\Settings;
return array(
    "paths" => array(
        "migrations" => "%%PHINX_CONFIG_DIR%%/db/migrations",
        "seeds" => "%%PHINX_CONFIG_DIR%%/db/seeds"
    ),
    "environments" => array(
        "default_migration_table" => "phinxlog",
        "default_database" => "dev",
        "dev" => array(
            "adapter" => "mysql",
            "host" => Settings::get('db_host'),
            "name" => Settings::get('db_database'),
            "user" => Settings::get('db_user'),
            "pass" => Settings::get('db_password'),
            "port" => Settings::get('db_port')
        )
    )
);
?>