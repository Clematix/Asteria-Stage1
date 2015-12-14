<?php
class Books extends Zend_Db_Table

    {

       protected $_name='books';
//	    function checkUnique($username)
//	    {
//	        $select = $this->_db->select()
//	                            ->from($this->_name,array('username'))
//	                            ->where('username=?',$username);
//	        $result = $this->getAdapter()->fetchOne($select);
//	        if($result){
//	            return true;
//	        }
//	        return false;
//	    }

        public function getBooksData()
          {
           $select = $this->_db->select()
                           ->from($this->_name);
           $results = $this->getAdapter()->fetchAll($select);
           return $results;
          }
          
          public function getBooks($name)
    {
        $select = $this->select()
                            ->from($this->_name)
                            ->where('book_name=?',$name);
        
        $result = $this->getAdapter()->fetchAll($select);
        
        if($result)
        {
            return $result;
        }
        else
        {
            return false;
        }
        
    }
          
        public function fetchUserChats($username)
        {
            $select = $this->_db->select()
                        ->from($this->_name,array('message','sent'))
                        ->where('from_user=?',$username)
                        ->orWhere('to_user=?',$username);
            $results = $this->getAdapter()->fetchAll($select);
            
            if($results)
            {
                return $results;
            }
            else
            {
                return false;
            }
           
        }

    }
