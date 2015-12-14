<?php
class SubscriptionForm extends Zend_Form
{
protected $value;
public function __construct($value=null)
   {
       if($value != null)
	   {
	       $this->value = $value;
		   //print_r($value);
	   }
   parent::__construct();
   }
   
    public function init()
    {
//       $this->setMethod('post');
//	   //$this->setAction('/fb_admin/resource/add/');
//	   $this->addElement('hidden', 'id', array(
//						'value' => $this->value['id'],));
//	   
//	   $this->addElement('text', 'name', array(
//	   					'label' => 'Resource Name',
//						'value' => $this->value['name'],
//						'size'  => '63',
//						'required' => true));
//						
//	   $this->addElement('text', 'description', array(
//	   					'label' => 'Resource Description',
//						'value' => $this->value['description'],
//						'size'  => '63',
//						'required' => true));
//									
//		
//		if(isset($this->value['id']))
//		{					
//		$this->addElement('submit', 'submit', array(
//							'ignore' => true,
//							'label' => 'Save Resource',
//							));
//		}
//		else
//		{
//		$this->addElement('submit', 'submit', array(
//							'ignore' => true,
//							'label' => 'Create Resource',
//							));
//		}		
		$email = $this->addElement('text', 'email', array(
            'filters'    => array('StringTrim', 'StringToLower'),
			'required'   => true,
            'validators' => array(
                'EmailAddress',
            ),
            'label'      => 'Email:',
			'class' => 'form-control'
			
        )); 					
    }


}

?>

