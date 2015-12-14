<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Position extends Zend_Db_Table

    {

       protected $_name='position';
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
       
        public function getposition()
       {
         $select = $this->_db->select()
                        ->from('position');
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
       
        public function saveposition($data)
       {
           date_default_timezone_set('Asia/Kolkata');
            $dt = new DateTime();
            $date =  $dt->format('d-m-Y H:i:s');
        
       $position = new Position();
       
       $positionvals =  $position->getposition();
       $last = end($positionvals);
       $lastcode = $last['code'];
      $newcode = $lastcode + 1;
     if(strlen($newcode)<2){
       echo  $newcode = '0'.$newcode;
     }
     
//       
//echo "<pre>";
//print_r($data);
//
//exit;
        
        
       if($data['id'] == ''){
           $data1=array('descr'=>$data['descr'], 'code'=>$newcode, 'desc'=>$data['desc'], 'status'=>'1', 'date'=>$date);
                       $vald1 = $position->fetchAll($position->select()
                                            ->where('descr = ?', trim($data['descr'])));
        
                        $vald1 = $vald1->toArray();
//        echo "<pre>";
//        print_r($vald1);
//        exit;
                                if(count($vald1) == '0'){ 
                                     $id = $position->insert($data1);
                                      $dub = '0';
                                }
                                else{
                                     $dub = '1';
                                    }
                        } 
                        else{
                            $data2=array('desc'=>$data['desc'], 'status'=>'1', 'date'=>$date);
                          $where = array('id =' => $data['id']);
                        $position->update($data2, 'id='.$data['id']);  
                        $id = $data['id']; 
                         $dub = '2';
                        }
           
            $data = '';
            return $dub;
        }
        
          public function deleteposition($id)
       {
        $table = new Position();
        $table->delete('id='.$id);	
        }
             
        public function getpositionval($data)
       {
        $position = new Position();
        $row = $position->fetchAll($position->select()->where('id = ?', $data['id']));
        $row = $row->toArray();
        return $row;
       }
        public function changestatusposition($data)
       {
       $data1=array('status'   =>  $data['status']);
       $position = new Position();
       $where = array('id =' => $data['id']);
       $position->update($data1, 'id='.$data['id']);  
       return $row;
       }
       
          public function getpositionactive()
       {
        
        $position = new Position();
        $row1 = $position->fetchAll($position->select()->where('status = ?', '1'));
         $row1 = $row1->toArray();
        return $row1;
       }
   
    }
