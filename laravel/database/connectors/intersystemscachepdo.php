<?php namespace Laravel\Database\Connectors;

use PDO;

class IntersystemsCachePDO extends PDO {
    private $_connection_id;

    public function __construct($dsn, $username = '', $password = '') {
        $this->_connection_id = @odbc_connect($dsn, $username, $password);
        if (!$this->_connection_id) {
            throw new \PDOException("Cann\'t set connection with $dsn");
        }
    }

    public function set_statement_class($statement_class) {
        $this->_statement_class = $statement_class;
    }

    public function set_preparing_fetched_row_function(\Closure $closure) {
        $class = $this->_statement_class;
        $class::set_preparing_fetched_row_function($closure);
    }

    public function set_prepare_bindings_function(\Closure $closure) {
        $class = $this->_statement_class;
        $class::set_prepare_bindings_function($closure);
    }

    public function prepare($statement, $driver_options = array()) {
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
