<?php

namespace CI;

defined('BASEPATH') OR define('BASEPATH', '');

/**
 * @author Antônio Junior
 */
class Database {

    private static $configFile;
    private static $instance;

    public static function getConfigFile() {
        if (self::$configFile == null) {
            throw new \Exception("You need set the configuration file with the DatabaseLoader::setConfigFile(\"path to you file configuration\")");
        }

        return self::$configFile;
    }

    public static function setConfigFile($configFile) {
        if (!file_exists($configFile)) {
            throw new \Exception("The configuration file $configFile does not exist.");
        }

        self::$configFile = $configFile;
    }

    public static function getBasePath() {
        return str_replace("\\", "/", __DIR__)."/";
    }

    /**
     * 
     * @return \CI_DB_query_builder
     */
    public static function init($params = '', $query_builder_override = NULL) {
        // Load the DB config file if a DSN string wasn't passed
        if (is_string($params) && strpos($params, '://') === FALSE) {
            include(self::getConfigFile());

            if (!isset($db) OR count($db) === 0) {
                throw new \Exception('No database connection settings were found in the database config file.');
            }

            if ($params !== '') {
                $active_group = $params;
            }

            if (!isset($active_group)) {
                throw new \Exception('You have not specified a database connection group via $active_group in your config file.');
            } elseif (!isset($db[$active_group])) {
                throw new \Exception('You have specified an invalid database connection group (' . $active_group . ') in your config file.');
            }

            $params = $db[$active_group];
        } elseif (is_string($params)) {
            /**
             * Parse the URL from the DSN string
             * Database settings can be passed as discreet
             * parameters or as a data source name in the first
             * parameter. DSNs must have this prototype:
             * $dsn = 'driver://username:password@hostname/database';
             */
            if (($dsn = @parse_url($params)) === FALSE) {
                throw new \Exception('Invalid DB Connection String');
            }

            $params = array(
                'dbdriver' => $dsn['scheme'],
                'hostname' => isset($dsn['host']) ? rawurldecode($dsn['host']) : '',
                'port' => isset($dsn['port']) ? rawurldecode($dsn['port']) : '',
                'username' => isset($dsn['user']) ? rawurldecode($dsn['user']) : '',
                'password' => isset($dsn['pass']) ? rawurldecode($dsn['pass']) : '',
                'database' => isset($dsn['path']) ? rawurldecode(substr($dsn['path'], 1)) : ''
            );

            // Were additional config items set?
            if (isset($dsn['query'])) {
                parse_str($dsn['query'], $extra);

                foreach ($extra as $key => $val) {
                    if (is_string($val) && in_array(strtoupper($val), array('TRUE', 'FALSE', 'NULL'))) {
                        $val = var_export($val, TRUE);
                    }

                    $params[$key] = $val;
                }
            }
        }

        // No DB specified yet? Beat them senseless...
        if (empty($params['dbdriver'])) {
            throw new \Exception('You have not selected a database type to connect to.');
        }

        // Load the DB classes. Note: Since the query builder class is optional
        // we need to dynamically create a class that extends proper parent class
        // based on whether we're using the query builder class or not.
        if ($query_builder_override !== NULL) {
            $query_builder = $query_builder_override;
        }
        // Backwards compatibility work-around for keeping the
        // $active_record config variable working. Should be
        // removed in v3.1
        elseif (!isset($query_builder) && isset($active_record)) {
            $query_builder = $active_record;
        }

        require_once(self::getBasePath() . 'database/DB_driver.php');
        require_once(self::getBasePath() . 'database/DB.php');


        // Load the DB driver
        $driver_file = self::getBasePath() . 'database/drivers/' . $params['dbdriver'] . '/' . $params['dbdriver'] . '_driver.php';

        if (!file_exists($driver_file))
            throw new \Exception('Invalid DB driver');

        require_once($driver_file);

        // Instantiate the DB adapter
        $driver = 'CI_DB_' . $params['dbdriver'] . '_driver';
        $DB = new $driver($params);

        // Check for a subdriver
        if (!empty($DB->subdriver)) {
            $driver_file = self::getBasePath() . 'database/drivers/' . $DB->dbdriver . '/subdrivers/' . $DB->dbdriver . '_' . $DB->subdriver . '_driver.php';

            if (file_exists($driver_file)) {
                require_once($driver_file);
                $driver = 'CI_DB_' . $DB->dbdriver . '_' . $DB->subdriver . '_driver';
                $DB = new $driver($params);
            }
        }

        $DB->initialize();
        self::$instance = $DB;
        return self::$instance;
    }

    /**
     * 
     * @return \CI_DB_query_builder
     */
    public static function get() {
        if (self::$instance == null) {
            self::init();
        }

        return self::$instance;
    }

}
