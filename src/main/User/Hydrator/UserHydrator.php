<?php

namespace phptests\User\Hydrator;

use phptests\common\Hydrator\HydratorInterface;
use phptests\User\UserInterface;
use \Exception;

class UserHydrator implements HydratorInterface
{
    public function extract($object)
    {
        if (! $object instanceof UserInterface) {
            throw new Exception('Object does not implement UserInterface');
        }

        return (object) array(
            'id' => $object->getId(),
            'first_name' => $object->getFirstName(),
            'last_name' => $object->getLastName(),
            'email' => $object->getEmail(),
            'password' => $object->getPassword(),
            'salt' => $object->getSalt(),
        );
    }

    public function hydrate($data, &$object)
    {
        if (! $object instanceof UserInterface) {
            throw new Exception('Object does not implement UserInterface');
        }

        $object->setId($this->safe_offset($data, 'id', null));
        $object->setFirstName($this->safe_offset($data, 'first_name'));
        $object->setLastName($this->safe_offset($data, 'last_name'));
        $object->setEmail($this->safe_offset($data, 'email'));
        $object->setPassword($this->safe_offset($data, 'password'));
        $object->setSalt($this->safe_offset($data, 'salt'));
    }

    protected function safe_offset($obj, $key, $default = '')
    {
        if (!isset($obj->$key)) {
            return $default;
        }

        return $obj->$key;
    }
}
