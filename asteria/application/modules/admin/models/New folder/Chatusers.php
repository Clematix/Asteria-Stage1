<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Chatusers extends Zend_Db_Table

    {

       protected $_name='chat';
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
                        ->distinct()
                        ->from($this->_name,array('from_user'));
        $results = $this->getAdapter()->fetchAll($select);
        
        return $results;
       }

    }
