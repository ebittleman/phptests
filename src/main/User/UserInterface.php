<?php

namespace phptests\User;

interface UserInterface
{
    public function getId();
    public function setId($id);
    public function getFirstName();
    public function setFirstName($first_name);
    public function getLastName();
    public function setLastName($last_name);
    public function getEmail();
    public function setEmail($email);
    public function getPassword();
    public function setPassword($password);
    public function getSalt();
    public function setSalt($salt);
}
