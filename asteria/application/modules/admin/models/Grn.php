<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Grn extends Zend_Db_Table

    {

       protected $_name='grn';
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
       
        public function grnlist()
       {
         $select = $this->_db->select()
                        ->from(array('p' => 'grn'))
                        ->join(array('l' => 'vendor'), 'p.vendor_name = l.id', array('vendor_name'))
                        ->join(array('m' => 'vendorpo'), 'p.vendor_po = m.id', array('vendor_po'));
         
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
       
       
       public function getvendorpovals($data)
       {
       //echo "<pre>";    print_r($data);  exit;
        $vendor_po = new Vendorpo();
        $row = $vendor_po->fetchAll($vendor_po->select()->from('vendorpo',array('vendorpo.id','vendorpo.vendor_po'))->where('vendor_name = ?', $data['val'])->where('status = ?', '1'));
        $row = $row->toArray();
         //   echo "<pre>";    print_r($row); exit;   
         return $row;
        }
        
          public function getvendorpo_materials($data)
       {
       //echo "<pre>";    print_r($data);  exit;
         $vendorpo_materials = new VendorPoMaterials();
        $row = $vendorpo_materials->fetchAll($vendorpo_materials->select()->where('vendorpo_id = ?', $data['val']));
        $row = $row->toArray();
        
         $select = $this->_db->select()
                    ->from(array('p' => 'vendorpo_materials'))
                    ->join(array('l' => 'material'), 'p.item = l.id', array('part_no'))
                    ->where('vendorpo_id = ?', $data['val']);
                
         $results = $this->getAdapter()->fetchAll($select);
         
         
         //   echo "<pre>";    print_r($row); exit;   
         return $results;
        }
        
         public function getinventorydetails($data)
       {
         $select = $this->_db->select()
                    ->from('material')
                    ->where('id = ?', $data['itemid']);
          $material_det = $this->getAdapter()->fetchAll($select);
          
       //  print_r($material_det);
          $select1 = $this->_db->select()
                    ->from(array('p' => 'inventory'))
                    ->where('itemid = ?', $data['itemid'])
                    ->order('uniqueid desc')
                    ->limit(1) ;
                
            $results = $this->getAdapter()->fetchAll($select1);
            
          //  print_r($results); 
            
           $count = $data['okqty'];
          if($material_det[0]['stock_handling'] == 'Item'){
            
              // Vendor Details
              $mat_vendordet = $this->_db->select()
                    ->from('material_vendordetails')
                    ->where('material_id = ?', $data['itemid'])
                    ->where('vendor =?', $data['vendorid']);
           
         $mat_vendordet = $this->getAdapter()->fetchAll($mat_vendordet);
           // print_r($mat_vendordet);
              
            
          
            
             if($material_det[0][uom] == $mat_vendordet[0][vendoruom]){
                            $count = $data['okqty'];
                }
             else{
                 // Conversion Factor
                  $count        = 'New';
                  $basic        = $mat_vendordet[0][conv_vend_basic];
                  $conv_vend    = $mat_vendordet[0][conv_vend];
                  
                  $converted = $data['okqty'] / $conv_vend ; 
                  $count = $converted * $basic ;
                  
                  $int = explode('.',$count);
                  if($int[1]){
                      $count = $int[0];
                  }
                  else{
                      $count = $count;
                  }
                }
                
                
//                print_r($count);
//                exit;
                $init = $results[0][uniqueid];
                    $uniq = '';
                     
                    if($results){
                        //echo "Yes";
                        for($i=1; $i<=$count; $i++){
                            $uniq.= "".++$init.", ";
                            $trimwhere = rtrim($uniq, ", ");
                        }

                    }
                    else{
                        $init = 'AA000';
                        for($i=1; $i<=$count; $i++){
                            $uniq.= "".++$init.", ";
                            $trimwhere = rtrim($uniq, ", ");
                        }
                    }
                $uniquevals = $trimwhere;
             
         }
          
          
          
         if($material_det[0]['stock_handling'] == 'Batch'){
             // echo "Batch";
            $count = '1';
              date_default_timezone_set('Asia/Kolkata');
                $dt = new DateTime();
             $current =  $dt->format('y-m-d');
            // print_r($current);
             $date =  substr($results[0]['uniqueid'], 0, 8);
             if($date == $current){
                $char =  substr($results[0]['uniqueid'], 9);
             //   print_r($char);
                $init = $char;
                for($i=1; $i<=$count; $i++){
                            $uniq.= $current."-".++$init.", ";
                            $trimwhere = rtrim($uniq, ", ");
                        }
             }
             else{
                 $init = 'AA';
                 for($i=1; $i<=$count; $i++){
                            $uniq.= $current."-".$init++.", ";
                            $trimwhere = rtrim($uniq, ", ");
                        }
             }
                 $uniquevals = $trimwhere;
          }
           print_r($uniquevals); 
         return $uniquevals;
        }
        
        
        public function getinventorydetailsedit($data)
       {
//            echo "<pre>";
//            print_r($data);
         $serial=array();
         $select = $this->_db->select()
                    ->from('material')
                    ->where('id = ?', $data['itemid']);
          $material_det = $this->getAdapter()->fetchAll($select);
          
       //  print_r($material_det);
          $select1 = $this->_db->select()
                    ->from(array('p' => 'inventory'))
                    ->where('itemid = ?', $data['itemid'])
                    ->order('uniqueid desc')
                    ->limit(1) ;
                
            $results = $this->getAdapter()->fetchAll($select1);
            
          //  print_r($results); 
            
           $count = $data['okqty'];
           if($count<0){
               $count = substr($count,1);
           }
//           print_r($count);
//           exit;
          if($material_det[0]['stock_handling'] == 'Item'){
            
              // Vendor Details
              $mat_vendordet = $this->_db->select()
                    ->from('material_vendordetails')
                    ->where('material_id = ?', $data['itemid'])
                    ->where('vendor =?', $data['vendorid']);
           
         $mat_vendordet = $this->getAdapter()->fetchAll($mat_vendordet);
           //  print_r($mat_vendordet);
              
            
          
            
             if($material_det[0][uom] == $mat_vendordet[0][vendoruom]){
                            $count = $count;
                }
             else{
                 // Conversion Factor
                 
                }
                
                $init = $results[0][uniqueid];
                    $uniq = '';
                     
                    if($results){
                        //echo "Yes";
                        for($i=1; $i<=$count; $i++){
                            $uniq.= "".++$init.", ";
                            $trimwhere = rtrim($uniq, ", ");
                        }

                    }
                    else{
                        $init = 'AA000';
                        for($i=1; $i<=$count; $i++){
                            $uniq.= "".++$init.", ";
                            $trimwhere = rtrim($uniq, ", ");
                        }
                    }
                $uniquevals = $trimwhere;
             
         }
          
          
          
         if($material_det[0]['stock_handling'] == 'Batch'){
             // echo "Batch";
              date_default_timezone_set('Asia/Kolkata');
                $dt = new DateTime();
             $current =  $dt->format('y-m-d');
            // print_r($current);
             $date =  substr($results[0]['uniqueid'], 0, 8);
             if($date == $current){
                $char =  substr($results[0]['uniqueid'], 9);
             //   print_r($char);
                $init = $char;
                for($i=1; $i<=$count; $i++){
                            $uniq.= $current."-".++$init.", ";
                            $trimwhere = rtrim($uniq, ", ");
                        }
             }
             else{
                 $init = 'AA';
                 for($i=1; $i<=$count; $i++){
                            $uniq.= $current."-".$init++.", ";
                            $trimwhere = rtrim($uniq, ", ");
                        }
             }
                 $uniquevals = $trimwhere;
          }
          
           
           $data['serial'] .= ", ".$uniquevals;
           $serial['serial'] = $data['serial'];
           $serial['toadd'] = $uniquevals;
          // print_r($uniquevals); 
          // exit;
         return $serial;
        }
        
         public function savegrnval($data)
       {


           date_default_timezone_set('Asia/Kolkata');
            $dt = new DateTime();
            $date =  $dt->format('Y-m-d H:i:s');
            
        $grn = new Grn();
        $grn_material = new Grnmaterial();
        $inventory = new Inventory();
         $vendorpo_materials = new VendorPoMaterials();
           
            
           
      $data1=array( 'vendor_name'   =>  $data['vendor_name'],
                    'vendor_po'     =>  $data['vendor_po'],
                    'grn_no'        =>  $data['grn_no'],
                    'grn_date'      =>  $data['grn_date'],
                    'status'      =>  '0',
                    'date'          =>  $date);
      
      
//       print_r($data1);
//       exit;
        if($data['id'] == ''){
            $id = $grn->insert($data1);
            $grn_id = $id;
                 for($i=0; $i<count($data[item]); $i++){
                   
                  $data2=array( 
                    'grn_id'        =>trim($grn_id),
                    'item'          =>trim($data[item][$i]),
                    'poqty'         =>trim($data[poqty][$i]),
                    'rcvdqty'       =>trim($data[rcvdqty][$i]),
                    'okqty'         =>trim($data[okqty][$i]),
                    'rejectedqty'   =>trim($data[rejectedqty][$i]),
                    'ast_sl'        =>trim($data[ast_sl][$i]),
                    'mfgdate'       =>trim($data[mfgdate][$i]),
                    'expiry'        =>trim($data[expiry][$i]),
                    'serial'        =>trim($data[serial][$i]));
                  

                  $grnmat = $grn_material->insert($data2);
                  $serial_count = explode(", ", $data[serial][$i]);
                  
                  // Adding to Inventory
                  for($j=0; $j<count($serial_count); $j++){
                            $data3=array( 
                            'grn_id'     =>trim($grn_id),
                            'itemid'     =>trim($data[item][$i]),
                            'uniqueid'   =>trim($serial_count[$j]),
                            'status'     =>'0');
                           $inv = $inventory->insert($data3);
                    
                  }
                  
                  $balance = trim($data[poqty][$i]) - trim($data[okqty][$i]);
                   $pending=array('pending'      =>  $balance);
                    
                    $where = array('vendorpo_id = ?' => $data[vendor_po],'item = ?' => $data[item][$i]);
                    $vendorpo_materials->update($pending, $where);   
                  
             //   exit;  
            }
             $grnpo = $grn->grnponum_update($data['grn_no']);
             $dub = '0';
        } 
        
        else{
            
            $data4=array('grn_date'      =>  $data['grn_date'],
                        'status'      =>  '0');
            
         $where = array('id =' => $data['id']);
         
         $grn->update($data4, 'id='.$data['id']);  
         $grn_id = $data['id'];
         
         for($i=0; $i<count($data[item]); $i++){
                   
                  $data5=array( 
                    'rcvdqty'       =>trim($data[rcvdqty][$i]),
                    'okqty'         =>trim($data[okqty][$i]),
                    'rejectedqty'   =>trim($data[rejectedqty][$i]),
                    'ast_sl'        =>trim($data[ast_sl][$i]),
                    'mfgdate'       =>trim($data[mfgdate][$i]),
                    'expiry'        =>trim($data[expiry][$i]),
                    'serial'        =>trim($data[serial][$i]));
                  

                //  $grnmat = $grn_material->insert($data5);
                  
                  $where = array('id =' => $data[grn_mat_id][$i]);
                  $grn_material->update($data5, 'id='.$data[grn_mat_id][$i]);
                    
                  if($data[toadd][$i]){
                  $serial_count = explode(", ", $data[toadd][$i]);
                //  print_r(count($serial_count));
                //  exit;
                  // Adding to Inventory
                  for($j=0; $j<count($serial_count); $j++){
                            $data6=array( 
                            'grn_id'     =>trim($grn_id),
                            'itemid'     =>trim($data[item][$i]),
                            'uniqueid'   =>trim($serial_count[$j]),
                            'status'     =>'0');
                           $inv = $inventory->insert($data6);
                    
                        }
                      }
                      
                        if($data[todel][$i]){
                  $serial_count = explode(", ", $data[todel][$i]);
                  
                        for($j=0; $j<count($serial_count); $j++){
                                            $condition = array(
                                                    'uniqueid = ?' => trim($serial_count[$j]),
                                                    'grn_id = ?' => $grn_id
                                                );
                                          //  print_r($condition);
                                        $this->_db->delete('inventory', $condition);
                           // $this->_db->delete('inventory', array('uniqueid = ?' => $serial_count[$j],'grn_id = ?' => $grn_id));
                        }
                      }
               
            }
            //exit;
         $dub = '2';
        }
         $data = '';
         return $dub;
    }
    
      public function getgrnval($data)
       {
       //  echo "<pre>";    print_r($data); exit;
        $grn = new Grn();
        $row = $grn->fetchAll($grn->select()->where('id = ?', $data['id']));
        $row = $row->toArray();
        
        $select = $this->_db->select()
                        ->from(array('p' => 'grn_material'))
                        ->join(array('m' => 'material'), 'p.item = m.id', array('part_no'))
                        ->Where('grn_id = ?', $data['id']);
         
        $materials = $this->getAdapter()->fetchAll($select);
       $row[0]['materials'] = $materials;
        
        return $row;
        }
          public function getvendorpo($data)
       {
          
         $vendorpo = new Vendorpo();
      $vald1 = $vendorpo->fetchAll($vendorpo->select()
                                            ->from('vendorpo',array('vendorpo.id','vendorpo.vendor_po'))
                                            ->Where('vendor_name = ?', $data)
                                            ->Where('status = ?', '1'));
       $results = $vald1->toArray();
      // print_r($results);
                for($i=0; $i<count($results); $i++){
                  $val[$results[$i]['id']] = $results[$i]['vendor_po'];
                }
        return $val;
       }
       
         public function grnponum_update($val)
       {
//           print_r($val);
//           exit;
            $data = array('content' => $val);
            $n = $this->_db->update('utilies', $data, 'id=3');
       }
       
        public function approvedgrn($data)
       {
       //echo "<pre>";    print_r($data); exit;
             $data1=array('status'   =>  $data['status']);
             
             
        $grn = new Grn();
       $where = array('id =' => $data['vendorid']);
       $grn->update($data1, 'id='.$data['vendorid']);  
         
         //print_r($row);
       return $row;
        }
        
    }
