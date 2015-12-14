<?php


class Adminusers extends Zend_Db_Table

    {

            protected $_name='adminusers';
            
             public function getUsers($table)
             {   
           $this->_name=$table;
           $select = $this->_db->select()
                           ->from($this->_name);
           $results = $this->getAdapter()->fetchAll($select);
           return $results;
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
            
            function fetchEdit($id)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name)
	                            ->where('id=?',$id);
	        $result = $this->getAdapter()->fetchRow($select);
	        if($result){
	            return $result;
	        }
	        return false;
	    }

	   public function getUsersData()
       {
        $select = $this->_db->select()
                        ->from($this->_name);
        $results = $this->getAdapter()->fetchAll($select);
        
        return $results;
       }
       
      public function fetchRoles()
       {
           
        $select = $this->_db->select()
                        ->from($this->_name,array('role'));
        $results = $this->getAdapter()->fetchAll($select);
        
        return $results;
       }
   public function fetchPassword($id)
       {
           
        $select = $this->_db->select()
                        ->from($this->_name,array('password'))
                        ->where('id=?',$id);
        $results = $this->getAdapter()->fetchOne($select);
        
        return $results;
       }
      
    }
