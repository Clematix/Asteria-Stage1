<?php
class Chat extends Zend_Db_Table_Abstract
{
    protected $_name = 'chat';
    
    public function getChats($name)
    {
        $select = $this->select()
                            ->from($this->_name,array('message','from_user','to_user'))
                            ->where('from_user=?',$name)
                            ->orWhere('to_user=?',$name);
        
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
    
//    protected $_message;
//    protected $_sessId;
//    protected $_role;
//    protected $_id;
//    
//    public function __construct(array $options = null) {
//        if (is_array($options)) {
//            $this->setOptions($options);
//        }
//    }
//    
//    public function __set($name, $value)
//    {
//        $method = 'set' . $name;
//
//        if (('mapper' == $name) || !method_exists($this, $method)) {
//            throw new Exception('Invalid property');
//        }
//
//        $this->$method($value);
//    }
//    
//    public function __get($name)
//    {
//        $method = 'get' . $name;
//
//        if (('mapper' == $name) || !method_exists($this, $method)) {
//            throw new Exception('Invalid property');
//        }
//
//        return $this->$method();
//    }
//    
//    public function setOptions(array $options)
//    {
//        $methods = get_class_methods($this);
//
//        foreach ($options as $key => $value) {
//            $method = 'set' . ucfirst($key);
//
//            if (in_array($method, $methods)) {
//                $this->$method($value);
//            }
//        }
//
//        return $this;
//    }
//    
//    public function setMessage($message)
//    {
//        $this->_message = (string) $message;
//        return $this;
//    }
//    
//    public function getMessage()
//    {
//        return $this->_message;
//    }
//    
//    public function setSessId($sessId)
//    {
//        $this->_sessId = $sessId;
//        return $this;
//    }
//    
//    public function getSessId()
//    {
//        return $this->_sessId;
//    }
//    
//    public function setRole($role)
//    {
//        $this->_role = $role;
//        return $this;
//    }
//
//    public function getRole()
//    {
//        return $this->_role;
//    }
//    
//    public function setId($id)
//    {
//        $this->_id = (int) $id;
//        return $this;
//    }
//    
//    public function getId()
//    {
//        return $this->_id;
//    }
}

