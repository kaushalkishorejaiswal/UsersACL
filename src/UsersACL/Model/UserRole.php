<?php
namespace UsersACL\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;

class UserRole extends AbstractTableGateway
{

    public $table = 'user_role';

    /**
     * Constructor for the UserRole Table
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
     * Function for getting the user roles
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     * @param array $where            
     * @param array $columns            
     * @param string $orderBy            
     * @param string $paging            
     * @throws \Exception
     * @return \UsersACL\Model\Paginator unknown
     */
    public function getUserRoles($where = array(), $columns = array(), $orderBy = '', $paging = false)
    {
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array(
                'sa' => $this->table
            ));
            
            if (count($where) > 0) {
                $select->where($where);
            }
            
            $select->where($where);
            
            if (count($columns) > 0) {
                $select->columns($columns);
            }
            
            if (! empty($orderBy)) {
                $select->order($orderBy);
            }
            
            if ($paging) {
                
                $dbAdapter = new DbSelect($select, $this->getAdapter());
                $paginator = new Paginator($dbAdapter);
                
                return $paginator;
            } else {
                $statement = $sql->prepareStatementForSqlObject($select);
                
                $clients = $this->resultSetPrototype->initialize($statement->execute())
                    ->toArray();
                
                return $clients;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }
}
