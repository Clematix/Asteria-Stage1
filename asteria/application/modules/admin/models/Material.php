<?php

/* class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
  } */

class Material extends Zend_Db_Table {

    protected $_name = 'material';

    function checkUnique($email) {
	        $select = $this->_db->select()
                ->from($this->_name, array('email'))
                ->where('email=?', $email);
	        $result = $this->getAdapter()->fetchOne($select);
        if ($result) {
	            return true;
	        }
	        return false;
	    }

    public function getUsersData() {
        $select = $this->_db->select()
                        ->from($this->_name);
        $results = $this->getAdapter()->fetchAll($select);
        
        return $results;
       }
       
    public function getmaterial() {
                $material = new Material();
            //    $material_vendordetails = new MaterialVendorDetails();
             
         $select = $this->_db->select()
                        ->from('material');
        $results = $this->getAdapter()->fetchAll($select);
        
        for ($i = 0; $i < count($results); $i++) {
             
             // To Get UOM Name Starts
                    $uomname = $material->getuom_name($results[$i][uom]);
                    $results[$i]['uomname'] = $uomname[0][uom];
            // To Get UOM Name Ends
        // Vendor Information Details Starts
             //   $vendordetails = $material_vendordetails->getvendordetails($results[$i][id]);
        //  print_r($vendordetails); 
//          for($j=0; $j<count($vendordetails); $j++){
//              $k = $j +1;
//              $results[$i]['vendor_'.$k] = $vendordetails[$j][vendor];
//              $results[$i]['vendor_pdt_id_'.$k] = $vendordetails[$j][vendor_pdt_id];
//              $results[$i]['vendor_pdt_desc_'.$k] = $vendordetails[$j][vendor_pdt_desc];
//              $results[$i]['lead_time_'.$k] = $vendordetails[$j][lead_time];
//              $results[$i]['vendoruom_'.$k] = $vendordetails[$j][vendoruom];
//              $results[$i]['list_price_'.$k] = $vendordetails[$j][list_price];
//              $results[$i]['moq_'.$k] = $vendordetails[$j][moq];
//              $results[$i]['conv_vend_basic_'.$k] = $vendordetails[$j][conv_vend_basic];
//              $results[$i]['conv_vend_'.$k] = $vendordetails[$j][conv_vend];
//              
//          }
        // Vendor Information Details Ends
        }
//        echo "<pre>";
//       print_r($results); 
//        exit;
        return $results;
       }
       
