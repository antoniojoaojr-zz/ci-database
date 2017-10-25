<?php

// include composer
include 'vendor/autoload.php';

// set the config file of the database
CI\Database::setConfigFile('config-database.php');
// load the database components according you config file
CI\Database::init();

// use
// like codeigniter but
// $this->db, transform to CI\Database::get()

$normal_query = CI\Database::get()->query("SELECT * FROM users");

// active record query
$active_record = CI\Database::get()->where("user_id", 1)
                ->get("users")->row();

echo $active_record->name;

/**
 * 
 * QUERY ERROS GENERATE A DatabaseException
 * LIKE:
 * 
 */
try {
    $active_record = CI\Database::get()->where("user_id", 1)->get("useres")->row();
} catch (\CI\DatabaseException $ex) {
    // throw you error here
    $ex->getHeading(); // heading error
    $ex->getMessage(); // message error
}