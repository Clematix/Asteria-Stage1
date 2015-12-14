<?php

class Utilities extends Zend_Db_Table {

    protected $_name = 'utilies';

   
    
    public function fetchSupplierAddress($id) {
        if(!$id){$id=1;}
        $select = $this->_db->select()
                ->from($this->_name,array('content'))
                ->where('id=?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }
    
     public function fetchSoNo() {
       
        $select = $this->_db->select()
                ->from($this->_name,array('content'))
                ->where('name=?', 'so_serial');
      $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }
    
      public function fetchWoNo() {
       
        $select = $this->_db->select()
                ->from($this->_name,array('content'))
                ->where('name=?', 'wo_serial');
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }
   

}
