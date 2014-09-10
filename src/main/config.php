<?php

return array(
    'couchdb' => array(
        'dsn' => 'http://127.0.0.1:5984',
        'db' => 'phptests',
    ),
    'pdo' => array(
        'dsn' => 'mysql:host=localhost;port=3380;dbname=phptests',
        'username' => 'root',
        'password' => 'changeme1',
    ),
    'services' => array(
        'phptests\Common\Database\PdoAdapter' => 'phptests\Common\Factory\Database\PdoAdapterFactory',
        'phptests\User\Mapper\UserMapper' => 'phptests\User\Factory\UserMapperFactory',
    )
);
