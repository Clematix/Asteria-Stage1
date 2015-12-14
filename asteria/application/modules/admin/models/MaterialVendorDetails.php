<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class MaterialVendorDetails extends Zend_Db_Table

    {

       protected $_name='material_vendordetails';
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

	   public function getvendordetails($data)
       {
             //  echo "<pre>"; 
        $select = $this->_db->select()
                        ->from($this->_name)
                        ->where('material_id=?',$data);
        $results = $this->getAdapter()->fetchAll($select);
       // print_r($results); exit;
        return $results;
       }
       
         public function getmaterial_vendor($data)
       {

        $select = $this->_db->select()
             ->from(array('p' => 'material_vendordetails'),array('material_id', 'vendoruom'))
                ->join(array('l' => 'material'), 'p.material_id = l.id', array('id', 'part_no'))
                ->where('vendor=?',$data['id']);
        
       // exit;
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
   
       
        public function getmaterialpdt($data)
       {


        $select = $this->_db->select()
             ->from(array('p' => 'material_vendordetails'),array('vendor', 'vendor_pdt_id', 'vendor_pdt_desc', 'vendoruom'))
                ->join(array('l' => 'uom'), 'p.vendoruom = l.id', array('id', 'uom'))
                ->join(array('m' => 'material'), 'p.material_id = m.id', array('id', 'part_no', 'material_desc'))
                ->where('material_id=?',$data['id'], 'vendor=?',$data['vendor_id']);
        
        
        $results = $this->getAdapter()->fetchRow($select);
        if($results['vendor_pdt_id'] == ''){
            $results['vendor_pdt_id'] = $results['part_no'];
        }
        
        if($results['vendor_pdt_desc'] == ''){
            $results['vendor_pdt_desc'] = $results['material_desc'];
        }
//      echo "<pre>";
//       print_r($results);
//       exit;
        return $results;
       }
       
       
    }
