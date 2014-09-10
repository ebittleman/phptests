<?php

namespace phptests;

use couchClient;
use PDO;
use phptests\Common\Di\ServiceLocator;
use phptests\Common\Di\ServiceLocatorInterface;
use \Exception;

class Module
{
    public function init()
    {
        $config = $this->getConfig();

        $serviceLocator = new ServiceLocator(array(
            'Config' => function(ServiceLocatorInterface $sm) use ($config)
            {
                return $config;
            }
        ));

        if (isset($config['services'])) {
            $serviceLocator->loadConfig($config['services']);
        }

        $serviceLocator->loadConfig($this->getServices());

        return $serviceLocator;
    }

    public function getConfig()
    {
        return include (dirname(__FILE__) . '/config.php');
    }

    public function getServices()
    {
        return array(
            'couchClient' => function(ServiceLocatorInterface $sm)
            {
                $config = $sm->get('Config');

                if (empty($config['couchdb']['dsn']) || empty($config['couchdb']['db']))
                {
                    throw new Exception('Missing Required Settings For CouchDB');
                }

                return new couchClient ($config['couchdb']['dsn'], $config['couchdb']['db']);
            },
        );
    }
}
