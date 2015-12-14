<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Designbase extends Zend_Db_Table

    {

       protected $_name='designbase';
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
       
        public function getdesignbase()
       {
         $select = $this->_db->select()
                        ->from('designbase');
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }
       
        public function savedesignbase($data)
       {
           date_default_timezone_set('Asia/Kolkata');
            $dt = new DateTime();
            $date =  $dt->format('d-m-Y H:i:s');
        $data1=array('designbase'=>$data['designbase'], 'code'=>$data['code'], 'desc'=>$data['desc'], 'status'=>'1', 'date'=>$date);
       $designbase = new Designbase();
        
       if($data['id'] == ''){
                       $vald1 = $designbase->fetchAll($designbase->select()
                                            ->where('designbase = ?', trim($data['designbase']))
                                            ->OrWhere('code = ?', trim($data['code'])));
        
                        $vald1 = $vald1->toArray();
        
                                if(count($vald1) == '0'){ 
                                     $id = $designbase->insert($data1);
                                      $dub = '0';
                                }
                                else{
                                     $dub = '1';
                                    }
                        } 
                        else{
                          $where = array('id =' => $data['id']);
                        $designbase->update($data1, 'id='.$data['id']);  
                        $id = $data['id']; 
                         $dub = '2';
                        }
           
            $data = '';
            return $dub;
        }
        
          public function deletedesignbase($id)
       {
        $table = new Designbase();
        $table->delete('id='.$id);	
        }
             
        public function getdesignbaseval($data)
       {
        $designbase = new Designbase();
        $row = $designbase->fetchAll($designbase->select()->where('id = ?', $data['id']));
        $row = $row->toArray();
        return $row;
       }
        public function changestatusdesign($data)
       {
       $data1=array('status'   =>  $data['status']);
       $designbase = new Designbase();
       $where = array('id =' => $data['id']);
       $designbase->update($data1, 'id='.$data['id']);  
       return $row;
       }
       
        public function getdesignactive()
       {
        $designbase = new Designbase();
        $row1 = $designbase->fetchAll($designbase->select()->where('status = ?', '1'));
         $row1 = $row1->toArray();
        return $row1;
       }
   
    }
