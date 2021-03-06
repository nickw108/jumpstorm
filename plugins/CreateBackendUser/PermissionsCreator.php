<?php

namespace CreateBackendUser;

use \Exception as Exception;

/**
 * PermissionsCreator
 *
 * @category    Plugins
 * @package     Plugins_CreateBackendUser
 * @author      Christoph Aßmann <christoph.assmann@netresearch.de>
 * 
 * @property array $resources
 */
class PermissionsCreator extends AbstractCreator
{
    /**
     * (non-PHPdoc)
     * @see AbstractCreator::validateProperty()
     */
    protected function validateProperty($key, $value = null)
    {
        if (null === $value) {
            $value = $this->{$key};
        }
        
        if ($key === 'resources' && empty($value)) {
            throw new Exception('Please permit any resources via ini file.');
        }
        
        return true;
    }

    /**
     * (non-PHPdoc)
     * @see AbstractCreator::getAllowedProperties()
     */
    protected function getAllowedProperties()
    {
        return array(
            'resources'
        );
    }
    
    /**
     * Set permissions to given role as defined in config. If no permissions
     * are given, the role's permissions are not changed at all.
     *  
     * @param Mage_Admin_Model_Rules $rules
     * @param Mage_Admin_Model_Role $role
     */
    public function createPermissions(Mage_Admin_Model_Rules $rules,
            Mage_Admin_Model_Role $role)
    {
        if (null === $this->resources) {
            return null;
        }
        
        return $rules->setResources($this->resources)
            ->setRoleId($role->getId())
            ->saveRel()
            ->save();
    }
}
