<?php
namespace UsersACL\Utility;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Acl extends ZendAcl implements ServiceLocatorAwareInterface
{

    const DEFAULT_ROLE = 'guest';

    protected $_roleTableObject;

    protected $serviceLocator;

    protected $roles;

    protected $permissions;

    protected $resources;

    protected $rolePermission;

    protected $commonPermission;

    /**
     * Function Set Service Locator
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Function for initialize the ACL Function
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     */
    public function initAcl()
    {
        $this->roles = $this->_getAllRoles();
        $this->resources = $this->_getAllResources();
        $this->rolePermission = $this->_getRolePermissions();
        
        // we are not putting these resource & permission in table bcz it is
        // common to all user
        $this->commonPermission = array();
        $this->_addRoles()
            ->_addResources()
            ->_addRoleResources();
    }

    /**
     * Function isAccessAllowed
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     * @param integer $role            
     * @param integer $resource            
     * @param integer $permission            
     * @return boolean
     */
    public function isAccessAllowed($role, $resource, $permission)
    {
        if (! $this->hasResource($resource)) {
            return false;
        }
        if ($this->isAllowed($role, $resource, $permission)) {
            return true;
        }
        return false;
    }

    /**
     * Function for adding the roles
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     * @return \UsersACL\Utility\Acl
     */
    protected function _addRoles()
    {
        $this->addRole(new Role(self::DEFAULT_ROLE));
        
        if (! empty($this->roles)) {
            foreach ($this->roles as $role) {
                $roleName = $role['role_name'];
                if (! $this->hasRole($roleName)) {
                    $this->addRole(new Role($roleName), self::DEFAULT_ROLE);
                }
            }
        }
        return $this;
    }

    /**
     * Function for adding the resources
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     * @return \UsersACL\Utility\Acl
     */
    protected function _addResources()
    {
        if (! empty($this->resources)) {
            foreach ($this->resources as $resource) {
                if (! $this->hasResource($resource['resource_name'])) {
                    $this->addResource(new Resource($resource['resource_name']));
                }
            }
        }
        // add common resources
        if (! empty($this->commonPermission)) {
            foreach ($this->commonPermission as $resource => $permissions) {
                if (! $this->hasResource($resource)) {
                    $this->addResource(new Resource($resource));
                }
            }
        }
        
        return $this;
    }

    /**
     * Function for adding the Role Resouces
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     * @return \UsersACL\Utility\Acl
     */
    protected function _addRoleResources()
    {
        if (! empty($this->commonPermission)) {
            foreach ($this->commonPermission as $resource => $permissions) {
                foreach ($permissions as $permission) {
                    $this->allow(self::DEFAULT_ROLE, $resource, $permission);
                }
            }
        }
        
        if (! empty($this->rolePermission)) {
            foreach ($this->rolePermission as $rolePermissions) {
                $this->allow($rolePermissions['role_name'], $rolePermissions['resource_name'], $rolePermissions['permission_name']);
            }
        }
        
        return $this;
    }

    /**
     * Function for getting all the roles
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     */
    protected function _getAllRoles()
    {
        $roleTable = $this->getServiceLocator()->get("RoleTable");
        return $roleTable->getUserRoles();
    }

    /**
     * Function for getting all the resources
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     */
    protected function _getAllResources()
    {
        $resourceTable = $this->getServiceLocator()->get("ResourceTable");
        return $resourceTable->getAllResources();
    }

    /**
     * Function for getting all the permissions
     *
     * @author Kaushal Kishore <kaushal.rahuljaiswal@gmail.com>
     */
    protected function _getRolePermissions()
    {
        $rolePermissionTable = $this->getServiceLocator()->get("RolePermissionTable");
        return $rolePermissionTable->getRolePermissions();
    }

    /**
     * Function for debuging the ACL
     * 
     * @param unknown $role            
     * @param unknown $resource            
     * @param unknown $permission            
     */
    private function debugAcl($role, $resource, $permission)
    {
        echo 'Role:-' . $role . '==>' . $resource . '\\' . $permission . '<br/>';
    }
}
