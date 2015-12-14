<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class VendorPoMaterials extends Zend_Db_Table

    {

       protected $_name='vendorpo_materials';
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
