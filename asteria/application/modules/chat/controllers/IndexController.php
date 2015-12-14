<?php
class Chat_IndexController extends Zend_Controller_Action
{
    
    public function init()
    {
//        $this->_chatMapper = new Application_Model_ChatMapper();
        $this->_sessId = Zend_Session::getId();
        $this->view->sessId = $this->_sessId;
       
    }
    
    public function indexAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('chat/chat/');
        }
        $this->view->username = $data->username;
    }
}