<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Vendorpo extends Zend_Db_Table

    {

       protected $_name='vendorpo';
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

	   public function getUsersData()
       {
        $select = $this->_db->select()
                        ->from($this->_name);
        $results = $this->getAdapter()->fetchAll($select);
        
        return $results;
       }
        public function getvendorpo()
       {
         $select = $this->_db->select()
                    ->from(array('p' => 'vendorpo'))
                    ->join(array('l' => 'vendor'), 'p.vendor_name = l.id', array('vendor_name'));
                
         $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
       
       public function savevendorpo($data)
       {
           $vendor = new Vendor();
//           echo "<pre>";
//           print_r($data);
//           exit;
           date_default_timezone_set('Asia/Kolkata');
            $dt = new DateTime();
            $date =  $dt->format('Y-m-d H:i:s');
   $vendorpo_materials = new VendorPoMaterials();
            //print_r($date); exit;
      $data1=array( 'vendor_name'   =>  $data['vendor_name'],
                    'vendor_po'=>  $data['vendor_po'],
                    'department'=>  'Ram',
                    'shipping_address'=>  $data['shipping_address'],
                    'shipping' =>  $data['shipping'],
                    'delivery_date' =>  $data['delivery_date'],
                    'quote'        =>  $data['quote'],
                    'total_amt'        =>  $data['total_amt'],
                    'shipping_charge'        =>  $data['shipping_charge'],
                    'vat_charge'        =>  $data['vat_charge'],
                    'cst_charge'         =>  $data['cst_charge'],
                    'st_charge'     =>  $data['st_charge'],
                    'addn_req'     =>  $data['addn_req'],
                    'status'        =>  '0',
                    'date'          =>  $date);
      
       $vendorpo = new Vendorpo();
        
        if($data['id'] == ''){
            $id = $vendorpo->insert($data1);
            $vendorpo_id = $id;
                      for($i=0; $i<count($data[item]); $i++){
                   
                  $data2=array( 
                    'vendorpo_id'   =>trim($vendorpo_id),
                    'item'          =>trim($data[item][$i]),
                      'pdtid'          =>trim($data[pdtid][$i]),
                      'desc'          =>trim($data[desc][$i]),
                      'qty'           =>trim($data[qty][$i]),
                      'uom'           =>trim($data[uom][$i]),
                    'price'         =>trim($data[price][$i]),
                    'linetotal'     =>trim($data[linetotal][$i]),
                      'pending'           =>trim($data[qty][$i]));
                  
                  // print_r($data2);
                   // exit;
                  $id = $vendorpo_materials->insert($data2);
        
              }
              // Update PO ID in utilities
//              print_r($data['vendor_po']);
//              exit;
             
               $val = $vendor->vendorpo_update($data['vendor_po']);
             $dub = '0';
        } 
        
        else{
         
         $where = array('id =' => $data['id']);
         $vendorpo->update($data1, 'id='.$data['id']);  
         $vendorpo_id = $data['id'];
         
        $vendorpo_materials->delete('vendorpo_id='.$vendorpo_id);	
        
           for($i=0; $i<count($data[item]); $i++){
                   
                  $data2=array( 
                    'vendorpo_id'   =>trim($vendorpo_id),
                    'item'          =>trim($data[item][$i]),
                    'qty'           =>trim($data[qty][$i]),
                    'price'         =>trim($data[price][$i]),
                    'linetotal'     =>trim($data[linetotal][$i]),
                    'pending'           =>trim($data[qty][$i]));
                  
                  // print_r($data2);
                   // exit;
                  $id = $vendorpo_materials->insert($data2);
        
              }
              
         $dub = '2';
        }
         $data = '';
         return $dub;
    }
        
         public function getvendorpoval($data)
       {
       //echo "<pre>";    print_r($data); 
        $vendor_po = new Vendorpo();
        $material_vendordetails = new MaterialVendorDetails();
        $row = $vendor_po->fetchAll($vendor_po->select()->where('id = ?', $data['id']));
        $row = $row->toArray();
            // echo "<pre>";    print_r($row); exit;   
        $material_vendor = $material_vendordetails->getmaterial_vendor($row[0]['vendor_name']);
        
            
            $select2 = $this->_db->select()
                    ->from(array('p' => 'vendorpo_materials'))
                    ->where('p.vendorpo_id = ?', $row[0][id]);
            $materials = $this->getAdapter()->fetchAll($select2);
             //echo "<pre>"; print_r($material_vendor);
            // print_r(count($materials));
             for($i=0; $i<count($materials); $i++){
                 $materials[$i]['mat_vend'] = $material_vendor;
             }
             
           
         $row[0]['materials'] = $materials;
//         echo "<pre>"; print_r($row);
//         exit;
         return $row;
        }

    public function deletevendorpo($id)
       {
        //print_r($id); exit;
        $table = new Vendorpo();
        $vendorpo_materials = new VendorPoMaterials();
        $table->delete('id='.$id);
       
        $vendorpo_materials->delete('vendorpo_id='.$id);
         
        }
        
         public function approvedvendorpo($data)
       {
       //echo "<pre>";    print_r($data); exit;
             $data1=array('status'   =>  $data['status']);
             
             
       $vendorpo = new Vendorpo();
       $where = array('id =' => $data['vendorid']);
       $vendorpo->update($data1, 'id='.$data['vendorid']);  
         
         //print_r($row);
       return $row;
        }
      
        public function activevendor()
       {
            $vendor = new Vendor();
            $row1 = $vendor->fetchAll($vendor->select()->from('vendor',array('vendor.id','vendor.vendor_name'))->where('status = ?', '1'));
            $row1 = $row1->toArray();
            return $row1;
       } 
        
       
      
    }
