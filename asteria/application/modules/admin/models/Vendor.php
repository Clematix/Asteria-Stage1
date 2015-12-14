<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Vendor extends Zend_Db_Table

    {

       protected $_name='vendor';
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
        public function getvendor()
       {
         $select = $this->_db->select()
                        ->from('vendor');
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
       
       public function savevendorlist($data)
       {
           date_default_timezone_set('Asia/Kolkata');
            $dt = new DateTime();
            $date =  $dt->format('Y-m-d H:i:s');
   
            //print_r($date); exit;
      $data1=array( 'vendor_name'   =>  $data['vendor_name'],
                    'vendor_address'=>  $data['vendor_address'],
                    'vendor_country'=>  $data['vendor_country'],
//                    'vendor_state'  =>  $data['vendor_state'],
//                    'vendor_city'   =>  $data['vendor_city'],
                    'contact_person'=>  $data['contact_person'],
                    'contact_phone' =>  $data['contact_phone'],
                    'contact_email' =>  $data['contact_email'],
                    'pan_no'        =>  $data['pan_no'],
                    'tin_no'        =>  $data['tin_no'],
                    'vat_no'        =>  $data['vat_no'],
                    'cst_no'        =>  $data['cst_no'],
                    'st_no'         =>  $data['st_no'],
                    'bank_name'     =>  $data['bank_name'],
                    'acc_name'     =>  $data['acc_name'],
                    'bank_acc_no'   =>  $data['bank_acc_no'],
                    'bank_branch'   =>  $data['bank_branch'],
                    'bank_ifsc'     =>  $data['bank_ifsc'],
                    'mfg_code'     =>  $data['mfg_code'],
             'vendor_category'     =>  $data['vendor_category'],
                    'status'        =>  '0',
                    'date'          =>  $date);
       
       $vendor = new Vendor();
        
        if($data['id'] == ''){
            $id = $vendor->insert($data1);
             $dub = '0';
        } 
        
        else{
         
         $where = array('id =' => $data['id']);
         $vendor->update($data1, 'id='.$data['id']);  
         $id = $data['id'];
         $dub = '2';
        }
         $data = '';
         return $dub;
    }
        
         public function getvendorlistval($data)
       {
      // echo "<pre>";    print_r($data); exit;
       $vendor = new Vendor();
        $row = $vendor->fetchAll($vendor->select()->where('id = ?', $data['id']));
       
        $row = $row->toArray();
         //echo "<pre>"; print_r($row); exit;
       return $row;
        }

    public function deletevendor($id)
       {
        //print_r($id); exit;
        $table = new Vendor();
        $table->delete('id='.$id);	
        }
        
         public function approvedvendor($data)
       {
       //echo "<pre>";    print_r($data); exit;
             $data1=array('status'   =>  $data['status']);
             
             
       $vendor = new Vendor();
       $where = array('id =' => $data['vendorid']);
       $vendor->update($data1, 'id='.$data['vendorid']);  
         
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
        
       
        public function shippingaddress()
       {
         $select = $this->_db->select()
                        ->from('utilies')
                        ->where('name=?','shipping_address');
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
       
       public function vendorpo()
       {
         $select = $this->_db->select()
                        ->from('utilies')
                        ->where('name=?','vendorpo');
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
                             
       public function vendorpo_update($val)
       {
//           print_r($val);
//           exit;
            $data = array('content' => $val);
            $n = $this->_db->update('utilies', $data, 'id=2');
       }
       
       public function grncount()
       {
         $select = $this->_db->select()
                        ->from('utilies')
                        ->where('name=?','grn');
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
    }
