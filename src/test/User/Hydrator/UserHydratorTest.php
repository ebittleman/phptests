<?php
namespace phptests\User\Hydrator;

use phptests\User\Entity\User;

class UserHydratorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function NewInstance_NotEmpty()
    {
        $hydrator = new UserHydrator();

        $this->assertNotEmpty($hydrator);

        $this->assertInstanceOf('phptests\User\Hydrator\UserHydrator',
            $hydrator);
        $this->assertInstanceOf('phptests\Common\Hydrator\HydratorInterface',
            $hydrator);
    }

    /**
     * @test
     */
    public function Extract_Success()
    {
        $exp_id = 1;
        $exp_first_name = 'Eric';
        $exp_last_name = 'Bittleman';
        $exp_email = 'ebittleman@heyo.com';
        $exp_password = 'mypass';
        $exp_salt = 'aaffddss';

        $user = new User($exp_id, $exp_first_name, $exp_last_name, $exp_email,
            $exp_password, $exp_salt);
        $hydrator = new UserHydrator();

        $data = $hydrator->extract($user);

        $act_id = isset($data->id) ? $data->id : null;
        $act_first_name = isset($data->first_name) ? $data->first_name : null;
        $act_last_name = isset($data->last_name) ? $data->last_name : null;
        $act_email = isset($data->email) ? $data->email : null;
        $act_password = isset($data->password) ? $data->password : null;
        $act_salt = isset($data->salt) ? $data->salt : null;

        $this->assertEquals($exp_id, $act_id);
        $this->assertEquals($exp_first_name, $act_first_name);
        $this->assertEquals($exp_last_name, $act_last_name);
        $this->assertEquals($exp_email, $act_email);
        $this->assertEquals($exp_password, $act_password);
        $this->assertEquals($exp_salt, $act_salt);
    }

    /**
     * @test
     */
    public function Hydrate_Success()
    {
        $exp_id = 1;
        $exp_first_name = 'Eric';
        $exp_last_name = 'Bittleman';
        $exp_email = 'ebittleman@heyo.com';
        $exp_password = 'mypass';
        $exp_salt = 'aaffddss';

        $data = (object) array(
            'id' => $exp_id,
            'first_name' => $exp_first_name,
            'last_name' => $exp_last_name,
            'email' => $exp_email,
            'password' => $exp_password,
            'salt' => $exp_salt
        );

        $user = new User();
        $hydrator = new UserHydrator();

        $hydrator->hydrate($data, $user);

        $act_id = $user->getId();
        $act_first_name = $user->getFirstName();
        $act_last_name = $user->getLastName();
        $act_email = $user->getEmail();
        $act_password = $user->getPassword();
        $act_salt = $user->getSalt();

        $this->assertEquals($exp_id, $act_id);
        $this->assertEquals($exp_first_name, $act_first_name);
        $this->assertEquals($exp_last_name, $act_last_name);
        $this->assertEquals($exp_email, $act_email);
        $this->assertEquals($exp_password, $act_password);
        $this->assertEquals($exp_salt, $act_salt);
    }
}
