<?php
class Admin_UsersController extends Zend_Controller_Action
{
    
    
    public function init()
	  {
		                
        $get_users = new Chatusers();
        
        $users = $get_users->getUsersData();
        $this->view->userscount = count($users);
        
        $upload1 = new Upload();
        $books=$upload1->getUsersData();
        $this->view->books1=count($books);
      
        $input = new Userinput();
        $invoice=$input->getUsersData(); 
        $this->view->invoice1=count($invoice);
                
        $message = new contacts();
        $this->view->message1=count($message->getUsersData());
        
        $user = new User();
        $rowset = $user->fetchAll("status = 'ON'");
        $status=count($rowset);
        $this->view->status=$status;
        $this->view->member1=count($user->getUsersData());
                
	  }
          
    public function indexAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('admin/auth/login');
        }
        $this->view->username = $data->firstname." ".$data->lastname;
        
        
        $get_users = new Chatusers();
        
        $users = $get_users->getUsersData();
        $this->view->users = $users;
        $this->view->userscount = count($users);

    }
    
     public function startAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
       //$now = time()-strtotime($time);
//	echo $time = date('g:iA M dS', strtotime($time));
        
        $chats = new Chats();
        
        $time = Zend_Date::now();
        
                        
        if($this->getRequest()->isPost())
        {

            $post_data = $this->getRequest()->getPost();

           // print_r($post_data);exit;
           $data = array('from_user'=>'admin','email'=>'','to_user'=>$post_data['from'],'message'=>$post_data['message'],'sent'=>$time,'recd'=>0);
            //$data = array('from_user'=>'admin','email'=>'','to_user'=>$post_data['from'],'message'=>$post_data['message']);
 
            if($data)
            {
                $chats->insert($data);
            }
            $chats = $chats->getChats($post_data['from']);
            
            $entries =array();
            foreach ($chats as $key=>$result) {
                $entries[] = array('message' => $result['message'], 'sent'=>$result['sent'],'from_user'=>$result['from_user'],
                                   'to_user'=>$result['to_user']);
            }
            
            $entries['user'] = $post_data['from'];
            
//            print_r($entries);
//            return;
            print Zend_Json::encode($entries);
            exit;
            
        }
    }
    
        public function sessionchatsAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
                   
        $chat_model = new Chats();
        
        if($this->getRequest()->isPost())
        {
           $get_chats = $chat_model->getChats($this->getRequest()->getPost('from'));
           
            foreach ($get_chats as $result) {
                $entries[] = array('message' => $result['message'], 'from_user'=>$result['from_user'],
                                    'to_user'=>$result['to_user']);
            }
          
            echo Zend_Json::encode($entries);
            exit;
            
        }
    }


    public function loginAction()
    {

        $users = new Employee();

        $form = new LoginForm();
        $this->view->form = $form;
        if($this->getRequest()->isPost()){
			$data = $this->_request->getPost();
           // if($form->isValid($_POST)){
                //$data = $form->getValues();
                $auth = Zend_Auth::getInstance();
                $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter(),'employees');
                $authAdapter->setIdentityColumn('email')
                            ->setCredentialColumn('password');
                $authAdapter->setIdentity($data['email'])
                            ->setCredential(md5($data['password']));
                $result = $auth->authenticate($authAdapter);
                if($result->isValid()){
                    $storage = new Zend_Auth_Storage_Session();
                    $storage->write($authAdapter->getResultRowObject());
                    $this->_redirect('admin/auth/home');
                } else {
                    $this->view->errorMessage = "Invalid username or password. Please try again.";
                }
            //}
        }
    }
    public function signupAction()
    {
        $users = new Employee();
        $form = new RegistrationForm();
        $this->view->form=$form;
        if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
                $data = $form->getValues();
                if($data['password'] != $data['confirmPassword']){
                    $this->view->errorMessage = "Password and confirm password don't match.";
                    return;
                }
                if($users->checkUnique($data['email'])){
                    $this->view->errorMessage = "Email Id already Exist";
                    return;
                }
                unset($data['confirmPassword']);
				
				$data = array( 'firstname' => $data['firstname'],
				       'lastname' => $data['lastname'],
					   'email' => $data['email'],
                       'password'    => md5($data['password'])
                       );
				
                $users->insert($data);
                $this->_redirect('admin/auth/login');
            }
        }
    }

    public function forgotpasswordAction()
    {
        $users = new Employee();
        $form = new RegistrationForm();
        $this->view->form=$form;
        if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
                $data = $form->getValues();
                if($data['password'] != $data['confirmPassword']){
                    $this->view->errorMessage = "Password and confirm password don't match.";
                    return;
                }
                if($users->checkUnique($data['username'])){
                    $this->view->errorMessage = "Name already taken. Please choose another one.";
                    return;
                }
                unset($data['confirmPassword']);
                $users->insert($data);
                $this->_redirect('admin/auth/login');
            }
        }
    }

    public function logoutAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $storage->clear();
        $this->_redirect('admin/auth/login');
    }





}