<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Sales extends Zend_Db_Table

    {

       
    protected $_name='sales';
    
   public function fetchAllSo() {
        $select = $this->_db->select()
                ->from($this->_name);
              
        $results = $this->getAdapter()->fetchAll($select);

        return $results;
    }
    
    
    public function getSo($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                 ->where('id =?', $id);;
        $results = $this->getAdapter()->fetchRow($select);
        return $results;
    }
    
     public function getSoNo($id) {
        $select = $this->_db->select()
                ->from($this->_name,array('so_no'))
                 ->where('id =?', $id);;
        $results = $this->getAdapter()->fetchOne($select);
        if($results){
        return $results;}
        return false;
    }
    
     
   
}
