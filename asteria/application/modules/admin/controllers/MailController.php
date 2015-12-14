<?php
class Admin_MailController extends Zend_Controller_Action
{
    
	/* draws a calendar */
//   public function init()
//    {
//        
//        $get_users = new Chatusers();
//        
//        $users = $get_users->getUsersData();
//        $this->view->userscount = count($users);
//        
//        $upload1 = new Upload();
//        $books=$upload1->getUsersData();
//        $this->view->books1=count($books);
//      
//        $input = new Userinput();
//        $invoice=$input->getUsersData(); 
//        $this->view->invoice1=count($invoice);
//                
//        $message = new contacts();
//        $this->view->message1=count($message->getUsersData());
//        
//        $user = new User();
//        $rowset = $user->fetchAll("status = 'ON'");
//        $status=count($rowset);
//        $this->view->status=$status;
//        $this->view->member1=count($user->getUsersData());
//    }
	
	public function indexAction()
       {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
       
        if(!$data){
            $this->_redirect('admin/auth/login');
        }
       $this->view->username = $data->firstname." ".$data->lastname;
		
	$entry=new Config();
        if ($this->getRequest()->isPost()) {
		$formData = $this->_request->getPost();
               // print_r($formData);
                
                 $eff_date = new Zend_Date();
                 $data = array('mail_server'=>$formData['mail_server'],'mail_port'=>$formData['mail_port'],'mail_username'=>$formData['mail_username'],'mail_password'=>$formData['mail_password'],'admin_mail'=>$formData['admin_mail'],'contact_mail'=>$formData['contact_mail'],'date'=>$eff_date);

            if($data)
            {
                  $entry->insert($data);
            }
 
               
        }
		

    }
	
	




}