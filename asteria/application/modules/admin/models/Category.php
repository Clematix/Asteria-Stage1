<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Category extends Zend_Db_Table

    {

       protected $_name='categories';
	    
public function getUsersData()
       {
        $select = $this->_db->select()
                        ->from($this->_name);
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
    }
