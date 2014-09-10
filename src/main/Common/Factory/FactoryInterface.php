<?php

namespace phptests\Common\Factory;

use phptests\Common\Di\ServiceLocatorInterface;

interface FactoryInterface
{
    public function getInstance(ServiceLocatorInterface $sm);
}
