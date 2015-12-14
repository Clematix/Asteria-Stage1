<?php

class Zend_Controller_Action_Helper_Model extends Zend_Controller_Action_Helper_Abstract {

    public function authUser($table, $email, $password) {
      
        $db_table = new $table();
        $auth = Zend_Auth::getInstance();
        $authAdapter = new Zend_Auth_Adapter_DbTable($db_table->getAdapter(), $table); 
        $authAdapter->setIdentityColumn('email')
                ->setCredentialColumn('password');
        $authAdapter->setIdentity($email)
                ->setCredential(md5($password));
        $result = $auth->authenticate($authAdapter);
        if ($result->isValid()) {
            $storage = new Zend_Auth_Storage_Session();
            $storage->write($authAdapter->getResultRowObject());
            return 1;
        } else {
            return 0;
        }

    }
    

    public function checkUnique($table, $email) {
        $table_name = $table;
        $db_table = new $table_name();
        if ($db_table->checkUnique($email)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function checkExist($table,$data_exist,$data) {
        $db_table = new $table();
       
        $row = $db_table->fetchRow($db_table->select()->where($data_exist.' = ?', $data['name']));
        if($row)
        {
            return $row;
        }

//	        return false;
    }
    public function insert($table, $data) {
        $table_name = $table;
        $db_table = new $table_name();
//        $email=$data['email'];
        if ($db_table->insert($data)) {
//             $db_table->insert($data);
            return 1;
        } else {
             return 0;
        }
    }
    
    public function selectAll($table,$id=null)
    {
        $table_name = $table;
        $db_table = new $table_name();
        return $db_table->fetchAll();
        
    }
    
     public function selectAllBystatus($table,$id=null)
    {
        $table_name = $table;
        $db_table = new $table_name();
        return $db_table->fetchAll($db_table->select()->where('status = ?', '1'));
        
    }
     public function fetchrow($table,$id)
    {  
        $table_name = $table;
        $db_table = new $table_name();
        if($db_table->fetchRow($db_table->select()->where('email = ?', $id)))
        {
            return $db_table->fetchRow($db_table->select()->where('email = ?', $id));
        }

        if($db_table->fetchRow($db_table->select()->where('id = ?', $id)))
        {
              return $db_table->fetchRow($db_table->select()->where('id = ?', $id));
        }
        return false;
        
    }
    public function update($table,$id,$data){
        $table_name = $table;
        $db_table = new $table_name();
        $where = $db_table->getAdapter()->quoteInto('id = ?', $id);
        if($db_table->update($data, $where)){
        return true;}
        else{ return false;}
    }
    
    public function updateRole($table,$id,$data){
        $table_name = $table;
        $db_table = new $table_name();
         $where = $db_table->getAdapter()->quoteInto('acl_role_id = ?', $id);
        if($db_table->update($data, $where)){
        return true;
        
        }
        else{ 
            return false;
            
        }
    }
    
    public function delete($table, $id)
    {    $table_name = $table;
         $db_table = new $table_name();
         $row = $db_table->fetchRow($db_table->select()->where('id = ?', $id));
         $where = $db_table->getAdapter()->quoteInto('id = ?', $id);
         $db_table->delete($where);
         return true;
    }
    
     public function deleterow($table, $id)
    {    $table_name = $table;
         $db_table = new $table_name();
         $row = $db_table->fetchRow($db_table->select()->where('acl_role_id = ?', $id));
         $where = $db_table->getAdapter()->quoteInto('acl_role_id = ?', $id);
         $db_table->delete($where);
         return true;
    }
  
     public function checklogged()
    {   
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if ($data) {
            return $data;
        }
        else{
            return 0;
            
        }
    }
}
