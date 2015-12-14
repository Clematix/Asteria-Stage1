<?php
class Default_ContactController extends Zend_Controller_Action
{
    public function indexAction()
    {
        
        $storage = new Zend_Auth_Storage_Session();
          $data = $storage->read();

          if(!empty($data))
          {
              $this->view->uname = $data->uname;
              $this->view->email = $data->email;
          }
	  //$this->view->headTitle()->prepend('IndexPage'); 
	   $this->view->headTitle()->append('ContactUs'); 
//	   $form	= 	new ContactForm();
//		$this->view->form	=	$form;
           
              
           
          
          }
       
	  

	
	
}
