<?php
namespace UsersACL\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class PermissionTable extends AbstractTableGateway
{

    public $table = 'permission';

    /**
     * Constructor for the Permission Table
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
     * Function for getting the Resource Permissions
     * 
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     * @param
     *            Integer
     * @throws Exception
     * @return Error
     */
    public function getResourcePermissions($roleId)
    {
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array(
                'p' => $this->table
            ));
            $select->columns(array(
                'resid'
            ));
            
            $select->join(array(
                "r" => "resource"
            ), "p.resid = r.resid", array(
                "name",
                "route"
            ));
            $select->where(array(
                'p.rid' => $roleId
            ));
            $select->order(array(
                'menu_order'
            ));
            
            $statement = $sql->prepareStatementForSqlObject($select);
            $resources = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            return $resources;
        } catch (\Exception $err) {
            throw $err;
        }
    }
}
