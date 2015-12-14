<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Materialtype extends Zend_Db_Table

    {

       protected $_name='materialtype';
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
       
        public function getmaterialtype()
       {
         $select = $this->_db->select()
                        ->from('materialtype');
                        
        $results = $this->getAdapter()->fetchAll($select);
       
        return $results;
       }
       
        public function savematerialtype($data)
       {
           date_default_timezone_set('Asia/Kolkata');
            $dt = new DateTime();
            $date =  $dt->format('d-m-Y H:i:s');

        //  echo "<pre>"; print_r($data); exit;
        
      $data1=array('type'=>$data['type'], 'code'=>$data['code'], 'desc'=>$data['desc'],'bom_val'=>$data['bom_val'], 'status'=>'1', 'date'=>$date);
      //echo "<pre>"; print_r($data1); exit;
       $materialtype = new Materialtype();
        
       
                    if($data['id'] == ''){
                        $vald1 = $materialtype->fetchAll($materialtype->select()
                                            ->where('type = ?', trim($data['type']))
                                            ->OrWhere('code = ?', trim($data['code'])));
        
                        $vald1 = $vald1->toArray();
        
                                if(count($vald1) == '0'){   
                                      $id = $materialtype->insert($data1);
                                      $dub = '0';
                                }
                                else{
                                     $dub = '1';
                                    }
                        } 
                        else{
                         $where = array('id =' => $data['id']);
                        $materialtype->update($data1, 'id='.$data['id']);  
                        $id = $data['id'];
                        }
                        
         
         
          $data = '';
        return $dub;
        }
          public function deletematerialtype($id)
       {
        //print_r($id); exit;
        $table = new Materialtype();
        $row = $table->fetchAll($table->select()->where('id = ?', $id));
        $row = $row->toArray();

        
         $material = new Material();
        $row = $material->fetchAll($material->select()->where('material_type = ?', $row[0][id]));
        $row = $row->toArray();
        
        if(COUNT($row)>0){
             $del = '1';
         }     
        
        else{      
        $table->delete('id='.$id);	
        $del = '0';
        }
        return $del;
        
        }
             
        public function getmaterialtypeval($data)
       {
      // echo "<pre>";    print_r($data); exit;
       $materialtype = new Materialtype();
        $row = $materialtype->fetchAll($materialtype->select()->where('id = ?', $data['id']));
        $row = $row->toArray();
       return $row;
        }
        public function changestatustype($data)
       {
       $data1=array('status'   =>  $data['status']);
       $materialtype = new Materialtype();
       $where = array('id =' => $data['id']);
       $materialtype->update($data1, 'id='.$data['id']);  
       return $row;
        }
        public function getmattypeactive()
       {
         $materialtype = new Materialtype();
       $row1 = $materialtype->fetchAll($materialtype->select()->where('status = ?', '1'));
         $row1 = $row1->toArray();
        return $row1;
       }
       
       
       public function getBomrequired()
       {
         $select = $this->_db->select()
                ->from($this->_name,array('id'))
                ->where('bom_val =?', 'Yes');
        $results = $this->getAdapter()->fetchAll($select);

        return $results;
       }
   
    }
