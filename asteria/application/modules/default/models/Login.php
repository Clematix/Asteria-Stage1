<?php
//use Zend\Crypt\Key\Derivation\Scrypt;
class Signup extends Zend_Db_Table
   {

       protected $_name='users';
       
        public function saltme($pass,$salt)
        {
        $key  = Scrypt::calc($pass, $salt, 2048, 2, 1, 64);
        return $key;
        }
        
        
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
