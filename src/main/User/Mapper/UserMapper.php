<?php
namespace phptests\User\Mapper;

use phptests\Common\Hydrator\HydratorInterface;
use phptests\User\UserInterface;
use phptests\Common\Database\DatabaseAdapterInterface;
use \Exception;

class UserMapper
{

    /**
     *
     * @var DatabaseAdapterInterface
     */
    private $db;

    /**
     *
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     *
     * @var UserInterface
     */
    private $prototype;

    private $tableName = 'User';

    public function __construct(&$db, $hydrator, $prototype)
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     *
     * @param int $id
     * @return UserInterface
     */
    public function findById($id)
    {
        $this->db->select($this->tableName,
            array(
                'id' => $id
            ));

        if (! $row = $this->db->fetch()) {
            return null;
        }

        return $this->createEntity($row);
    }

    /**
     *
     * @param array $conditions
     * @return array.<UserInterface>
     */
    public function findAll(array $conditions = array())
    {
        $entities = array();
        $this->db->select($this->tableName, $conditions);
        $rows = $this->db->fetchAll();

        if ($rows) {
            foreach ($rows as $row) {
                $entities[] = $this->createEntity($row);
            }
        }

        return $entities;
    }

    /**
     *
     * @param UserInterface $user
     * @return void
     */
    public function insert(UserInterface &$user)
    {
        $row = $this->extractEntity($user);

        if (! empty($row['Id'])) {
            throw new Exception('Id cannot be set when inserting');
        }

        unset($row['Id']);

        $id = $this->db->insert($this->tableName, $row);

        $user->setId($id);
    }

    /**
     *
     * @param mixed $id
     * @return boolean
     */
    public function delete($id)
    {
        if ($id instanceof UserInterface) {
            $id = $id->getId();
        }

        return $this->db->delete($this->tableName,

        "id = $id");
    }

    public function extractEntity(UserInterface &$user)
    {
        $data = $this->hydrator->extract($user);

        return array(
            "Id" => $data->id,
            "FirstName" => $data->first_name,
            "LastName" => $data->last_name,
            "Email" => $data->email,
            "Password" => $data->password,
            "Salt" => $data->salt
        );
    }

    protected function createEntity($row)
    {
        $data = (object) array(
            'id' => $row->Id,
            'first_name' => $row->FirstName,
            'last_name' => $row->LastName,
            'email' => $row->Email,
            'password' => $row->Password,
            'salt' => $row->Salt
        );

        $user = clone $this->prototype;

        $this->hydrator->hydrate($data, $user);

        return $user;
    }
}
