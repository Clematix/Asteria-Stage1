<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Shipping extends Zend_Db_Table

    {
       
    protected $_name='shipping_method';
    
    function checkUnique($name)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name,array('name'))
	                            ->where('name=?',$name);
                $result = $this->getAdapter()->fetchRow($select);
	        if($result){
	            return true;
	        }
	        return false;
	    }
               
    public function fetchAllMethod() {
        $select = $this->_db->select()
                ->from($this->_name);
           
        $results = $this->getAdapter()->fetchAll($select);

        return $results;
    }
    
    public function fetchMethods() {
        $select = $this->_db->select()
                ->from($this->_name)
              ->Where('status =1');
        $results = $this->getAdapter()->fetchAll($select);

        return $results;
    }
    
    public function fetchEdit($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->Where('id =?',$id);
              
        $results = $this->getAdapter()->fetchRow($select);

        return $results;
    }
   
}
