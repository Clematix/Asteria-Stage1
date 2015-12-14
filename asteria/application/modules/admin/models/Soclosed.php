<?php

class Soclosed extends Zend_Db_Table

    {

       
    protected $_name='so_closed';
    
   public function getClosedCount($soid,$solineid)
       {
            $select = $this->_db->select()
                ->from($this->_name)
                      ->where('so_id = ?',$soid)
                      ->where('so_line = ?',$solineid);
              $result = $this->getAdapter()->fetchAll($select);
              if($result){return count($result);}
              return false;
       }
    
     
   
}
