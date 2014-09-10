<?php
namespace phptests\User\Mapper;

use phptests\User\Entity\User;
use phptests\User\Mapper\UserMapper;

class UserMapperTest extends \PHPTests_TestCase
{

    /**
     *
     * @var UserMapper
     */
    protected $mapper;

    protected function setUp()
    {
        parent::setUp();
        $this->mapper = $this->serviceLocator->get('phptests\User\Mapper\UserMapper');
    }

    /**
     * @test
     */
    public function InsertUser_Success()
    {
        $user = new User(null, 'Eric', 'Bittleman', 'ebittleman@heyo.com',
            'mypass', 'aaffddss');

        $this->mapper->insert($user);

        $id = $user->getId();

        $this->assertNotEmpty($id);
        $this->assertGreaterThan(0, $id);

        return $user;
    }

    /**
     * @test
     * @depends InsertUser_Success
     * @param User $user
     */
    public function FindById_Success($user)
    {
        $id = $user->getId();

        $act_user = $this->mapper->findById($id);

        $this->assertNotEmpty($act_user);
        $this->assertEquals($user->getId(), $act_user->getId());
        $this->assertEquals($user->getFirstName(), $act_user->getFirstName());
        $this->assertEquals($user->getLastName(), $act_user->getLastName());
        $this->assertEquals($user->getEmail(), $act_user->getEmail());
        $this->assertEquals($user->getPassword(), $act_user->getPassword());
        $this->assertEquals($user->getSalt(), $act_user->getSalt());

        return $act_user;
    }

    /**
     * @test
     * @depends FindById_Success
     */
    public function Delete_Sucess($user)
    {
        $res = $this->mapper->delete($user);
        $this->assertNotEmpty($res);
    }
}
