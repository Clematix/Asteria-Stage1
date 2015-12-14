<?php
class students extends Zend_Db_Table_Abstract
{
    //protected $_name = 'students';
	
	
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
	
	
}
