<?php

namespace phptests\Common\Di;

use phptests\Common\Factory\FactoryInterface;
use \Exception;

class ServiceLocator implements ServiceLocatorInterface
{
    private $config;

    private $singletons;

    private $factories;

    public function __construct(array $config = array())
    {
        $this->config = array();
        $this->singletons = array();
        $this->factories = array();

        $this->loadConfig($config);
    }

    public function loadConfig(array $config = array())
    {
        if (!empty($config)) {
            foreach($config as $serviceName => $settings) {
                $this->set($serviceName, $settings);
            }
        }
    }

    public function &get($serviceName)
    {
        $settings = $this->safe_offset($this->config, $serviceName);

        if (empty($settings)) {
            throw new Exception('Undefined Service: ' . $serviceName);
        }

        if (!is_array($settings)) {
            $settings = array(
                'factory' => $settings,
                'singleton' => true,
            );

            $this->set($serviceName, $settings, true);
        }

        $instance = $this->safe_offset($this->singletons, $serviceName);
        $is_singleton = $this->safe_offset($settings, 'singleton', false);

        if (!empty($is_singleton) && !empty($instance)) {
            return $instance;
        }

        $factory = $this->getFactory($serviceName, $settings);

        $instance = call_user_func($factory, $this);

        if ($is_singleton) {
            $this->singletons[$serviceName] = &$instance;
        }

        return $instance;
    }

    public function set($serviceName, $settings, $force = false)
    {
        $curr_settings = $this->safe_offset($this->config, $serviceName);
        if (!empty($curr_settings) && !$force) {
            throw new Exception('Service already defined: ' . $serviceName);
        }

        if (!empty($curr_settings)) {
            unset($this->config[$serviceName]);
            unset($this->singletons[$serviceName]);
            unset($this->factories[$serviceName]);
        }

        $this->config[$serviceName] = $settings;

        return $this;
    }

    protected function getFactory($serviceName, array $settings)
    {
        $factory = $this->safe_offset($this->factories, $serviceName);

        if (empty($factory)) {
            
            $factory_def = $this->safe_offset($settings, 'factory');
            
            if (empty($factory_def)) {
                throw new Exception('`factory` not set');
            }

            $factory = $this->convertToCallable($factory_def);
        }

        if (!is_callable($factory))
        {
            throw new Exception('Factory is not callable for service: ' . $serviceName);
        }

        $this->factories[$serviceName] = &$factory; 

        return $factory;
    }

    protected function convertToCallable($factory_def) {
        $callable = null;

        if (is_callable($factory_def)) {
            return $factory_def;
        }
        
        if (!is_string($factory_def) || !class_exists($factory_def)) {
            throw new Exception('Class Not Found: ' . $factory_def);
        }
           
        $factory = new $factory_def();

        if (! $factory instanceof FactoryInterface) {
            throw new Exception('Factory must implement phptests\Factory\FactoryInterface: ' . $factory_def);
        }
        
        return array($factory, 'getInstance');
    }

    protected function safe_offset(array &$array, $key, $default = null)
    {
        if (!isset($array[$key])) {
            return $default;
        }

        return $array[$key];
    }
}
