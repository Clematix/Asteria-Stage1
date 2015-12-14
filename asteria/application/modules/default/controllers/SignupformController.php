<?php

class Default_SignupformController extends Zend_Controller_Action
{
    protected $_signup = null;
//    protected $_ = null;
    
    public function init()
    {
        $this->_signup = new Signup();
//        echo APPLICATION_DIR;
        

    }
    
    public function indexAction()
    {
          $storage = new Zend_Auth_Storage_Session();
          $data = $storage->read();

          if(!empty($data))
          {
             //$this->_redirect('/');
             //$uri = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
          }       
        
    $recaptcha = new Zend_Service_ReCaptcha('6Ldx6fQSAAAAAAczcMiXsQRJvYIUic9HhtQKGLVe', '6Ldx6fQSAAAAAPBkdo7icKU0OHJqZCBz3pSia2Qx ');
    $this->view->recaptcha = $recaptcha->getHtml();
            
    $this->view->formaction = 'signupform/index';
    $model = new Signup();
    
 
//    $salt = $model->salt();
        if($this->getRequest()->isPost())
            
        {
           
            $result = $recaptcha->verify(
                $_POST['recaptcha_challenge_field'],
                $_POST['recaptcha_response_field']
            );
            
            if (!$result->isValid()) 
            {
                echo "ci";
                exit;
            }
            else
                {
                $odcn = null;
             $uname =  $this->getRequest()->getParam('uname');
             $email =  $this->getRequest()->getParam('email');
             $password =  $model->salsa208Core64($this->getRequest()->getParam('password'));
             $contactno= $this->getRequest()->getParam('contactno');
             $odcn = $this->getRequest()->getParam('odcn');
             if(empty($odcn))
             {
                $odcn =  'N';
             }
             else
             {
                 $odcn =  'Y';
             }
            
             $data = array('uname'=>$uname,'email'=>$email,'password'=>$password,'odcn'=>$odcn,'contactno'=>$contactno);
              
             if(!$model->checkUnique($email))
             {
                $model->insert($data);
                echo "1";exit;
             }
             else
             {
                echo "0";exit;
             }
            }
             
        }
    }
            
 public function logoutAction()
 {
     $status=new Signup();
          $storage = new Zend_Auth_Storage_Session();
          $data = $storage->read();
          $where = $status->getAdapter()->quoteInto('email = ?', $data->email);
          $updatedata=array('status'=>'OFF');
          $status->update($updatedata, $where);
                     
                     
        $storage = new Zend_Auth_Storage_Session();
        $storage->clear();
        $this->_redirect('/');
        
 }


}


      
