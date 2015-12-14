<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Workorder extends Zend_Db_Table

    {
       
    protected $_name='work_order';
    
       public function checkExist($so,$so_line,$item) 
       {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where('item_id = ?', $item)
                ->where('so_id = ?', $so)
                ->where('so_line_item = ?', $so_line)
                ;
        $result = $this->getAdapter()->fetchRow($select);
        if ($result) {
            return count($result);
        }
        return false;
       }
       
       public function getAllWo()
       {
            $select = $this->_db->select()
                ->from($this->_name)
                     ->order('status');
              $result = $this->getAdapter()->fetchAll($select);
              if($result){return $result;}
              return false;
       }
       
        public function getWoItemById($id) {
          $select = $this->_db->select()
                ->from($this->_name)->where('so_id=?',$id)
                ->order('status');
              $result = $this->getAdapter()->fetchAll($select);
              if($result){return $result;}
              return false;
     
    }
        public function getWoCount($id)
       {
            $select = $this->_db->select()
                ->from($this->_name)
                      ->where('so_line_item = ?',$id)
                      ->where('status = ?','0');
              $result = $this->getAdapter()->fetchAll($select);
              if($result){return count($result);}
              return false;
       }
   
        
}
