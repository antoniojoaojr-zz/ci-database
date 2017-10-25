<?php

namespace CI;

/**
 * @author Antônio Junior
 */
class DatabaseLanguage {

    protected static $db_invalid_connection_str = 'Unable to determine the database settings based on the connection string you submitted.';
    protected static $db_unable_to_connect = 'Unable to connect to your database server using the provided settings.';
    protected static $db_unable_to_select = 'Unable to select the specified database: %s';
    protected static $db_unable_to_create = 'Unable to create the specified database: %s';
    protected static $db_invalid_query = 'The query you submitted is not valid.';
    protected static $db_must_set_table = 'You must set the database table to be used with your query.';
    protected static $db_must_use_set = 'You must use the "set" method to update an entry.';
    protected static $db_must_use_index = 'You must specify an index to match on for batch updates.';
    protected static $db_batch_missing_index = 'One or more rows submitted for batch updating is missing the specified index.';
    protected static $db_must_use_where = 'Updates are not allowed unless they contain a "where" clause.';
    protected static $db_del_must_use_where = 'Deletes are not allowed unless they contain a "where" or "like" clause.';
    protected static $db_field_param_missing = 'To fetch fields requires the name of the table as a parameter.';
    protected static $db_unsupported_function = 'This feature is not available for the database you are using.';
    protected static $db_transaction_failure = 'Transaction failure: Rollback performed.';
    protected static $db_unable_to_drop = 'Unable to drop the specified database.';
    protected static $db_unsupported_feature = 'Unsupported feature of the database platform you are using.';
    protected static $db_unsupported_compression = 'The file compression format you chose is not supported by your server.';
    protected static $db_filepath_error = 'Unable to write data to the file path you have submitted.';
    protected static $db_invalid_cache_path = 'The cache path you submitted is not valid or writable.';
    protected static $db_table_name_required = 'A table name is required for that operation.';
    protected static $db_column_name_required = 'A column name is required for that operation.';
    protected static $db_column_definition_required = 'A column definition is required for that operation.';
    protected static $db_unable_to_set_charset = 'Unable to set client connection character set: %s';
    protected static $db_error_heading = 'A Database Error Occurred';

    public function line($line) {
        return self::${$line};
    }

}
