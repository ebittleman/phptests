<?php
namespace phptests\Common\Factory\Database;

use phptests\Common\Factory\FactoryInterface;
use phptests\Common\Di\ServiceLocatorInterface;
use phptests\Common\Database\PdoAdapter;
use \Exception;

class PdoAdapterFactory implements FactoryInterface
{
    public function getInstance(ServiceLocatorInterface $sm)
    {
        $config = $sm->get('Config');

        if (
            empty($config['pdo']['dsn']) ||
            !isset($config['pdo']['username']) ||
            !isset($config['pdo']['password'])
        ) {
            throw new Exception('Missing Required Settings For PDO');
        }

        return new PdoAdapter($config['pdo']['dsn'], $config['pdo']['username'], $config['pdo']['password']);
    }
}
