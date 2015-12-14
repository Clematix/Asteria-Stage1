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
    $this->view->headTitle()->append('Login'); 
    }
    
    public function logincheckAction()
    {
        if($this->getRequest()->isPost())
        {
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
                    
                     $where = $users->getAdapter()->quoteInto('email = ?', $data['email']);
                     $updatedata=array('status'=>'ON');
                     $users->update($updatedata, $where);
                 
                    
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
            $uname =  $this->getRequest()->getParam('forgetemail');
            $users = new Signup();
            $allrow = $users->fetchRow($users->select()->where('email = ?', $uname));
           
        if($uname==$allrow['email'])
            {   
            $random=md5($allrow['uid']);
                $html='';
                $mailconfig=new Config();
                 $mail_config=$mailconfig->fetchRow();
    
//                $mailhost = $mail_config['mail_server'];
//                $mailconfig = array('auth'      => 'login',
//                    'username'  => $mail_config['mail_username'],
//                    'password'  => $mail_config['mail_password'],
//                    'port'      => $mail_config['mail_port'],
//                    'auth'=>'login');
                
                $mailhost = 'smtp.gmail.com';
                $mailconfig = array('auth'      => 'login',
                    'username'  => 'kumaran.m89@gmail.com',
                    'password'  => '',
                    'ssl'       => 'ssl',
                    'port'      => '465',
                    'auth'=>'login');
                
                
                $transport = new Zend_Mail_Transport_Smtp($mailhost, $mailconfig);
                Zend_Mail::setDefaultTransport($transport);
                
    $html .='<a href="demo.clematix.com/clematixdigital/loginform/passwordchange/'.md5(date('l')).'/'.$random.'">click here to reset your password</a>';
    
    
                $mail = new Zend_Mail();
                //$mail->setBodyText('<a href="www.google.com/clematixdigital/loginform/passwordchange/key/'.$random.'">click here to reset your password</a>');
                $mail->setBodyHtml($html);
                $mail->setFrom('kumar@clematix.co.in', 'Kumar from clematix');
                $mail->addTo($uname, 'Kumar');
                $mail->setSubject('clematix test mail');
                $success = $mail->send();
            if(!$success) 
                {
                  echo '0';exit;
                }
            else{//echo $mail->getBodyHtml($html);exit;
                  echo '1';exit;
                }
                
            }
        else {
              echo '0';exit;
             
             }
          
    
        }
        
    }
      
    
    public function passwordchangeAction()
    {
            $key =  $this->getRequest()->getParam(md5(date('l')));
            $users = new Signup();
          
            $allrow = $users->fetchAll();
           
            
            for($i=0;$i<count($allrow);$i++)
            {
            $random=md5($allrow[$i]['uid']);
            if($key==$random)
             {
               $this->view->passchange= $allrow[$i]['email'];
               $this->view->changekey= md5($allrow[$i]['email']);
             }
            }
    }
    public function pcupdateAction()
          {
             if($this->getRequest()->isPost())
             {
                $email =  $this->getRequest()->getParam('pcuemail');
                $cahngekey =  $this->getRequest()->getParam('changekey');
                $password =  $this->getRequest()->getParam('pcupassword');
                $chnauth=md5($email);
                
                $accchange = new Signup();
               $check=$accchange->checkUnique($email);
               if($check)
               {if($chnauth=$cahngekey){
                    $passwordchange =  $accchange->salsa208Core64($password);
                    $updatedata=array('password'=>$passwordchange);
                    $where = $accchange->getAdapter()->quoteInto('email = ?', $email);
                    $accchange->update($updatedata, $where);
                    echo '1';exit;
                              }
                              else{
                                  echo '0';exit;
                              }
                   
                               }
                else {
                    echo '0';exit;
                    }
             }
   
            
        
                 }
    
    

}