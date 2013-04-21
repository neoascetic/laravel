<?php namespace Laravel\Database\Connectors;

class IntersystemsCache extends Connector {
    const PDO_CONNECTION_CONFIG_KEY = 'pdo_connection_class';

    public function connect($config)
    {
        extract($config);

        if (isset($config[static::PDO_CONNECTION_CONFIG_KEY])) {
            $pdo_connection_class = $config[static::PDO_CONNECTION_CONFIG_KEY];
        } else {
            $pdo_connection_class = '\Laravel\Database\Connectors\IntersystemsCachePDO';
        }
        $pdo = new $pdo_connection_class($dsn, $username, $password);
        $pdo->apply_config($config);
        return $pdo;
    }
}
