<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Upload extends Zend_Db_Table

    {

       protected $_name='uploads';
	    function checkUnique($file)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name,array('file'))
	                            ->where('file=?',$file);
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
