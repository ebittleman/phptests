<?php
namespace phptests\Common\Factory\Database;

use phptests\Common\Factory\FactoryInterface;
use phptests\Common\Di\ServiceLocatorInterface;
use phptests\Common\Database\PdoAdapter;

class PdoAdapterFactory implements FactoryInterface
{
    public function getInstance(ServiceLocatorInterface $sm)
    {
        $config = $sm->get('Config');

        if (
            empty($config['pdo']['dsn']) ||
            empty($config['pdo']['username']) ||
            empty($config['pdo']['password'])
        ) {
            throw new Exception('Missing Required Settings For PDO');
        }

        return new PdoAdapter($config['pdo']['dsn'], $config['pdo']['username'], $config['pdo']['password']);
    }
}
