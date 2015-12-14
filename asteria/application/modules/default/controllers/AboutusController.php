<?php
class Default_AboutusController extends Zend_Controller_Action
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
//$locale = new Zend_Locale('fr_CA');
//$list = $locale->getTranslationList('language');
//
//$locale->getTranslation('fr', 'language', 'en');

// prints the names of all countries in German language
//print_r($locale->getTranslationList('france', 'de_AT'));

	  //$this->view->headTitle()->prepend('IndexPage'); 
	   $this->view->headTitle()->append('AboutUs'); 
           
           
           
//           $this->_helper_layout->setLayout('a'); //other-layout.phtml
//            $layout->setLayoutPath('/layout/custom'); 
//            
//            $layout->setLayout('a'); 
           
//           Zend_Layout::getMvcInstance()->setLayout('a');
        
//	   $form	= 	new ContactForm();
//		$this->view->form	=	$form;
	  
    }
	
	
}
