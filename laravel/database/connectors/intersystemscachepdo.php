<?php namespace Laravel\Database\Connectors;

use PDO;

class IntersystemsCachePDO extends PDO {
    const PDO_STATEMENT_CONFIG_KEY = 'pdo_statement_class';
    const PDO_LOCALES_CONFIG_KEY = 'locales';
    const PDO_ENCODING_CONFIG_KEY = 'encoding';
    const PDO_IS_NOLOCKING_CONFIG_KEY = 'is_nolocking';

    private $_connection_id;
    private $_statement_class = '\Laravel\Database\Connectors\IntersystemsCachePDOStatement';
    private $_is_nolocking = false;

    public function __construct($dsn) {
        $this->_connection_id = odbc_connect($dsn, '', '');
    }

    public function set_statement_class($statement_class) {
        $this->_statement_class = $statement_class;
    }

    public function apply_config($config) {
        // Apply locales
        if (
            isset($config[static::PDO_LOCALES_CONFIG_KEY]) &&
            is_array($config[static::PDO_LOCALES_CONFIG_KEY])
        ) {
            foreach ($config[static::PDO_LOCALES_CONFIG_KEY] as $l) {
                setlocale(LC_ALL, $l[0], $l[1], $l[2]);
            }
        }
        // Initialize converting of coding
        if (
            isset($config[static::PDO_ENCODING_CONFIG_KEY]) &&
            is_string($config[static::PDO_ENCODING_CONFIG_KEY])
        ) {
            list($from, $to) = explode(' ', $config[static::PDO_ENCODING_CONFIG_KEY]);
            $stmt_class = $this->_statement_class;
            $stmt_class::init_iconv($from, $to);
        }
        // Initalize statement class
        if (
            isset($config[static::PDO_STATEMENT_CONFIG_KEY]) &&
            is_string($config[static::PDO_STATEMENT_CONFIG_KEY])
        ) {
            $this->_statement_class = $config[static::PDO_STATEMENT_CONFIG_KEY];
        }
        // Initialize nolock options
        if (isset($config[static::PDO_IS_NOLOCKING_CONFIG_KEY])) {
            $this->_is_nolocking = $config[static::PDO_IS_NOLOCKING_CONFIG_KEY];
        }
    }

    public function prepare($statement, $driver_options = array()) {
        // Apply %NOLOCK to statement
        if ($this->_is_nolocking) {
            $statement = ltrim($statement);
            $k = strpos($statement, ' ');
            $statement = substr($statement, 0, $k).' %NOLOCK'
                .substr($statement, $k);
        }
        $stmt = odbc_prepare($this->_connection_id, $statement);
        return new $this->_statement_class($stmt);
    }

    public function beginTransaction() {
        // TODO: implement it
    }

    public function rollback() {
        // TODO: implement it
    }

    public function commit() {
        // TODO: implement it
    }
}
