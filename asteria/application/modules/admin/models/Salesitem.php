<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Salesitem extends Zend_Db_Table

    {

       
    protected $_name='sales_lineitem';
    
   public function getWoMaterialId($id)
       {
       $select='select sl.id, sl.qty,sl.item_code,b.id as bid from sales_lineitem as sl inner join bom as b on sl.item_code=b.material_id where sl.status=0 and sl.sales_id='.$id;
            $result = $this->getAdapter()->fetchAll($select);
          
            if($result){
                return $result;
            }
            return false;
            
       }
       
       public function getWoMaterialIdInventory($id)
       {
            $select='select sl.id, sl.qty,sl.item_code,b.id as bid from sales_lineitem as sl inner join bom as b on sl.item_code=b.material_id where sl.sales_id='.$id;
//       $select='select sl.id, sl.qty,sl.item_code,b.id as bid from sales_lineitem as sl inner join bom as b on sl.item_code=b.material_id where sl.status=0 and sl.sales_id='.$id;
            $result = $this->getAdapter()->fetchAll($select);
          
            if($result){
                return $result;
            }
            return false;
            
       }
       public function getItemToPurchase($id)
       {
            $select='select sl.id, sl.qty,sl.item_code from sales_lineitem as sl left join bom as b on sl.item_code=b.material_id where sl.status=0 and b.material_id is NULL and sl.sales_id='.$id;
            $result = $this->getAdapter()->fetchAll($select);
           
            if($result){
                return $result;
            }
            return false;
            
       }
                                       

    public function total($id) {

        $select = $this->_db->select()
                ->from($this->_name, array('qty', 'unit_price'))
                ->where('sales_id = ?', $id);
        $result = $this->getAdapter()->fetchAll($select);
        if ($result) {
            return $result;
        }
    }

    public function lineitembyId($id) {

        $select = $this->_db->select()
                ->from($this->_name)
                ->where('sales_id = ?', $id);
        $result = $this->getAdapter()->fetchAll($select);
        if ($result) {
            return $result;
        }
    }

     public function getSoProject($id) {

        $select = $this->_db->select()
                ->from($this->_name,array('project_id'))
                ->where('id = ?', $id);
        $result = $this->getAdapter()->fetchOne($select);
        if ($result) {
            $project=new Project();
         return $project->getProjectName($result);
      
        }
    }
    
    
    
}
