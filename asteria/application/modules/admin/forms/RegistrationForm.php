<?php
class RegistrationForm extends Zend_Form
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
    
		
	$firstname = $this->addElement('text', 'firstname', array(
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
                $department = $this->addElement('select', 'department', array(
            'required' => true,
            'ignore'   => true,
            'label'    => 'Department',
			'class' => 'form-control', 
        ));
                
                $group = $this->addElement('select', 'group', array(
            'required' => true,
            'ignore'   => true,
            'label'    => 'Group',
			'class' => 'form-control', 
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
	
	public function init1()
    {
        $firstname = $this->createElement('text','firstname');
        $firstname->setLabel('First Name:')
                    ->setRequired(false);

        $lastname = $this->createElement('text','lastname');
        $lastname->setLabel('Last Name:')
                    ->setRequired(false);

        $email = $this->createElement('text','email');
        $email->setLabel('Email: *')
                ->setRequired(false);

        $password = $this->createElement('password','password');
        $password->setLabel('Password: *')
                ->setRequired(true);

        $confirmPassword = $this->createElement('password','confirmPassword');
        $confirmPassword->setLabel('Confirm Password: *')
                ->setRequired(true);

        $register = $this->createElement('submit','register');
        $register->setLabel('Sign up')
                ->setIgnore(true);

        $this->addElements(array(
                        $firstname,
                        $lastname,
                        $email,
                        $password,
                        $confirmPassword,
                        $register
        ));
    }
}

