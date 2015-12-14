<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Fnlm extends Zend_Db_Table

    {

       protected $_name='fnlm';
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
       
        public function getfinal()
       {
         $select = $this->_db->select()
                        ->from('fnlm');
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
       
        public function savefinal($data)
       {
           date_default_timezone_set('Asia/Kolkata');
            $dt = new DateTime();
            $date =  $dt->format('d-m-Y H:i:s');
    
       $final = new Fnlm();

       $finalvals =  $final->getfinal();
       $last = end($finalvals);
       $lastcode = $last['code'];
      $newcode = $lastcode + 1;
     if(strlen($newcode)<2){
       echo  $newcode = '0'.$newcode;
     }
     
     
       if($data['id'] == ''){
            $data1=array('descr'=>$data['descr'], 'code'=>$newcode, 'desc'=>$data['desc'], 'status'=>'1', 'date'=>$date);
            
                       $vald1 = $final->fetchAll($final->select()
                                            ->where('descr = ?', trim($data['descr'])));
        
                        $vald1 = $vald1->toArray();
//        echo "<pre>";
//        print_r($vald1);
//        exit;
                                if(count($vald1) == '0'){ 
                                     $id = $final->insert($data1);
                                      $dub = '0';
                                }
                                else{
                                     $dub = '1';
                                    }
                        } 
                        else{
                             $data2=array('desc'=>$data['desc'], 'status'=>'1', 'date'=>$date);
                          $where = array('id =' => $data['id']);
                        $final->update($data2, 'id='.$data['id']);  
                        $id = $data['id']; 
                         $dub = '2';
                        }
           
            $data = '';
            return $dub;
        }
        
          public function deletefinal($id)
       {
        $table = new Fnlm();
        $table->delete('id='.$id);	
        }
             
        public function getfinalval($data)
       {
        $final = new Fnlm();
        $row = $final->fetchAll($final->select()->where('id = ?', $data['id']));
        $row = $row->toArray();
        return $row;
       }
        public function changestatusfinal($data)
       {
       $data1=array('status'   =>  $data['status']);
       $final = new Fnlm();
       $where = array('id =' => $data['id']);
       $final->update($data1, 'id='.$data['id']);  
       return $row;
       }
   
        public function getfinalactive()
       {
        
        $final = new Fnlm();
        $row1 = $final->fetchAll($final->select()->where('status = ?', '1'));
         $row1 = $row1->toArray();
        return $row1;
       }
       
    }
