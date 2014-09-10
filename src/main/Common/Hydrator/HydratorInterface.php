<?php

namespace phptests\common\Hydrator;

interface HydratorInterface
{
    public function extract($object);
    public function hydrate($data, &$object);
}
