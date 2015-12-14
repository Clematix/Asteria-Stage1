<?php


class Designation extends Zend_Db_Table

    {

       protected $_name='group';
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
            
            
      public function getUsersData()
       {
        $select = $this->_db->select()
                        ->from($this->_name);
        $results = $this->getAdapter()->fetchAll($select);
        
        return $results;
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
            
            
            function fetchOne($id)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name,array('name'))
	                            ->where('id=?',$id);
	        $result = $this->getAdapter()->fetchOne($select);
	        if($result){
	            return $result;
	        }
	        return false;
	    }

    }
