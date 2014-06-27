<?php
namespace UsersACL\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class ResourceTable extends AbstractTableGateway
{

    public $table = 'resource';

    /**
     * Constructor for the Resource Table
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     * @param Adapter $adapter            
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();
    }

    /**
     * Function for getting all the resources
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     * @throws \Exception
     * @return unknown
     */
    public function getAllResources()
    {
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array(
                'rs' => $this->table
            ));
            $select->columns(array(
                'id',
                'resource_name'
            ));
            $statement = $sql->prepareStatementForSqlObject($select);
            $resources = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            return $resources;
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }
}
