<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Materialgroup extends Zend_Db_Table

    {

       protected $_name='materialgroup';
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
       
        public function getmaterialgroup()
       {
         $select = $this->_db->select()
                        ->from('materialgroup')
                        ->joinLeft('materialgroupcategory', 'materialgroupcategory.charac = materialgroup.category',
                            array('materialgroupcategory.category')
                            );
       $results = $this->getAdapter()->fetchAll($select);
        return $results;
       }

        public function getsubcategory($data)
       {
         
         $materialgroup = new Materialgroup();
      $vald1 = $materialgroup->fetchAll($materialgroup->select()
                                            ->from('materialgroup',array('materialgroup.id','materialgroup.group_comp'))
                                            ->Where('group_char = ?', $data['charac'])
                                            ->Where('status = ?', '1'));
       $results = $vald1->toArray();
      
                for($i=0; $i<count($results); $i++){
                  $val[$results[$i]['id']] = $results[$i]['group_comp'];
                }
        return $val;
       }
        public function getsubcategory_material($data)
       {
          
         $materialgroup = new Materialgroup();
      $vald1 = $materialgroup->fetchAll($materialgroup->select()
                                            ->from('materialgroup',array('materialgroup.id','materialgroup.group_comp'))
                                            ->Where('group_char = ?', $data)
                                            ->Where('status = ?', '1'));
       $results = $vald1->toArray();
      // print_r($results);
                for($i=0; $i<count($results); $i++){
                  $val[$results[$i]['id']] = $results[$i]['group_comp'];
                }
        return $val;
       }
       
       public function getsubcategorycode($data)
       {
       //    print_r($data); exit;
         $materialgroup = new Materialgroup();
         $vald1 = $materialgroup->fetchAll($materialgroup->select()
                                            ->from('materialgroup',array('materialgroup.group_comp_char'))
                                            ->Where('id = ?', $data['id']));
       $val = $vald1->toArray();
//       echo "<pre>";
//       print_r($val);
//       exit;
        return $val;
       }
       
       
       public function savematerialgroup($data)
       {
           date_default_timezone_set('Asia/Kolkata');
            $dt = new DateTime();
            $date =  $dt->format('Y-m-d H:i:s');

        $group_comp_char = trim(strtoupper($data['group_comp_char']));
        if($data['id'] == ''){
            $group_comp_char = $data['group_char'].$group_comp_char;
            }
        $data1=array('category'=>$data['category'], 'group_char'=>$data['group_char'], 'group_comp'=>trim($data['group_comp']), 'group_comp_char'=>$group_comp_char, 'group_desc'=>trim($data['group_desc']), 'status'=>'0', 'date'=>$date);
      
     $materialgroup = new Materialgroup();
       
      
         
                    if($data['id'] == ''){
                        $vald1 = $materialgroup->fetchAll($materialgroup->select()
                                            ->where('category = ?', $data['category'])
                                            ->Where('group_comp = ?', $data['group_comp']));
                        $vald1 = $vald1->toArray();
                        
                        $vald2 = $materialgroup->fetchAll($materialgroup->select()
                                                            ->where('category = ?', $data['category'])
                                                            ->Where('group_comp_char = ?', $data['group_comp_char']));
                        $vald2 = $vald2->toArray();
        
                                if(count($vald1) == '0' && count($vald2) == '0'){
                                      $id = $materialgroup->insert($data1);
                                      $dub = '0';
                                }
                                else{
                                     $dub = '1';
                                    }
                        } 
                        else{
                         $where = array('id =' => $data['id']);
                         $materialgroup->update($data1, 'id='.$data['id']);  
                         $id = $data['id'];
                         $dub = '2';
                        }
           
            $data = '';
            return $dub;
        }
       
        public function deletematerialgroup($id)
       {
        //print_r($id); exit;
        $table = new Materialgroup();
        $table->delete('id='.$id);	
        }
        
        public function getmaterialgroupval($data)
       {
      // echo "<pre>";    print_r($data); exit;
       $materialgroup = new Materialgroup();
        $row = $materialgroup->fetchAll($materialgroup->select()->where('id = ?', $data['id']));
        $row = $row->toArray();
       return $row;
        }
        
           public function changestatusgroup($data)
       {
       $data1=array('status'   =>  $data['status']);
       $materialgroup = new Materialgroup();
       $where = array('id =' => $data['id']);
       $materialgroup->update($data1, 'id='.$data['id']);  
       return $row;
        }

   
    }
