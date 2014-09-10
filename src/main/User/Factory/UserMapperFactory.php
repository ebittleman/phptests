<?php
namespace phptests\User\Factory;

use phptests\Common\Factory\FactoryInterface;
use phptests\Common\Di\ServiceLocatorInterface;
use phptests\User\Mapper\UserMapper;
use phptests\User\Hydrator\UserHydrator;
use phptests\User\Entity\User;

class UserMapperFactory implements FactoryInterface
{

    public function getInstance(ServiceLocatorInterface $sm)
    {
        $db = $sm->get('phptests\Common\Database\PdoAdapter');
        $hydrator = new UserHydrator();
        $prototype = new User();

        return new UserMapper($db, $hydrator, $prototype);
    }
}
