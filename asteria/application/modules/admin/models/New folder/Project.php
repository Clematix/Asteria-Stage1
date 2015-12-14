<?php

/*class Application_Model_User extends Zend_Db_Table
{
  //protected $_dbTable;
 protected $_name = 'users';
}*/

class Project extends Zend_Db_Table

    {

       protected $_name='projects';
	    public function save($formData)
		{
             
                 $eff_date = new Zend_Date($formData['date'], 'dd/mm/yyyy', 'en');
                 $eff_date = $eff_date->get('yyyy-mm-dd');
                 
                
                 
			$data = array(
                                'name' => $formData['name'],
                                'totalhour' => $formData['totalhour'],
                                'clientid'   => $formData['client'],
                                'date' => $eff_date,
				'entrydate' => date('Y-m-d H:i:s'),
				'by' => $formData['by'],
				
			);
	              
                        if($formData['id']>0)
                        {
                            $this->update($data, array('id = ?' => $formData['id']));
                        }
                        else{
			$this->insert($data);
                        }
			
		} 

    }
