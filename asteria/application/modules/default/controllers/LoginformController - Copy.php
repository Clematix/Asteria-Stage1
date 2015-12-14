<?php
class Default_LoginformController extends Zend_Controller_Action
{
    protected $_signup = null;
//    protected $_ = null;
    
    public function init()
    {
        $this->_signup = new Signup();
    }
    
    public function indexAction()
    {
    $this->view->formaction = 'loginform/loginCheck';
    $model = new Signup();

        if($this->getRequest()->isPost())
        {
             $odcn = null;
             $uname =  $this->getRequest()->getParam('uname');
             $email =  $this->getRequest()->getParam('email');
             $password =  $model->salsa208Core64($this->getRequest()->getParam('password'));
             $odcn = $this->getRequest()->getParam('odcn');
             if(empty($odcn))
             {
                $odcn =  'N';
             }
             else
             {
                 $odcn =  'Y';
             }
            
             $data = array('uname'=>$uname,'email'=>$email,'password'=>$password,'odcn'=>$odcn);
              
             if(!$model->checkUnique($email))
             {
                $model->insert($data);
                
             }
             else
             {
                $this->_helper->flashMessenger->addMessage(" This email is already taken");
                $this->view->messages = $this->_helper->flashMessenger->getMessages();
             }
        }
    }
    
    public function logincheckAction()
    {
        if($this->getRequest()->isPost())
        {
            $uname =  $this->getRequest()->getParam('uname');
            $data = $this->_request->getPost();
            
            $users = new Signup();
            $pass =  $users->salsa208Core64($data['password']);
            $auth = Zend_Auth::getInstance();
                $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter(),'users');
                $authAdapter->setIdentityColumn('email')
                            ->setCredentialColumn('password');
                $authAdapter->setIdentity($data['email'])
                            ->setCredential($pass);
                $result = $auth->authenticate($authAdapter);
              
              if($result->isValid())  
              {
                    $storage = new Zend_Auth_Storage_Session();
                    $storage->write($authAdapter->getResultRowObject());                    
                    $this->_redirect('/');
              }
              else
              {
                 echo '1';
                 exit;
           
              }
                
        }
    }
    
    public function forgetpasswordAction()
    {
        
        if($this->getRequest()->isPost())
        {
//            $email='sankar03m@gmail.com';
//            $username='sankar';
          $config = array(
              'auth' => 'login',
                'username' => 'kumaran.m89@gmail.com',
                'password' => '99520goudham',
               'ssl' => 'tls',           
                'port' => 465
                );

    $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);

    $mail = new Zend_Mail();
    $mail->addTo('kumaran.m89@gmail.com', 'kumar')
            ->setFrom('kumaran.m89@gmail.com')
            ->setSubject('Profile Activation')
            ->setBodyHtml('body text')
            ->send($transport);
    
    
        }
        
    }
            



}