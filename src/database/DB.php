<?php

if (!isset($query_builder) OR $query_builder === TRUE) {
    require_once(self::getBasePath() . 'database/DB_query_builder.php');
    if (!class_exists('CI_DB', FALSE)) {

        /**
         * CI_DB
         *
         * Acts as an alias for both CI_DB_driver and CI_DB_query_builder.
         *
         * @see	CI_DB_query_builder
         * @see	CI_DB_driver
         */
        class CI_DB extends CI_DB_query_builder {
            
        }

    }
} elseif (!class_exists('CI_DB', FALSE)) {

    /**
     * @ignore
     */
    class CI_DB extends CI_DB_driver {
        
    }

}