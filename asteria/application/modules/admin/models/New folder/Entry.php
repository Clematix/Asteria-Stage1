<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Entry extends Zend_Db_Table

    {

       protected $_name='entries';
	     public function save($formData)
		{
             
                 $eff_date = new Zend_Date($formData['date'], 'dd/mm/yyyy', 'en');
                 $eff_date = $eff_date->get('yyyy-mm-dd');
                 
                
                 
			$data = array(
                                'date' => $eff_date,
				'start'   => $formData['start'],
				'end' => $formData['end'],
				'descp' => $formData['descp'],
				'catid' => $formData['category'],
				'pid' => $formData['projects'],
			        'entrydate' => date('Y-m-d H:i:s'),
				'by' => $formData['by'],
				
			);
	             // echo "<pre>"; print_r($data); 
                        if($formData['id']>0)
                        {
                            $this->update($data, array('id = ?' => $formData['id']));
                        }
                        else{
			$this->insert($data);
                        }
			
		}

    }
