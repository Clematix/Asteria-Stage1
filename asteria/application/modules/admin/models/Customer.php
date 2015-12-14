<?php

class Customer extends Zend_Db_Table {

    protected $_name = 'customer';

    function checkUnique($email) {
        $select = $this->_db->select()
                ->from($this->_name, array('email','telephone','company_name'))
                ->where('email=?', $email);
        $result = $this->getAdapter()->fetchOne($select);
        if ($result) {
            return true;
        }
        return false;
    }

    public function fetch($id) {
        $select = $this->_db->select()
                ->from($this->_name, array('customer_id'))
                ->where('customer_id=?', $id);
        $results = $this->getAdapter()->fetchRow($select);

        return $results;
    }

    public function fetchEdit($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where('customer_id=?', $id);
        $results = $this->getAdapter()->fetchRow($select);

        return $results;
    }
    
    
    public function fetchCustomerAddress($id) {
        $select = $this->_db->select()
                ->from($this->_name,array('company_address'))
                ->where('customer_id=?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }
    
     public function fetchCustomerName($id) {
        $select = $this->_db->select()
                ->from($this->_name,array('company_name'))
                ->where('customer_id=?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }
    
    public function fetchAllCustomer() {
        $select = $this->_db->select()
                ->from($this->_name);
              
        $results = $this->getAdapter()->fetchAll($select);

        return $results;
    }

}
