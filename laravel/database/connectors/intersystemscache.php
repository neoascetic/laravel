<?php namespace Laravel\Database\Connectors;

class IntersystemsCache extends Connector {
    const PDO_CONNECTION_CONFIG_KEY = 'pdo_connection_class';
    const PDO_STATEMENT_CONFIG_KEY = 'pdo_statement_class';

    public function connect($config)
    {
        extract($config);

        if (isset($config[static::PDO_CONNECTION_CONFIG_KEY])) {
            $pdo_connection_class = $config[static::PDO_CONNECTION_CONFIG_KEY];
        } else {
            $pdo_connection_class = '\Laravel\Database\Connectors\IntersystemsCachePDO';
        }
        if (isset($config[static::PDO_STATEMENT_CONFIG_KEY])) {
            $statement_class = $config[static::PDO_STATEMENT_CONFIG_KEY];
        } else {
            $statement_class = '\Laravel\Database\Connectors\IntersystemsCachePDOStatement';
        }

        $pdo = new $pdo_connection_class($dsn, $username, $password);
        $pdo->set_statement_class($statement_class);
        static::after_connection($pdo, $config);

        return $pdo;
    }

    public static function after_connection($pdo, $config) {}
}
