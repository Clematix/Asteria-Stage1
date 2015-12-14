<?php
class ContactsForm extends Zend_Form
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
        
         $name = $this->addElement('text', 'fullname', array(
            'filters'    => array('StringTrim', 'StringToLower'),
			'required'   => true,
            'label'      => 'First Name:',
			'class' => 'form-control'
			
        ));
		$email = $this->addElement('text', 'email', array(
            'filters'    => array('StringTrim', 'StringToLower'),
			'required'   => true,
            'validators' => array(
                'EmailAddress',
            ),
            'label'      => 'Email:',
			'class' => 'form-control'
			
        )); 	
                
                $subject = $this->addElement('text', 'subject', array(
            'filters'    => array('StringTrim', 'StringToLower'),
			'required'   => true,
            'label'      => 'First Name:',
			'class' => 'form-control'
			
        ));
                 $message = $this->addElement('text', 'message', array(
            'filters'    => array('StringTrim', 'StringToLower'),
			'required'   => true,
            'label'      => 'message',
			'class' => 'form-control'
			
        ));
                
              
    }


}

?>

