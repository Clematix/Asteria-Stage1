<?php


class AclRoles extends Zend_Db_Table

    {

      protected $_name=null;
      
     
      public function fetchModules() {
        $this->_name = 'acl_modules';

        $row = $this->_db->select()
                        ->from($this->_name);
        $results = $this->getAdapter()->fetchAll($row);
        if ($results) {
            return $results;
        }

        return false;
    }
    
    public function fetchModulename($id) {
        $this->_name = 'acl_modules';
        $row = $this->_db->select()
                ->from($this->_name,array('module_name'))
                ->where('module_id = ?', $id);
        $result = $this->getAdapter()->fetchOne($row);
        if ($result) {
            return $result;
        }

        return false;
    }
    
     public function fetchResourceName($id) {
        $this->_name = 'acl_controller_list';
        $row = $this->_db->select()
                ->from($this->_name,array('controller_name'))
                ->where('acl_controller_id = ?', $id);
        $result = $this->getAdapter()->fetchOne($row);
        if ($result) {
            return $result;
        }

        return false;
    }
    
    public function fetchResourcePath($id) {
        $this->_name = 'acl_controller_list';
        $row = $this->_db->select()
                ->from($this->_name,array('controller_action'))
                ->where('acl_controller_id = ?', $id);
        $result = $this->getAdapter()->fetchOne($row);
        if ($result) {
            return $result;
        }

        return false;
    }
    
    public function fetchRoles($id) {
        $this->_name = 'acl_roles';

        $row = $this->_db->select()
                      ->from($this->_name)
	                            ->where('acl_role_id = ?',$id);
        $result = $this->getAdapter()->fetchRow($row);
        if ($results) {
            return $results;
        }

        return false;
    }
    public function createRole($data) {
        $this->_name = 'acl_roles';

 
        if ($this->_name->insert($data)) {
            return 1;
        }
        return 0;
    }
    
    public function fetchResource($where,$id) {
        $this->_name = 'acl_controller_list';
        
        $row = $this->_db->select()
                      ->from($this->_name)
	                            ->where($where.'=?',$id);
 $result = $this->getAdapter()->fetchAll($row);
       
        if($result)
        {
            return $result;
        }
                return false;

        
    }

    function checkUnique($email)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name,array('email'))
	                            ->where('email=?',$email);
	        $result = $this->getAdapter()->fetchOne($select);
	        if($result){
	            return true;
	        }
	        return false;
	    }

       public function getRoles()
       {
        $select = $this->_db->select()
                        ->from($this->_name);
        $results = $this->getAdapter()->fetchAll($select);
        
        return $results;
       }
       
       public function getRole()
       {
        $select = $this->_db->select()
	                            ->from($this->_name,array('acl_role_id'))
	                            ->where('email=?',$email);
        $results = $this->getAdapter()->fetchOne($select);
        
        return $results;
       }       

    }