    public function getuom_name($id) {
         $select = $this->_db->select()
                        ->from('uom')
                ->where('id=?', $id);
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
       
    public function getmaterialmaxid() {
         $select = $this->_db->select()
                ->from(array('material'), array('max(id)'));
        $results = $this->getAdapter()->fetchOne($select);
        $newid = $results + 1;
        $count = strlen($newid);
        $i = 5 - $count;
        
        for ($j = $i; $j > 0; $j--) {
            $newid = '0' . $newid;
        }
        return $newid;
       }
       
    public function getuom() {
         $select = $this->_db->select()
                        ->from('uom');
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
       
    public function savematerial($data, $user) {
//        echo "<pre>";
//        print_r($data);
//        exit;
        
            date_default_timezone_set('Asia/Kolkata');
            $dt = new DateTime();
             $material = new Material();
            $material_vendordetails = new MaterialVendorDetails();
            
            
            // Removing last '-' Starts
                $part = $data['part_no'];
                            //$string = 'AAAA-00005-A-0001-';       //print_r($string);echo "<br>";
                 $part_val = substr($part,-1);                    //print_r($part_val);echo "<br>";
                if($part_val == '-'){
                    $part_val2 = substr($part,0, -1);
                    $data['part_no'] = $part_val2;
                }
             // Removing last '-' Ends
             
                 $revis_new = 'A';
             // No Revision or Drawing for Other than Asteria Starts
                if($data['design_base']!='A'){
                    $data['drawing_no']='';
                    $revis_new='';
                  
                }
                else{
                   $rev = 'A';
                 }
                
                // Ends
               if(!$data['id']){
                    $createddate =  $dt->format('Y-m-d H:i:s');
                    $createduser = $user->id;
                    
                    
                    if($_FILES["upload"]["name"]){
                   if($data['design_base']=='A'){
                        $img_name=$_FILES["upload"]["name"];
                        //  print_r($img_name); 
          	$pcs=explode(" ",$img_name);
              //  print_r($pcs);
               foreach($pcs as $img1)
		{
			$imgname1.=$img1."_";
		}
                $ext=explode(".",$img_name);
                $newname= $data['drawing_no'].'-'.$rev.'.'.$ext[1];
             //  print_r($newname); print_r($newname); $len=strlen($imgname1); $imgname=substr($imgname1,0,($len-1));	
                $imgname = $newname;
             //   exit;
            }
            else{
               $img_name=$_FILES["upload"]["name"];
             $imgname = $img_name;
             $newname = $imgname;
          	
            }
		
                    move_uploaded_file($_FILES["upload"]["tmp_name"],"image/" . $imgname);
                  // echo "Stored in: " . "image/" . $img_name;
//                        echo "<pre>";
//                        print_r($data['part_no']);
//                       
                    }
                    else{
                     $newname = '';   
                    }
                        
            $data1=array('part_no'          =>trim($data['part_no']),
                    'material_desc'         =>trim($data['material_desc']),
                    'uom'                   =>trim($data['uom']),
                    'drawing_no'            =>trim($data['drawing_no']),
                    'revision_no'           =>  $revis_new,
                    'material_status'       =>trim($data['material_status']),
                    'upload'                =>$newname,
                    'material_category'     =>trim($data['material_category']),
                    'material_sub_category' =>trim($data['material_sub_category']),
                    'material_type'         =>trim($data['material_type']),
                    'design_base'           =>trim($data['design_base']),
                    'mech_position'         =>trim($data['mech_position']),
                    'mech_finish'           =>trim($data['mech_finish']),
                    'oem_name'              =>trim($data['oem_name']),
                    'oem_pdt_id'            =>trim($data['oem_pdt_id']),
                    'oem_pdt_desc'          =>trim($data['oem_pdt_desc']),
                    'oem_lead_time'         =>trim($data['oem_lead_time']),
                    'min_stock'             =>trim($data['min_stock']),
                    'stock_handling'        =>trim($data['stock_handling']),
                    'moving_price'          =>trim($data['moving_price']),
                    'manuf_cost'            =>trim($data['manuf_cost']),
                    'gen_price'             =>trim($data['gen_price']),
                    'mat_life'              =>trim($data['mat_life']),
                    'weight'                =>trim($data['weight']),
                    'addn_info'             =>trim($data['addn_info']),
                    'status'                => '0',
                    'created_date'          => $createddate,
                    'created_user'          => $createduser,
                    'updated_date'          =>  '0',
                    'updated_user'          =>  '0');
                   

                $vald1 = $material->fetchAll($material->select()
                                            ->where('material_desc = ?', trim($data['material_desc'])));
                $vald1 = $vald1->toArray();
          
                if(count($vald1) == '0'){   
                        $id = $material->insert($data1);
                       
                       $material_id = $id;
                      for($i=0; $i<count($data[vendor]); $i++){
                   
                  $data2=array( 
                    'material_id'       =>trim($material_id),
                    'vendor'            =>trim($data[vendor][$i]),
                    'vendor_pdt_id'     =>trim($data[vendor_pdt_id][$i]),
                    'vendor_pdt_desc'   =>trim($data[vendor_pdt_desc][$i]),
                    'lead_time'         =>trim($data[lead_time][$i]),
                    'vendoruom'         =>trim($data[vendoruom][$i]),
                    'list_price'        =>trim($data[list_price][$i]),
                    'moq'               =>trim($data[moq][$i]),
                    'conv_vend_basic'   =>trim($data[conv_vend_basic][$i]),
                    'conv_vend'         =>trim($data[conv_vend][$i]));
                  
                  // print_r($data2);
                   // exit;
                  $id = $material_vendordetails->insert($data2);
               }
                        
                         $dub = '0';
            } else {
                         $dub = '1';
                 }
        } else {
//          echo "Save"; 
//          echo "<pre>";
//          
//          exit;
                   $updateduser = $user->id;
                   $updateddate =  $dt->format('Y-m-d H:i:s');
                   
                   
                        if($data['design_base']!='A'){
                            $rev = '';
                        }
                        else{
                            $rev = ++$data['revision_no'];
                        }
                        
                   $select = $this->_db->select()
                        ->from('material')
                           ->where('id = ?', trim($data['id']));
                 $uploaded = $this->getAdapter()->fetchAll($select);
                 
//                 print_r($uploaded);
//                 exit;
        if($_FILES["upload"]["name"]){
          // print_r($data['design_base']);
            if($data['design_base']=='A'){
                $img_name=$_FILES["upload"]["name"];
              //  print_r($img_name); 
          	$pcs=explode(" ",$img_name);
              //  print_r($pcs);
               foreach($pcs as $img1)
		{
			$imgname1.=$img1."_";
		}
                $ext=explode(".",$img_name);
                $newname= $data['drawing_no'].'-'.$rev.'.'.$ext[1];
             //  print_r($newname); print_r($newname); $len=strlen($imgname1); $imgname=substr($imgname1,0,($len-1));	
                $imgname = $newname;
             //   exit;
            }
            else{
               $img_name=$_FILES["upload"]["name"];
             $imgname = $img_name;
             $newname = $imgname;
          	
            }
                    move_uploaded_file($_FILES["upload"]["tmp_name"],"image/" . $imgname);
                 //  echo "Stored in: " . "image/" . $img_name;
            }
            else {
            $rev = $uploaded[0]['revision_no'];
            $newname = $uploaded[0]['upload'];
          //  $newname = '';   
          }
       // echo "Ram2122"; exit;
                  $data1=array( 
                    'part_no'               =>trim($data['part_no']),
                    'material_desc'         =>trim($data['material_desc']),
                    'revision_no'           =>$rev,
                    'design_base'           =>trim($data['design_base']),
                    'material_status'       =>trim($data['material_status']),
                    'upload'                =>$newname,
                    'oem_name'              =>trim($data['oem_name']),
                    'oem_pdt_id'            =>trim($data['oem_pdt_id']),
                    'oem_pdt_desc'          =>trim($data['oem_pdt_desc']),
                    'oem_lead_time'         =>trim($data['oem_lead_time']),
                    'min_stock'             =>trim($data['min_stock']),
                    'mat_life'              =>trim($data['mat_life']),
                    'weight'                =>trim($data['weight']),
                    'addn_info'             =>trim($data['addn_info']),
                    'status'                =>  '0',
                    'updated_date'          =>  $updateddate,
                    'updated_user'          =>  $updateduser);
                  
                 //   echo "==";  echo "<pre>"; print_r($data); exit;
                   $where = array('id =' => $data['id']);
                 $material->update($data1, 'id='.$data['id']);  
                 $id = $data['id'];
                   $dub = '2';
                   
               $material_id = $id;
 
                   
            for ($i = 0; $i < count($data[vendor]); $i++) {
                   
                  $data2=array( 
                    'material_id'       =>trim($material_id),
                    'vendor'            =>trim($data[vendor][$i]),
                    'vendor_pdt_id'     =>trim($data[vendor_pdt_id][$i]),
                    'vendor_pdt_desc'   =>trim($data[vendor_pdt_desc][$i]),
                    'lead_time'         =>trim($data[lead_time][$i]),
                    'vendoruom'         =>trim($data[vendoruom][$i]),
                    'list_price'        =>trim($data[list_price][$i]),
                    'moq'               =>trim($data[moq][$i]),
                    'conv_vend_basic'   =>trim($data[conv_vend_basic][$i]),
                    'conv_vend'         =>trim($data[conv_vend][$i]));
                  
                 //  print_r($data1);
                  $where = array('id='.$data[vendor_id][$i]);
                   $material_vendordetails->update($data2, 'id='.$data[vendor_id][$i]);  
              //     $id = $material_vendordetails->insert($data1);
               }
               
               
//                   echo "<pre>"; 
//                print_r($data);
//                exit;
              }
      
            $data = '';
            return $dub;
        }
       
    public function getmaterialval($data) {
        $material = new Material();
        $material_vendordetails = new MaterialVendorDetails();
        $row = $material->fetchAll($material->select()->where('id = ?', $data['id']));
        $row = $row->toArray();
         
        
          for ($i=0; $i<count($row); $i++) {
             
                $uomname = $material->getuom_name($row[$i][uom]);
                $row[$i]['uomname'] = $uomname[0][uom];
                 $subcat= explode('-',$row[$i][part_no]);
                  $row[$i]['subcat_val'] = $subcat[0]; 
                   $row[$i]['newid'] = $subcat[2]; 
        // Vendor Information Details Starts
               //   print_r($row[$i][id]);
                $vendordetails = $material_vendordetails->getvendordetails($row[$i][id]);
       //  echo "<pre>"; print_r($vendordetails); exit;
         for($j=0; $j<count($vendordetails); $j++){
              $k = $j +1;
              $row[$i]['vendor_id_'.$k] = $vendordetails[$j][id];
             $row[$i]['vendor_'.$k] = $vendordetails[$j][vendor];
              $row[$i]['vendor_pdt_id_'.$k] = $vendordetails[$j][vendor_pdt_id];
              $row[$i]['vendor_pdt_desc_'.$k] = $vendordetails[$j][vendor_pdt_desc];
              $row[$i]['lead_time_'.$k] = $vendordetails[$j][lead_time];
              $row[$i]['vendoruom_'.$k] = $vendordetails[$j][vendoruom];
                            $uomname = $material->getuom_name($vendordetails[$j][vendoruom]);
              $row[$i]['vendoruomval_'.$k] = $uomname[0][uom];
              $row[$i]['list_price_'.$k] = $vendordetails[$j][list_price];
              $row[$i]['moq_'.$k] = $vendordetails[$j][moq];
              $row[$i]['conv_vend_basic_'.$k] = $vendordetails[$j][conv_vend_basic];
              $row[$i]['conv_vend_'.$k] = $vendordetails[$j][conv_vend];
       }
        // Vendor Information Details Ends
      }
      
       
//        echo "<pre>";  
//      print_r($row);
//        exit;
       return $row;
        }
       
    public function changestatusmaterial($data) {
        $data1 = array('status' => $data['status']);
       $material = new Material();
       $where = array('id =' => $data['vendorid']);
        $material->update($data1, 'id=' . $data['vendorid']);
         
         //print_r($row);
       return $row;
        }

    public function getBomType() {

        $select = $this->_db->select()
                ->from('material', array('material_type'));
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
    }

    public function fetchUom($id) {
        $select = $this->_db->select()
                ->from('uom', array('uom'))
                ->where('id=?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }

    public function deletematerial($id) {
        //print_r($id); exit;
        $mat_table = new Material();
        $bom_table = new Bom();
        $bomref_table = new Bomref();
        
        
        $bomref = $this->_db->select()
                ->from('bom_ref')
                ->where('material_id=?', $id);
        $bomref_values = $this->getAdapter()->fetchAll($bomref);
     //  print_r($bomref_values);
     
        $inventory = $this->_db->select()
                ->from('inventory')
                ->where('itemid=?', $id)
                ->where('status=?', '0');
        $inventory_values = $this->getAdapter()->fetchAll($inventory);
//     print_r($inventory_values);
//     
//         exit;  
        $workorder = $this->_db->select()
                ->from('work_order')
                ->where('item_id=?', $id)
                ->where('status=?', '0');
        $workorder_values = $this->getAdapter()->fetchAll($workorder);
        
        $saleslineitem = $this->_db->select()
                ->from('sales_lineitem')
                ->where('item_code=?', $id);
               
        $saleslineitem_values = $this->getAdapter()->fetchAll($saleslineitem);
      //  print_r($saleslineitem_values);
        
        $vendorpomat = $this->_db->select()
                ->from('vendorpo_materials')
                ->where('item=?', $id);
        $vendorpomat_values = $this->getAdapter()->fetchAll($vendorpomat);
     //   print_r($vendorpomat_values);
        
        
     //  exit;
       if((count($bomref_values) > '0') || (count($inventory_values) > '0') || (count($workorder_values) > '0') || (count($saleslineitem_values) > '0') || (count($vendorpomat_values) > '0')){
         // echo "Del";
            $val = '0';
     }
     else{
            $bom_table->delete('material_id=' . $id);
            $bomref_table->delete('material_id=' . $id);
            $mat_table->delete('id=' . $id);
            $val = '1';
     }
//        if($bomref_values || $inventory_values || $workorder_values || $saleslineitem_values || $vendorpomat_values){
//          
//        }else{
//           
//        }
     //print_r($val); exit;
        return $val;
        
    }

    public function fetchMaterial($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where('id=?', $id);
             
        $results = $this->getAdapter()->fetchRow($select);

        return $results;
    }

    public function fetchBomMaterial($id) {
        $select = $this->_db->select()
                ->from($this->_name, array('id', 'part_no', 'material_desc', 'uom'))
                ->where('id !=?', $id)
//                ->where('status=?', '1')
                ;
              
        $results = $this->getAdapter()->fetchAll($select);

        return $results;
    }

    public function fetchMaterialDesc($id) {
        $select = $this->_db->select()
                ->from($this->_name, array('material_desc'))
                ->where('id =?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }

    public function fetchBomMaterialType($id) {
        $select = $this->_db->select()
                ->from('materialtype', array('type'))
                ->where('id =?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }

    public function fetchBomMaterialId($partno) {
        $select = $this->_db->select()
                ->from($this->_name, array('id'))
                ->where('part_no =?', $partno);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }

    public function fetchBomPartno($id) {

        $select = $this->_db->select()
                ->from($this->_name, array('part_no'))
                ->where('id = ?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }

    public function getbommaterialCategory($id) {

        $select = $this->_db->select()
                ->from($this->_name, array('material_category'))
                ->where('id = ?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }

    public function getmaterialactive() {
         $material = new Material();
       $row1 = $material->fetchAll($material->select()->where('status = ?', '1'));
         $row1 = $row1->toArray();
        return $row1;
       }

    public function getmaterialactivePartno() {
        $select = $this->_db->select()
                ->from($this->_name, array('id', 'part_no'))
                ->where('status =?', '1');
        $results = $this->getAdapter()->fetchAll($select);

        return $results;
    }

    public function getmaterialLineactive($id) {
        $material = new Material();
        $row1 = $material->fetchRow($material->select()->where('id = ?', $id));
        $row1 = $row1->toArray();
        return $row1;
    }
   
       
//       sales
       
        public function woRequired($id,$project)
       {
            
          $select = $this->_db->select()
                ->from($this->_name,array('design_base'))
                ->where('id =?', $id);
       $results = $this->getAdapter()->fetchOne($select);
       
          if($results=='A')
          {  
              $bom=new Bom();
              $row = $bom->fetchRow($bom->select()->where('material_id = ?', $id)->where('project_id = ?', $project));
              $row = $row->toArray();
              return $row;
            }
     
          return false;
       }
       
      public function getBomRequired()
         {
      $select="select ma.id,ma.part_no from material as ma left join materialtype as mt on ma.material_type=mt.id where mt.bom_val='Yes' and ma.status=1";
         $result=$this->getAdapter()->fetchAll($select);
         if($result){
         return $this->getAdapter()->fetchAll($select);}else{
             return false;
         }
       }
       
       
       public function getwomaterial($id)
         {
              $select = $this->_db->select()
                    ->from('material',array('stock_handling'))
                    ->where('id = ?', $id);
          $material_det = $this->getAdapter()->fetchOne($select);
           if($material_det){
         return $material_det;}else{
             return false;
         }
         }
       
       
    }
