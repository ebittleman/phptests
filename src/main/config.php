<?php

return array(
    'couchdb' => array(
        'dsn' => getenv('COUCHDB_DSN'),
        'db' => getenv('COUCHDB_DB'),
    ),
    'pdo' => array(
        'dsn' => getenv('PDO_DSN'),
        'username' => getenv('PDO_USERNAME'),
        'password' => getenv('PDO_PASSWORD'),
    ),
    'services' => array(
        'phptests\Common\Database\PdoAdapter' => 'phptests\Common\Factory\Database\PdoAdapterFactory',
        'phptests\User\Mapper\UserMapper' => 'phptests\User\Factory\UserMapperFactory',
    )
);
