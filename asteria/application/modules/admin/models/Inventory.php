<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Inventory extends Zend_Db_Table

    {

       protected $_name='inventory';
          

	   public function getUsersData()
       {
        $select = $this->_db->select()
                        ->from($this->_name);
        $results = $this->getAdapter()->fetchAll($select);
        
        return $results;
       }
       
        public function checkStock($id) 
       {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where('itemid = ?', $id)
                ->where('status = ?', '0');
        $result = $this->getAdapter()->fetchAll($select);
        if ($result) {
            return count($result);
        }
        return '0';
       }
       
       public function getInventoryItemById($id)
       {
     $select='select al.id,sl.qty,sl.item_code,ma.part_no, al.so_no from item_available as al left join sales_lineitem as sl on al.so_line_item=sl.id inner join material as ma on al.item_id=ma.id where al.so_no='.$id;

   $result = $this->getAdapter()->fetchAll($select);
        if ($result) {
            return $result;
        }
        return false;
       }
       
        public function getallbyId($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where('itemid=?', $id)
                 ->where('status =?', '0');

        $result = $this->getAdapter()->fetchAll($select);
        if ($result) {
            return $result;
        }
        return false;
    } 
     public function getwomaterial($id){
        
         $select1 = $this->_db->select()
                    ->from(array('p' => 'inventory'))
                    ->where('itemid = ?', $id)
                    ->order('uniqueid desc')
                    ->limit(1) ;
                
            $results = $this->getAdapter()->fetchAll($select1);
             if ($results) {
            return $results;
        }
        return false;
    }
      
    }
