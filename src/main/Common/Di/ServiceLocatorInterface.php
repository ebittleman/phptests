<?php

namespace phptests\Common\Di;

interface ServiceLocatorInterface
{
    public function get($serviceName);

    public function set($serviceName, $params);
}