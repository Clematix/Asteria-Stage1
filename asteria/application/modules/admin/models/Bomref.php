<?php


class Bomref extends Zend_Db_Table

    {

       
    protected $_name='bom_ref';
    
    public function checkUnique($bomid,$id)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name,array('material_id'))
	                            ->where('material_id=?',$bomid)
                                     ->where('project_id=?',$id);
	        $result = $this->getAdapter()->fetchRow($select);
	        if($result){
	            return true;
	        }
	        return false;
	    }
    
       public function getBomRefMaterial($data)
       {
        $material = new Bomref();
        $row = $material->fetchAll($material->select()->where('bom_id = ?', $data));
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
        
        public function getallBomLine($id)
       {
        $select = $this->_db->select()
                ->from($this->_name,array('bom_id'))
                ->where('material_id=?', $id);
        $results = $this->getAdapter()->fetchAll($select);

        return $results;

        }
         public function getWoMaterialId_BomHasBom($id) {

        $select = $this->_db->select()
                ->from($this->_name, array('bom_id', 'material_id', 'qty'))
                ->where('bom_id=?', $id);
        $results = $this->getAdapter()->fetchAll($select);
      
        if ($results) {
            return $results;
        } else {
            return false;
        }
    }
       
    }
