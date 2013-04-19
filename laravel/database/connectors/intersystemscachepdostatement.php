<?php namespace Laravel\Database\Connectors;

use PDO;
use PDOStatement;

class IntersystemsCachePDOStatement extends PDOStatement {
    private static $_iconv;

    private $_stmt;
    public $is_raw_odbc = true;

    public function __construct($statement) {
        $this->_stmt = $statement;
    }

    private static function encoding($obj, $is_inversion = false, $class = 'stdClass') {
        if (is_null(static::$_iconv)) return $obj;
        list($from, $to) = !$is_inversion ?
            array(static::$_iconv['from'], static::$_iconv['to']) :
            array(static::$_iconv['to'], static::$_iconv['from']);
        if (is_object($obj)) {
            $return = new $class;
            foreach ((array) $obj as $key => $val) {
                $return->$key = iconv($from, $to, $val);
            }
            return $return;
        }
        $return = array();
        foreach ($obj as $key => $val) {
            $return[$key] = iconv($from, $to, $val);
        }
        return $return;
    }

    public function execute($input_params = array()) {
        return (boolean) odbc_execute(
            $this->_stmt, static::encoding($input_params, true));
    }

    public function fetchAll($style = PDO::FETCH_CLASS, $class = 'stdClass', $ctor_args = array()) {
        $return = array();
        if ($style === PDO::FETCH_CLASS) {
            while ($row = odbc_fetch_object($this->_stmt)) {
                $row = static::encoding($row, false, $class);
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
                $return[] = static::encoding($row);
            }
        }
        return $return;
    }

    public static function init_iconv($from, $to) {
        static::$_iconv = array('from' => $from, 'to' => $to);
    }
}

