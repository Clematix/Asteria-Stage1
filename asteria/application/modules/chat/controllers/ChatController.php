<?php
//use Zend\Mvc\Controller\Plugin\FlashMessenger;
//require_once("Zend\Mvc\Controller\Plugin\FlashMessenger.php");
class Chat_ChatController extends Zend_Controller_Action
{
    public $_chatMapper;
//    public $table;
    public $_usertable;
   

    public function init()
      {
        $this->_dbTable = new Chat();
        $this->_userTable = new Users();
      }

    public function indexAction()
     {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        
        if(empty($data->uname))
        {
            echo 0;
            exit;
        }
        else
        {
            echo 1;
            exit;
        }
        
        
        
        if(!$admin)
        {
                $this->view->message = 'Admin is currently Offline. Please send Your Query in the chat. We will respond you ASAP';
        }

        $this->view->m1 = 'new';
    }
    
    public function startAction()
    {
      
          $table = new Chat();
//        $time = Zend_Date::now();
          $time ='';
         if($this->getRequest()->isPost())
          {
            $post_data = $this->getRequest()->getPost();
            $to = 'admin';
            
            $data = array('from_user'=>$post_data['from'],'email'=>$post_data['email'],'to_user'=>$to,'message'=>$post_data['message']);

            if($data)
            {
                  $table->insert($data);
            }
 
            
//            $user_data = array('uname'=>$post_data['from'],'email'=>$post_data['email'],'password'=>'02121','odcn'=>'N');
//            
//            if($user_data && !$this->_userTable->checkUnique($post_data['from'])) { $this->_userTable->insert($user_data); }
            
//            $admin_model = new Admintable();
//            $admin_session = $admin_model->fetchAll()->toArray();
//
//            if(empty($admin_session))
//            {
//            #send mail if admin is offline
//              $mail = new Zend_Mail();
//              $mail->setBodyText($post_data['message']);
//              $mail->setFrom($post_data['email'], $post_data['from']);
//              $mail->addTo($admin_session[0]['email'],$admin_session[0]['name']);
//              $mail->setSubject('You Got a Query');
//              $mail->send();
//            }
            #ends
    

            $get_chats = $this->_dbTable->getChats($post_data['from']);
            
            foreach ($get_chats as $result) {
                $entries[] = array('message' => $result['message'], 'sent'=>$result['sent'],'from_user'=>$result['from_user'],
                                    'to_user'=>$result['to_user']);
            }
            
//            print_r($entries);
            
            echo Zend_Json::encode($entries);
            exit;
            
        }
       
    }
    
    public function sessionchatsAction()
    {
       
//        $this->_helper->layout()->disableLayout();
//        $this->_helper->viewRenderer->setNoRender(true);
        $table = new Chat();
        if($this->getRequest()->isPost())
        {
           $get_chats = $table->getChats($this->getRequest()->getPost('from'));
           if(empty($get_chats))
           {
               $entries = array();
           }
           
            foreach ($get_chats as $result) {
                $entries[] = array('message' => $result['message'], 'sent'=>$result['sent'],'from_user'=>$result['from_user'],
                                    'to_user'=>$result['to_user']);
            }
          
            echo Zend_Json::encode($entries);
            exit;
            
        }
    }
    
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Chat');
        }

        return $this->_dbTable;
    }
    
    public function viewcustomerchatAction()
    {
        if ($this->_request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            $chat = new Application_Model_Chat($request->getParams());
            $this->_chatMapper->save($chat);
        }
    }
    
    public function getmessagesAction()
    {
        $request = $this->getRequest()->getParam('sessId');
        $entries = array();

        if ($this->_request->isXmlHttpRequest()) {
            $messages = $this->_chatMapper->findBySess($request);
            foreach ($messages as $result) {
                $entries[] = array('role' => $result->role, 'message' => $result->message);
            }
        }
        echo Zend_Json::encode($entries);
    }
}

