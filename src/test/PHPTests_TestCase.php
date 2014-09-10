<?php

use phptests\Module;

class PHPTests_TestCase extends PHPUnit_Framework_TestCase
{
    protected $serviceLocator;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        global $serviceLocator;

        $this->serviceLocator = &self::getServiceLocator();
    }

    protected static function &getServiceLocator()
    {
        static $serviceLocator = null;

        if (!is_null($serviceLocator)) {
            return $serviceLocator;
        }

        $module = new Module();

        $serviceLocator = $module->init();

        return $serviceLocator;
    }
}
