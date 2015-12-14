<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Materialstatus extends Zend_Db_Table

    {

       protected $_name='materialstatus';
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
       
        public function getmaterialstatus()
       {
         $select = $this->_db->select()
                        ->from('materialstatus');
                        
        
        $results = $this->getAdapter()->fetchAll($select);
//        echo "<pre>";
//        print_r($results); exit;
       
        return $results;
       }
   
        public function savematerialstatus($data)
       {
      $data1=array('name'=>trim($data['name']), 'charac'=>trim($data['charac']), 'desc'=>trim($data['desc']));
       $materialstatus = new Materialstatus();
        
        $vald1 = $materialstatus->fetchAll($materialstatus->select()
                                            ->where('name = ?', trim($data['name']))
                                            ->OrWhere('charac = ?', trim($data['charac'])));
        
          $vald1 = $vald1->toArray();
          
           if(count($vald1) == '0'){   
                if($data['id'] == ''){
                    $id = $materialstatus->insert($data1);

                } 
                else{
                 $where = array('id =' => $data['id']);
                 $materialstatus->update($data1, 'id='.$data['id']);  
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
        
         public function getmaterialstatusval($data)
       {
       $materialstatus = new Materialstatus();
        $row = $materialstatus->fetchAll($materialstatus->select()->where('id = ?', $data['id']));
              $row = $row->toArray();
       return $row;
        }
        
    public function deletematerialstatus($id)
       {
        //print_r($id); exit;
         $table = new Materialstatus();
        $row = $table->fetchAll($table->select()->where('id = ?', $id));
        $row = $row->toArray();
        
//        echo "<pre>";
//        print_r($row[0][id]);
        
         $material = new Material();
        $row = $material->fetchAll($material->select()->where('material_status = ?', $row[0][id]));
        $row = $row->toArray();
//          echo "<br>";
//        print_r($row);    
         if(COUNT($row)>0){
             $del = '1';
         }     
        
        else{      
        $table->delete('id='.$id);	
        $del = '0';
        }
        return $del;
        }
        
         public function changestatusmaterialstatus($data)
       {
       $data1=array('status'   =>  $data['status']);
       $materialstatus = new Materialstatus();
       $where = array('id =' => $data['vendorid']);
       $materialstatus->update($data1, 'id='.$data['vendorid']);  
         
         //print_r($row);
       return $row;
        }
        
    }
