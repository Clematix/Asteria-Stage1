<?php

class Application_Model_ChatMapper
{
    protected $_dbTable;
    
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }

        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }

        $this->_dbTable = $dbTable;
        return $this;
    }
    
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Chat');
        }

        return $this->_dbTable;
    }
    
    public function save(Application_Model_Chat $question) 
    {
        $data = array(
            'message'   => $question->getMessage(),
            'sessId'    => $question->getSessId(),
            'role'      => $question->getRole()
        );

        if (null === ($id = $question->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    
    public function find($id, Application_Model_Chat $question)
    {
        $result = $this->getDbTable()->find($id);

        if (0 == count($result))
            return;

        $row = $result->current();
        $question->setId($row->id)
                 ->setMessage($row->message)
                 ->setSessId($row->sessId)
                 ->setRole($row->role);
    }
    
    public function findBySess($sessId)
    {
        $select = $this->getDbTable()->select()->where('sessId = ?', $sessId);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        
        if (!count($resultSet)) {
            throw new Zend_Exception('No chat found.');
        }
        
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Chat();
            $entry->setId($row->id)
                  ->setMessage($row->message)
                  ->setSessId($row->sessId)
                  ->setRole($row->role);
            $entries[] = $entry;
        }
        
        return $entries;
    }
    
    public function selectDistinctSessId()
    {
        $select = $this->getDbTable()->select()->distinct()->from($this->_dbTable, 'sessId');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Chat();
            $entry->setSessId($row->sessId);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();

        foreach ($resultSet as $row) {
            $entry = new Application_Model_Chat();
            $entry->setId($row->id)
                  ->setMessage($row->message)
                  ->setSessId($row->sessId)
                  ->setRole($this->role);
            $entries[] = $entry;
        }

        return $entries;
    }
}

