<?php

class Aclrole extends Zend_Db_Table {

    protected $_name = 'acl_roles';

    public function fetchRoles($id) {

        $row = $this->_db->select()
                ->from($this->_name)
                ->where('acl_role_id = ?', $id);
        $result = $this->getAdapter()->fetchRow($row);
        if ($result) {
            return $result;
        }

        return false;
    }
    
    public function checkRole($name) {

        $row = $this->_db->select()
                ->from($this->_name,array('acl_role_name'))
                ->where('acl_role_name = ?', $name);
        $result = $this->getAdapter()->fetchOne($row);
        if ($result) {
            return $result;
        }

        return false;
    }
    
    function fetchEdit($id)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name)
	                            ->where('acl_role_id=?',$id);
	        $result = $this->getAdapter()->fetchRow($select);
	        if($result){
	            return $result;
	        }
	        return false;
	    }
            
            function deleterow($id)
	    {
	        $select = $this->_db->delete()
	                            ->from($this->_name)
	                            ->where('acl_role_id=?',$id);
	        if($select){
	            return $select;
	        }
	        return false;
	    }
            
            
            

}
