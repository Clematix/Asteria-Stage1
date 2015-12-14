<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Bom extends Zend_Db_Table

    {

       
    protected $_name='bom';
    
   function checkUnique($bomid)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name,array('material_id'))
	                            ->where('material_id=?',$bomid);
//                                     ->where('project_id=?',$id);
	        $result = $this->getAdapter()->fetchRow($select);
	        if($result){
	            return true;
	        }
	        return false;
	    }
    
       public function getbommaterial($data)
       {
        $material = new Material();
        $row = $material->fetchAll($material->select()->where('id = ?', $data['id']));
        $row = $row->toArray();
        return $row;
        }
        
       
       public function fetchBom($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where('id=?', $id);
        $results = $this->getAdapter()->fetchRow($select);

        return $results;
    }
    
    public function fetchBomId($id) {
        $select = $this->_db->select()
                ->from($this->_name,array('bom_project_id'))
                ->where('id=?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }
    
    public function fetchBomQuanty($id) {
        $select = $this->_db->select()
                ->from($this->_name,array('quanty'))
                ->where('id=?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }
    
     public function changestatus($data)
       {
       $data=array('status'   =>  $data['status']);
       $material = new Bom();
       $where = array('id =' => $data['id']);
       $material->update($data, 'id='.$data['id']);  
         
         //print_r($row);
       return true;
        }
        
        
        function checkExist($bomid)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name,array('material_id'))
	                            ->where('id=?',$bomid);
	        $result = $this->getAdapter()->fetchOne($select);
	        if($result){
	            return $result;
	        }
	        return false;
	    }
            
            
            function getRevision($bomid)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name,array('bom_rev_id'))
	                            ->where('id=?',$bomid);
	        $result = $this->getAdapter()->fetchOne($select);
	        if($result){
	            return $result;
	        }
	        return false;
	    }
            
            function getBomBomrev($bomid)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name,array('bom_rev_id','bom_project_id'))
	                            ->where('material_id=?',$bomid);
	        $result = $this->getAdapter()->fetchRow($select);
	        if($result){
	            return $result;
	        }
	        return false;
	    }
            
            function getProjectInBom() {
                    $select = $this->_db->select()
                            ->from($this->_name, array('project_id'));

                    $result = $this->getAdapter()->fetchAll($select);
                    if ($result) {
                        return $result;
                    }
                    return false;
                                       }
                                       
                                       function projectID($id) {
                    $select = $this->_db->select()
                            ->from($this->_name, array('project_id'))
                            ->where('material_id = ?',$id);
                    $result = $this->getAdapter()->fetchAll($select);
                    if ($result) {
                        return $result;
                    }
                    return false;
                                       }
                                         public function getBomStatus($id) {
        $select = $this->_db->select()
                ->from($this->_name, array('status'))
                ->where('id=?', $id);

        $result = $this->getAdapter()->fetchOne($select);
        if ($result) {
            return $result;
        }
        return false;
    }
   public function checkbom($id) {
        $select = $this->_db->select()
                ->from($this->_name,array('id'))
                ->where('material_id=?', $id);

        $result = $this->getAdapter()->fetchOne($select);
        if ($result) {
            return $result;
        }
        return false;
    } 
    
                                       
   
}
