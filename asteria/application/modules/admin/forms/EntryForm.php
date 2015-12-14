<?php
class EntryForm extends Zend_Form
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
    
		
	$firstname = $this->addElement('text', 'start', array(
            'filters'    => array('StringTrim', 'StringToLower'),
			'required'   => true,
            'label'      => 'First Name:',
			'class' => 'form-control'
			
        )); 
		
	$lastname = $this->addElement('text', 'lastname', array(
            'filters'    => array('StringTrim', 'StringToLower'),
			'required'   => true,
            'label'      => 'Last Name:',
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

        $password = $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                'Alnum',
                array('StringLength', false, array(6, 20)),
            ),
            'required'   => true,
            'label'      => 'Password:',
			'class' => 'form-control'
        ));
		
		$confirmPassword = $this->addElement('password', 'confirmPassword', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                'Alnum',
                array('StringLength', false, array(6, 20)),
            ),
            'required'   => true,
            'label'      => 'Confirm Password: *',
			'class' => 'form-control'
        ));

        $login = $this->addElement('submit', 'register', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Sign up',
			'class' => 'btn btn-default', 
        ));
		
		 $reset = $this->addElement('reset', 'reset', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Reset',
			'class' => 'btn btn-default', 
        ));



	  }
	
	
}

