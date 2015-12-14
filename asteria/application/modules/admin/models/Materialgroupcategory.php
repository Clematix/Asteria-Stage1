<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Materialgroupcategory extends Zend_Db_Table

    {

       protected $_name='materialgroupcategory';
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
       
          public function getmaterialgroupcategory()
       {
         $select = $this->_db->select()
                        ->from('materialgroupcategory');
                        
        $results = $this->getAdapter()->fetchAll($select);
       
        return $results;
       }
         public function getmaterialgroupcategoryactive()
       {
        
        $materialgroupcategory = new Materialgroupcategory();
        $row1 = $materialgroupcategory->fetchAll($materialgroupcategory->select()->where('status = ?', '1'));
         $row1 = $row1->toArray();
        return $row1;
       }
      
         public function getmaterialgroupcateval($data)
       {
      // echo "<pre>";    print_r($data); exit;
       $materialgroupcategory = new Materialgroupcategory();
        $row = $materialgroupcategory->fetchAll($materialgroupcategory->select()->where('id = ?', $data['id']));
        $row = $row->toArray();
       return $row;
        }
        
        public function savematerialgroupcategory($data)
       {
           date_default_timezone_set('Asia/Kolkata');
            $dt = new DateTime();
            $date =  $dt->format('d-m-Y H:i:s');

        $data['category'] = trim($data['category']);
        $data['charac'] = trim($data['charac']);
      
        
      $data1=array('category'=>$data['category'], 'charac'=>  ucfirst($data['charac']), 'status'=>'1', 'date'=>$date);
      
      
      
      
       $materialgroupcategory = new Materialgroupcategory();
        
        $vald1 = $materialgroupcategory->fetchAll($materialgroupcategory->select()
                                            ->where('category = ?', $data['category'])
                                            ->OrWhere('charac = ?', $data['charac']));
        $vald1 = $vald1->toArray();
      

                if(count($vald1) == '0'){   
                        if($data['id'] == ''){
                            $id = $materialgroupcategory->insert($data1);
                        } 
                        else{
                         $where = array('id =' => $data['id']);
                         $materialgroupcategory->update($data1, 'id='.$data['id']);  
                         $id = $data['id'];
                        }
                    $dub = '0';
                }
         else{
             $dub = '1';
         }
          $data = '';
         return $dub;
       }
       
       public function changestatusgroupcategory($data)
       {
       //echo "<pre>";    print_r($data); exit;
             $data1=array('status'   =>  $data['status']);
             
             
       $materialgrpcate = new Materialgroupcategory();
       $where = array('id =' => $data['vendorid']);
       $materialgrpcate->update($data1, 'id='.$data['vendorid']);  
         
         //print_r($row);
       return $row;
        }

   
          public function deletematerialgroupcategory($id)
       {
        //print_r($id); exit;
        $table = new Materialgroupcategory();
        $table->delete('id='.$id);	
        }
        
        
    }
