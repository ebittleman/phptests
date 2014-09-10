<?php

namespace phptests\Common\Hydrator;

interface HydratorInterface
{
    public function extract($object);
    public function hydrate($data, &$object);
}
