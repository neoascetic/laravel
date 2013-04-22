<?php namespace Laravel\Database\Connectors;

use PDO;
use PDOStatement;

class IntersystemsCachePDOStatement extends PDOStatement {
    private static $_preparing_fetched_row_function;
    private static $_preparing_bindings_function;

    private $_stmt;

    public function __construct($statement) {
        $this->_stmt = $statement;
    }

    public function execute($bindings = array()) {
        $f = static::$_preparing_bindings_function;
        if (is_callable($f)) $bindings = $f($bindings);
        return (boolean) odbc_execute($this->_stmt, $bindings);
    }

    public function fetchAll($style = PDO::FETCH_CLASS, $class = 'stdClass', $ctor_args = array()) {
        $return = array();
        $f = static::$_preparing_fetched_row_function;
        if ($style === PDO::FETCH_CLASS) {
            while ($row = odbc_fetch_object($this->_stmt)) {
                if (is_callable($f)) $row = $f($row, $class);
                if (!$row instanceof $class) {
                    $tmp = $row;
                    $row = new $class;
                    foreach ((array) $tmp as $key => $val) {
                        $row->$key = $val;
                    }
                }
                $return[] = $row;
            }
        } else {
            while ($row = odbc_fetch_array($this->_stmt)) {
                if (is_callable($f)) $row = $f($row, $class);
                $return[] = $row;
            }
        }
        return $return;
    }

    public static function set_prepare_bindings_function(\Closure $closure) {
        static::$_preparing_bindings_function = $closure;
    }

    public static function set_preparing_fetched_row_function(\Closure $closure) {
        static::$_preparing_fetched_row_function = $closure;
    }
}

