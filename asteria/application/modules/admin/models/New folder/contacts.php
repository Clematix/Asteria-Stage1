<?php
class contacts extends Zend_Db_Table_Abstract
{
//protected $_name = 'contacts';
	
	
	public function fetchStudents()
	{
	    
	    $row = $this->fetchAll();
		return $row;
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
            
             public function getUsersData()
       {
        $select = $this->_db->select()
                        ->from($this->_name);
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
	
	
}
