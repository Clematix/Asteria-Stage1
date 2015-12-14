<?php

class Signup extends Zend_Db_Table
   {

       protected $_name='users';
       
        public function saltme($pass,$salt)
        {
        $key  = calc($pass, $salt, 2048, 2, 1, 64);
        return $key;
        }
        
        public function salt()
        {
            $salt = 'jdwgc';
            return $salt;
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
    
    

    /**
     * Salsa 20/8 core (64 bit version)
     *
     * @param  string $b
     * @return string
     * @see    https://tools.ietf.org/html/draft-josefsson-scrypt-kdf-01#section-2
     * @see    http://cr.yp.to/salsa20.html
     */
    public static function salsa208Core64($b)
    {
        $b32 = array();
        for ($i = 0; $i < 16; $i++) {
            list(, $b32[$i]) = unpack("V", substr($b, $i * 4, 4));
        }

        $x = $b32;
        for ($i = 0; $i < 8; $i += 2) {
            $a      = ($x[ 0] + $x[12]) & 0xffffffff;
            $x[ 4] ^= ($a << 7) | ($a >> 25);
            $a      = ($x[ 4] + $x[ 0]) & 0xffffffff;
            $x[ 8] ^= ($a << 9) | ($a >> 23);
            $a      = ($x[ 8] + $x[ 4]) & 0xffffffff;
            $x[12] ^= ($a << 13) | ($a >> 19);
            $a      = ($x[12] + $x[ 8]) & 0xffffffff;
            $x[ 0] ^= ($a << 18) | ($a >> 14);
            $a      = ($x[ 5] + $x[ 1]) & 0xffffffff;
            $x[ 9] ^= ($a << 7) | ($a >> 25);
            $a      = ($x[ 9] + $x[ 5]) & 0xffffffff;
            $x[13] ^= ($a << 9) | ($a >> 23);
            $a      = ($x[13] + $x[ 9]) & 0xffffffff;
            $x[ 1] ^= ($a << 13) | ($a >> 19);
            $a      = ($x[ 1] + $x[13]) & 0xffffffff;
            $x[ 5] ^= ($a << 18) | ($a >> 14);
            $a      = ($x[10] + $x[ 6]) & 0xffffffff;
            $x[14] ^= ($a << 7) | ($a >> 25);
            $a      = ($x[14] + $x[10]) & 0xffffffff;
            $x[ 2] ^= ($a << 9) | ($a >> 23);
            $a      = ($x[ 2] + $x[14]) & 0xffffffff;
            $x[ 6] ^= ($a << 13) | ($a >> 19);
            $a      = ($x[ 6] + $x[ 2]) & 0xffffffff;
            $x[10] ^= ($a << 18) | ($a >> 14);
            $a      = ($x[15] + $x[11]) & 0xffffffff;
            $x[ 3] ^= ($a << 7) | ($a >> 25);
            $a      = ($x[ 3] + $x[15]) & 0xffffffff;
            $x[ 7] ^= ($a << 9) | ($a >> 23);
            $a      = ($x[ 7] + $x[ 3]) & 0xffffffff;
            $x[11] ^= ($a << 13) | ($a >> 19);
            $a      = ($x[11] + $x[ 7]) & 0xffffffff;
            $x[15] ^= ($a << 18) | ($a >> 14);
            $a      = ($x[ 0] + $x[ 3]) & 0xffffffff;
            $x[ 1] ^= ($a << 7) | ($a >> 25);
            $a      = ($x[ 1] + $x[ 0]) & 0xffffffff;
            $x[ 2] ^= ($a << 9) | ($a >> 23);
            $a      = ($x[ 2] + $x[ 1]) & 0xffffffff;
            $x[ 3] ^= ($a << 13) | ($a >> 19);
            $a      = ($x[ 3] + $x[ 2]) & 0xffffffff;
            $x[ 0] ^= ($a << 18) | ($a >> 14);
            $a      = ($x[ 5] + $x[ 4]) & 0xffffffff;
            $x[ 6] ^= ($a << 7) | ($a >> 25);
            $a      = ($x[ 6] + $x[ 5]) & 0xffffffff;
            $x[ 7] ^= ($a << 9) | ($a >> 23);
            $a      = ($x[ 7] + $x[ 6]) & 0xffffffff;
            $x[ 4] ^= ($a << 13) | ($a >> 19);
            $a      = ($x[ 4] + $x[ 7]) & 0xffffffff;
            $x[ 5] ^= ($a << 18) | ($a >> 14);
            $a      = ($x[10] + $x[ 9]) & 0xffffffff;
            $x[11] ^= ($a << 7) | ($a >> 25);
            $a      = ($x[11] + $x[10]) & 0xffffffff;
            $x[ 8] ^= ($a << 9) | ($a >> 23);
            $a      = ($x[ 8] + $x[11]) & 0xffffffff;
            $x[ 9] ^= ($a << 13) | ($a >> 19);
            $a      = ($x[ 9] + $x[ 8]) & 0xffffffff;
            $x[10] ^= ($a << 18) | ($a >> 14);
            $a      = ($x[15] + $x[14]) & 0xffffffff;
            $x[12] ^= ($a << 7) | ($a >> 25);
            $a      = ($x[12] + $x[15]) & 0xffffffff;
            $x[13] ^= ($a << 9) | ($a >> 23);
            $a      = ($x[13] + $x[12]) & 0xffffffff;
            $x[14] ^= ($a << 13) | ($a >> 19);
            $a      = ($x[14] + $x[13]) & 0xffffffff;
            $x[15] ^= ($a << 18) | ($a >> 14);
        }
        for ($i = 0; $i < 16; $i++) {
            $b32[$i] = ($b32[$i] + $x[$i]) & 0xffffffff;
        }
        $result = '';
        for ($i = 0; $i < 16; $i++) {
            $result .= pack("V", $b32[$i]);
        }

        return $result;
    }

    
   }
