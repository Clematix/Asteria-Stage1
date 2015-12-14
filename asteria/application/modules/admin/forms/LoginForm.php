<?php
class LoginForm extends Zend_Form
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
    
		
	$username = $this->addElement('text', 'email', array(
            'filters'    => array('StringTrim', 'StringToLower'),
			'required'   => true,
            'validators' => array(
                'EmailAddress',
            ),
            'label'      => 'Email Address:',
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
		
		

        $login = $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Login',
			'class' => 'btn btn-default', 
        ));
		
		 $reset = $this->addElement('reset', 'reset', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Reset',
			'class' => 'btn btn-default', 
        ));



	  }

  /* public function init1()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        // Add an email element
        $this->addElement('text', 'email', array(
            'label'      => 'Your email address:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));

        // Add the comment element
        $this->addElement('textarea', 'comment', array(
            'label'      => 'Please Comment:',
            'required'   => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 20))
                )
        ));

        // Add a captcha
        $this->addElement('captcha', 'captcha', array(
            'label'      => 'Please enter the 5 letters displayed below:',
            'required'   => true,
            'captcha'    => array(
                'captcha' => 'Figlet',
                'wordLen' => 5,
                'timeout' => 300
            )
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Sign Guestbook',
        ));

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }*/


}

?>

